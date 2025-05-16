<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CollectionController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
});

<<<<<<< HEAD
Route::get('/logout', function () {
    session()->flush(); 
    return redirect('/login');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/orderadmin', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('orderadmin');
});
=======
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\BlogController;

// Cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/update-pilih', [CartController::class, 'updatePilih'])->name('cart.update_pilih');


// Wishlist
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('/wishlist/check/{productId}', [WishlistController::class, 'isWishlisted'])->name('wishlist.check');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::get('/wishlist/check/{productId}', [WishlistController::class, 'isWishlisted']);
Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.show');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/delete', [WishlistController::class, 'removeFromWishlist']);
Route::get('/product_list', [ProductController::class, 'index'])->name('product.list');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('checkout.updateQuantity');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.payNow');

// Munculin form login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/detail', [CollectionController::class, 'detail'])->name('detail');
Route::get('/product-list', [CollectionController::class, 'productList'])->name('product.list');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('detail_sepatu/{id}', [ProductController::class, 'show'])->name('detail_sepatu.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
// Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
>>>>>>> 3ca815e0bdcd36811bd003179a2e5ebb4c9218b6

Route::get('/home', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
});

<<<<<<< HEAD
Route::get('/blog', function () {
    return view('blog');
});

Route::get('/aboutus', function () {
    return view('aboutus');
=======
Route::get('/orderadmin', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('admin.order');
>>>>>>> 3ca815e0bdcd36811bd003179a2e5ebb4c9218b6
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about-us', function () {
    return view('aboutus');
})->name('about');

<<<<<<< HEAD
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('detail_sepatu/{id}', [ProductController::class, 'show'])->name('detail_sepatu.show');


Route::get('/orderadmin', [OrderController::class, 'adminIndex'])->name('orderadmin');

Route::get('/products', [ProductController::class, 'index'])->name('productadmin');
Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('productadmin.delete');

Route::get('/products/create', [ProductController::class, 'create'])->name('addproduct');
Route::post('/products/store', [ProductController::class, 'store'])->name('addproduct.store');

Route::get('/product/{id}/edit/{color_id}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');








=======
Route::get('/collection', function () {
    return view('collection');
})->name('collection');

Route::get('/blog', [BlogController::class, 'showBlogPage']);
// Route::get('/load-more-blogs', [BlogController::class, 'loadMore']);

// Route::get('/load-more-blogs', [BlogController::class, 'loadMoreBlogs']);
>>>>>>> 3ca815e0bdcd36811bd003179a2e5ebb4c9218b6
