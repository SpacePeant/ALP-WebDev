<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }
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
        ->select('p.id', 'p.name', DB::raw('SUM(pv.stock) as total_stock'))
        ->where('p.status', 'active')
        ->where('pv.stock', '>', 0)
        ->groupBy('p.id', 'p.name')
        ->orderByDesc('total_stock')
        ->get();

    $bestSellers = DB::table('order_details as od')
        ->join('product as p', 'od.product_id', '=', 'p.id')
        ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
        ->groupBy('p.name')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

    return view('dashboard', compact('data', 'balance', 'totalSold', 'stockAvailable', 'productStock', 'bestSellers'));
}

public function dett($id)
    {
        $details = DB::table('product as p')
            ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
            ->join('product_color as pc', 'pv.color_id', '=', 'pc.id')
            ->select('p.id as pid', 'p.name', 'pc.color_name', 'pv.size', 'pv.stock')
            ->where('p.id', $id)
            ->get();
dd($details);
        return response()->json([
            'productName' => $details->isNotEmpty() ? $details[0]->name : 'Produk tidak ditemukan',
            'variants' => $details
        ]);
    }

public function getData(Request $request)
{
    $filter = $request->get('filter', 'week'); 
    $balanceMonth = $balanceWeek = $balanceYear = 0;
    $totalSoldMonth = $totalSoldWeek = $totalSoldYear = 0;
    $bestSellersMonth = $bestSellersWeek = $bestSellersYear = collect();

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

    if ($filter === 'month') {
        $data = DB::select("
            WITH week_numbers AS (
                SELECT 1 AS week_of_month UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5
            ),
            sales_per_week AS (
                SELECT 
                    WEEK(o.order_date, 1) - WEEK(DATE_SUB(o.order_date, INTERVAL DAY(o.order_date) - 1 DAY), 1) + 1 AS week_of_month,
                    SUM(p.price * od.quantity) AS total
                FROM order_details od
                LEFT JOIN orders o ON o.id = od.order_id
                LEFT JOIN product p ON p.id = od.product_id
                WHERE MONTH(o.order_date) = MONTH(CURDATE()) AND YEAR(o.order_date) = YEAR(CURDATE())
                GROUP BY week_of_month
            )
            SELECT 
                w.week_of_month,
                COALESCE(s.total, 0) AS total
            FROM week_numbers w
            LEFT JOIN sales_per_week s ON w.week_of_month = s.week_of_month
            ORDER BY w.week_of_month;
        ");
        $labels = array_column($data, 'week_of_month');
        $values = array_column($data, 'total');

        $data = [
        'labels' => $labels,
        'sales' => $values,
        ];
        

        $balanceMonth = DB::table('orders')
        ->whereNotNull('payment_url')
        ->whereMonth('order_date', now()->month)
        ->whereYear('order_date', now()->year)
        ->sum('total_amount');

        $totalSoldMonth = DB::table('order_details as od')
        ->join('orders as o', 'od.order_id', '=', 'o.id')
        ->whereMonth('o.order_date', now()->month)
        ->whereYear('o.order_date', now()->year)
        ->sum('od.quantity');

        $bestSellersMonth = DB::table('order_details as od')
        ->join('orders as o', 'od.order_id', '=', 'o.id')
        ->join('product as p', 'od.product_id', '=', 'p.id')
        ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
        ->whereMonth('o.order_date', now()->month)
        ->whereYear('o.order_date', now()->year)
        ->groupBy('p.name')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();
    } elseif ($filter === 'week') {
        $data = DB::select("
            WITH days_of_week AS (
                SELECT 'Monday' AS day_name UNION ALL
                SELECT 'Tuesday' UNION ALL
                SELECT 'Wednesday' UNION ALL
                SELECT 'Thursday' UNION ALL
                SELECT 'Friday' UNION ALL
                SELECT 'Saturday' UNION ALL
                SELECT 'Sunday'
            ),
            sales_per_day AS (
                SELECT 
                    DAYNAME(o.order_date) AS day_name,
                    SUM(p.price * od.quantity) AS total
                FROM order_details od
                LEFT JOIN orders o ON o.id = od.order_id
                LEFT JOIN product p ON p.id = od.product_id
                WHERE YEARWEEK(o.order_date, 1) = YEARWEEK(CURDATE(), 1)
                GROUP BY DAYNAME(o.order_date)
            )
            SELECT 
                d.day_name,
                COALESCE(s.total, 0) AS total
            FROM days_of_week d
            LEFT JOIN sales_per_day s ON d.day_name = s.day_name
            ORDER BY FIELD(d.day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        ");
        $labels = array_column($data, 'day_name');
        $values = array_column($data, 'total');

        $data = [
        'labels' => $labels,
        'sales' => $values,
        ];

        $balanceWeek = DB::table('orders')
        ->whereNotNull('payment_url')
        ->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()])
        ->sum('total_amount');

        $totalSoldWeek = DB::table('order_details as od')
        ->join('orders as o', 'od.order_id', '=', 'o.id')
        ->whereBetween('o.order_date', [now()->startOfWeek(), now()->endOfWeek()])
        ->sum('od.quantity');

        $bestSellersWeek = DB::table('order_details as od')
        ->join('orders as o', 'od.order_id', '=', 'o.id')
        ->join('product as p', 'od.product_id', '=', 'p.id')
        ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
        ->whereBetween('o.order_date', [now()->startOfWeek(), now()->endOfWeek()])
        ->groupBy('p.name')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();
    } else {
        $data = DB::select("
            WITH months AS (
                SELECT 1 AS month_num, 'January' AS month_name UNION ALL
                SELECT 2, 'February' UNION ALL
                SELECT 3, 'March' UNION ALL
                SELECT 4, 'April' UNION ALL
                SELECT 5, 'May' UNION ALL
                SELECT 6, 'June' UNION ALL
                SELECT 7, 'July' UNION ALL
                SELECT 8, 'August' UNION ALL
                SELECT 9, 'September' UNION ALL
                SELECT 10, 'October' UNION ALL
                SELECT 11, 'November' UNION ALL
                SELECT 12, 'December'
            ),
            sales_per_month AS (
                SELECT 
                    MONTH(o.order_date) AS month_num,
                    SUM(p.price * od.quantity) AS total
                FROM order_details od
                LEFT JOIN orders o ON o.id = od.order_id
                LEFT JOIN product p ON p.id = od.product_id
                WHERE YEAR(o.order_date) = YEAR(CURDATE())
                GROUP BY MONTH(o.order_date)
            )
            SELECT 
                m.month_name,
                COALESCE(s.total, 0) AS total
            FROM months m
            LEFT JOIN sales_per_month s ON m.month_num = s.month_num
            ORDER BY m.month_num;
        ");
        $labels = array_column($data, 'month_name');
        $values = array_column($data, 'total');

        $data = [
        'labels' => $labels,
        'sales' => $values,
        ];

        $balanceYear = DB::table('orders')
        ->whereNotNull('payment_url')
        ->whereYear('order_date', now()->year)
        ->sum('total_amount');

        $totalSoldYear = DB::table('order_details as od')
        ->join('orders as o', 'od.order_id', '=', 'o.id')
        ->whereYear('o.order_date', now()->year)
        ->sum('od.quantity');

        $bestSellersYear = DB::table('order_details as od')
        ->join('orders as o', 'od.order_id', '=', 'o.id')
        ->join('product as p', 'od.product_id', '=', 'p.id')
        ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
        ->whereYear('o.order_date', now()->year)
        ->groupBy('p.name')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();
    }

    return response()->json([
    'data' => $data,
    'balance' => $filter === 'month' ? $balanceMonth : ($filter === 'week' ? $balanceWeek : $balanceYear),
    'totalSold' => $filter === 'month' ? $totalSoldMonth : ($filter === 'week' ? $totalSoldWeek : $totalSoldYear),
    'stockAvailable' => $stockAvailable,
    'productStock' => $productStock,
    'bestSellers' => $filter === 'month' ? $bestSellersMonth : ($filter === 'week' ? $bestSellersWeek : $bestSellersYear),
]);
}
}