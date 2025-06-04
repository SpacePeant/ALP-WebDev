<?php

namespace App\Http\Controllers;

use index;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollectionController extends Controller
{
    //
    public function index()
    {
        return view('collection');
    }

    public function detail(Request $request)
{
    $search = $request->input('search', '');
    $sort = $request->input('sort', '');
    $min = (int)$request->input('min', 500) * 1000;
    $max = (int)$request->input('max', 10000) * 1000;
    $categories = $request->input('category', []);
    $colors = $request->input('color', []);
    $sizes = $request->input('size', []);
    $genders = $request->input('gender', []);

    $maxPrice = DB::table('product')->max('price');

    $roundedMax = ceil($maxPrice / 1000000) * 1000000;

    $query = DB::table('product as p')
        ->select(
            'p.id as product_id',
            'p.name as product_name',
            'p.gender',
            'p.price',
            'p.description',
            'c.name as category_name',
            'pc.color_code',
            'pc.color_name',
            'pc.color_code_bg',
            'pc.color_font',
            'pci.image_atas',
            'pci.image_bawah',
            'pci.image_kiri',
            'pci.image_kanan'
        )
        ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
        ->leftJoin('product_color as pc', function ($join) {
            $join->on('p.id', '=', 'pc.product_id')
                 ->where('pc.is_primary', true)
                 ->where('pc.status', 'active');
        })
        ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
        ->whereBetween('p.price', [$min, $max]);

    if (!empty($search)) {
        $query->where('p.name', 'like', '%' . $search . '%');
    }

    if (!empty($categories)) {
        $query->whereIn('c.name', $categories);
    }

    if (!empty($colors)) {
        $query->whereExists(function ($subquery) use ($colors) {
            $subquery->select(DB::raw(1))
                ->from('product_color as all_colors')
                ->whereColumn('all_colors.product_id', 'p.id')
                ->whereIn('all_colors.color_name', $colors)
                ->where('all_colors.status', 'active');
        });
    }

    if (!empty($sizes)) {
        $query->whereIn('p.id', function ($subquery) use ($sizes) {
            $subquery->select('product_id')
                ->from('product_variant')
                ->whereIn('size', $sizes);
        });
    }

    if (!empty($genders)) {
        $query->whereIn('p.gender', $genders);
    }

    // Sorting
    if ($sort === 'price_asc') {
        $query->orderBy('p.price', 'asc');
    } elseif ($sort === 'price_desc') {
        $query->orderBy('p.price', 'desc');
    } else {
        $query->orderBy('p.created_at', 'desc');
    }

    $perPage = $request->input('entries', 8); 
    $products = $query->paginate($perPage)->appends(['entries' => $perPage]);

    if ($request->ajax()) {
        return view('partials.product_list', ['products' => $products])->render();
    }

    $categories = DB::table('category')->pluck('name');

    $colors = DB::table('product_color')
        ->select('color_name', DB::raw('MIN(color_code) as color_code'))
        ->groupBy('color_name')
        ->get();

    $sizes = DB::table('product_variant')
        ->select('size')
        ->groupBy('size')
        ->orderBy('size', 'asc')
        ->get();

    $genders = ['Men', 'Women', 'Unisex'];

    return view('detail', [
        'products' => $products,
        'categories' => $categories,
        'colors' => $colors,
        'sizes' => $sizes,
        'genders' => $genders,
        'minPrice' => 0,          
        'maxPrice' => $roundedMax/1000,  
        'perPage' => $perPage,
    ]);
}


public function productList(Request $request)
{
    // Ambil data dari request
    $search = $request->input('search', '');
    $sort = $request->input('sort', '');
    $min = (int) $request->input('min', 500) * 1000;
    $max = (int) $request->input('max', 10000) * 1000;
    $categories = $request->input('category', []);
    $colors = $request->input('color', []);
    $sizes = $request->input('size', []);
    $genders = $request->input('gender', []);

    // Bangun query
    $maxPrice = DB::table('product')->max('price');

    $roundedMax = ceil($maxPrice / 1000000) * 1000000;
    $maxPrice = $roundedMax / 1000; // Untuk tampilan
    $minPrice = 0; // Untuk tampilan
    $query = DB::table('product as p')
    ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
    ->leftJoin('product_color as pc_primary', function ($join) {
        $join->on('p.id', '=', 'pc_primary.product_id')
             ->where('pc_primary.is_primary', true)
             ->where('pc_primary.status', 'active');
    })
    ->leftJoin('product_color_image as pci', 'pc_primary.id', '=', 'pci.color_id')
    ->select(
        'p.id as product_id', 'p.name as product_name', 'p.gender', 'p.price',
        'c.name as category_name',
        'pc_primary.color_code', 'pc_primary.color_name', 'pc_primary.color_code_bg', 'pc_primary.color_font',
        'pci.image_kiri'
    )
    ->whereBetween('p.price', [$min, $max]);

if (!empty($colors)) {
    $query->whereExists(function ($subquery) use ($colors) {
        $subquery->select(DB::raw(1))
            ->from('product_color as pc_all')
            ->whereColumn('pc_all.product_id', 'p.id')
            ->whereIn('pc_all.color_name', $colors)
            ->where('pc_all.status', 'active');
    });
}

    if ($search) {
        $query->where('p.name', 'like', "%{$search}%");
    }

    if (!empty($categories)) {
        $query->whereIn('c.name', $categories);
    }

    if (!empty($sizes)) {
        $query->whereIn('p.id', function ($subquery) use ($sizes) {
            $subquery->select('product_id')
                    ->from('product_variant')
                    ->whereIn('size', $sizes)
                    ->where('stock', '>', 0); // Tambahkan ini
        });
    }


    if (!empty($genders)) {
        $query->whereIn('p.gender', $genders);
    }

    if ($sort === 'price_asc') {
        $query->orderBy('p.price', 'asc');
    } elseif ($sort === 'price_desc') {
        $query->orderBy('p.price', 'desc');
    } else {
        $query->orderBy('p.created_at', 'desc');
    }


$perPage = $request->input('entries', 8);
$products = $query->paginate($perPage)->appends(['entries' => $perPage]);

if ($request->ajax()) {
    return view('partials.product_list', compact('products'))->render(); // partial untuk AJAX
} else {
    $categories = DB::table('category')->pluck('name');

    $colors = DB::table('product_color')
        ->select('color_name', DB::raw('MIN(color_code) as color_code'))
        ->groupBy('color_name')
        ->get();

    $sizes = DB::table('product_variant')
        ->select('size')
        ->groupBy('size')
        ->orderBy('size', 'asc')
        ->get();

    $genders = ['Men', 'Women', 'Unisex'];

    return view('detail', compact(
    'products',
    'categories',
    'colors',
    'sizes',
    'genders',
    'minPrice',
    'maxPrice',
    'perPage'
));
}
}
}
