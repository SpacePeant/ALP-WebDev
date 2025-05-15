<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer',
        'size' => 'required',
        'color_code' => 'required',
    ]);

    $product_id = $request->product_id;
    $size = $request->size;
    $color_code = $request->color_code;
    $user_id = Auth::id() ?? $request->query('user_id', 1);

    $color = DB::table('product_color')
        ->where('product_id', $product_id)
        ->where('color_code', $color_code)
        ->first();

    if (!$color) {
        return response()->json(['success' => false, 'message' => 'Warna tidak ditemukan'], 400);
    }

    DB::table('cart_items')->insert([
        'customer_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => 1,
        'size' => $size,
        'color_name' => $color->color_name,
    ]);

    return response()->json(['success' => true]);
}

}
