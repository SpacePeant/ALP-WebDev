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
    // public function addToCart(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|integer',
    //         'size'       => 'required|string',
    //         'color_code' => 'required|string',
    //     ]);

    //     $userId = Session::get('user_id', 1);
    //     $productId = $request->product_id;
    //     $size = $request->size;
    //     $colorCode = $request->color_code;

    //     $color = ProductColor::where('product_id', $productId)
    //                 ->where('color_code', $colorCode)
    //                 ->first();

    //     if (!$color) {
    //         return response()->json(['success' => false, 'message' => 'Warna tidak ditemukan']);
    //     }

    //     $variant = ProductVariant::where('product_id', $productId)
    //                 ->where('size', $size)
    //                 ->first();

    //     if (!$variant) {
    //         return response()->json(['success' => false, 'message' => 'Ukuran tidak ditemukan']);
    //     }

    //     $item = CartItem::where('user_id', $userId)
    //                 ->where('product_id', $productId)
    //                 ->where('product_color_id', $color->id)
    //                 ->where('product_variant_id', $variant->id)
    //                 ->first();

    //     if ($item) {
    //         $item->quantity += 1;
    //         $item->save();
    //         return response()->json(['success' => true, 'message' => 'Jumlah diperbarui']);
    //     } else {
    //         CartItem::create([
    //             'user_id'        => $userId,
    //             'product_id'         => $productId,
    //             'product_color_id'   => $color->id,
    //             'product_variant_id' => $variant->id,
    //             'quantity'           => 1,
    //         ]);
    //         return response()->json(['success' => true, 'message' => 'Item ditambahkan ke keranjang']);
    //     }
    // }

     public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer',
        'size'       => 'required|string',
        'color_code' => 'required|string',
        'quantity'   => 'nullable|integer|min:1',
    ]);

    $userId = Session::get('user_id', 1);
    $productId = $request->product_id;
    $size = $request->size;
    $colorCode = $request->color_code;
    $quantity = max((int)$request->input('quantity', 1), 1);

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

    // Ambil item yang sudah ada di keranjang (jika ada)
    $item = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->where('product_color_id', $color->id)
                ->where('product_variant_id', $variant->id)
                ->first();

    $existingQty = $item ? $item->quantity : 0;
    $totalQty = $existingQty + $quantity;

    // Cek stok cukup atau tidak
    if ($totalQty > $variant->stock) {
        return response()->json([
            'success' => false,
            'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $variant->stock . '. Dicart anda sudah ada ' . $item->quantity
        ]);
    }

    // Update atau buat baru
    if ($item) {
        $item->quantity = $totalQty;
        $item->save();
        return response()->json(['success' => true, 'message' => 'Jumlah diperbarui']);
    } else {
        CartItem::create([
            'user_id'            => $userId,
            'product_id'         => $productId,
            'product_color_id'   => $color->id,
            'product_variant_id' => $variant->id,
            'quantity'           => $quantity,
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
                    ->where('user_id', $userId)
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

    // Ambil informasi stock berdasarkan cart_id
   $cartItem = CartItem::with(['product', 'productColor', 'productVariant'])
    ->where('id', $cartId)
    ->first();

if (!$cartItem) {
    return response()->json(['error' => 'Item tidak ditemukan'], 404);
}

// Ambil nilai is_pilih
$pil = $cartItem->is_pilih;

// Jika is_pilih == false (belum dipilih), maka cek stok dulu
if (!$pil) {
    $stock = optional($cartItem->productVariant)->stock;

    if ($stock <= 0) {
        return response()->json(['error' => 'Stok habis, tidak dapat dipilih'], 400);
    }
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
        ->where('ci.user_id', $user_id)
        ->where('pc.status', 'active')
        ->select(
            'ci.id',
            'ci.product_id',
            'ci.product_color_id',
            'p.price',
            'p.name',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih',
            'pv.stock' 
        )
        ->groupBy(
            'ci.id',
            'ci.product_id',
            'ci.product_color_id',
            'p.price',
            'p.name',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih',
            'pv.stock'
        )
        ->get();

        foreach ($cartItems as $item) {
                $item->availableSizes = ProductVariant::where('product_id', $item->product_id)
                    ->where('color_id', $item->product_color_id)
                    ->get();

                $item->currentSize = $item->size; // asumsinya kolom size ada di cart_items
        }

        return view('cart', [
            'cartItems' => $cartItems
        ]);
    }

    public function getAvailableSizes(Request $request)
    {
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');

        $sizes = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->orderBy('size')
            ->get(['id', 'size', 'stock']);

        return response()->json($sizes);
    }

    public function updateSize(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|integer',
            'variant_id' => 'required|integer',
        ]);

        $cartItem = CartItem::find($request->cart_id);
        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan']);
        }

        $variant = ProductVariant::find($request->variant_id);
        if (!$variant) {
            return response()->json(['success' => false, 'message' => 'Variant tidak ditemukan']);
        }

        $cartItem->product_variant_id = $request->variant_id;
        $cartItem->quantity = 1;  // reset quantity jadi 1
        $cartItem->save();

        return response()->json([
            'success' => true,
            'max_quantity' => $variant->stock,
            'updated_quantity' => 1,
        ]);
    }
}