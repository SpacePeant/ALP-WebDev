<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!session()->has('user_id')) return redirect('/login');
    return view('home');
});

use App\Http\Controllers\AuthController;

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

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/', function () {
    return view('home');
});