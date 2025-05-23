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
                c.name as customer_name,
                p.name as product_name,
                pc.color_name as color,
                pv.size as size,
                DATE(od.created_at) AS date,
                od.quantity AS quantity,
                p.price as price,
                (p.price * od.quantity) as total
            FROM order_details od
            LEFT JOIN orders o ON o.id = od.order_id
            LEFT JOIN customers c ON c.id = o.customer_id
            LEFT JOIN product p ON p.id = od.product_id
            LEFT JOIN product_color pc ON pc.id = od.product_color_id
            LEFT JOIN product_variant pv ON pv.id = od.product_variant_id
            WHERE od.created_at BETWEEN ? AND ?
            GROUP BY c.name, p.name, pc.color_name, pv.size, date, od.quantity, p.price
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
    $start = $request->query('start_date');
    $end = $request->query('end_date');

    $sales = DB::select("
        SELECT 
            c.name as customer_name,
            p.name as product_name,
            pc.color_name as color,
            pv.size as size,
            DATE(od.created_at) AS date,
            od.quantity AS quantity,
            p.price as price,
            (p.price * od.quantity) as total
        FROM order_details od
        LEFT JOIN orders o ON o.id = od.order_id
        LEFT JOIN customers c ON c.id = o.customer_id
        LEFT JOIN product p ON p.id = od.product_id
        LEFT JOIN product_color pc ON pc.id = od.product_color_id
        LEFT JOIN product_variant pv ON pv.id = od.product_variant_id
        WHERE od.created_at BETWEEN ? AND ?
        GROUP BY c.name, p.name, pc.color_name, pv.size, date, od.quantity, p.price
        ORDER BY date
    ", [$start, $end]);

    $pdf = Pdf::loadView('report', [
        'sales' => $sales,
        'start' => $start,
        'end' => $end
    ])->setPaper('A4', 'landscape');

    return $pdf->download("laporan-penjualan-{$start}-sampai-{$end}.pdf");
}

public function fetchSalesTable(Request $request)
{
    $start = $request->start_date;
    $end = $request->end_date;

    $sales = DB::select("
        SELECT 
            c.name as customer_name,
            p.name as product_name,
            pc.color_name as color,
            pv.size as size,
            DATE(od.created_at) AS date,
            od.quantity AS quantity,
            p.price as price,
            (p.price * od.quantity) as total
        FROM order_details od
        LEFT JOIN orders o ON o.id = od.order_id
        LEFT JOIN customers c ON c.id = o.customer_id
        LEFT JOIN product p ON p.id = od.product_id
        LEFT JOIN product_color pc ON pc.id = od.product_color_id
        LEFT JOIN product_variant pv ON pv.id = od.product_variant_id
        WHERE od.created_at BETWEEN ? AND ?
        GROUP BY c.name, p.name, pc.color_name, pv.size, date, od.quantity, p.price
        ORDER BY date
    ", [$start, $end]);

    return view('partials.sales-table', compact('sales'))->render();
}

}
