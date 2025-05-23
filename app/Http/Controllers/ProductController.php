<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function show($id, Request $request)
{
    // Query produk (sesuaikan dengan yang kamu pakai sekarang)
    $product = DB::table('product as p')
        ->select(
            'p.id as product_id',
            'p.name as product_name',
            'p.gender',
            'p.price',
            'c.name as category_name',
            'p.category_id',
            'pc.color_code',
            'pc.color_name',
            'pc.color_code_bg',
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
        ->where('pc.status', 'active')
        ->where('p.id', $id)
        ->first();

    if (!$product) {
        abort(404, 'Produk tidak ditemukan.');
    }
    $product->rating = 4.6;
    // Data warna, ukuran, stock, dsb.
    $color_options = DB::table('product_color')
        ->leftJoin('product_color_image', 'product_color.id', '=', 'product_color_image.color_id')
        ->where('product_color.product_id', $id)
        ->where('product_color.status', 'active')
        ->select(
            'product_color.id',
            'product_color.color_name',
            'product_color.color_code',
            'product_color.is_primary',
            'product_color_image.image_atas',
            'product_color_image.image_bawah',
            'product_color_image.image_kiri',
            'product_color_image.image_kanan'
        )
        ->get();

        $youMayAlsoLike = DB::table('product as p')
        ->select(
            'p.id as product_id',
            'p.name as product_name',
            'p.price',
            'pc.color_code_bg',
            'pc.color_font',
            'pci.image_kiri'
        )
        ->leftJoin('product_color as pc', function ($join) {
            $join->on('p.id', '=', 'pc.product_id')
                 ->where('pc.is_primary', true);
        })
        ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
        ->where('p.category_id', $product->category_id)      
        ->where('pc.status', 'active')
        ->limit(5)
        ->get();
        
    $size_options = DB::table('product_variant as pv')
        ->join('product_color as pc', 'pc.id', '=', 'pv.color_id')
        ->where('pv.product_id', $id)
        ->select('pv.size')
        ->groupBy('pv.size')
        ->orderBy('pv.size')
        ->get();

    $size_stock = DB::table('product_variant as pv')
        ->join('product_color as pc', 'pc.id', '=', 'pv.color_id')
        ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
        ->where('pv.product_id', $id)
        ->select(
            'pv.size',
            'pv.stock',
            'pc.color_code',
            'pc.color_code_bg',
            'pci.image_atas',
            'pci.image_bawah',
            'pci.image_kanan',
            'pci.image_kiri'
        )
        ->orderBy('pv.size')
        ->get();

        $userId = Session::get('user_id', 1); // Ambil dari session


    // Cek wishlist user
    $isWishlisted = false;
    if ($userId) {
        $isWishlisted = Wishlist::where('customer_id', $userId)
                                ->where('product_id', $id)
                                ->exists();
    }
    $reviews = ProductReview::where('product_id', $id)
    ->with('customer') // pastikan relasi di model
    ->latest()
    ->get();
    
    $reviewss = ProductReview::select('rating', DB::raw('count(*) as count'))
    ->where('product_id', $id)
    ->groupBy('rating')
    ->get();

$ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

foreach ($reviewss as $review) {
    $ratingCounts[$review->rating] = $review->count;
}

$totalReviews = array_sum($ratingCounts);

$averageRating = $totalReviews > 0 
    ? round(ProductReview::where('product_id', $id)->avg('rating'), 1) 
    : 0;

    return view('detailsepatu', [
        'product' => $product,
        'color_options' => $color_options,
        'size_options' => $size_options,
        'size_stock' => $size_stock,
        'isWishlisted' => $isWishlisted,
        'youMayAlsoLike' => $youMayAlsoLike,
        'reviews' => $reviews,
        'ratingCounts' => $ratingCounts,
        'totalReviews' => $totalReviews,
        'averageRating' => $averageRating,
    ]);
}
// public function show($id, Request $request)
//     {
//         $product = DB::table('product as p')
//             ->select(
//                 'p.id as product_id',
//                 'p.name as product_name',
//                 'p.gender',
//                 'p.price',
//                 'c.name as category_name',
//                 'pc.color_code',
//                 'pc.color_name',
//                 'pc.color_code_bg',
//                 'pci.image_atas',
//                 'pci.image_bawah',
//                 'pci.image_kiri',
//                 'pci.image_kanan'
//             )
//             ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
//             ->leftJoin('product_color as pc', function ($join) {
//                 $join->on('p.id', '=', 'pc.product_id')
//                      ->where('pc.is_primary', true);
//             })
//             ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
//             ->where('p.status', 'active')
//             ->where('p.id', $id)
//             ->first();

//         if (!$product) {
//             abort(404, 'Produk tidak ditemukan.');
//         }

//         $color_options = DB::table('product_color')
//             ->leftJoin('product_color_image', 'product_color.id', '=', 'product_color_image.color_id')
//             ->where('product_color.product_id', $id)
//             ->select(
//                 'product_color.id',
//                 'product_color.color_name',
//                 'product_color.color_code',
//                 'product_color.is_primary',
//                 'product_color_image.image_atas',
//                 'product_color_image.image_bawah',
//                 'product_color_image.image_kiri',
//                 'product_color_image.image_kanan'
//             )
//             ->get();


//         $size_options = DB::table('product_variant as pv')
//             ->join('product_color as pc', 'pc.id', '=', 'pv.color_id')
//             ->where('pv.product_id', $id)
//             ->select('pv.size')
//             ->groupBy('pv.size')
//             ->orderBy('pv.size')
//             ->get();

//         $size_stock = DB::table('product_variant as pv')
//             ->join('product_color as pc', 'pc.id', '=', 'pv.color_id')
//             ->leftJoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
//             ->where('pv.product_id', $id)
//             ->select(
//                 'pv.size',
//                 'pv.stock',
//                 'pc.color_code',
//                 'pc.color_code_bg',
//                 'pci.image_atas',
//                 'pci.image_bawah',
//                 'pci.image_kanan',
//                 'pci.image_kiri'
//             )
//             ->orderBy('pv.size')
//             ->get();

//         $user_id = Auth::id() ?? $request->query('user_id', 1);

//         return view('detailsepatu', [
//             'product' => $product,
//             'color_options' => $color_options,
//             'size_options' => $size_options,
//             'size_stock' => $size_stock,
//             'user_id' => $user_id,
//         ]);
//     }

    public function index()
    {
        $products = DB::table('product as p')
            ->leftjoin('product_color as pc', 'p.id', '=', 'pc.product_id')
            ->leftjoin('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
            ->select('p.id', 'pc.id as color_id', 'p.name', 'pc.color_name', 'pci.image_kiri')
            ->where('pc.status', 'active')
            ->groupBy('p.id', 'pc.id', 'p.name', 'pc.color_name', 'pci.image_kiri')
            ->get();

        return view('productadmin', compact('products'));
    }

    public function delete($id)
{
    $color = DB::table('product_color')->where('id', $id)->first();

    DB::table('product_color')
        ->where('id', $id)
        ->update(['status' => 'inactive', 'is_primary' => 0]);

    if ($color->is_primary == 1) {
        $newPrimary = DB::table('product_color')
            ->where('product_id', $color->product_id)
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->orderBy('id', 'asc') 
            ->first();

        if ($newPrimary) {
            DB::table('product_color')
                ->where('id', $newPrimary->id)
                ->update(['is_primary' => 1]);
        }
    }

    return redirect()->route('productadmin');
}

    public function create()
    {
        $categories = Category::all();
        // dd($categories);
        return view('addproduct', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required|exists:categories,id',
            'description' => 'required',
            'price' => 'required|numeric',
            'color' => 'required|array',
            'color.*' => 'required|string',
            'color_code' => 'required|array',
            'color_code.*' => 'required|string',
            'size' => 'nullable|array',
            'gender' => 'nullable|string'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'gender' => $request->gender ?? 'Unisex',
            'description' => $request->description,
            'price' => $request->price,
            'status' => 1,
            'category_id' => $request->category,
        ]);

        foreach ($request->color as $index => $colorName) {
            $color = ProductColor::create([
                'product_id' => $product->id,
                'color_name' => $colorName,
                'color_code' => $request->color_code[$index],
                'is_primary' => false,
            ]);

            // if ($request->size) {
            //     foreach ($request->size as $size) {
            //         ProductVariant::create([
            //             'product_id' => $product->id,
            //             'color_id' => $color->id,
            //             'size' => $size,
            //             'stock' => 0,
            //         ]);
            //     }
            // }

            for ($size = 36; $size <= 45; $size++) {
            ProductVariant::create([
            'product_id' => $product->id,
            'color_id' => $color->id,
            'size' => $size,
            'stock' => 0,
        ]);
    }
        }

        return redirect()->route('addproduct')->with('success', 'Product saved successfully!');
    }

    public function edit($id, $color_id)
    {
    $product = DB::table('product as p')
        ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
        ->leftJoin('product_color as pc', 'pc.product_id', '=', 'p.id')
        ->leftJoin('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
        ->leftJoin('product_variant as pv', function ($join) {
            $join->on('pv.product_id', '=', 'p.id')
                 ->on('pv.color_id', '=', 'pc.id');
        })
        ->where('p.id', $id)
        ->where('pc.id', $color_id)
        ->select(
            'p.*',
            'c.name as category_name',
            'pc.id as color_id',
            'pc.color_name',
            'pci.image_kiri',
            'pci.image_kanan',
            'pci.image_atas',
            'pci.image_bawah',
            'pv.size',
            'pv.stock'
        )
        ->first();

    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    $sizeStock = DB::table('product_variant')
        ->where('product_id', $id)
        ->where('color_id', $color_id)
        ->pluck('stock', 'size'); 

        return view('editproduct', [
            'product' => $product,
            'sizeStock' => $sizeStock,
            'sizeStocksJson' => json_encode($sizeStock),
            'color_id' => $color_id,
            'id' => $id
        ]);
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nama_produk' => 'required|string|max:255',
        'gender' => 'required|in:Men,Women,Unisex',
        'deskripsi' => 'nullable|string',
        'kategori' => 'required|integer|exists:categories,id',
        'harga' => 'required|integer',
        'color_id' => 'required|integer',
        'stocks_json' => 'required|json',
    ]);

    $product = Product::findOrFail($id);
    $product->name = $validated['nama_produk'];
    $product->gender = $validated['gender'];
    $product->description = $validated['deskripsi'];
    $product->price = $validated['harga'];
    $product->category_id = $validated['kategori'];
    $product->updated_at = now();
    $product->save();

    $stocksArray = json_decode($validated['stocks_json'], true);

    if (is_array($stocksArray)) {
        foreach ($stocksArray as $size => $stock) {
            ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'color_id' => $validated['color_id'],
                    'size' => $size,
                ],
                [
                    'stock' => $stock,
                ]
            );
        }
    }

    return redirect()->route('productadmin')->with('success', 'Produk berhasil diperbarui');
}
public function update_gambar(Request $request)
{
    $request->validate([
        'color_id' => 'required|integer|exists:product_color_image,color_id',
        'position' => 'required|in:atas,kiri,kanan,bawah',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $colorId = $request->input('color_id');
    $position = $request->input('position');
    $imageFile = $request->file('image');

    $folderPath = public_path("image/sepatu/{$position}/");
    $fileName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
    $columnName = "image_" . $position;

    $oldImage = DB::table('product_color_image')
        ->where('color_id', $colorId)
        ->value($columnName);

    if ($oldImage && file_exists($folderPath . $oldImage)) {
        unlink($folderPath . $oldImage);
    }

    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0775, true);
    }

    $imageFile->move($folderPath, $fileName);
    DB::table('product_color_image')
        ->where('color_id', $colorId)
        ->update([
            $columnName => $fileName
        ]);

    return back()->with('success', 'Image successfully updated!');
}

public function getVariants($color_id)
{
    $variants = DB::table('product_variant as pv')
    ->leftJoin('product_color as pc', 'pc.id', '=', 'pv.color_id')
    ->leftJoin('product as p', 'p.id', '=', 'pc.product_id')
    ->leftJoin('category as c', 'c.id', '=', 'p.category_id')
    ->leftJoin('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
    ->where('pv.color_id', $color_id)
    ->select(
        'pc.color_name',
        'p.name as product_name',
        'c.name as category_name',
        'pv.size',
        'pv.stock',
        'pci.image_kiri'
    )
    ->get();

return response()->json($variants);

}
}


