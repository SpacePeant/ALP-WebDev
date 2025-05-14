<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        return view('home');
    }

    public function about() {
        return view('aboutus');
    }

    public function collection() {
        return view('collection');
    }

    public function wishlist() {
        return view('wishlist');
    }

    public function cart() {
        return view('cart');
    }
}

