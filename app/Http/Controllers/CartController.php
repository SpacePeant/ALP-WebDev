<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Tambah ke keranjang
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'size'       => 'required|string',
            'color_code' => 'required|string',
        ]);

        $userId = Session::get('user_id', 1);
        $productId = $request->product_id;
        $size = $request->size;
        $colorCode = $request->color_code;

        $color = ProductColor::where('product_id', $productId)
                    ->where('color_code', $colorCode)
                    ->first();

        if (!$color) {
            return response()->json(['success' => false, 'message' => 'Warna tidak ditemukan']);
        }

        $variant = ProductVariant::where('product_id', $productId)
                    ->where('size', $size)
                    ->first();

        if (!$variant) {
            return response()->json(['success' => false, 'message' => 'Ukuran tidak ditemukan']);
        }

        $item = CartItem::where('customer_id', $userId)
                    ->where('product_id', $productId)
                    ->where('product_color_id', $color->id)
                    ->where('product_variant_id', $variant->id)
                    ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
            return response()->json(['success' => true, 'message' => 'Jumlah diperbarui']);
        } else {
            CartItem::create([
                'customer_id'        => $userId,
                'product_id'         => $productId,
                'product_color_id'   => $color->id,
                'product_variant_id' => $variant->id,
                'quantity'           => 1,
            ]);
            return response()->json(['success' => true, 'message' => 'Item ditambahkan ke keranjang']);
        }
    }

    // Hapus item dari keranjang
    public function removeFromCart(Request $request)
    {
        $userId = Auth::id();
        $cartItemId = $request->cart_item_id;

        $deleted = CartItem::where('id', $cartItemId)
                    ->where('customer_id', $userId)
                    ->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Item dihapus dari keranjang']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus item']);
        }
    }

    public function updateCart(Request $request)
    {
        $id = $request->input('id');
        $quantity = (int) $request->input('quantity');

        if (!$id || $quantity < 0) {
            return response('Data tidak lengkap atau tidak valid', 400);
        }

        if ($quantity === 0) {
            CartItem::where('id', $id)->delete();
        } else {
            CartItem::where('id', $id)->update(['quantity' => $quantity]);
        }

        return response('OK', 200);
    }

    public function updatePilih(Request $request)
    {
        $cartId = $request->input('cart_id');
        $isPilih = $request->input('is_pilih');

        if (is_null($cartId) || is_null($isPilih)) {
            return response()->json(['error' => 'Data tidak lengkap'], 400);
        }

        $updated = CartItem::where('id', $cartId)->update(['is_pilih' => $isPilih]);

        if ($updated) {
            return response()->json(['message' => 'Status updated']);
        } else {
            return response()->json(['error' => 'Gagal update status'], 500);
        }
    }

    public function index()
    {
        $user_id = Session::get('user_id');

        if (!$user_id) {
            return redirect('/login');
        }

        $cartItems = DB::table('cart_items as ci')
        ->join('product as p', 'p.id', '=', 'ci.product_id')
        ->join('product_color as pc', 'pc.id', '=', 'ci.product_color_id')
        ->join('product_color_image as pci', 'pci.color_id', '=', 'ci.product_color_id')
        ->join('product_variant as pv', 'pv.id', '=', 'ci.product_variant_id')
        ->where('ci.customer_id', $user_id)
        ->select(
            'ci.id',
            'p.price',
            'p.name',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih'
        )
        ->groupBy(
            'ci.id',
            'p.price',
            'p.name',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih'
        )
        ->get();

        return view('cart', [
            'cartItems' => $cartItems
        ]);
    }
}
