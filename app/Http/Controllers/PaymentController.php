<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Transaction;

class PaymentController extends Controller
{
public function handleReturn($order_id)
{
    // Midtrans Config
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');

    // Ekstrak id dari string order_id misal 'ORDER-123' -> 123
    $id = (int) str_replace('ORDER-', '', $order_id);

    $order = Order::findOrFail($id);

    try {
        /** @var object $status */
        $status = Transaction::status('ORDER-' . $order->id);

        if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
            $order->status = 'paid';
        } elseif ($status->transaction_status == 'pending') {
            $order->status = 'pending';
        } elseif ($status->transaction_status == 'expire') {
            $order->status = 'expired';
        } elseif ($status->transaction_status == 'cancel') {
            $order->status = 'cancelled';
        } else {
            $order->status = $status->transaction_status;
        }

        $order->save();

        return view('paymentstatus', [
            'order' => $order,
            'status_message' => 'Payment status has been updated automatically.'
        ]);

    } catch (\Exception $e) {
        return redirect()->route('payment.status', $order->id)
            ->with('error', 'Auto-check failed: ' . $e->getMessage());
    }
}

public function checkStatus($order_id)
{
    // Same as handleReturn logic
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');

    $id = (int) str_replace('ORDER-', '', $order_id);

    $order = Order::findOrFail($id);

    try {
        /** @var object $status */
        $status = Transaction::status('ORDER-' . $order->id);

        if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
            $order->status = 'paid';
        } elseif ($status->transaction_status == 'pending') {
            $order->status = 'pending';
        } elseif ($status->transaction_status == 'expire') {
            $order->status = 'expired';
        } elseif ($status->transaction_status == 'cancel') {
            $order->status = 'cancelled';
        } else {
            $order->status = $status->transaction_status;
        }

        $order->save();

        return view('paymentstatus', [
            'order' => $order,
            'status_message' => 'Payment status checked manually.'
        ]);

    } catch (\Exception $e) {
        return back()->with('error', 'Failed to check payment status: ' . $e->getMessage());
    }
}
}
