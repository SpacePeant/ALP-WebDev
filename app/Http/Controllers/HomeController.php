<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        if (!session()->has('user_id')) {
        return redirect('/login');
        }

        if (Auth::user()->role !== 'customer') {
            return redirect()->route('dashboard');
        }
    
        $topProducts = DB::table('order_details as od')
            ->leftJoin('product as p', 'p.id', '=', 'od.product_id')
            ->leftJoin('product_color as pc', function ($join) {
                $join->on('pc.product_id', '=', 'p.id')
                     ->where('pc.is_primary', true);
            })
            ->leftJoin('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                'p.price',
                'pc.color_code_bg',
                'pc.color_font',
                'pci.image_kiri',
                DB::raw('SUM(od.quantity) as total_quantity')
            )
            ->where('pc.status', 'active')
            ->groupBy(
                'p.id',
                'p.name',
                'p.price',
                'pc.color_code_bg',
                'pc.color_font',
                'pci.image_kiri'
            )
            ->orderByDesc('total_quantity')
            ->limit(4)
            ->get();

        $newestProduct = DB::table('product as p')
        ->join('product_color as pc', 'p.id', '=', 'pc.product_id')
        ->join('product_color_image as pci', 'pc.id', '=', 'pci.color_id')
        ->where('pc.is_primary', 1)
        ->orderByDesc('p.id')
        ->select('p.id', 'p.name', 'pci.image_kiri', 'pc.color_code_bg', 'pc.color_font')
        ->first();
        return view('home', [
            'topProduct' => $topProducts,
            'newestProduct' => $newestProduct
        ]);
    }
}