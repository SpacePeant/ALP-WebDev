@if(count($orders) > 0)
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
@else
  <div class="text-center" role="alert">
    No orders found.
  </div>
@endif