@extends('base.base1')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
</head>
<div class="container my-5">
  <h2 id="my-cart-title" class="mb-4"><strong>My Cart</strong></h2>
  <div class="row">
    <div class="col-lg-8">
      <table class="table">
        <thead>
          <tr>
            <th class="text-muted">Product</th>
            <th class="text-muted">Price</th>
            <th class="text-muted">Qty</th>
            <th id="total-column" class="text-muted">Total</th>
          </tr>
        </thead>
        <tbody>
          @if($cartItems->count() > 0)
          @foreach($cartItems as $item)
          <tr data-cart-id="{{ $item->id }}">
              <td>
                  <label class="custom-checkbox me-3">
                      <input type="checkbox" {{ $item->is_pilih == 1 ? 'checked' : '' }}>
                      <span class="checkmark"></span>
                  </label>
          
                  <img src="{{ asset('image/sepatu/kiri/' . $item->image_kiri) }}" class="product-img me-3" alt="{{ $item->name }}">
                  
                  <div class="d-inline-block align-items-center">
                      <p class="mb-1 fw-semibold">{{ $item->name }}</p>
                      <small class="mb-1 text-muted">Size: {{ $item->size }}</small><br>
                      <small class="mb-1 text-muted">Color: {{ $item->color_name }}</small>
                  </div>
              </td>
              <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
              <td>
                  <div class="qty-container">
                      <div class="qty-btn">-</div>
                      <span class="qty-value item-qty">{{ $item->quantity }}</span>
                      <div class="qty-btn">+</div>
                  </div>
              </td>
              <td id="total-column">Rp. {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
          </tr>
          @endforeach
          @else
            <tr>
              <td colspan="4">Your cart is empty.</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
    <div class="col-lg-4">
      <div class="summary-box">
        <h6><strong>Order Summary</strong></h6>
        <div class="d-flex justify-content-between">
          <span>Items</span>
          <span id="summary-items">0</span>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <span>Total</span>
          <span id="summary-total">Rp. 0</span>
        </div>
        <a href="{{ url('checkout') }}" class="btn btn-black w-100">Checkout</a>
      </div>
    </div>
  </div>
</div>

<style>
  body { 
    font-family: 'Red Hat Text', sans-serif; 
  }
  #my-cart-title { 
    font-family: 'Playfair Display';
    margin-top: 100px; 
  }
  .product-img {
    max-height: 100px;
    max-width: 100px;
    object-fit: cover;
  }
  td {
    vertical-align: middle;
  }
  .d-inline-block {
    display: inline-block;
    vertical-align: middle;
  }
  .qty-container {
    display: flex;
    align-items: center;
  }
  .qty-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    border-radius: 6px;
    border: 2px solid #ddd;
    background-color: transparent;
    font-size: 20px;
    font-weight: 300;
    color: #555;
    transition: all 0.2s ease;
    padding: 0;
    cursor: pointer;
  }
  .qty-btn:hover {
    background-color: #f0f0f0;
  }
  .qty-value {
    font-size: 18px;
    font-weight: 500;
    min-width: 24px;
    text-align: center;
    padding: 0 30px 0 20px;
  }
  #total-column { 
    width: 130px; 
  }
  th.text-muted {
    font-weight: 400; 
  }
  .custom-checkbox { 
    position: relative; 
    display: inline-block; 
    width: 17px; 
    height: 17px; 
  }
  .custom-checkbox input[type="checkbox"] { 
    opacity: 0; 
    position: absolute; 
  }
  .checkmark { 
    position: absolute; 
    top: 0; 
    left: 0; 
    height: 17px; 
    width: 17px; 
    background-color: white; 
    border: 2px solid #000; 
    border-radius: 3px; 
    cursor: pointer; 
  }
  .custom-checkbox input:checked ~ .checkmark { 
    background-color: black; 
  }
  .checkmark::after { 
    content: ""; 
    position: absolute; 
    display: none; 
  }
  .custom-checkbox input:checked ~ .checkmark::after { 
    display: block; 
  }
  .custom-checkbox .checkmark::after { 
    left: 5px; 
    top: 2px; 
    width: 4px; 
    height: 8px; 
    border: solid white;
    border-width: 0 2px 2px 0; 
    transform: rotate(45deg); 
  }
  .summary-box { 
    border: 1px solid #ccc; 
    border-radius: 10px; 
    padding: 20px; 
  }
  .btn-black { 
    background-color: black !important; 
    color: white !important; 
    border-radius: 0; 
    border: none; 
  }
  .btn-black:hover { 
    background-color: black !important; 
    color: white !important; 
  }
  .item-qty { 
    display: inline-block; 
    width: 24px; 
    text-align: center; 
    font-variant-numeric: tabular-nums; 
  }
  .table-bordered { 
    border: none; 
  }
  .table-bordered th, .table-bordered td { 
    border: none; 
  }
</style>

<script>
  function formatRupiah(number) {
    return 'Rp. ' + number.toLocaleString('id-ID');
  }

  function updateRowTotal(row) {
    const unitPriceText = row.querySelectorAll("td")[1].textContent;
    const unitPrice = parseInt(unitPriceText.replace('Rp. ', '').replace(/\./g, ''));
    const qty = parseInt(row.querySelector(".item-qty").textContent);
    const total = unitPrice * qty;
    row.querySelectorAll("td")[3].textContent = formatRupiah(total);
  }

  function updateSummary() {
    let totalItems = 0;
    let totalPrice = 0;
    document.querySelectorAll("tbody tr").forEach(row => {
      const checkbox = row.querySelector('input[type="checkbox"]');
      if (!checkbox) return;
      const qty = parseInt(row.querySelector(".item-qty").textContent);
      const totalText = row.querySelectorAll("td")[3].textContent;
      const numericPrice = parseInt(totalText.replace('Rp. ', '').replace(/\./g, ''));
      if (checkbox.checked) {
        totalItems += qty;
        totalPrice += numericPrice;
      }
    });
    document.getElementById("summary-items").textContent = totalItems;
    document.getElementById("summary-total").textContent = formatRupiah(totalPrice);
  }

  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.qty-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const isIncrement = this.textContent === '+';
        const row = this.closest('tr');
        const qtySpan = row.querySelector('.item-qty');
        let currentQty = parseInt(qtySpan.textContent);
        if (isIncrement) {
          currentQty++;
        } else {
          currentQty--;
          if (currentQty === 0) {
            row.remove();
            updateSummary();
          }
        }
        qtySpan.textContent = currentQty;
        updateRowTotal(row);
        updateSummary();

        const cartId = row.getAttribute("data-cart-id");
        fetch("{{ route('cart.update') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: `id=${cartId}&quantity=${currentQty}`
        });
      });
    });

    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const isChecked = this.checked ? 1 : 0;
        const row = this.closest('tr');
        const cartId = row.dataset.cartId;

        fetch("{{ route('cart.update_pilih') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: `cart_id=${cartId}&is_pilih=${isChecked}`
        })
        .then(response => {
        if (!response.ok) {
            console.error('Failed to update is_pilih');
        }
        })
        .catch(error => {
        console.error('Error:', error);
        });

        updateSummary();
    });
    });

    document.querySelectorAll("tbody tr").forEach(row => {
      updateRowTotal(row);
    });

    updateSummary();
  });
</script>

@endsection
