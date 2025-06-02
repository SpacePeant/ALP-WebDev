<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function salesReport(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $sales = [];

    if ($startDate && $endDate) {
        $sales = DB::select("
            SELECT 
                u.name as customer_name,
                p.name as product_name,
                pc.color_name as color,
                pv.size as size,
                DATE(od.created_at) AS date,
                od.quantity AS quantity,
                p.price as price,
                (p.price * od.quantity) as total
            FROM order_details od
            LEFT JOIN orders o ON o.id = od.order_id
            LEFT JOIN users u ON u.id = o.user_id
            LEFT JOIN product p ON p.id = od.product_id
            LEFT JOIN product_color pc ON pc.id = od.product_color_id
            LEFT JOIN product_variant pv ON pv.id = od.product_variant_id
            WHERE od.created_at BETWEEN ? AND ?
            GROUP BY u.name, p.name, pc.color_name, pv.size, date, od.quantity, p.price
            ORDER BY date
        ", [$startDate, $endDate]);
    }

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

    return view('dashboard', compact('data', 'balance', 'totalSold', 'stockAvailable', 'productStock', 'bestSellers', 'sales', 'startDate', 'endDate'));
}

public function downloadPDF(Request $request)
{
    $year = $request->query('year');
    $month = $request->query('month'); // bisa kosong/null

    if (!$year) {
        abort(400, 'Year parameter is required');
    }

    $sql = "
        SELECT 
            u.name as customer_name,
            p.name as product_name,
            pc.color_name as color,
            pv.size as size,
            DATE(od.created_at) AS date,
            od.quantity AS quantity,
            p.price as price,
            (p.price * od.quantity) as total
        FROM order_details od
        LEFT JOIN orders o ON o.id = od.order_id
        LEFT JOIN users u ON u.id = o.user_id
        LEFT JOIN product p ON p.id = od.product_id
        LEFT JOIN product_color pc ON pc.id = od.product_color_id
        LEFT JOIN product_variant pv ON pv.id = od.product_variant_id
        WHERE YEAR(o.order_date) = ?
    ";

    $params = [$year];

    if ($month) {
        $sql .= " AND MONTH(o.order_date) = ? ";
        $params[] = $month;
    }

    $sql .= "
        GROUP BY u.name, p.name, pc.color_name, pv.size, date, od.quantity, p.price
        ORDER BY date
    ";

    $sales = DB::select($sql, $params);

    $filename = "laporan-penjualan-{$year}";
    if ($month) {
        $filename .= "-{$month}";
    }
    $filename .= ".pdf";

    $pdf = Pdf::loadView('report', [
        'sales' => $sales,
        'year' => $year,
        'month' => $month,
    ])->setPaper('A4', 'landscape');

    
    return $pdf->download($filename);
    //     return view('report', [
    //     'sales' => $sales,
    //     'start' => $start,
    //     'end' => $end
    // ]);
}

public function fetchSalesTable(Request $request)
{
    $start = $request->start_date;
    $end = $request->end_date;

    $sales = DB::select("
        SELECT 
            u.name as customer_name,
            p.name as product_name,
            pc.color_name as color,
            pv.size as size,
            DATE(od.created_at) AS date,
            od.quantity AS quantity,
            p.price as price,
            (p.price * od.quantity) as total
        FROM order_details od
        LEFT JOIN orders o ON o.id = od.order_id
        LEFT JOIN users c ON c.id = o.user_id
        LEFT JOIN product p ON p.id = od.product_id
        LEFT JOIN product_color pc ON pc.id = od.product_color_id
        LEFT JOIN product_variant pv ON pv.id = od.product_variant_id
        WHERE od.created_at BETWEEN ? AND ?
        GROUP BY u.name, p.name, pc.color_name, pv.size, date, od.quantity, p.price
        ORDER BY date
    ", [$start, $end]);

    return view('partials.sales-table', compact('sales'))->render();
}
public function getData(Request $request)
{
    $year = $request->get('year');
    $month = $request->get('month');

    // Validasi input
    if (!$year) {
        return response()->json(['error' => 'Year is required.'], 400);
    }

    // Inisialisasi data
    $labels = [];
    $values = [];
    $balance = 0;
    $totalSold = 0;
    $bestSellers = collect();

    // Menghitung stock yang tersedia
    $stockAvailable = DB::table('product_variant as pv')
        ->join('product as p', 'pv.product_id', '=', 'p.id')
        ->where('p.status', 'active')
        ->sum('pv.stock');

    // Mengambil data stock per produk
    $productStock = DB::table('product as p')
        ->join('product_variant as pv', 'p.id', '=', 'pv.product_id')
        ->select('p.name', DB::raw('SUM(pv.stock) as total_stock'))
        ->where('p.status', 'active')
        ->where('pv.stock', '>', 0)
        ->groupBy('p.name')
        ->orderByDesc('total_stock')
        ->get();

    if ($month) {
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
                WHERE MONTH(o.order_date) = ? AND YEAR(o.order_date) = ?
                GROUP BY week_of_month
            )
            SELECT 
                w.week_of_month,
                COALESCE(s.total, 0) AS total
            FROM week_numbers w
            LEFT JOIN sales_per_week s ON w.week_of_month = s.week_of_month
            ORDER BY w.week_of_month;
        ", [$month, $year]);

        $labels = array_map(function($week) {
            return 'Week ' . $week;
        }, array_column($data, 'week_of_month'));
        $values = array_column($data, 'total');

        // Menghitung balance dan total penjualan untuk bulan tersebut
        $balance = DB::table('orders')
            ->whereNotNull('payment_url')
            ->whereMonth('order_date', $month)
            ->whereYear('order_date', $year)
            ->sum('total_amount');

        $totalSold = DB::table('order_details as od')
            ->join('orders as o', 'od.order_id', '=', 'o.id')
            ->whereMonth('o.order_date', $month)
            ->whereYear('o.order_date', $year)
            ->sum('od.quantity');

        $bestSellers = DB::table('order_details as od')
            ->join('orders as o', 'od.order_id', '=', 'o.id')
            ->join('product as p', 'od.product_id', '=', 'p.id')
            ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
            ->whereMonth('o.order_date', $month)
            ->whereYear('o.order_date', $year)
            ->groupBy('p.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    } else {
        // Jika hanya tahun yang dipilih, tampilkan data per bulan dalam tahun tersebut
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
                WHERE YEAR(o.order_date) = ?
                GROUP BY MONTH(o.order_date)
            )
            SELECT 
                m.month_name,
                COALESCE(s.total, 0) AS total
            FROM months m
            LEFT JOIN sales_per_month s ON m.month_num = s.month_num
            ORDER BY m.month_num;
        ", [$year]);

        $labels = array_column($data, 'month_name');
        $values = array_column($data, 'total');

        // Menghitung balance dan total penjualan untuk tahun tersebut
        $balance = DB::table('orders')
            ->whereNotNull('payment_url')
            ->whereYear('order_date', $year)
            ->sum('total_amount');

        $totalSold = DB::table('order_details as od')
            ->join('orders as o', 'od.order_id', '=', 'o.id')
            ->whereYear('o.order_date', $year)
            ->sum('od.quantity');

        $bestSellers = DB::table('order_details as od')
            ->join('orders as o', 'od.order_id', '=', 'o.id')
            ->join('product as p', 'od.product_id', '=', 'p.id')
            ->select('p.name', DB::raw('SUM(od.quantity) as total_sold'))
            ->whereYear('o.order_date', $year)
            ->groupBy('p.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    }

    return response()->json([
        'data' => [
            'labels' => $labels,
            'sales' => $values,
        ],
        'balance' => $balance,
        'totalSold' => $totalSold,
        'stockAvailable' => $stockAvailable,
        'productStock' => $productStock,
        'bestSellers' => $bestSellers,
    ]);
}
}
