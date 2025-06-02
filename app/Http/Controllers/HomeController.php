<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        if (!session()->has('user_id')) {
        return redirect('/login');
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

        return view('home', [
            'topProduct' => $topProducts
        ]);
    }
}
