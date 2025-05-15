<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;

Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/collection', [PageController::class, 'collection'])->name('collection');
Route::get('/wishlist', [PageController::class, 'wishlist'])->name('wishlist');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about-us', function () {
    return view('aboutus');
})->name('about');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/collection', function () {
    return view('collection');
})->name('collection');