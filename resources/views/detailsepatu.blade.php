@php
    $user_id = $user_id ?? null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Page - Air Jordan 1 Low</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">

  <style>
    html, body {
    margin: 0;
    padding: 0;
    overflow: hidden; /* Hilangkan scroll */
    height: 100vh;     /* Tinggi sesuai viewport */
    font-family: 'Red Hat Text', sans-serif;
}

.product-wrapper {
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(to bottom, #ffffff, #CFCFCF);
  font-family: 'Red Hat Text', sans-serif;
  margin: 0;
}

.product-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  box-sizing: border-box;
}

.product-page {
  display: flex;
  align-items: flex-start;
  gap: 40px;
  max-width: 1200px;
  width: 100%;
  justify-content: center;
  align-items: center;
}

.left-section {
  width: 100px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.main-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.main-image img {
  width: 150%;
  height: auto;
  transition: 0.3s ease;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.right-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.thumbnail-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.thumbnail {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 12px;
  border: 2px solid transparent;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.2s ease;
  background-color: white;
}

.circle-bg {
  position: absolute;
  width: 320px;
  height: 320px;
  background-color: #791c24;
  border-radius: 50%;
  z-index: 1;
}
.thumbnail.active {
  border: 2px solid #333;
  opacity: 1;
  border-color: black;
}

.thumbnail:hover {
  opacity: 1;
}

.main-image img {
  width: 110%;
  z-index: 2;
  position: relative;
}

.right-section {
  flex: 1;
}

.category {
  color: #777;
  margin-bottom: 10px;
}

.product-name {
  font-size: 36px;
  font-weight: bold;
  margin: 0;
}

.rating {
  font-size: 18px;
  color: gold;
  margin: 8px 0;
}

.amount-sold {
  color: #444;
  margin-bottom: 10px;
}

.price {
  font-size: 24px;
  font-weight: 300;
  color: black;
  margin-bottom: 20px;
}

.color-options {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.color-circle {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  cursor: pointer;
  border: 2px solid #ddd;
  transition: transform 0.2s;
}

.color-circle:hover {
  transform: scale(1.1);
}

.size-title {
  font-weight: bold;
  margin-bottom: 10px;
}

.size-options {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 30px;
}

.size-btn {
  padding: 8px 16px;
  border: 1px solid black;
  background: white;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s;
}

.size-btn.selected {
  background: black;
  color: white;
}

.actions {
  display: flex;
  gap: 10px;
  align-items: center;
}

.buy-now,
.add-cart {
  padding: 10px 20px;
  background: black;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.add-cart {
  background: #444;
}

.wishlist {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}
.back-to-collection {
    position: fixed;
    top: 20px;
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
.color-circle.selected {
    border: 2px solid #000; 
}
.size-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
  </style>
</head>
<body>
<a href="javascript:void(0);" onclick="history.back();" class="back-to-collection" title="Kembali ke koleksi">
  <i data-feather="corner-down-left"></i>
</a>
<div class="product-wrapper">
    <div class="product-page">
        @if ($product)
            <div class="left-section">
                <div class="thumbnail-list">
                    <img src="{{ asset('image/sepatu/atas/' . $product->image_atas) }}" class="thumbnail active" alt="Tampak Atas">
                    <img src="{{ asset('image/sepatu/bawah/' . $product->image_bawah) }}" class="thumbnail" alt="Tampak Bawah">
                    <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" class="thumbnail" alt="Tampak Kiri">
                    <img src="{{ asset('image/sepatu/kanan/' . $product->image_kanan) }}" class="thumbnail" alt="Tampak Kanan">
                </div>
            </div>

            <div class="main-image">
                <div class="circle-bg" style="background-color: {{ $product->color_code_bg }};"></div>
                <img id="mainShoeImage" src="{{ asset('image/sepatu/atas/' . $product->image_atas) }}" alt="{{ $product->product_name }}" />
            </div>

            <div class="right-section">
                <p class="category">
                    {{ ucfirst($product->gender) }} {{ $product->category_name }} Shoes
                </p>

                <h1 class="product-name">
                    {!! nl2br(e($product->product_name)) !!}
                </h1>

                <p class="price">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="color-options">
                    @if (!empty($color_options))
                    @foreach ($color_options as $index => $color)
                        <div 
                            class="color-circle{{ $index === 0 ? ' selected' : '' }}"
                            data-color-code="{{ $color->color_code }}"
                            data-color-code-bg="{{ $color->color_code }}"
                            data-image-atas="{{ asset('image/sepatu/atas/' . $color->image_atas) }}"
                            data-image-bawah="{{ asset('image/sepatu/bawah/' . $color->image_bawah) }}"
                            data-image-kiri="{{ asset('image/sepatu/kiri/' . $color->image_kiri) }}"
                            data-image-kanan="{{ asset('image/sepatu/kanan/' . $color->image_kanan) }}"
                            style="background-color: {{ $color->color_code }};"
                        ></div>
                    @endforeach
                    @endif
                </div>
                <p class="size-title">Select Size</p>
                <div class="size-options">
                    @if (!empty($size_options) && count($size_options) > 0)
                        @foreach ($size_options as $index => $size)
                            <button class="size-btn{{ $index === 0 ? ' selected' : '' }}" data-size="{{ $size->size }}">
                                EU {{ $size->size }}
                            </button>
                        @endforeach
                    @else
                        <p class="no-size">Size not available</p>
                    @endif
                </div>

                <p id="stockInfo" class="stock-info">Stock: -</p>

                <div class="actions">
                    <button class="buy-now">Buy Now</button>
                    <button class="add-cart" 
                            id="addToCartBtn"
                            data-product-id="{{ $product->product_id ?? '' }}">
                        Add To Cart
                    </button>
                    <button class="wishlist" data-product-id="{{ $product->product_id ?? '' }}">♡</button>
                </div>
            </div>
        @else
            <p>Produk tidak ditemukan.</p>
        @endif
    </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
</script>
<script>

document.addEventListener('DOMContentLoaded', function () {
    const stockData = @json($size_stock);
    let selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;
    let selectedColorCodeBg = document.querySelector('.color-circle.selected')?.dataset.colorCodeBg;

    if (selectedColorCodeBg) {
        document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg;
    }

    const updateSizeButtons = () => {
        document.querySelectorAll('.size-btn').forEach(btn => {
            const size = btn.dataset.size;
            const match = stockData.find(item =>
    item.size.toString() === size &&
    item.color_code.toLowerCase() === selectedColorCode.toLowerCase() &&
    parseInt(item.stock) > 0
);

            if (match) {
                btn.disabled = false;
                btn.classList.remove('disabled');
            } else {
                btn.disabled = true;
                btn.classList.remove('selected');
                btn.classList.add('disabled');
            }
        });
    };

    const showStockAlert = () => {
        const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;

        if (selectedSize && selectedColorCode) {
            const match = stockData.find(item =>
    item.size.toString() === selectedSize.toString() &&
    item.color_code.toLowerCase() === selectedColorCode.toLowerCase()
);

            if (match) {
                document.getElementById('stockInfo').textContent = 'Stock: ' + match.stock;
            } else {
                document.getElementById('stockInfo').textContent = 'Stock: 0';
            }
        } else {
            document.getElementById('stockInfo').textContent = 'Stock: -';
        }
    };

    // Event listener warna
    document.querySelectorAll('.color-circle').forEach(el => {
        el.addEventListener('click', function () {
        document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        selectedColorCode = this.dataset.colorCode;
        selectedColorCodeBg = this.dataset.colorCodeBg;

        // Ganti latar belakang
        document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg;

        // Ganti gambar utama
        const newImage = this.dataset.imageAtas;
        document.getElementById('mainShoeImage').src = newImage;

        // Ganti thumbnail
        document.querySelectorAll('.thumbnail')[0].src = this.dataset.imageAtas;
        document.querySelectorAll('.thumbnail')[1].src = this.dataset.imageBawah;
        document.querySelectorAll('.thumbnail')[2].src = this.dataset.imageKiri;
        document.querySelectorAll('.thumbnail')[3].src = this.dataset.imageKanan;

        updateSizeButtons();
        showStockAlert();
    });
    });

    // Event listener size
    document.querySelectorAll('.size-btn').forEach(el => {
        el.addEventListener('click', function () {
            if (this.disabled) return;
            document.querySelectorAll('.size-btn').forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            showStockAlert();
        });
    });

    updateSizeButtons();
    document.querySelector('.size-btn:not([disabled])')?.click();

    // Thumbnail image switch
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            const mainImg = document.getElementById('mainShoeImage');
            mainImg.src = this.src;

            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const altText = this.alt.toLowerCase();
            if (altText.includes("kiri")) {
                mainImg.style.transform = "rotate(-28deg)";
            } else if (altText.includes("kanan")) {
                mainImg.style.transform = "rotate(28deg)";
            } else {
                mainImg.style.transform = "rotate(0deg)";
            }
        });
    });

    // Feather icons replace
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Wishlist
    const wishlistBtn = document.querySelector('.wishlist');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            fetch('{{ route("wishlist.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Produk ditambahkan ke wishlist!");
                } else {
                    alert("Gagal menambahkan ke wishlist.");
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Add to Cart
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
            const selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;

            if (!selectedSize || !selectedColorCode) {
                alert('Silakan pilih ukuran dan warna terlebih dahulu.');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('product_id', productId);
            formData.append('size', selectedSize);
            formData.append('color_code', selectedColorCode);

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Error:', err);
            });
        });
    }
});
</script>

</body>
</html>
