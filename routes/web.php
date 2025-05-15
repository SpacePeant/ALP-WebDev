<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CollectionController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/home', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
});

Route::get('/orderadmin', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('admin.order');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/', function () {
    return view('home');
});

Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/detail', [CollectionController::class, 'detail'])->name('collection.detail');

Route::post('/add-to-cart', [CartController::class, 'store'])->name('cart.store');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('detail_sepatu/{id}', [ProductController::class, 'show'])->name('detail_sepatu.show');

Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');




