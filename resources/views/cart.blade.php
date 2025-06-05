@extends('base.base1')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          <tr data-cart-id="{{ $item->id }}" data-stock="{{ $item->stock }}">
              <td>
                  <label class="custom-checkbox me-3">
                      <input type="checkbox" {{ $item->is_pilih == 1 ? 'checked' : '' }}>
                      <span class="checkmark"></span>
                  </label>
          
                  <img src="{{ asset('image/sepatu/kiri/' . $item->image_kiri) }}" class="product-img me-3" alt="{{ $item->name }}">
                  
                  <div class="d-inline-block align-items-center">
                      <p class="mb-1 fw-semibold">{{ $item->name }}</p>
                      <small class="mb-1 text-muted">Size:</small>
            @php
                $currentSize = $item->size;
            @endphp
            <select 
                class="form-select size-select"  
                style="width: 100px; margin-bottom: 5px; display: inline-block; font-size: 14px;"
                data-product-id="{{ $item->product_id }}"
                data-color-id="{{ $item->product_color_id }}"
                data-cart-id="{{ $item->id }}"
                data-current-size="{{ $currentSize }}">

                      @foreach($item->availableSizes as $variant)
                        <option 
                            value="{{ $variant->id }}" 
                            data-stock="{{ $variant->stock }}"
                            data-size="{{ $variant->size }}"
                            {{ $variant->size == $item->currentSize ? 'selected' : '' }}
                        >
                            {{ $variant->size }}
                        </option>
                      @endforeach
            </select>

                  <br>
                      <small class="mb-1 text-muted">Color: {{ $item->color_name }}</small>
                  </div>
              </td>
              <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
              <td>
                  <div class="qty-container">
  <div class="qty-btn">-</div>
  <span 
    class="qty-value item-qty" 
    data-cart-id="{{ $item->id }}" 
    contenteditable="true" 
    style="
      display: inline-block; 
      min-width: 60px; 
      max-width: 60px;
      white-space: nowrap; 
      overflow-x: hidden; 
      text-overflow: clip; 
      border: none; 
      padding: 2px 6px; 
      border-radius: 4px; 
      user-select: text;
      vertical-align: middle;
    "
  >{{ $item->quantity }}</span>
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
        <a href="{{ url('checkout') }}" class="btn btn-black w-100" id="checkout-btn">Checkout</a>
      </div>
    </div>
  </div>
</div>
<div id="loader" class="loader-overlay" style="display: none">
      <div class="loader"></div>
  </div>
<script>
  document.querySelectorAll('.qty-value[contenteditable="true"]').forEach(span => {
    span.addEventListener('keydown', function(e) {
      // Cegah enter (baris baru)
      if (e.key === 'Enter') {
        e.preventDefault();
      }
    });

    span.addEventListener('input', function(e) {
      // Hanya izinkan angka saja
      let clean = this.textContent.replace(/[^0-9]/g, '');
      this.textContent = clean;

      // Pindahkan kursor ke akhir setelah update textContent
      const range = document.createRange();
      const sel = window.getSelection();
      range.selectNodeContents(this);
      range.collapse(false);
      sel.removeAllRanges();
      sel.addRange(range);
    });
  });
</script>

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

  .loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255,255,255,0.8);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #555;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
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

function updatePlusButtonState(row) {
    const stock = parseInt(row.getAttribute('data-stock'));
    const currentQty = parseInt(row.querySelector('.item-qty').textContent);

    const btns = row.querySelectorAll('.qty-btn');
    btns.forEach(btn => {
        if (btn.textContent.trim() === '+') {
            btn.style.pointerEvents = currentQty >= stock ? 'none' : 'auto';
            btn.style.opacity = currentQty >= stock ? '0.5' : '1';
        }
    });
}
function checkIfCartIsEmpty() {
    const tbody = document.querySelector("tbody");
    if (tbody.querySelectorAll("tr").length === 0) {
        const emptyRow = document.createElement("tr");
        emptyRow.innerHTML = `<td colspan="4" class="text-left">Your cart is empty.</td>`;
        tbody.appendChild(emptyRow);
    }
}
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi row total & summary
    document.querySelectorAll("tbody tr").forEach(row => {
        updateRowTotal(row);
        updatePlusButtonState(row);
    });
    updateSummary();

    // Tombol + dan -
   document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const isIncrement = this.textContent.trim() === '+';
        const row = this.closest('tr');
        const qtySpan = row.querySelector('.item-qty');
        let currentQty = parseInt(qtySpan.textContent);
        const stock = parseInt(row.getAttribute("data-stock"));

        if (isIncrement) {
            if (currentQty < stock) {
                currentQty++;
            }
        } else {
            if (currentQty > 1) {
                currentQty--;
            } else {
                 Swal.fire({
                  title: 'Are you sure?',
                  text: "Do you want to remove this item from your cart?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes',
                  cancelButtonText: 'Cancel'
              }).then((result) => {
    if (result.isConfirmed) {
        // Hapus elemen baris dari DOM
        row.remove();
        updateSummary();
        checkIfCartIsEmpty();

        // Tampilkan notifikasi sukses
        Swal.fire({
            icon: 'success',
            title: 'Removed!',
            text: 'The item has been removed from your cart.',
            timer: 1500,
            showConfirmButton: false
        });

        // Ambil ID cart dan kirim update quantity = 0
        const cartId = row.getAttribute("data-cart-id");
        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: `id=${cartId}&quantity=0`
        });

    } else if (result.dismiss !== Swal.DismissReason.cancel) {
        // Jika gagal dan bukan karena cancel, tampilkan error
        Swal.fire('Error', result.message || "Failed to remove item.", 'error');
    }
});
              return;
            }
        }

        qtySpan.textContent = currentQty;
        updateRowTotal(row);
        updateSummary();
        updatePlusButtonState(row);

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

// Tambahkan event listener untuk input di contenteditable span
document.querySelectorAll('.item-qty[contenteditable="true"]').forEach(qtySpan => {
    let alreadyWarned = false;

    qtySpan.addEventListener('input', function () {
        const row = this.closest('tr');
        const stock = parseInt(row.getAttribute("data-stock"));
        let rawVal = this.textContent;
        let val = rawVal.replace(/[^0-9]/g, ''); // hanya angka

        if (val === '') {
            return;
        }

        let numVal = parseInt(val);

        // Minimal 1
        if (isNaN(numVal) || numVal <= 0) numVal = 1;

        // Kalau melebihi stok, beri popup dulu, baru ubah nilainya
        if (numVal > stock) {
            if (!alreadyWarned) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limited Stock',
                    text: `The maximum stock for this product is ${stock}`,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                alreadyWarned = true; // hanya muncul 1x saat edit ini
            }
            numVal = stock;
        } else {
            alreadyWarned = false; // reset kalau angka sudah masuk akal
        }

        // Update textContent
        this.textContent = numVal;

        // Pindahkan kursor ke akhir
        const range = document.createRange();
        const sel = window.getSelection();
        range.selectNodeContents(this);
        range.collapse(false);
        sel.removeAllRanges();
        sel.addRange(range);

        updateRowTotal(row);
        updateSummary();
        updatePlusButtonState(row);

        const cartId = row.getAttribute("data-cart-id");
        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: `id=${cartId}&quantity=${numVal}`
        });
    });

    qtySpan.addEventListener('blur', function () {
        if (this.textContent.trim() === '') {
            this.textContent = '1';

            const row = this.closest('tr');
            updateRowTotal(row);
            updateSummary();
            updatePlusButtonState(row);

            const cartId = row.getAttribute("data-cart-id");
            fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: `id=${cartId}&quantity=1`
            });
        }
    });

    qtySpan.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
});

    // Checkbox untuk pilih item
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
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Kalau gagal (misalnya stok habis), tampilkan SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient stock!',
                    text: data.error,
                });

                // Kembalikan checkbox ke keadaan sebelumnya
                this.checked = !isChecked;
            } else {
                // Kalau berhasil, update ringkasan
                updateSummary();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update selection. Please try again.',
            });

            // Kembalikan checkbox ke keadaan sebelumnya
            this.checked = !isChecked;
        });
    });
});

    // Size dropdown
    document.querySelectorAll('.size-select').forEach(function (select) {
        const productId = select.dataset.productId;
        const colorId = select.dataset.colorId;
        const cartId = select.dataset.cartId;

        fetch(`/cart/sizes?product_id=${productId}&color_id=${colorId}`)
            .then(res => res.json())
            .then(sizes => {
                select.innerHTML = '';
                sizes.forEach(s => {
                    const option = document.createElement('option');
                    option.value = s.id;
                    option.textContent = `${s.size} ${s.stock === 0 ? '(Out of stock)' : ''}`;
                    option.disabled = s.stock === 0;
                    if (parseInt(s.size) === parseInt(select.getAttribute('data-current-size'))) {
                        option.selected = true;
                    }
                    option.setAttribute('data-stock', s.stock);
                    select.appendChild(option);
                });
            });

        select.addEventListener('change', function () {
          const row = this.closest('tr');
          const qtySpan = row.querySelector('.item-qty');

          const variantId = this.value;
          const selectedOption = this.options[this.selectedIndex];
          const stock = parseInt(selectedOption.getAttribute('data-stock'));

          const currentQty = parseInt(qtySpan.textContent) || 1;

          // sesuaikan quantity: min antara quantity lama dan stock size baru
          const newQty = currentQty > stock ? stock : currentQty;

          // update quantity di UI dan data-stock
          qtySpan.textContent = newQty;
          row.setAttribute('data-stock', stock);

          updateRowTotal(row);
          updateSummary();
          updatePlusButtonState(row);

          fetch('/cart/update-size', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({
                  cart_id: cartId,
                  variant_id: variantId,
                  quantity: newQty
              })
          })
          .then(res => res.json())
          .then(data => {
              if (!data.success) {
                  console.error("Failed to update size.");
              }
          });
        });
      });
});

document.addEventListener("DOMContentLoaded", function () {
  const checkoutBtn = document.getElementById("checkout-btn");

  checkoutBtn.addEventListener("click", function (e) {
    const itemCount = parseInt(document.getElementById('summary-items').innerText);

    if (itemCount === 0) {
      e.preventDefault();
      
      Swal.fire({
        icon: 'warning',
        title: 'Oops!',
        text: 'No items selected for checkout.',
        confirmButtonText: 'OK'
      });
    } else {
      // Show loader only if there are items
      document.getElementById("loader").style.display = "flex";
    }
  });
});


//   window.addEventListener("pageshow", function (event) {
//   // Fired when coming back via Back/Forward cache (bfcache)
//   document.getElementById("loader").style.display = "none";
// });
</script>
@endsection