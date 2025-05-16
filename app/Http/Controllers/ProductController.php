<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
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
        ->where('p.status', 'active')
        ->where('p.id', $id)
        ->first();

    if (!$product) {
        abort(404, 'Produk tidak ditemukan.');
    }

    // Data warna, ukuran, stock, dsb.
    $color_options = DB::table('product_color')
        ->leftJoin('product_color_image', 'product_color.id', '=', 'product_color_image.color_id')
        ->where('product_color.product_id', $id)
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

    // Kirim data ke view
    return view('detailsepatu', [
        'product' => $product,
        'color_options' => $color_options,
        'size_options' => $size_options,
        'size_stock' => $size_stock,
        'isWishlisted' => $isWishlisted,
    ]);
}

}