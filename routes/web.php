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

// ==============================
// GENERAL & LANDING PAGE ROUTES
// ==============================
Route::get('', fn() => view('auth.login'));
Route::get('/forgotpassword', fn() => view('forgotpassword'));

// ==============================
// AUTH ROUTES
// ==============================
Route::get('/signup', [RegisterController::class, 'show'])->name('signup.form');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');



// ==============================
// ROUTES: USER AUTHENTICATED
// ==============================
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Email Verified Required
    Route::middleware(['verified'])->group(function () {
        Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/dashboard/filter', [ChartController::class, 'getData']);
        Route::get('/dashboard/sort-stock', [ProductController::class, 'sortStock']);
    });

    // Role: Customer Only
    Route::middleware(['role:customer'])->group(function () {
        // Cart
        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('cart');
            Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
            Route::post('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
            Route::post('/update-pilih', [CartController::class, 'updatePilih'])->name('cart.update_pilih');
            Route::post('/update-size', [CartController::class, 'updateSize'])->name('cart.updateSize');
            Route::get('/sizes', [CartController::class, 'getAvailableSizes']);
        });

        // Wishlist
        Route::prefix('wishlist')->group(function () {
            Route::get('/', [WishlistController::class, 'index'])->name('wishlist');
            Route::post('/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
            Route::post('/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
            Route::post('/delete', [WishlistController::class, 'removeFromWishlist']);
            Route::get('/check/{productId}', [WishlistController::class, 'isWishlisted'])->name('wishlist.check');
            Route::post('/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        });

        // Checkout & Payment
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('checkout.updateQuantity');
        Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.payNow');
        Route::get('/payment/status/{id}', [PaymentController::class, 'checkStatus'])->name('payment.status');
        Route::get('/payment/return/{id}', [PaymentController::class, 'handleReturn'])->name('payment.return');
        Route::post('/detail_sepatu/{id}/add-review', [ProductController::class, 'addReview'])->name('product.addReview');

        // ==============================
        // PUBLIC PRODUCT & COLLECTION
        // ==============================
        Route::get('/product-list', [CollectionController::class, 'productList'])->name('product.list');
        Route::match(['get', 'post'], '/detail', [CollectionController::class, 'detail'])->name('detail');
        Route::get('/product-detail/{id}', function ($id) {
            $details = DB::table('product as p')
                ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
                ->join('product_color as pc', 'pv.color_id', '=', 'pc.id')
                ->select('p.id as pid', 'p.name', 'pc.color_name', 'pv.size', 'pv.stock')
                ->where('p.id', $id)
                ->get();

            return response()->json([
                'productName' => $details->isNotEmpty() ? $details[0]->name : 'Produk tidak ditemukan',
                'variants' => $details
            ]);
        });

        // ==============================
        // BLOG & ARTICLE
        // ==============================
        Route::get('/blog', [BlogController::class, 'showBlogPage'])->name('blog');
        Route::get('/load-more-blogs', [BlogController::class, 'loadMoreBlogs']);
        Route::get('/articles/{id}', [ArticleController::class, 'show']);

        // Product
        Route::get('detail_sepatu/{id}', [ProductController::class, 'show'])->name('detail_sepatu.show');

        // ==============================
        // ORDER
        // ==============================
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/order', [OrderController::class, 'index'])->name('order');

        // Home
        Route::get('/about-us', fn() => view('aboutus'))->name('about');
        Route::get('/collection', fn() => view('collection'))->name('collection');
    });

    // Role: Admin Only
    Route::middleware(['role:admin'])->group(function () {
        // Report
         Route::get('/report', fn() => view('report-menu'))->name('report');
        Route::prefix('report/sales')->group(function () {
            Route::get('/', [ReportController::class, 'salesReport'])->name('report.sales');
            Route::get('/pdf', [ReportController::class, 'downloadPDF'])->name('report.sales.pdf');
            Route::get('/data', [ReportController::class, 'fetchSalesTable'])->name('report.sales.data');
        });
        Route::get('/reportt', [ReportController::class, 'getData']);

         // ==============================
        // BLOG & ARTICLE
        // ==============================
        Route::get('/admin/blogs', [ArticleController::class, 'showAdmin'])->name('showadmin');
        Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/admin/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
        Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');

        // Order
        Route::get('/orderadmin', [OrderController::class, 'adminIndex'])->name('orderadmin');
        Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
        Route::get('/admin/orders/filter', [OrderController::class, 'filterAjax'])->name('admin.orders.filter');

        // ==============================
        // PRODUCT (ADMIN & PUBLIC)
        // ==============================
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('productadmin');
            Route::get('/create', [ProductController::class, 'create'])->name('addproduct');
            Route::post('/store', [ProductController::class, 'store'])->name('addproduct.store');
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('productadmin.delete');
        });
        Route::get('/product/{id}/edit/{color_id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product/update-gambar', [ProductController::class, 'update_gambar'])->name('product.update_gambar');
        Route::get('/product/{color_id}', [ProductController::class, 'getVariants']);
        Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');
        Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.detail');
        Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');
    });
});

Route::post('/midtrans/webhook', [CheckoutController::class, 'handleMidtransWebhook']);
require __DIR__.'/auth.php';