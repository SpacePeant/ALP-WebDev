<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChartController;
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

Route::get('', function () {
    return view('auth.login');
});
Route::get('/about-us', fn() => view('aboutus'))->name('about');
Route::get('/collection', fn() => view('collection'))->name('collection');
Route::get('/report', fn() => view('report-menu'))->name('report');
Route::get('/forgotpassword', fn() => view('forgotpassword'));

// ==============================
// AUTH & USER ROUTES
// ==============================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/forgotpassword', fn() => view('forgotpassword'));

Route::get('/signup', [RegisterController::class, 'show'])->name('signup.form');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');

// Home
    

Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hanya bisa diakses jika sudah verifikasi email
    Route::middleware(['verified'])->group(function () {
        // Home & Dashboard
        Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // Dashboard Features
        Route::get('/dashboard/filter', [ChartController::class, 'getData']);
        Route::get('/dashboard/sort-stock', [ProductController::class, 'sortStock']);

        Route::middleware(['auth', 'role:customer'])->group(function () {
    // Home
    Route::get('/about-us', fn() => view('aboutus'))->name('about');
    Route::get('/collection', fn() => view('collection'))->name('collection');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/update-pilih', [CartController::class, 'updatePilih'])->name('cart.update_pilih');
    Route::post('/cart/update-size', [CartController::class, 'updateSize'])->name('cart.updateSize');
    Route::get('/cart/sizes', [CartController::class, 'getAvailableSizes']);

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::post('/wishlist/delete', [WishlistController::class, 'removeFromWishlist']);
    Route::get('/wishlist/check/{productId}', [WishlistController::class, 'isWishlisted'])->name('wishlist.check');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout & Payment
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('checkout.updateQuantity');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.payNow');
    Route::get('/payment/return/{order}', [PaymentController::class, 'handleReturn'])->name('payment.return');
    Route::get('/payment/status/{order}', [PaymentController::class, 'checkStatus'])->name('payment.status');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order', [OrderController::class, 'index'])->name('order');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Features
    Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter', [ChartController::class, 'getData']);
    Route::get('/dashboard/sort-stock', [ProductController::class, 'sortStock']);

    // Product Management
    Route::get('/products', [ProductController::class, 'index'])->name('productadmin');
    Route::get('/products/create', [ProductController::class, 'create'])->name('addproduct');
    Route::post('/products/store', [ProductController::class, 'store'])->name('addproduct.store');
    Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('productadmin.delete');
    Route::get('/product/{id}/edit/{color_id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::post('/product/update-gambar', [ProductController::class, 'update_gambar'])->name('product.update_gambar');
    Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');

    // Orders
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::get('/admin/orders/filter', [OrderController::class, 'filterAjax'])->name('admin.orders.filter');

    // Report & Chart
    Route::get('/report/sales', [ReportController::class, 'salesReport'])->name('report.sales');
    Route::get('/report/sales/pdf', [ReportController::class, 'downloadPDF'])->name('report.sales.pdf');
    Route::get('/report/sales/data', [ReportController::class, 'fetchSalesTable'])->name('report.sales.data');

    // Article (Admin View)
    Route::get('/admin/blogs', [ArticleController::class, 'showAdmin'])->name('showadmin');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/admin/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

Route::post('/detail_sepatu/{id}/add-review', [ProductController::class, 'addReview'])->name('product.addReview');