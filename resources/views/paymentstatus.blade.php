@extends('base.base1')

@section('content')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Red+Hat+Text&display=swap" rel="stylesheet">

<!-- Custom Styles -->
<style>
    body {
        font-family: 'Red Hat Text', sans-serif;
        background-color: #f8f9fa;
    }

    h1 {
        margin-top: 50px;
        margin-bottom:-10px;
        font-family: 'Playfair Display', serif;
    }

    .payment-status-card {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        max-width: 600px;
        margin: auto;
    }

    .payment-status-card p {
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
    }

    .btn + .btn {
        margin-left: 0.5rem;
    }

    .badge {
        font-weight: normal;
        font-size: 14px;
        padding: 6px 16px;
        border-radius: 20px;
        border: 1px solid transparent;
        display: inline-block;
        text-align: center;
    }

    .status-btn {
    font-size: 14px;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1px solid transparent;
    display: inline-block;
    text-align: center;
    text-decoration: none;
    }

    .status-success {
    background-color: #d4edda;
    color: #3c763d;
    border-color: #c3e6cb;
    }

    .status-pending {
    background-color: #fff3cd;
    color: #856404;
    border-color: #ffeeba;
    }

    .status-failed {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
    }

    .status-unknown {
    background-color: #e2e3e5;
    color: #383d41;
    border-color: #d6d8db;
    }


</style>

<h1 class="text-center">Payment Status</h1>

<div class="container py-5">
    <div class="payment-status-card">

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p>Invoice Number:{{ $order->id }}</p>
        <p>Total Amount: Rp {{ number_format($order->total_amount) }}</p>

        <p>Payment Status:
        @if ($order->status == 'paid')
            <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-success">Paid</a>
        @elseif ($order->status == 'pending')
            <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-pending">Pending</a>
        @elseif ($order->status == 'failed' || $order->status == 'cancelled')
            <a href="{{ route('payment.status', $order->id) }}" class="badge bg-danger">Failed</a>
        @elseif ($order->status == 'expired')
            <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-failed">Expired</a>
        @else
            <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-unknown">{{ ucfirst($order->status) }}</a>
        @endif
        </p>

        <p>{{ $status_message }}</p>

        <div class="text-center mt-4">
            <a href="{{ route('payment.status', $order->id) }}" class="btn btn-outline-secondary">Check Status Again</a>
            <a href="{{ route('order') }}" class="btn btn-primary">View My Orders</a>
        </div>
    </div>
</div>
@endsection
