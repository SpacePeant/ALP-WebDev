<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{public function adminIndex(Request $request)
        {
        // Ambil semua order (ringkasan)
        $orders = DB::table('orders as o')
    ->join('order_details as od', 'o.id', '=', 'od.order_id')
    ->join('customers as c', 'o.customer_id', '=', 'c.id')
    ->select(
        'o.*',
        'c.name as customer_name',
        'c.address as customer_address',
        'c.phone_number',
        DB::raw('COUNT(od.product_id) as item_count'),
        DB::raw('SUM(od.unit_price * od.quantity) as total'),
        'o.payment_method' // tambahkan ini
    )
    ->groupBy(
        'o.id', 'c.name', 'c.phone_number', 'o.status', 
        'o.customer_id', 'o.created_at', 'o.updated_at', 
        'c.address', 'o.payment_method' // pastikan semua kolom yang dipilih dimasukkan di groupBy
    )
    ->orderByDesc('o.id')
    ->get();

        $orderDetails = [];

        foreach ($orders as $order) {
            $orderId = $order->id;

            $details = DB::table('order_details as od')
                ->join('product as p', 'od.product_id', '=', 'p.id')
                ->join('product_variant as pv', 'od.product_variant_id', '=', 'pv.id')
                ->join('product_color as pc', 'od.product_color_id', '=', 'pc.id')
                ->join('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
                ->select('p.name', 'pci.image_kiri', 'pc.color_name', 'pv.size', 'od.quantity', 'p.price')
                ->where('od.order_id', $orderId)
                ->get();

            $orderDetails[$orderId] = $details;
        }


        // Stat count
        $completedOrders = DB::table('orders')->where('status', 'Completed')->count();
        $pendingOrders = DB::table('orders')->where('status', 'Pending')->count();

        return view('orderadmin', compact('orders', 'orderDetails', 'completedOrders', 'pendingOrders', 'orderId'));
    }
    
    public function index(Request $request)
{
    $customer_id = Session::get('user_id') ?? $request->query('user_id', 1);

    // Ambil data orders dan ringkasannya, plus info customer & payment_method
    $orders = DB::table('orders as o')
        ->join('order_details as od', 'o.id', '=', 'od.order_id')
        ->join('customers as c', 'o.customer_id', '=', 'c.id')
        ->select(
            'o.*',
            'c.name as customer_name',
            'c.phone_number as customer_phone',
            'c.address as customer_address',
            'o.payment_method',
            DB::raw('COUNT(od.product_id) as item_count'),
            DB::raw('SUM(od.unit_price * od.quantity) as total')
        )
        ->where('o.customer_id', $customer_id)
        ->groupBy(
            'o.id',
            'c.name',
            'c.phone_number',
            'c.address',
            'o.payment_method',
            'o.customer_id',
            'o.status',
            'o.created_at',
            'o.updated_at'
            // tambahkan kolom lain dari o.* yang dipakai jika error
        )
        ->orderByDesc('o.id')
        ->get();

    // Ambil detail produk tiap order
    foreach ($orders as $order) {
        $order->details = DB::table('order_details as od')
            ->join('product as p', 'od.product_id', '=', 'p.id')
            ->join('product_variant as pv', 'od.product_variant_id', '=', 'pv.id')
            ->join('product_color as pc', 'od.product_color_id', '=', 'pc.id')
            ->join('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
            ->select('p.name', 'pci.image_kiri', 'pc.color_name', 'pv.size', 'od.quantity', 'od.unit_price')
            ->where('od.order_id', $order->id)
            ->get();
    }

    return view('order', [
        'orders' => $orders
    ]);
}
}
