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

  <style>
    body {
      font-family: 'Red Hat Display', sans-serif;
      background-color: #f8f9fa;
      padding: 40px;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      margin-bottom: 40px;
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
  </style>
</head>
<body>
  <h1>Orders</h1>

    @foreach($orders as $order)
     <div class="order-card">
        <div class="order-header mb-3">
            <div>
                <p class="mb-1">Order ID: {{ $order->id }}</p>
                <p class="mb-1">Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                <p class="mb-1">Items: {{ $order->details->count() }}</p>
                <p class="mb-1">Total: Rp {{ number_format($order->details->sum(fn($d) => $d->unit_price * $d->quantity), 2, ',', '.') }}</p>
            </div>
            <div class="text-end">
                <button class="view-order-toggle" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#orderDetails{{ $order->id }}"
        aria-expanded="false"
        aria-controls="orderDetails{{ $order->id }}">
    View Order <span class="dropdown-icon">▼</span>
</button>
<div class="mt-2">
    @if ($order->status == 'Delivered')
    <span class="status-btn status-delivered">Delivered</span>
@else
    <span class="status-btn status-pending">{{ $order->status }}</span>
@endif
            </div>
        </div>
    </div>

        <div class="collapse" id="orderDetails{{ $order->id }}">
            <hr>
            <p>Customer: {{ $customer->name }}</p>
            <p>Phone: {{ $customer->phone_number }}</p>
            <p>Address: {{ $customer->address ?? 'N/A' }}</p>
            <p>Payment Method: {{ session('payment_method') ?? 'N/A' }}</p>
            <p class="mb-2">Products</p>

            @foreach($order->details as $detail)
                <div class="product-item">
                    {{-- <img src="{{ asset('image/sepatu/kiri/' . $detail->colorImage->image_kiri) }}"> --}}
                    {{-- @if(!empty($detail->colorImage->image_kiri))
    <img src="{{ asset('image/sepatu/kiri/' . $detail->colorImage->image_kiri) }}" alt="Sepatu Kiri" style="max-width: 100px;">
@else
    <p>Gambar tidak tersedia</p>
@endif --}}
<img src="{{ asset('image/sepatu/kiri/' . $detail->colorImage->image_kiri) }}" alt="{{ $detail->product->name }}">
                    <div class="product-info">
                        <p class="mb-0">{{ $detail->product->name }}</p>
                        <small class="text-muted">Color: {{ $detail->color_name }}</small><br>
                        <small class="text-muted">Size: {{ $detail->size }}</small>
                    </div>
                    <div class="product-qty-price">
                        <small>x {{ $detail->quantity }}</small><br>
                        <strong>Rp {{ number_format($detail->product->price, 2, ',', '.') }}</strong>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>