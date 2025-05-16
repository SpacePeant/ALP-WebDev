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

Route::get('/home', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
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

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('detail_sepatu/{id}', [ProductController::class, 'show'])->name('detail_sepatu.show');


Route::get('/orderadmin', [OrderController::class, 'adminIndex'])->name('orderadmin');

Route::get('/products', [ProductController::class, 'index'])->name('productadmin');
Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('productadmin.delete');

Route::get('/products/create', [ProductController::class, 'create'])->name('addproduct');
Route::post('/products/store', [ProductController::class, 'store'])->name('addproduct.store');

Route::get('/product/{id}/edit/{color_id}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');








