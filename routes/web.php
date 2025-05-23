<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CollectionController;

Route::get('/orderadmin', [OrderController::class, 'adminIndex'])->name('orderadmin');

Route::get('/products', [ProductController::class, 'index'])->name('productadmin');
Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('productadmin.delete');

Route::get('/products/create', [ProductController::class, 'create'])->name('addproduct');
Route::post('/products/store', [ProductController::class, 'store'])->name('addproduct.store');

Route::get('/product/{id}/edit/{color_id}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::post('/product/update-gambar', [ProductController::class, 'update_gambar'])->name('product.update_gambar');

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

// Payment
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('checkout.updateQuantity');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.payNow');
Route::post('/midtrans/webhook', [CheckoutController::class, 'handleMidtransWebhook']);

Route::get('/payment/return/{order}', [PaymentController::class, 'handleReturn'])
->name('payment.return');

Route::get('/payment/status/{order}', [PaymentController::class, 'checkStatus'])
->name('payment.status');

// REPORT
Route::get('/report/sales', [ReportController::class, 'salesReport'])->name('report.sales');
Route::get('/report/sales/pdf', [ReportController::class, 'downloadPDF'])->name('report.sales.pdf');
Route::get('/report/sales/data', [ReportController::class, 'fetchSalesTable'])->name('report.sales.data');

// Route::get('/chart/data', [ChartController::class, 'getData']);
// Route::get('/dashboard', [ChartController::class, 'getData']);
Route::get('/dashboard/filter', [ChartController::class, 'getData']);


// Route::get('/payment/return/{order}', [PaymentController::class, 'handleReturn'])
// ->name('payment.return');

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
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
// Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
// Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::get('/orderadmin', function () {
//     if (!session()->has('user_id')) return redirect('/login');
//     return view('orderadmin');
// });

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/about-us', function () {
    return view('aboutus');
})->name('about');

Route::get('/collection', function () {
    return view('collection');
})->name('collection');

Route::get('/report', function () {
    return view('report-menu');
})->name('report');

Route::get('/blog', [BlogController::class, 'showBlogPage'])->name('blog');
Route::get('/load-more-blogs', [BlogController::class, 'loadMoreBlogs']);

Route::get('/signup', [RegisterController::class, 'show'])->name('signup.form');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/order', [OrderController::class, 'index'])->name('order');

Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');

Route::get('/articles/{id}', [ArticleController::class, 'show']);


Route::get('/articles/{id}', [ArticleController::class, 'show']);


Route::get('/forgotpassword', function () {return view('forgotpassword');});

Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');

Route::get('/product-detail/{id}', function ($id) {
    $details = DB::table('product as p')
        ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
        ->join('product_color as pc', 'pv.color_id', '=', 'pc.id')
        ->select('p.name', 'pc.color_name', 'pv.size', 'pv.stock')
        ->where('p.id', $id)
        ->get();

    // Ambil nama produk dari data pertama (anggap pasti ada)
    $productName = $details->isNotEmpty() ? $details[0]->name : 'Produk tidak ditemukan';

    return response()->json([
        'productName' => $productName,
        'variants' => $details
    ]);
});
