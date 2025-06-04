@extends('base.base1')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container py-5" id="HAH">
    <a href="{{ route('cart') }}" class="back-to-collection" title="Back to cart">
        <i data-feather="corner-down-left"></i>
      </a>
    <h1 class="text-center mb-5">Checkout</h1>

    <div class="row">
        {{-- Customer Info --}}
        <div class="col-md-8">
            <h5>Customer Information</h5><br>

            <div class="row mb-3">
                <div class="col">
                    <p>Name</p>
                    <input type="text" class="form-control" value="{{ $customer->name }}">
                </div>
                <div class="col">
                    <p>Phone Number</p>
                    <input type="text" class="form-control" value="{{ $customer->phone_number }}">
                </div>
            </div>

            <div class="mb-4">
                <p>Address</p>
                <input type="text" class="form-control" value="{{ $customer->address }}">
            </div>

            <h5>Products</h5><br>

            <div id="product-list">
                @forelse ($cartItems as $item)
                    <div class="product-card d-flex align-items-center mb-3" data-id="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->stock }}">
                        <img src="{{ asset('image/sepatu/kiri/' . $item->image_kiri) }}" alt="{{ $item->name }}" class="product-img me-3" style="width:100px;">

                        <div class="flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <strong>{{ $item->name }}</strong><br>
                                <small>Color: {{ $item->color_name }}<br>Size: {{ $item->size }}</small>
                            </div>

                            <div class="mt-2 d-flex align-items-center gap-2 qty-container">
                                <button class="qty-btn btn-minus">−</button>
                                <span class="qty-value item-qty" data-cart-id="{{ $item->id }}" contenteditable="true" 
                                        style="
                                        display: inline-block; 
                                        min-width: 30px; 
                                        max-width: 30px;
                                        white-space: nowrap; 
                                        overflow-x: hidden; 
                                        text-overflow: clip; 
                                        border: none; 
                                        padding: 2px 6px; 
                                        border-radius: 4px; 
                                        user-select: text;
                                        vertical-align: middle;
                                        ">{{ $item->quantity }}
                                </span>
                                <button class="qty-btn btn-plus">+</button>
                            </div>
                        </div>
                        <div class="text-end ms-3 price">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }},00
                        </div>
                    </div>
                @empty
                    <p class="text-center mt-3">No items found in cart.</p>
                @endforelse
            </div>
        </div>

        {{-- Order Summary & Payment --}}
        <div class="col-md-4">
            <form method="POST" action="{{ route('checkout.payNow') }}">
                @csrf
                <div class="border p-3 rounded">
                    <h6>Order Summary</h6>

                    <div class="d-flex justify-content-between">
                        <span>Items</span><span id="item-count">{{ $cartItems->sum('quantity') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span><span id="subtotal">
                            Rp {{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }},00
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping fee</span><span>Rp 30.000,00</span>
                    </div>
                    <div class="d-flex justify-content-between" style ="margin-bottom: 20px;">
                        <strong>Total</strong><strong id="total">
                            Rp {{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity) + 30000, 0, ',', '.') }},00
                        </strong>
                    </div>
                    <input type="hidden" name="payment_method" id="payment_method_input" value="cash">
                    <button type="submit" name="pay_now" class="btn btn-dark w-100">Pay Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="popupMessage" class="popup hidden">
    <div class="popup-content">
      <div class="popup-icon" id="popupIcon">✔️</div>
      <div class="popup-text" id="popupText">Pesan</div>
      <button onclick="closePopup()">OK</button>
    </div>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function formatCurrency(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ',00';
    }

    function updateSummary() {
        let totalItems = 0;
        let subtotal = 0;
        document.querySelectorAll('.product-card').forEach(card => {
            const qty = parseInt(card.querySelector('.item-qty').textContent);
            const price = parseInt(card.getAttribute('data-price'));
            totalItems += qty;
            subtotal += qty * price;
        });
        document.getElementById('item-count').textContent = totalItems;
        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('total').textContent = formatCurrency(subtotal + 30000);
    }

    function checkIfCartEmpty() {
        const productList = document.getElementById('product-list');
        if (!productList) return;
        if (productList.children.length === 0) {
            productList.innerHTML = '<p class="text-center mt-3">No items found in cart.</p>';
        }
    }

    document.querySelectorAll('.payment-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.payment-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('payment_method_input').value = this.getAttribute('data-method');
        });
    });

    document.querySelectorAll('.qty-container').forEach(container => {
        const btnMinus = container.querySelector('.btn-minus');
        const btnPlus = container.querySelector('.btn-plus');
        const qtySpan = container.querySelector('.item-qty');
        const productCard = container.closest('.product-card');
        const cartItemId = productCard.getAttribute('data-id');
        const priceEl = productCard.querySelector('.price');
        const maxStock = parseInt(productCard.getAttribute('data-stock'));
        const productPrice = parseInt(productCard.getAttribute('data-price'));

        const updateButtonState = (qty) => {
            btnMinus.disabled = qty <= 1;
            btnPlus.disabled = qty >= maxStock;
        };

        const updateQuantityOnServer = (newQty) => {
            fetch("{{ route('checkout.updateQuantity') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_item_id: cartItemId,
                    quantity: newQty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) alert('Failed to update quantity');
            })
            .catch(() => alert('Error updating quantity'));
        };

        // set contenteditable true
        qtySpan.setAttribute('contenteditable', 'true');
        qtySpan.style.minWidth = '30px';
        qtySpan.style.display = 'inline-block';
        qtySpan.style.textAlign = 'center';

        // prevent Enter key default
        qtySpan.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') e.preventDefault();
        });

        // Validate input on input event with debounce
        let debounceTimeout = null;
       qtySpan.addEventListener('input', function () {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                let val = this.textContent.replace(/[^0-9]/g, '');
                if (val === '') {
                    priceEl.textContent = formatCurrency(0);
                    updateSummary();
                    updateButtonState(0);
                    return;
                }
                let numVal = parseInt(val);
                if (isNaN(numVal) || numVal < 1) numVal = 1;
                if (numVal > maxStock) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limited Stock',
                        text: `The maximum stock for this product is ${maxStock}`,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    numVal = maxStock;
                }
                this.textContent = numVal;

                // move cursor to end
                const range = document.createRange();
                const sel = window.getSelection();
                range.selectNodeContents(this);
                range.collapse(false);
                sel.removeAllRanges();
                sel.addRange(range);

                priceEl.textContent = formatCurrency(numVal * productPrice);
                updateSummary();
                updateButtonState(numVal);
                updateQuantityOnServer(numVal);
            }, 500);
        });
        btnMinus.addEventListener('click', () => {
            let qty = parseInt(qtySpan.textContent);
            if (qty > 1) {
                qty--;
                qtySpan.textContent = qty;
                priceEl.textContent = formatCurrency(qty * productPrice);
                updateSummary();
                updateButtonState(qty);
                updateQuantityOnServer(qty);
            } else {
                Swal.fire({
                    title: 'Remove this item from cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateQuantityOnServer(0);
                        productCard.remove();
                        updateSummary();
                        checkIfCartEmpty();
                        Swal.fire('Removed!', 'Item has been removed.', 'success');
                    }
                });
            }
        });

        btnPlus.addEventListener('click', () => {
            let qty = parseInt(qtySpan.textContent);
            if (qty < maxStock) {
                qty++;
                qtySpan.textContent = qty;
                priceEl.textContent = formatCurrency(qty * productPrice);
                updateSummary();
                updateButtonState(qty);
                updateQuantityOnServer(qty);
            }
        });

        // Initialize button states
        updateButtonState(parseInt(qtySpan.textContent));
    });
});

</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
#HAH{
    margin-top:60px;
}
    h1 {
        font-family: 'Playfair Display', serif;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        font-size: 24px;
        text-decoration: none;
        color: black;
    }
    .back-btn:hover {
        text-decoration: none;
        color: #555;
    }
    .product-card {
        border: 1px solid #ddd;
        padding: 12px;
        border-radius: 5px;
    }
    .qty-container {
        display: flex;
        align-items: center;
        gap: 10px;
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
        min-width: 20px;
        text-align: center;
        display: inline-block;
    }
    .payment-btn.active {
        background-color: #333;
        color: white;
    }
    .popup {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex; justify-content: center; align-items: center;
        z-index: 999;
        animation: fadeIn 0.3s ease;
    }

.popup.hidden {
  display: none;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.popup-content {
  background: #fff;
  padding: 30px 40px;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  text-align: center;
  max-width: 400px;
  width: 90%;
  animation: popIn 0.3s ease;
}

@keyframes popIn {
  0% { transform: scale(0.95); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
.popup-icon {
  font-size: 40px;
  margin-bottom: 15px;
}

.popup-text {
  font-size: 18px;
  margin-bottom: 20px;
  color: #333;
}

.popup-content button {
  padding: 10px 24px;
  background-color: #4CAF50;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.popup-content button:hover {
  background-color: #45a049;
}

.back-to-collection {
    position: fixed;
    top: 100px;
    right: 20px;
    background: #fff;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
}
.back-to-collection:hover {
    background: #f0f0f0;
}

.btn-minus:disabled,
.btn-plus:disabled {
    opacity: 0.5;
}
</style>
@endsection
