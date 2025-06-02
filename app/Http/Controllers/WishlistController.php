<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    // Tambah ke wishlist
    public function addToWishlist(Request $request)
    {
        $userId = Session::get('user_id', 1);
        $productId = $request->product_id;

        if (!$userId || !$productId) {
            return response()->json(['success' => false, 'message' => 'Data not complete']);
        }

        $exists = Wishlist::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Already added to wishlist']);
        }

        try {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat create wishlist: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add to wishlist']);
        }

        return response()->json(['success' => true, 'message' => 'Added to wishlist']);
    }

    // Hapus dari wishlist
    public function removeFromWishlist(Request $request)
    {
        $userId = Session::get('user_id', 1);
        $productId = $request->product_id;

        $deleted = Wishlist::where('user_id', $userId)
                           ->where('product_id', $productId)
                           ->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to remove from wishlist']);
        }
    }

    // Cek apakah produk ada di wishlist
    public function isWishlisted($productId)
    {
        $userId = Auth::id();

        $exists = Wishlist::where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->exists();

        return response()->json(['wishlisted' => $exists]);
    }

    public function index(Request $request)
{
    $userId = session('user_id', $request->query('user_id', 1));

    $wishlists = DB::table('wishlists as w')
    ->join('product as p', 'p.id', '=', 'w.product_id')
    ->join('product_color as pc', 'pc.product_id', '=', 'w.product_id')
    ->join('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
    ->where('pc.is_primary', true)
    ->where('w.user_id', $userId)
    ->select('w.id', 'w.user_id', 'w.product_id', 'p.name','p.price', 'pci.image_kiri')
    ->get();

return view('wishlist', [
    'wishlists' => $wishlists
]);
}
}
