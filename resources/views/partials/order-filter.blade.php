@if(count($orders) > 0)
<div>
  @foreach ($orders as $order)
    <div class="order-card">
      <div class="order-header mb-3 d-flex justify-content-between align-items-center">
        <div>
          <p class="mb-1">Order ID: {{ $order->id }}</p>
          <p class="mb-1">Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
          <p class="mb-1">Items: {{ $order->item_count }}</p>
          {{-- <p class="mb-1">Total: Rp. {{ number_format($order->total, 2, ',', '.') }}</p> --}}
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
          <button class="view-order-toggle" type="button">
            View Order <span class="dropdown-icon">▼</span>
          </button>
        </div>
      </div>

      <!-- WRAPPER UNTUK ANIMASI -->
      <div class="order-details-wrapper">
        <div class="order-details-content">
          <hr>
          <p>Customer: {{ $order->cust_name }}</p>
          <p>Phone No.: {{ $order->cust_phone_number }}</p>
          <p>Shipped To: {{ $order->cust_address }}</p>
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

<div id="paginationWrapper" class="pagination-wrapper mt-4">
    {{-- Show Entries --}}
    <div class="d-flex align-items-center">
        <label for="entries" class="me-2 mb-0">Show</label>
        <select id="entries" name="entries" class="form-select form-select-sm w-auto"
                onchange="changeEntries(this.value)">
            <option value="5" {{ request('entries') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
        </select>
        <span class="ms-2">entries</span>
    </div>

    {{-- Pagination --}}
@if ($orders->hasPages())
    <nav>
        <ul class="pagination pagination-sm mb-0">
            {{-- Prev --}}
            @if ($orders->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Prev</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $orders->previousPageUrl() }}">Prev</a>
                </li>
            @endif

            @php
                $current = $orders->currentPage();
                $last = $orders->lastPage();
            @endphp

            {{-- Show 1-4 if currentPage <= 3 --}}
            @if ($last <= 5)
                @for ($i = 1; $i <= $last; $i++)
                    <li class="page-item {{ $current == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @else
                @if ($current <= 3)
                    @for ($i = 1; $i <= 4; $i++)
                        <li class="page-item {{ $current == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->url($last) }}">{{ $last }}</a>
                    </li>
                @elseif ($current > 3 && $current < $last - 2)
                    <li class="page-item"><a class="page-link" href="{{ $orders->url(1) }}">1</a></li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    @for ($i = $current - 1; $i <= $current + 1; $i++)
                        <li class="page-item {{ $current == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item"><a class="page-link" href="{{ $orders->url($last) }}">{{ $last }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $orders->url(1) }}">1</a></li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    @for ($i = $last - 3; $i <= $last; $i++)
                        <li class="page-item {{ $current == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                @endif
            @endif

            {{-- Next --}}
            @if ($orders->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $orders->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endif
</div>

<span id="total-orders" hidden>{{ $orders->total() }}</span>