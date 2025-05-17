<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function adminIndex(Request $request)
        {
        // Ambil semua order (ringkasan)
        $orders = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('customers as c', 'o.customer_id', '=', 'c.id')
            ->select(
                'o.*',
                'c.name as customer_name',
                'c.phone_number',
                DB::raw('COUNT(od.product_id) as item_count'),
                DB::raw('SUM(od.unit_price * od.quantity) as total')
            )
            ->groupBy('o.id', 'c.name', 'c.phone_number', 'o.status', 'o.customer_id', 'o.created_at', 'o.updated_at')
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

        // Ambil data customer
        $customer = DB::table('customers')
            ->select('name', 'phone_number')
            ->where('id', $customer_id)
            ->first();

        if (!$customer) {
            $customer = (object) [
                'name' => 'N/A',
                'phone_number' => 'N/A',
            ];
        }

        // Ambil data orders dan ringkasannya
        $orders = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->select('o.*', DB::raw('COUNT(od.product_id) as item_count'), DB::raw('SUM(od.unit_price * od.quantity) as total'))
            ->where('o.customer_id', $customer_id)
            ->groupBy('o.id')
            ->orderByDesc('o.id')
            ->get();

        // Untuk setiap order, ambil detail produk
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
            'customer' => $customer,
            'orders' => $orders,
            'customer_address' => Session::get('customer_address', 'N/A'),
            'payment_method' => Session::get('payment_method', 'N/A'),
        ]);
    }
}
