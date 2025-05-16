<?php

namespace App\Http\Controllers;

use index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    $query = DB::table('product as p')
        ->select(
            'p.id as product_id',
            'p.name as product_name',
            'p.gender',
            'p.price',
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
                 ->where('pc.is_primary', true);
        })
        ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
        ->where('p.status', 'active')
        ->whereBetween('p.price', [$min, $max]);

    if (!empty($search)) {
        $query->where('p.name', 'like', '%' . $search . '%');
    }

    if (!empty($categories)) {
        $query->whereIn('c.name', $categories);
    }

    if (!empty($colors)) {
        $query->whereIn('pc.color_code', $colors);
    }

    if (!empty($sizes)) {
        $query->whereIn('p.id', function($subquery) use ($sizes) {
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

    $products = $query->get();

    $categories = DB::table('category')->pluck('name');

    $colors = DB::table('product_color')
        ->select('color_name', 'color_code')
        ->groupBy('color_name', 'color_code')
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
    ]);

    // return view('detail');
    
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
    $query = DB::table('product as p')
        ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
        ->leftJoin('product_color as pc', function ($join) {
            $join->on('p.id', '=', 'pc.product_id')
                 ->where('pc.is_primary', true);
        })
        ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
        ->select(
            'p.id as product_id', 'p.name as product_name', 'p.gender', 'p.price',
            'c.name as category_name',
            'pc.color_code', 'pc.color_name', 'pc.color_code_bg', 'pc.color_font',
            'pci.image_kiri'
        )
        ->where('p.status', 'active')
        ->whereBetween('p.price', [$min, $max]);

    if ($search) {
        $query->where('p.name', 'like', "%{$search}%");
    }

    if (!empty($categories)) {
        $query->whereIn('c.name', $categories);
    }

    if (!empty($colors)) {
        $query->whereIn('pc.color_code', $colors);
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

    if ($sort === 'price_asc') {
        $query->orderBy('p.price', 'asc');
    } elseif ($sort === 'price_desc') {
        $query->orderBy('p.price', 'desc');
    } else {
        $query->orderBy('p.created_at', 'desc');
    }

    $products = $query->get();

    return view('partials.product_list', compact('products'))->render(); // Partial HTML untuk AJAX
}
}
