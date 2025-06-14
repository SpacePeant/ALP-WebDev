<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
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
        ->where('ci.user_id', $user_id)
        ->where('ci.is_pilih', 1)
        ->select(
            'ci.id',
            'p.price',
            'p.name',
            'pv.stock',
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
            'pv.stock',
            'ci.quantity',
            'pv.size',
            'pc.color_name',
            'pci.image_kiri',
            'ci.is_pilih'
        )
        ->get();

    // Ambil data customer
    $customer = DB::table('users')->where('id', $user_id)->first();

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
        $cartItems = DB::table('cart_items')
    ->join('product_variant', 'cart_items.product_variant_id', '=', 'product_variant.id')
    ->join('product', 'product_variant.product_id', '=', 'product.id')
    ->join('product_color', 'product_variant.color_id', '=', 'product_color.id')
    ->select(
        'cart_items.*',
        'product_variant.stock',
        'product_variant.size',
        'product_variant.id as product_variant_id',
        'product.id as product_id',
        'product_color.id as product_color_id',
        'product.price',
        'product_color.color_name as color_name',
        'product.name as product_name'
    )
    ->where('cart_items.user_id', $customerId)
    ->where('cart_items.is_pilih', 1)
    ->get();

if ($cartItems->isEmpty()) {
    DB::rollBack(); 
    return back()->with([
            'error' => "Your cart is empty."
        ]);
}

foreach ($cartItems as $item) {
    if ($item->quantity > $item->stock) {
        DB::rollBack(); 
        return back()->with([
            'error' => "The stock for <strong>{$item->product_name}</strong> is insufficient (Size: {$item->size}, Color: {$item->color_name}).<br>
                    Available Stock: <strong>{$item->stock}</strong>, Amount of Order: <strong>{$item->quantity}</strong>."
        ]);
    }
}

    DB::table('product_variant')
    ->where('id', $item->product_variant_id);
$cartItems = CartItem::with('product')
            ->where('user_id', $customerId)
            ->where('is_pilih', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }
        $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->product->price) + 30000;
        $order = Order::create([
            // 'order_id' => $orderId, // hapus ini karena gak ada kolom order_id
            'user_id' => $customerId,
            'order_date' => now(),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'cust_name' => $request->input('cust_name'),
            'cust_phone_number' => $request->input('cust_phone_number'),
            'cust_address' => $request->input('cust_address'),
        ]);

        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id, // pakai id dari DB
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

        $email = trim(session('user_email', 'guest@example.com'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Log::error('Invalid email format: ' . $email);
            return back()->with('error', 'Email is invalid. Please update your profile.');
        }

        $user_name = session('user_name', 'Guest');

        // buat order_id string untuk Midtrans pakai id order:
        $midtransOrderId = 'ORDER-' . $order->id;

        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $user_name,
                'email' => $email,
            ],
            'callbacks' => [
                'finish' => url('/payment/return/' . urlencode($midtransOrderId)),
            ],
        ];

        $snapUrl = Snap::createTransaction($params)->redirect_url;

        $order->payment_url = $snapUrl;
        $order->save();

        DB::commit();

        session()->forget('cart');
        CartItem::where('user_id', $customerId)->where('is_pilih', 1)->delete();

        return redirect()->away($snapUrl);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Midtrans error: ' . $e->getMessage());
        return back()->with('error', 'An error occurred while processing the payment.');
    }
}


public function handleMidtransWebhook(Request $request)
{
    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = config('services.midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    Log::info('Webhook received:', $request->all());

    // Cek signature untuk validasi
    $signatureKey = $request->input('signature_key');
    $orderId = $request->input('order_id', '');
    $statusCode = $request->input('status_code', '');
    $grossAmount = $request->input('gross_amount', '');

    $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . Config::$serverKey);

    if ($signatureKey !== $expectedSignature) {
        Log::warning("Invalid signature for order ID: $orderId");
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // Ambil data penting
    $transactionStatus = $request->input('transaction_status');
    $paymentType = $request->input('payment_type');
    $midtransOrderId = $orderId;

    Log::info("OrderId: $midtransOrderId, PaymentType: $paymentType, TransactionStatus: $transactionStatus");

    // Ambil ID order, sesuaikan dengan format order kamu
    $id = (int) str_replace('ORDER-', '', $midtransOrderId);
    $order = \App\Models\Order::find($id);

    if ($order) {
        $mapStatus = [
            'settlement' => 'paid',
            'capture' => 'paid',
            'pending' => 'pending',
            'expire' => 'expired',
            'cancel' => 'cancelled',
            'deny' => 'failed',
            'failure' => 'failed',
        ];

        // Cek dulu va_numbers dan permata_va_number, karena kadang tidak ada di payload
        $vaNumbers = $request->input('va_numbers', []);
        $permataVa = $request->input('permata_va_number', null);

        $paymentChannel = match ($paymentType) {
            'bank_transfer' => (isset($vaNumbers[0]['bank']) ? $vaNumbers[0]['bank'] : 'permata') . ($permataVa ? " ({$permataVa})" : ''),
            'gopay' => 'Gopay',
            'qris' => 'QRIS',
            'credit_card' => 'Kartu Kredit',
            default => ucfirst($paymentType),
        };

        $order->payment_method = $paymentChannel;
        $order->status = $mapStatus[$transactionStatus] ?? 'unknown';
        $order->save();

        Log::info("Order updated successfully: Order ID $id");
    } else {
        Log::warning("Order $id not found.");
    }

    // Response 200 OK supaya Midtrans tidak retry
    return response()->json(['message' => 'OK'], 200);
}


}
