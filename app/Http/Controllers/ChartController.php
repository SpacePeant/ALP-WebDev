<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // Bisa juga data dikirim dari DB lewat model, tapi disini kita pakai statis dulu
        $data = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'sales' => [5, 9, 7, 12, 8, 15, 10],
        ];

        return view('dashboard', compact('data'));
    }

    public function indexDashboard()
{
    $balance = DB::table('product_variant as pv')
        ->join('product as p', 'pv.product_id', '=', 'p.id')
        ->where('p.status', 'active')
        ->select(DB::raw('SUM(p.price * pv.stock) as balance'))
        ->value('balance');

    $totalSold = DB::table('order_details as od')
        ->sum('od.quantity');

    $stockAvailable = DB::table('product_variant as pv')
        ->join('product as p', 'pv.product_id', '=', 'p.id')
        ->where('p.status', 'active')
        ->sum('pv.stock');

   $productStock = DB::table('product as p')
    ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
    ->select('p.name', DB::raw('SUM(pv.stock) as total_stock'))
    ->where('pv.stock', '>', 0)
    ->groupBy('p.name')
    ->orderByDesc('total_stock')
    ->get();

    // Dummy best seller
    $bestSellers = DB::table('order_details as od')
    ->join('product as p', 'od.product_id', '=', 'p.id')
    ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
    ->groupBy('p.name')
    ->orderByDesc('total_sold')
    ->limit(3)
    ->get();

    return view('dashboard', compact('balance', 'totalSold', 'stockAvailable', 'productStock', 'bestSellers'));
}

public function chart() {
    $today = Carbon::today();

    // Ambil data penjualan 7 hari terakhir
    $sales = DB::table('orders')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
        ->whereBetween('created_at', [Carbon::now()->subDays(6), $today])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Format ke array untuk Chart.js
    $labels = [];
    $data = [];

    foreach ($sales as $sale) {
        $labels[] = Carbon::parse($sale->date)->format('D'); // Contoh: "Mon", "Tue"
        $data[] = $sale->total;
    }

    return view('dashboard', [
        'labels' => $labels,
        'data' => $data,
        // ...data lainnya seperti $balance, $stockAvailable dll
    ]);
}


}