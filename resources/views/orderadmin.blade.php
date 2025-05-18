@extends('base.baseadmin')

@section('content')

@php
    $user_id = $user_id ?? null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Red Hat Display', sans-serif;
      background-color: #f8f9fa;
    }

    .container {
        padding: 40px;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      margin-bottom: 40px;
      margin-top:100px;
      text-align: center;
    }

    .order-card {
      background-color: #fff;
      border-radius: 12px;
      border: 1px solid #ddd;
      padding: 24px;
      margin-bottom: 20px;
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    .status-btn {
      font-size: 14px;
      padding: 6px 16px;
      border-radius: 20px;
      border: 1px solid transparent;
      display: inline-block;
      text-align: center;
    }

    .status-delivered {
      background-color: #d4edda;
      color: #3c763d;
      border-color: #c3e6cb;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
      border-color: #ffeeba;
    }

    .view-order-toggle {
      font-weight: 500;
      color: #6c757d;
      background: none;
      border: none;
      padding: 0;
      margin-bottom: 90px;
    }

    .view-order-toggle .dropdown-icon {
      transition: transform 0.3s ease;
      display: inline-block;
      margin-left: 6px;
    }

    .view-order-toggle[aria-expanded="true"] .dropdown-icon {
      transform: rotate(180deg);
    }

    .product-item {
      display: flex;
      align-items: center;
      padding: 12px 0;
      border-top: 1px solid #eee;
    }

    .product-item img {
      width: 80px;
      height: auto;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 16px;
    }

    .product-info {
      flex-grow: 1;
    }

    .product-qty-price {
      text-align: right;
      white-space: nowrap;
    }

    hr {
      margin: 20px 0;
    }
    .order-details-wrapper {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease;
}

.order-details-wrapper.open {
  max-height: 1000px;
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
</head>
<body>

<div class="container">
  <h1 class="text-center mb-4">Orders</h1>
  <div class="d-flex justify-content-center gap-4 mb-4">
    <!-- Completed Orders -->
    <div class="border rounded p-4 shadow-sm d-flex align-items-center" style="width: 250px;">
      <div class="rounded-circle bg-success bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
        <i class="bi bi-bag-check-fill text-success fs-3"></i>
      </div>
      <div class="ms-3">
        <h4 class="mb-0">{{ $completedOrders }}</h4>
        <small class="text-muted">Completed Orders</small>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="border rounded p-4 shadow-sm d-flex align-items-center" style="width: 250px;">
      <div class="rounded-circle bg-warning bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
        <i class="bi bi-truck text-warning fs-3"></i>
      </div>
      <div class="ms-3">
        <h4 class="mb-0">{{ $pendingOrders }}</h4>
        <small class="text-muted">Pending Orders</small>
      </div>
    </div>
  </div>

<div>
  @foreach ($orders as $order)
    <div class="order-card">
      <div class="order-header mb-3 d-flex justify-content-between align-items-center">
        <div>
          <p class="mb-1">Order ID: {{ $order->id }}</p>
          <p class="mb-1">Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
          <p class="mb-1">Items: {{ $order->item_count }}</p>
          <p class="mb-1">Total: Rp. {{ number_format($order->total, 2, ',', '.') }}</p>
          <div class="mb-1">
              Status:
              @if ($order->status == 'paid')
                  <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-success">Paid</a>
              @elseif ($order->status == 'pending')
                  <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-pending">Pending</a>
              @elseif ($order->status == 'failed' || $order->status == 'cancelled')
                  <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-failed">Failed</a>
              @elseif ($order->status == 'expired')
                  <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-failed">Expired</a>
              @else
                  <a href="{{ route('payment.status', $order->id) }}" class="status-btn status-unknown">{{ ucfirst($order->status) }}</a>
              @endif
          </div>
        </div>
        <div class="text-end">
          <button class="view-order-toggle" type="button">
            View Order <span class="dropdown-icon">▼</span>
          </button>
        </div>
      </div>

      <!-- WRAPPER UNTUK ANIMASI -->
      <div class="order-details-wrapper">
        <div class="order-details-content">
          <hr>
          <p>Customer: {{ $order->customer_name }}</p>
          <p>Phone No.: {{ $order->phone_number }}</p>
          <p>Shipped To: {{ $order->customer_address }}</p>
          <p>Payment Method: {{ $order->payment_method }}</p>
          <hr>
          <p class="mb-2">Products</p>

          @foreach ($orderDetails[$order->id] ?? [] as $detail)
            <div class="product-item d-flex align-items-center mb-2">
              <img src="{{ asset('image/sepatu/kiri/' . $detail->image_kiri) }}" alt="{{ $detail->name }}" style="width: 80px; height:auto;">
              <div class="product-info ms-3">
                <p class="mb-0">{{ $detail->name }}</p>
                <small class="text-muted">Color: {{ $detail->color_name }}</small><br>
                <small class="text-muted">Size: {{ $detail->size }}</small>
              </div>
              <div class="product-qty-price ms-auto text-end">
                <small>x {{ $detail->quantity }}</small><br>
                Rp. {{ number_format($detail->price, 2, ',', '.') }}
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  @endforeach
</div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.querySelectorAll('.view-order-toggle').forEach(function(button) {
    button.addEventListener('click', function () {
      const orderCard = this.closest('.order-card');
      const wrapper = orderCard.querySelector('.order-details-wrapper');
      const icon = this.querySelector('.dropdown-icon');

      // Tutup semua wrapper lain
      document.querySelectorAll('.order-details-wrapper').forEach(function(w) {
        if (w !== wrapper) {
          w.classList.remove('open');
          const otherIcon = w.closest('.order-card').querySelector('.dropdown-icon');
          if (otherIcon) otherIcon.textContent = '▼';
        }
      });

      // Toggle current
      wrapper.classList.toggle('open');
      icon.textContent = wrapper.classList.contains('open') ? '▲' : '▼';
    });
  });
</script>

</body>
</html>

@endsection
