<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
            // Sales Chart Data
    $startDate = Carbon::now()->subDays(6)->startOfDay();
    $endDate = Carbon::now()->endOfDay();

    $rawSales = DB::table('order_details')
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(quantity) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $labels = [];
    $salesMap = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        $labels[] = $date->format('D');
        $salesMap[$date->toDateString()] = 0;
    }

    foreach ($rawSales as $sale) {
        $salesMap[$sale->date] = $sale->total;
    }

    $data = [
        'labels' => $labels,
        'sales' => array_values($salesMap),
    ];

    // Informasi lainnya
    $balance = DB::table('orders')
    ->whereNotNull('payment_url')
    ->sum('total_amount');

    $totalSold = DB::table('order_details as od')->sum('od.quantity');

    $stockAvailable = DB::table('product_variant as pv')
        ->join('product as p', 'pv.product_id', '=', 'p.id')
        ->where('p.status', 'active')
        ->sum('pv.stock');

    $productStock = DB::table('product as p')
        ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
        ->select('p.name', DB::raw('SUM(pv.stock) as total_stock'))
        ->where('p.status', 'active')
        ->where('pv.stock', '>', 0)
        ->groupBy('p.name')
        ->orderByDesc('total_stock')
        ->get();

    $bestSellers = DB::table('order_details as od')
        ->join('product as p', 'od.product_id', '=', 'p.id')
        ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
        ->groupBy('p.name')
        ->orderByDesc('total_sold')
        ->limit(3)
        ->get();

    return view('dashboard', compact('data', 'balance', 'totalSold', 'stockAvailable', 'productStock', 'bestSellers'));
}
}