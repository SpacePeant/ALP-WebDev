<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
}


==============================
GENERAL & LANDING PAGE ROUTES
==============================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/forgotpassword', fn() => view('forgotpassword'));

Route::get('/signup', [RegisterController::class, 'show'])->name('signup.form');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');

Route::middleware(['auth'])->group(function () {
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
    Route::get('/payment/return/{id}', [PaymentController::class, 'handleReturn'])->name('payment.return');
    Route::get('/payment/status/{id}', [PaymentController::class, 'checkStatus'])->name('payment.status');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order', [OrderController::class, 'index'])->name('order');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Detail
    Route::get('detail_sepatu/{id}', [ProductController::class, 'show'])->name('detail_sepatu.show');

    // Blog & Article
    Route::get('/blog', [BlogController::class, 'showBlogPage'])->name('blog');
    Route::get('/load-more-blogs', [BlogController::class, 'loadMoreBlogs']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);

    Route::match(['get', 'post'], '/detail', [CollectionController::class, 'detail'])->name('detail');
    Route::get('/product-list', [CollectionController::class, 'productList'])->name('product.list');

    // Review
    Route::post('/detail_sepatu/{id}/add-review', [ProductController::class, 'addReview'])->name('product.addReview');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Features
    // Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard/filter', [ChartController::class, 'getData']);
    // Route::get('/dashboard/sort-stock', [ProductController::class, 'sortStock']);

    // Product Management
    Route::get('/products', [ProductController::class, 'index'])->name('productadmin');
    Route::get('/products/create', [ProductController::class, 'create'])->name('addproduct');
    Route::post('/products/store', [ProductController::class, 'store'])->name('addproduct.store');
    Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('productadmin.delete');
    Route::get('/product/{id}/edit/{color_id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::post('/product/update-gambar', [ProductController::class, 'update_gambar'])->name('product.update_gambar');
    Route::get('/product_list', [ProductController::class, 'index'])->name('product.list');
    Route::get('/product-detail/{id}', function ($id) {
        $details = DB::table('product as p')
            ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
            ->join('product_color as pc', 'pv.color_id', '=', 'pc.id')
            ->select('p.id as pid', 'p.name', 'pc.color_name', 'pv.size', 'pv.stock')
            ->where('p.id', $id)
            ->get();

        Log::info("Product ID: $id");
        Log::info("Details count: " . $details->count());

        return response()->json([
            'productName' => $details->isNotEmpty() ? $details[0]->name : 'Produk tidak ditemukan',
            'variants' => $details
        ]);
    });
    Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.detail');
    Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');

    // Orders
    Route::get('/orderadmin', [OrderController::class, 'adminIndex'])->name('orderadmin');
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::get('/admin/orders/filter', [OrderController::class, 'filterAjax'])->name('admin.orders.filter');

    // Report & Chart
    Route::get('/report', fn() => view('report-menu'))->name('report');
    Route::get('/report/sales', [ReportController::class, 'salesReport'])->name('report.sales');
    Route::get('/report/sales/pdf', [ReportController::class, 'downloadPDF'])->name('report.sales.pdf');
    Route::get('/report/sales/data', [ReportController::class, 'fetchSalesTable'])->name('report.sales.data');

    // Article (Admin View)
    Route::get('/admin/blogs', [ArticleController::class, 'showAdmin'])->name('showadmin');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/admin/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
});
    });
});


require _DIR_.'/auth.php';



Route::middleware(['auth', 'role:customer'])->group(function () {
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