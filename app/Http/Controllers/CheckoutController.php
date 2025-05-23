<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
{
    $user_id = Session::get('user_id');

    if (!$user_id) {
        return redirect('/login');
    }

    // Ambil data cart items
    $cartItems = DB::table('cart_items as ci')
        ->join('product as p', 'p.id', '=', 'ci.product_id')
        ->join('product_color as pc', 'pc.id', '=', 'ci.product_color_id')
        ->join('product_color_image as pci', 'pci.color_id', '=', 'ci.product_color_id')
        ->join('product_variant as pv', 'pv.id', '=', 'ci.product_variant_id')
        ->where('ci.customer_id', $user_id)
        ->where('ci.is_pilih', 1)
        ->select(
            'ci.id',
            'p.price',
            'p.name',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih'
        )
        ->groupBy(
            'ci.id',
            'p.price',
            'p.name',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih'
        )
        ->get();

    // Ambil data customer
    $customer = DB::table('customers')->where('id', $user_id)->first();

    return view('checkout', [
        'cartItems' => $cartItems,
        'customer' => $customer
    ]);
}

public function updateQuantity(Request $request)
{
    $cartItemId = $request->input('cart_item_id');
    $quantity = (int) $request->input('quantity');

    if (!$cartItemId || $quantity < 0) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak lengkap atau tidak valid'
        ], 400);
    }

    if ($quantity === 0) {
        CartItem::where('id', $cartItemId)->delete();
    } else {
        CartItem::where('id', $cartItemId)->update(['quantity' => $quantity]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Quantity berhasil diupdate'
    ], 200);
}

public function processCheckout(Request $request)
    {
        $customerId = session('user_id') ?? $request->query('user_id', 1);
        Log::info('Pay Now clicked by user ID: ' . $customerId);
        Log::info('Request data:', $request->all());

        DB::beginTransaction();

        try {
            $cartItems = CartItem::with('product')
                ->where('customer_id', $customerId)
                ->where('is_pilih', 1)
                ->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang kosong.');
            }

            $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

            $order = Order::create([
                'customer_id' => $customerId,
                'order_date' => now(),
                'status' => 'Pending',
                'total_amount' => $totalAmount,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_color_id' => $item->product_color_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);
            }

            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $email = trim(session('user_email', 'Guest'));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Log::error('Invalid email format: ' . $email);
                return back()->with('error', 'Email Anda tidak valid. Mohon perbarui profil Anda.');
            }

            $user_name = session('user_name', 'Guest');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => $user_name,
                    'email' => $email,
                ],
                'callbacks' => [
                    'finish' => route('payment.return', $order->id),
                ],
            ];

            $snapUrl = Snap::createTransaction($params)->redirect_url;

            $order->payment_url = $snapUrl;
            $order->save();

            DB::commit();

            session()->forget('cart');
            CartItem::where('customer_id', $customerId)->where('is_pilih', 1)->delete();

            return redirect()->away($snapUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function handleMidtransWebhook(Request $request)
{
    Log::info('Webhook received:', $request->all());

    $orderId = $request->input('order_id');
    $paymentType = $request->input('payment_type');
    $transactionStatus = $request->input('transaction_status');

    Log::info("OrderId: $orderId, PaymentType: $paymentType, TransactionStatus: $transactionStatus");

    $order = Order::find($orderId);

    if ($order) {
        $order->payment_method = $paymentType;
        $order->status = $transactionStatus;
        $order->save();

        Log::info("Order updated successfully.");
    } else {
        Log::warning("Order $orderId not found.");
    }

    return response()->json(['message' => 'OK']);
}
}
