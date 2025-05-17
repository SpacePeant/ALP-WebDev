@extends('base.base1')

@section('content')

@php
    $user_id = $user_id ?? null;
@endphp

<div class="container">
  <h1 class="text-center mb-4">Orders</h1>

  <div>
    @foreach ($orders as $order)
      <div class="order-card">
        <div class="order-header mb-3 d-flex justify-content-between align-items-center flex-wrap">
          <div>
            <p class="mb-1">Order ID: {{ $order->id }}</p>
            <p class="mb-1">Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
            <p class="mb-1">Items: {{ $order->item_count }}</p>
            <p class="mb-1">Total: Rp. {{ number_format($order->total, 0, ',', '.') }}</p>
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
            <button class="view-order-toggle" type="button" aria-expanded="false" aria-controls="order-details-{{ $order->id }}">
              View Order <span class="dropdown-icon">▼</span>
            </button>
            <div class="mt-2">
            <div class="mt-2 d-flex align-items-center gap-2 flex-wrap justify-content-end">
              @if ($order->payment_url && $order->status == 'pending')
                  <a href="{{ $order->payment_url }}" target="_blank" class="status-btn pay-now-btn" style="margin-top: -120px;">
                      Pay Now
                  </a>
              @endif
            </div>
            </div>
          </div>
        </div>

        <div id="order-details-{{ $order->id }}" class="order-details-wrapper" aria-hidden="true">
          <div class="order-details-content">
            <hr>
            <p>Customer: {{ $order->customer_name }}</p>
            <p>Phone No.: {{ $order->customer_phone }}</p>
            <p>Shipped To: {{ $order->customer_address }}</p>
            <p>Payment Method: {{ $order->payment_method }}</p>
            <hr>
            <p class="mb-2">Products</p>

            @foreach ($order->details as $detail)
              <div class="product-item d-flex align-items-center mb-2">
                <img src="{{ asset('image/sepatu/kiri/' . $detail->image_kiri) }}" alt="{{ $detail->name }}" />
                <div class="product-info ms-3">
                  <p class="mb-0">{{ $detail->name }}</p>
                  <small class="text-muted">Color: {{ $detail->color_name }}</small><br>
                  <small class="text-muted">Size: {{ $detail->size }}</small>
                </div>
                <div class="product-qty-price ms-auto text-end">
                  <small>x {{ $detail->quantity }}</small><br>
                  Rp. {{ number_format($detail->unit_price, 0, ',', '.') }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  body {
    font-family: 'Red Hat Display', sans-serif;
    background-color: #f8f9fa;
  }

  .container {
    padding: 40px;
    margin-top: 70px;
  }

  h1 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    margin-bottom: 40px;
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

    .pay-now-btn {
      text-decoration: none;
      background-color: #444;
      color: #fff;
      border-color: #444;
    }

    .pay-now-btn:hover {
      background-color: black;
      border-color: black;
      color: #fff;
    }

  .view-order-toggle {
    font-weight: 500;
    color: #6c757d;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
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
</style>
@endpush

@push('scripts')
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
          const otherButton = w.closest('.order-card').querySelector('.view-order-toggle');
          if(otherButton) otherButton.setAttribute('aria-expanded', 'false');
          w.setAttribute('aria-hidden', 'true');
        }
      });

      // Toggle current
      const isOpen = wrapper.classList.toggle('open');
      icon.textContent = isOpen ? '▲' : '▼';
      this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      wrapper.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    });
  });
</script>
@endpush
