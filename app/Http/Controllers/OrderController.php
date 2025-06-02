<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;

class OrderController extends Controller
{
    public function adminIndex(Request $request)
    {
        $filter = $request->query('status'); // 'Paid', 'Pending', 'Expired', atau null
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $searchBy = $request->query('search_by');
        $keyword = $request->query('keyword');
        
        $query = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('users as u', 'o.user_id', '=', 'u.id')
            ->select(
                'o.*',
                'u.name as customer_name',
                'u.address as customer_address',
                'u.phone_number',
                DB::raw('COUNT(od.product_id) as item_count'),
                DB::raw('SUM(od.unit_price * od.quantity) as total'),
                // 'o.payment_method'
            )
            ->groupBy(
                'o.id', 'u.name', 'u.phone_number', 'o.status', 
                'o.user_id', 'o.created_at', 'o.updated_at', 
                'u.id', 'o.created_at', 'o.updated_at', 
                'u.address', 
                // 'o.payment_method'
            )
            ->orderByDesc('o.id');

        if (in_array($filter, ['Paid', 'Pending', 'Expired'])) {
            $query->where('o.status', $filter);
        }

        if ($startDate && $endDate) {
            $query->whereDate('o.order_date', '>=', $startDate)
            ->whereDate('o.order_date', '<=', $endDate);
        }
        if ($searchBy && $keyword) {
            if ($searchBy == 'order_id') {
                $query->where('o.id', 'LIKE', '%' . $keyword . '%');
            } elseif ($searchBy == 'customer_name') {
                $query->whereRaw('LOWER(u.name) LIKE ?', ['%' . strtolower($keyword) . '%']);
            }
        }
        // $orders = $query->get();

        $perPage = $request->input('entries', 5); // default 5
        $orders = $query->orderBy('o.order_date', 'desc')->paginate($perPage)->appends(['entries' => $perPage]);

            $orderDetails = [];

            if (count($orders) > 0) {
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
            } else {
                $orderId = null; 
            }

            // Stat count
            $completedOrders = DB::table('orders')->where('status', 'Completed')->count();
            $pendingOrders = DB::table('orders')->where('status', 'Pending')->count();
            
            if ($request->ajax()) {
                return view('partials.order-filter', ['orders' => $orders])->render();
            }
            return view('orderadmin', compact('orders', 'orderDetails', 'completedOrders', 'pendingOrders', 'orderId', 'filter', 'startDate', 'endDate', 'perPage'));
    }

public function filterAjax(Request $request)
{
    $filter = ucfirst(strtolower($request->query('status')));
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');
    $searchBy = $request->query('search_by');
    $keyword = $request->query('search');

    $query = DB::table('orders as o')
        ->join('order_details as od', 'o.id', '=', 'od.order_id')
        ->join('users as u', 'o.user_id', '=', 'u.id')
        ->select(
            'o.*',
            'u.name as customer_name',
            'u.address as customer_address',
            'u.phone_number',
            DB::raw('COUNT(od.product_id) as item_count'),
            DB::raw('SUM(od.unit_price * od.quantity) as total'),
            'o.payment_method'
        )
        ->groupBy(
            'o.id', 'u.name', 'u.phone_number', 'o.status',
            'o.user_id', 'o.created_at', 'o.updated_at',
            'u.address', 'o.payment_method'
        )
        ->orderByDesc('o.id');

    if (in_array($filter, ['Paid', 'Pending', 'Expired'])) {
        $query->where('o.status', $filter);
    }

    if ($startDate && $endDate) {
        $query->whereBetween('o.order_date', [$startDate, $endDate]);
    }

    if ($searchBy && $keyword) {
        if ($searchBy == 'order_id') {
            $query->where('o.id', $keyword);
        } elseif ($searchBy == 'customer_name') {
            $query->whereRaw('LOWER(u.name) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }
    }

    $orders = $query->get();

    $orderDetails = [];
    foreach ($orders as $order) {
        $details = DB::table('order_details as od')
            ->join('product as p', 'od.product_id', '=', 'p.id')
            ->join('product_variant as pv', 'od.product_variant_id', '=', 'pv.id')
            ->join('product_color as pc', 'od.product_color_id', '=', 'pc.id')
            ->join('product_color_image as pci', 'pci.color_id', '=', 'pc.id')
            ->select('p.name', 'pci.image_kiri', 'pc.color_name', 'pv.size', 'od.quantity', 'p.price')
            ->where('od.order_id', $order->id)
            ->get();

        $orderDetails[$order->id] = $details;
    }

    return view('partials.order-filter', compact('orders', 'orderDetails'));
}
    
public function index(Request $request)
{
    $filter = $request->query('status'); // 'Paid', 'Pending', 'Expired', atau null
    $customer_id = Session::get('user_id');
    $user_id = Session::get('user_id');

    if (!$customer_id) {
        return redirect('/login')->with('error', 'Session expired or not logged in.');
    }
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $search = $request->input('search');

    // Ambil data orders dan ringkasannya, plus info customer & payment_method
    $query = DB::table('orders as o')
        ->join('order_details as od', 'o.id', '=', 'od.order_id')
        ->join('users as u', 'o.user_id', '=', 'u.id')
        ->select(
            'o.*',
            'u.name as customer_name',
            'u.phone_number as customer_phone',
            'u.address as customer_address',
            // 'u.payment_method',
            DB::raw('COUNT(od.product_id) as item_count'),
            DB::raw('SUM(od.unit_price * od.quantity) as total')
        )
        ->where('o.user_id', $customer_id)
        ->groupBy(
            'o.id',
            'u.name',
            'u.phone_number',
            'u.address',
            // 'o.payment_method',
            'o.user_id',
            'o.status',
            'o.created_at',
            'o.updated_at'
            // tambahkan kolom lain dari o.* yang dipakai jika error
        );

        if (in_array($filter, ['Paid', 'Pending', 'Expired'])) {
            $query->where('o.status', $filter);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('o.order_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('o.order_date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('o.order_date', '<=', $endDate);
        }

        if ($search) {
        $query->whereExists(function ($subquery) use ($search) {
            $subquery->select(DB::raw(1))
                ->from('order_details')
                ->join('product as p', 'order_details.product_id', '=', 'p.id')
                ->whereRaw('order_details.order_id = o.id')
                ->whereRaw('LOWER(p.name) LIKE ?', ['%' . strtolower($search) . '%']);
        });
    }

    $perPage = $request->input('entries', 5); // default 5
    $orders = $query->orderBy('o.order_date', 'desc')->paginate($perPage)->appends(['entries' => $perPage]);

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

    if ($request->ajax()) {
        return view('partials.ordercust', ['orders' => $orders])->render();
    }

    return view('order', compact('orders', 'user_id', 'filter', 'startDate', 'endDate', 'search'));
}

public function boot()
{
    Paginator::useBootstrap();
}

}
