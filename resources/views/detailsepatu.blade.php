@extends('base.base1')

@section('title', 'Home')

@section('content') 
@php
    use Illuminate\Support\Facades\Session;
@endphp

@php
    $user_id = Session::get('user_id',1)
@endphp

@if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
  <title>Product Page - Air Jordan 1 Low</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    html, body {
    margin: 0;
    padding: 0;
    font-family: 'Red Hat Text', sans-serif;
}

.product-wrapper {
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
body {
  justify-content: center;
  align-items: center;
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
  opacity:80%;
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
.add-cart, #confirmAddToCart, #add-review-btn, #submitReview {
  padding: 10px 20px;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.add-cart, #confirmAddToCart, #add-review-btn, #submitReview {
  background: #444;
  transition: background-color 0.3s;
}

.add-cart:hover, #confirmAddToCart:hover, #add-review-btn:hover, #submitReview:hover {
  background:black;
}

.wishlist {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
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
.color-circle.selected {
    border: 2px solid #000; 
}
.size-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
#mainShoeImage {
    transition: opacity 0.3s ease;
    opacity: 1;
}

#mainShoeImage.fade-out {
    opacity: 0;
}
.product-rating i {
    font-size: 20px;
    vertical-align: middle;
}
.rating-number {
    font-size: 16px;
    vertical-align: middle;
    color: #333;
}

    .you-may-also-like-section h2{
      margin:30px 80px 20px 90px
}

    .product-card {
        background-color: #fff; 
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 240px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s, background-color 0.3s; 
        position: relative;
    }

    .product-card img {
        max-width: 100%;
        height: auto;
        transform: rotate(-28deg);
        border-radius: 4px;
        transition: transform 0.3s ease-in-out;
    }

    .product-card:hover img {
        transform: rotate(0deg); 
    }

.product-card:hover {
    background-color: var(--bg-color);
    color: var(--font-color);
}

.product-card:hover h3,
.product-card:hover p {
    color: var(--font-color);
}
    .product-card:hover {
        transform: translateY(-10px); 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        background-color: var(--bg-color); 
    }

    .product-card h3 {
        transition: all 0.3s ease;
        font-size: 18px;
        margin: 10px 0;
        color: inherit; 
        color: #333;
    }

    .product-card p {
        transition: all 0.3s ease;
        font-size: 16px;
        color: #333;
    }
    .overflow-x-auto::-webkit-scrollbar {
    display: none;
}

.product-card {
  height: 350px;
}

.horizontal-scroll-wrapper {
  display: flex;
  gap: 100px;
  overflow-x: auto;
  padding: 1rem 0;
  scroll-snap-type: x mandatory;
  margin:0px 80px 0px 80px
}

.horizontal-scroll-wrapper::-webkit-scrollbar {
  display: none; 
}

.product-link {
  flex: 0 0 auto;
  width: 200px; 
  scroll-snap-align: start;
  text-decoration:none;
}


.product-review-section {
  margin-top: 2rem;
}

.review-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 1rem;
  background-color: #fff;
}


  .product-review-section{
    margin-bottom:100px;
  }

  #stars{
    margin-right:40px;
  }
  
  .mobile-thumbnail {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 12px;
  border: 2px solid transparent;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.2s ease, border-color 0.2s ease;
  background-color: white;
  position: relative;
  z-index: 3;
}

.mobile-thumbnail.active {
  border-color: black;
  opacity: 1;
}

.mobile-thumbnail:hover {
  opacity: 1;
}

.mobile-circle-bg {
  position: absolute;
  width: 320px;
  height: 320px;
  background-color: #791c24; /* default, bisa diubah dinamis */
  border-radius: 50%;
  z-index: 1;
  top: 0;
  left: 0;
}

.mobile-main-image img {
  width: 110%;
  z-index: 2;
  position: relative;
  transition: transform 0.3s ease;
}

.mobile-right-section {
  flex: 1;
}

.mobile-category {
  color: #777;
  margin-bottom: 10px;
}

.mobile-product-name {
  font-size: 36px;
  font-weight: bold;
  margin: 0;
}

.mobile-rating {
  font-size: 18px;
  color: gold;
  margin: 8px 0;
}

.mobile-amount-sold {
  color: #444;
  margin-bottom: 10px;
}

.mobile-price {
  font-size: 24px;
  font-weight: 300;
  color: black;
  margin-bottom: 20px;
}

.mobile-color-options {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.mobile-color-circle {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  cursor: pointer;
  border: 2px solid #ddd;
  transition: transform 0.2s, border-color 0.2s;
  position: relative;
}

.mobile-color-circle:hover {
  transform: scale(1.1);
}

.mobile-color-circle.selected {
  border-color: black;
}

.mobile-size-title {
  font-weight: bold;
  margin-bottom: 10px;
}

.mobile-size-options {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 30px;
}

.mobile-size-btn {
  padding: 8px 16px;
  border: 1px solid black;
  background: white;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s, color 0.3s;
  user-select: none;
}

.mobile-size-btn.selected {
  background: black;
  color: white;
}

.mobile-size-btn.disabled {
  cursor: not-allowed;
  opacity: 0.4;
}

/* Untuk menampilkan stock info */
#stockInfo {
  font-weight: 600;
  margin-top: -15px;
  margin-bottom: 20px;
  color: #333;
}

/* Contoh styling untuk tombol wishlist & add to cart */
.mobile-wishlist-btn {
  cursor: pointer;
  color: #aaa;
  transition: color 0.3s;
}

.mobile-wishlist-btn.active {
  color: black;
}

.mobile-add-cart {
  background-color: #444;
  color: white;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 8px;
  transition: background-color 0.3s;
}

.mobile-add-cart:hover {
  background-color: black;
}

  /* product-page mobile style */
.mobile-product-wrapper {
  margin-top:60px;
  margin-bottom:100px;
  padding: 16px;
  font-family: Arial, sans-serif;
}

.mobile-category {
  font-size: 14px;
  color: #888;
  margin-bottom: 4px;
}

.mobile-product-rating {
  display: flex;
  align-items: center;
}

.mobile-rating-number {
  margin-left: 8px;
  font-weight: bold;
}

.mobile-product-name {
  font-size: 18px;
  margin: 8px 0;
}

.mobile-product-images {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.mobile-thumbnail-list {
  display: flex;
  gap: 8px;
  margin-bottom: 12px;
}

.mobile-thumbnail {
  width: 75px;
  height: 75px;
  margin-top:40px;
  object-fit: cover;
  border: 1px solid #ccc;
  cursor: pointer;
}

.mobile-thumbnail.active {
  border: 2px solid #000;
}

.mobile-main-image-wrapper {
  position: relative;
  width: 100%;
  max-width: 300px;
}

.mobile-circle-bg {
  width: 300px;
  height: 300px;
  border-radius: 150px;
  top: 0;
  z-index: 0;
}

.mobile-main-image-wrapper img {
  position: relative;
  width: 100%;
  z-index: 1;
}

.mobile-price {
  font-size: 20px;
  font-weight: bold;
  margin-top: 12px;
}

.mobile-color-options {
  display: flex;
  gap: 8px;
  margin: 12px 0;
}

.mobile-color-circle {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  border: 2px solid #ddd;
  cursor: pointer;
}

.mobile-color-circle.selected {
  border: 2px solid #000;
}

.mobile-size-title {
  font-weight: bold;
  margin-top: 16px;
}

.mobile-size-options {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin: 8px 0;
}

.mobile-size-btn {
  padding: 8px 12px;
  border: 1px solid #ccc;
  background: white;
  cursor: pointer;
}

.mobile-size-btn.selected {
  background: black;
  color: white;
}

.mobile-stock-info {
  margin-top: 10px;
  font-size: 14px;
}

.mobile-actions {
  display: flex;
  gap: 12px;
  margin-top: 16px;
}

.mobile-add-cart {
  flex: 1;
  padding: 10px;
  background-color: #444;
  color: white;
  border: none;
  cursor: pointer;
}

.mobile-wishlist-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: black;
}

#mainImage {
    transition: opacity 0.3s ease;
    opacity: 1;
}

#mainImage.fade-out {
    opacity: 0;
}

.product-wrapper {
  display: block;
  margin:100px 100px 0px 100px
}

.mobile-product-wrapper {
  display: none;
}
.qty-selector {
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
  width: 50px;
  height: 30px;
  font-size: 18px;
  font-weight: 500;
  text-align: center;
  padding: 0;
  margin: 0;
  appearance: textfield;
}

.qty-value:focus {
  outline: none;
  box-shadow: none;
}

.qty-value::-webkit-inner-spin-button,
.qty-value::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Base bottom sheet style */
.modal.modal-bottom .modal-dialog {
  position: fixed;
  bottom: 0;
  margin: 0 auto;
  width: 100%;
  max-width: 600px; /* LIMIT width on desktop */
  transform: translateY(100%);
  transition: transform 0.3s ease-out;
  left: 0;
  right: 0;
}

.modal.modal-bottom.show .modal-dialog {
  transform: translateY(0);
}

.modal-content {
  border-radius: 12px 12px 0 0;
  padding: 16px;
}

/* Optional shadow effect */
.modal.modal-bottom .modal-dialog {
  box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.2);
}

.star-rating input {
    display: none;
}
.star-rating label {
    color: #ccc;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
}

/* .star-rating {
    direction: rtl;
    font-size: 2rem;
    unicode-bidi: bidi-override;
    display: inline-flex;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #ccc;
    cursor: pointer;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
} */

@media screen and (max-width: 768px) {
  .product-wrapper {
    display: none;
  }
  .back-to-collection {
    top:80px;
  }

  .mobile-product-wrapper {
    display: block;
  }
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
      100% { transform: rotate(360deg);}
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
      100% { transform: rotate(360deg); }
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
      
          {{-- Rating stars di sini --}}
          <div class="product-rating" title="{{ $product->rating }} out of 5 stars">
            @php
              $fullStars = floor(number_format($averageRating, 1));
              $halfStar = ($averageRating - $fullStars) >= 0.5;
              $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            @endphp
            
            @for ($i = 0; $i < $fullStars; $i++)
                <i class="bi bi-star-fill" style="color: black;"></i>
            @endfor
            
            @if ($halfStar)
                <i class="bi bi-star-half" style="color: black;"></i>
            @endif
            
            @for ($i = 0; $i < $emptyStars; $i++)
                <i class="bi bi-star" style="color: black;"></i>
            @endfor
      
              <span class="rating-number" style="margin-left: 8px; font-weight: 600;">
                  {{ number_format($averageRating, 1) }}/5
              </span>
          </div>
      
          <h1 class="product-name">
              {!! nl2br(e($product->product_name)) !!}
          </h1>
      
          <p class="price">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>

              <div class="color-options">
                  @if (!empty($color_options))
                  @foreach ($color_options as $index => $color)
                      <div 
                          class="color-circle{{ $index === 0 ? ' selected' : '' }}"
                          data-color-name="{{ $color->color_name }}"
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
                {{-- <button class="add-cart"
                        id="addToCartBtn"
                        data-product-id="{{ $product->product_id ?? request()->get('id') }}">
                    Add To Cart
                </button> --}}

                <button class="add-cart"
        id="addToCartBtn"
        data-product-id="{{ $product->product_id }}">
    Add To Cart
</button>
                {{-- <p>User ID: {{ $user_id = Session::get('user_id', 'Guest') }}</p>
                <p>Product ID: {{ $product->product_id }}</p>
                <p>Wishlisted: {{ $isWishlisted ? 'YES' : 'NO' }}</p> --}}
              <button class="wishlist-btn" id="wishlistBtn" data-product-id="{{ $product->product_id }}">
                <i class="bi {{ $isWishlisted ? 'bi-heart-fill' : 'bi-heart' }}"></i>
              </button>
            </div>
          </div>
      @else
          <p>Product not found</p>
      @endif
  </div>
</div>

<div class="mobile-product-wrapper">
  <div class="mobile-product-page">
    @if ($product)
    <div class="mobile-product-header">
      <p class="mobile-category">
        {{ ucfirst($product->gender) }} {{ $product->category_name }} Shoes
      </p>

      <div class="mobile-product-rating" title="{{ $product->rating }} out of 5 stars">
        @php
          $fullStars = floor(number_format($averageRating, 1));
          $halfStar = ($averageRating - $fullStars) >= 0.5;
          $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        @endphp

        @for ($i = 0; $i < $fullStars; $i++)
          <i class="bi bi-star-fill" style="color: black;"></i>
        @endfor

        @if ($halfStar)
          <i class="bi bi-star-half" style="color: black;"></i>
        @endif

        @for ($i = 0; $i < $emptyStars; $i++)
          <i class="bi bi-star" style="color: black;"></i>
        @endfor

        <span class="mobile-rating-number">
          {{ number_format($averageRating, 1) }}/5
        </span>
      </div>

      <h1 class="mobile-product-name">{!! nl2br(e($product->product_name)) !!}</h1>
    </div>

    <div class="mobile-product-images">
      <div class="mobile-main-image-wrapper">
        <div class="mobile-circle-bg" style="background-color: {{ $product->color_code_bg }};"></div>
        <img id="mainImage" src="{{ asset('image/sepatu/atas/' . $product->image_atas) }}" alt="{{ $product->product_name }}">
      </div>
      <div class="mobile-thumbnail-list">
        <img src="{{ asset('image/sepatu/atas/' . $product->image_atas) }}" class="mobile-thumbnail active" alt="Tampak Atas">
        <img src="{{ asset('image/sepatu/bawah/' . $product->image_bawah) }}" class="mobile-thumbnail" alt="Tampak Bawah">
        <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" class="mobile-thumbnail" alt="Tampak Kiri">
        <img src="{{ asset('image/sepatu/kanan/' . $product->image_kanan) }}" class="mobile-thumbnail" alt="Tampak Kanan">
      </div>
    </div>

    <p class="mobile-price">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>

    <div class="mobile-color-options">
      @if (!empty($color_options))
        @foreach ($color_options as $index => $color)
        <div class="mobile-color-circle{{ $index === 0 ? ' selected' : '' }}"
          data-color-code="{{ $color->color_code }}"
          data-color-code-bg="{{ $color->color_code }}"
          data-image-atas="{{ asset('image/sepatu/atas/' . $color->image_atas) }}"
          data-image-bawah="{{ asset('image/sepatu/bawah/' . $color->image_bawah) }}"
          data-image-kiri="{{ asset('image/sepatu/kiri/' . $color->image_kiri) }}"
          data-image-kanan="{{ asset('image/sepatu/kanan/' . $color->image_kanan) }}"
          style="background-color: {{ $color->color_code }};">
        </div>
        @endforeach
      @endif
    </div>

    <p class="mobile-size-title">Select Size</p>
    <div class="mobile-size-options">
      @if (!empty($size_options) && count($size_options) > 0)
        @foreach ($size_options as $index => $size)
          <button class="mobile-size-btn{{ $index === 0 ? ' selected' : '' }}" data-size="{{ $size->size }}">
            EU {{ $size->size }}
          </button>
        @endforeach
      @else
        <p class="mobile-no-size">Size not available</p>
      @endif
    </div>

    <p id="stockIn" class="mobile-stock-info">Stock: -</p>

    <div class="mobile-actions">
      {{-- <button class="mobile-add-cart"
              id="addToCartBtn"
              data-product-id="{{ $product->product_id ?? request()->get('id') }}">
          Add To Cart
      </button> --}}

<button class="mobile-add-cart"
        id="addToCartBtn"
        data-product-id="{{ $product->product_id }}">
    Add To Cart
</button>
      <button class="mobile-wishlist-btn" id="wishlistBtn" data-product-id="{{ $product->product_id }}">
        <i class="bi {{ $isWishlisted ? 'bi-heart-fill' : 'bi-heart' }}"></i>
      </button>
    </div>
    @else
    <p>Product not found</p>
    @endif
  </div>
</div>

{{-- <div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog modal-bottom">
    <div class="modal-content p-3">
      <div class="d-flex align-items-center">
        <img id="modalShoeImageKiri" src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" alt="{{ $product->product_name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
        <div>
          <p class="mb-1 fw-semibold">{{ $product->product_name }}</p>
          <small class="text-muted">Size: <span id="modalSelectedSize">-</span></small><br>
          <small class="text-muted">Color: <span id="modalSelectedColor">{{ $product->color_name ?? '-' }}</span></small><br>
          <small class="text-muted">Stock: <span id="modalSelectedStock">-</span></small>
        </div>
      </div>
      <div class="d-flex align-items-center mt-3 justify-content-between">
        <span class="fw-semibold">Quantity:</span>
        <div class="qty-selector">
          <button class="qty-btn" id="btnMinus">-</button>
          <input id="inputQuantity" class="qty-value" type="number" value="1" min="1" readonly>
          <button class="qty-btn" id="btnPlus">+</button>
        </div>
      </div>

      <!-- Confirm Button -->
      <div class="mt-3 text-center">
        <button type="button" class="btn" id="confirmAddToCart">Confirm</button>
      </div>
    </div>
  </div>
</div> --}}

<div class="modal fade modal-bottom" id="cartModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="d-flex">
        <!-- Product image on left -->
        <img id="modalShoeImageKiri" src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" alt="{{ $product->product_name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
        
        <!-- Product details on right -->
        <div class="flex-grow-1">
          <p class="mb-1 fw-semibold">{{ $product->product_name }}</p>
          <small class="text-muted">Size: <span id="modalSelectedSize">-</span></small><br>
          <small class="text-muted">Color: <span id="modalSelectedColor">{{ $product->color_name ?? '-' }}</span></small><br>
          <small class="text-muted">Stock: <span id="modalSelectedStock">-</span></small>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-3">
        <span class="fw-semibold">Quantity:</span>
        <div class="qty-selector d-flex align-items-center">
          <button class="qty-btn" id="btnMinus">-</button>
          <input id="inputQuantity" class="qty-value" type="number" value="1" min="1">
          <button class="qty-btn" id="btnPlus">+</button>
        </div>
      </div>

      <!-- Confirm Button -->
      <div class="mt-3 text-center">
        <button type="button" class="btn btn-dark w-100" id="confirmAddToCart">Confirm</button>
      </div>
    </div>
  </div>
</div>

<div id="loader" class="loader-overlay" style="display: none;">
      <div class="loader"></div>
</div>
<script>
  // Fungsi untuk update qty dengan batasan stok
  function updateQuantityButtons() {
    const btnMinus = document.getElementById('btnMinus');
    const btnPlus = document.getElementById('btnPlus');
    const inputQty = document.getElementById('inputQuantity');
    const stockText = document.getElementById('modalSelectedStock').textContent.trim();

    const maxStock = parseInt(stockText) || 0;

    if (!btnMinus || !btnPlus || !inputQty || maxStock <= 0) return;

    // Reset quantity ke 1 saat modal muncul
    inputQty.value = 1;

    // Hapus event listener sebelumnya biar gak dobel
    const newBtnMinus = btnMinus.cloneNode(true);
    const newBtnPlus = btnPlus.cloneNode(true);
    btnMinus.parentNode.replaceChild(newBtnMinus, btnMinus);
    btnPlus.parentNode.replaceChild(newBtnPlus, btnPlus);

    newBtnMinus.addEventListener('click', () => {
      let current = parseInt(inputQty.value) || 1;
      if (current > 1) {
        inputQty.value = current - 1;
      }
    });

    newBtnPlus.addEventListener('click', () => {
      let current = parseInt(inputQty.value) || 1;
      if (current < maxStock) {
        inputQty.value = current + 1;
      }
    });

    inputQty.addEventListener('input', () => {
  let current = parseInt(inputQty.value);

  // Biarkan kosong saat sedang diketik (jangan paksa jadi 1)
  if (inputQty.value === '') return;

  if (isNaN(current) || current < 1) {
    inputQty.value = 1;
  } else if (current > maxStock) {
    inputQty.value = maxStock;
  }
});

// ✅ Tambahan: kalau keluar dari input, kosong → balik ke 1
inputQty.addEventListener('blur', () => {
  if (inputQty.value === '') {
    inputQty.value = 1;
  }
});
  }

  // Jalankan saat modal selesai tampil
  const cartModalElem = document.getElementById('cartModal');
  if (cartModalElem) {
    cartModalElem.addEventListener('shown.bs.modal', () => {
      updateQuantityButtons();
    });
  }
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Data stok yang di-push dari backend melalui Blade
    const stockData = @json($size_stock);
  
    // Inisialisasi warna yang terpilih (ambil dari salah satu, mobile atau desktop)
    let selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode || 
                            document.querySelector('.mobile-color-circle.selected')?.dataset.colorCode;
    let selectedColorCodeBg = document.querySelector('.color-circle.selected')?.dataset.colorCodeBg || 
                              document.querySelector('.mobile-color-circle.selected')?.dataset.colorCodeBg;
  
    if (selectedColorCodeBg) {
      document.querySelector('.circle-bg') && (document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg);
      document.querySelector('.mobile-circle-bg') && (document.querySelector('.mobile-circle-bg').style.backgroundColor = selectedColorCodeBg);
    }
  
    // Variabel untuk posisi thumbnail aktif: bisa 'atas', 'bawah', 'kiri', atau 'kanan'
    let activePosition = 'atas';
  
    // Fungsi untuk meng-update tombol ukuran di kedua sisi berdasarkan stok dan warna yang dipilih
    const updateSizeButtons = () => {
      // Mobile
      document.querySelectorAll('.mobile-size-btn').forEach(btn => {
        const size = btn.dataset.size;
        const match = stockData.find(item =>
          item.size.toString() === size &&
          item.color_code.toLowerCase() === selectedColorCode?.toLowerCase() &&
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
      // Desktop
      document.querySelectorAll('.size-btn').forEach(btn => {
        const size = btn.dataset.size;
        const match = stockData.find(item =>
          item.size.toString() === size &&
          item.color_code.toLowerCase() === selectedColorCode?.toLowerCase() &&
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
  
    // Fungsi untuk menampilkan informasi stok di kedua tampilan
    const showStockAlert = () => {
      const selectedSize = document.querySelector('.mobile-size-btn.selected')?.dataset.size || 
                           document.querySelector('.size-btn.selected')?.dataset.size;
      if (selectedSize && selectedColorCode) {
        const match = stockData.find(item =>
          item.size.toString() === selectedSize.toString() &&
          item.color_code.toLowerCase() === selectedColorCode.toLowerCase()
        );
        const stock = match ? match.stock : 0;
        document.getElementById('stockIn').textContent = 'Stock: ' + stock;
        document.getElementById('stockInfo').textContent = 'Stock: ' + stock;
        document.getElementById('modalSelectedStock').textContent = stock;
      } else {
        document.getElementById('stockIn').textContent = 'Stock: -';
        document.getElementById('stockInfo').textContent = 'Stock: -';
      }
    };
  
    // Fungsi fade untuk mengganti gambar utama dengan transisi
    const changeMainImageWithFade = (imgElement, newSrc) => {
      imgElement.classList.add('fade-out');
      setTimeout(() => {
        imgElement.src = newSrc;
        imgElement.onload = () => {
          imgElement.classList.remove('fade-out');
        };
      }, 200);
    };
  
    // -------------------------------
    // Sinkronisasi Warna (Color Selector)
    // -------------------------------
    // Fungsi update warna berdasarkan index (karena urutan antara desktop dan mobile diharapkan sama)
    const updateColorByIndex = (index) => {
      const mobileCircles = document.querySelectorAll('.mobile-color-circle');
      const desktopCircles = document.querySelectorAll('.color-circle');
      if (!mobileCircles[index] && !desktopCircles[index]) return;
  
      // Bersihkan kelas 'selected'
      mobileCircles.forEach(c => c.classList.remove('selected'));
      desktopCircles.forEach(c => c.classList.remove('selected'));
  
      // Tambahkan selected ke kedua sisi
      if (mobileCircles[index]) mobileCircles[index].classList.add('selected');
      if (desktopCircles[index]) desktopCircles[index].classList.add('selected');
  
      // Ambil data dari salah satu (misalnya desktop)
      const circle = desktopCircles[index] || mobileCircles[index];
      selectedColorCode = circle.dataset.colorCode;
      selectedColorCodeBg = circle.dataset.colorCodeBg;
  
      // Update background di kedua sisi
      document.querySelector('.circle-bg') && (document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg);
      document.querySelector('.mobile-circle-bg') && (document.querySelector('.mobile-circle-bg').style.backgroundColor = selectedColorCodeBg);
  
      updateSizeButtons();
      showStockAlert();
  
      // Update gambar (thumbnail & main image)
      const selectedImage = stockData.find(item =>
        item.color_code.toLowerCase() === selectedColorCode.toLowerCase()
      );
      if (selectedImage) {
        const basePathAtas   = "{{ asset('image/sepatu/atas') }}/";
        const basePathBawah  = "{{ asset('image/sepatu/bawah') }}/";
        const basePathKiri   = "{{ asset('image/sepatu/kiri') }}/";
        const basePathKanan  = "{{ asset('image/sepatu/kanan') }}/";
  
        // Update thumbnail mobile dan desktop
        const mobileThumbs = document.querySelectorAll('.mobile-thumbnail');
        const desktopThumbs = document.querySelectorAll('.thumbnail');
        if(mobileThumbs.length >= 4) {
          mobileThumbs[0].src = basePathAtas + selectedImage.image_atas;
          mobileThumbs[1].src = basePathBawah + selectedImage.image_bawah;
          mobileThumbs[2].src = basePathKiri + selectedImage.image_kiri;
          mobileThumbs[3].src = basePathKanan + selectedImage.image_kanan;
        }
        if(desktopThumbs.length >= 4) {
          desktopThumbs[0].src = basePathAtas + selectedImage.image_atas;
          desktopThumbs[1].src = basePathBawah + selectedImage.image_bawah;
          desktopThumbs[2].src = basePathKiri + selectedImage.image_kiri;
          desktopThumbs[3].src = basePathKanan + selectedImage.image_kanan;
        }
  
        // Tentukan sumber gambar baru berdasarkan posisi aktif
        const imageSrcObj = {
          atas: mobileThumbs[0].src,
          bawah: mobileThumbs[1].src,
          kiri: mobileThumbs[2].src,
          kanan: mobileThumbs[3].src
        };
        
        const newSrc = imageSrcObj[activePosition] || mobileThumbs[0].src;
        // Update main image untuk kedua sisi
        const mobileMainImg = document.getElementById('mainImage');
        const desktopMainImg = document.getElementById('mainShoeImage');
        changeMainImageWithFade(mobileMainImg, newSrc);
        changeMainImageWithFade(desktopMainImg, newSrc);
      }
    };
  
    // Pasang event listener pada kedua sisi untuk warna
    document.querySelectorAll('.mobile-color-circle').forEach((el, index) => {
      el.addEventListener('click', function () {
        updateColorByIndex(index);
      });
    });
    document.querySelectorAll('.color-circle').forEach((el, index) => {
      el.addEventListener('click', function () {
        updateColorByIndex(index);
      });
    });
  
    // -------------------------------
    // Sinkronisasi Thumbnail
    // -------------------------------
    // Saat klik pada thumbnail mobile
    document.querySelectorAll('.mobile-thumbnail').forEach((thumb, index) => {
      thumb.addEventListener('click', function () {
        document.querySelectorAll('.mobile-thumbnail').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.thumbnail')[index].classList.add('active');
        activePosition = ['atas', 'bawah', 'kiri', 'kanan'][index];
  
        const mobileMainImg = document.getElementById('mainImage');
        const desktopMainImg = document.getElementById('mainShoeImage');
        mobileMainImg.src = this.src;
        desktopMainImg.src = this.src;
  
        const altText = this.alt.toLowerCase();
        const angle = altText.includes('kiri') ? '-28deg' : altText.includes('kanan') ? '28deg' : '0deg';
        mobileMainImg.style.transform = `rotate(${angle})`;
        desktopMainImg.style.transform = `rotate(${angle})`;
      });
    });
    // Saat klik pada thumbnail desktop
    document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
      thumb.addEventListener('click', function () {
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.mobile-thumbnail').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        activePosition = ['atas', 'bawah', 'kiri', 'kanan'][index];
        document.querySelectorAll('.mobile-thumbnail')[index].classList.add('active');
        const mobileMainImg = document.getElementById('mainImage');
        const desktopMainImg = document.getElementById('mainShoeImage');
        mobileMainImg.src = this.src;
        desktopMainImg.src = this.src;
  
        const altText = this.alt.toLowerCase();
        const angle = altText.includes('kiri') ? '-28deg' : altText.includes('kanan') ? '28deg' : '0deg';
        mobileMainImg.style.transform = `rotate(${angle})`;
        desktopMainImg.style.transform = `rotate(${angle})`;
      });
    });
  
    // -------------------------------
    // Sinkronisasi Ukuran
    // -------------------------------
    // Fungsi update ukuran berdasarkan index (sama untuk desktop dan mobile)
    const updateSelectedSize = (index) => {
      const mobileSizes = document.querySelectorAll('.mobile-size-btn');
      const desktopSizes = document.querySelectorAll('.size-btn');
      mobileSizes.forEach(btn => btn.classList.remove('selected'));
      desktopSizes.forEach(btn => btn.classList.remove('selected'));
      if (mobileSizes[index]) mobileSizes[index].classList.add('selected');
      if (desktopSizes[index]) desktopSizes[index].classList.add('selected');
      showStockAlert();
    };
  
    document.querySelectorAll('.mobile-size-btn').forEach((btn, index) => {
      btn.addEventListener('click', () => updateSelectedSize(index));
    });
    document.querySelectorAll('.size-btn').forEach((btn, index) => {
      btn.addEventListener('click', () => updateSelectedSize(index));
    });
  
    // Inisialisasi tombol ukuran (update dan klik pertama yang aktif)
    updateSizeButtons();
    document.querySelector('.mobile-size-btn:not([disabled])')?.click();
    document.querySelector('.size-btn:not([disabled])')?.click();
  
    // -------------------------------
    // Wishlist (contoh: untuk mobile saja, implementasi sync opsional)
    // -------------------------------
//     document.querySelectorAll('.mobile-wishlist-btn').forEach(button => {
//   button.addEventListener('click', function () {
//     const productId = this.dataset.productId;
//     const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     const icon = this.querySelector('i');
//     const isWishlisted = icon.classList.contains('bi-heart-fill');
//     const url = isWishlisted ? '/wishlist/remove' : '/wishlist/add';

//     fetch(url, {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': token
//       },
//       body: JSON.stringify({ product_id: productId })
//     })
//     .then(response => response.json())
//     .then(data => {
//       if (data.success) {
//         // Toggle ikon pada mobile
//         this.classList.toggle('active');
//         icon.classList.toggle('bi-heart');
//         icon.classList.toggle('bi-heart-fill');

//         const desktopBtn = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
//         if (desktopBtn) {
//           const desktopIcon = desktopBtn.querySelector('i');
//           desktopBtn.classList.toggle('active', icon.classList.contains('bi-heart-fill'));
//           desktopIcon.classList.remove('bi-heart', 'bi-heart-fill');
//           desktopIcon.classList.add(icon.classList.contains('bi-heart-fill') ? 'bi-heart-fill' : 'bi-heart');
//         }
//       } else {
//         alert(data.message || 'Failed to Update Wishlist');
//       }
//     })
//     .catch(error => {
//       console.error(error);
//       alert('An Error Occured When Updating Wishlist');
//     });
//   });
// });

document.querySelectorAll('.mobile-wishlist-btn').forEach(button => {
  button.addEventListener('click', function () {
    if (this.classList.contains('loading')) return; // Cegah spam klik
    this.classList.add('loading'); // Tandai sedang loading

    const productId = this.dataset.productId;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const icon = this.querySelector('i');
    const isWishlisted = icon.classList.contains('bi-heart-fill');
    const url = isWishlisted ? '/wishlist/remove' : '/wishlist/add';

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Toggle ikon pada mobile
        this.classList.toggle('active');
        icon.classList.toggle('bi-heart');
        icon.classList.toggle('bi-heart-fill');

        // Sinkronisasi ikon pada desktop
        const desktopBtn = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
        if (desktopBtn) {
          const desktopIcon = desktopBtn.querySelector('i');
          desktopBtn.classList.toggle('active', icon.classList.contains('bi-heart-fill'));
          desktopIcon.classList.remove('bi-heart', 'bi-heart-fill');
          desktopIcon.classList.add(icon.classList.contains('bi-heart-fill') ? 'bi-heart-fill' : 'bi-heart');
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Failed!',
          text: data.message || 'Failed to update wishlist.',
          confirmButtonText: 'OK'
        });
      }
    })
    .catch(error => {
      console.error(error);
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'An error occurred while updating the wishlist.',
        confirmButtonText: 'OK'
      });
    })
    .finally(() => {
      this.classList.remove('loading'); // Aktifkan kembali tombol
    });
  });
});


// document.querySelectorAll('.wishlist-btn').forEach(button => {
//   button.addEventListener('click', function () {
//     if (this.classList.contains('loading')) return; // Cegah spam klik
//     this.classList.add('loading'); // Tandai tombol sedang loading
    
//     const productId = this.dataset.productId;
//     const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     const icon = this.querySelector('i');
//     const isWishlisted = icon.classList.contains('bi-heart-fill');
//     const url = isWishlisted ? '/wishlist/remove' : '/wishlist/add';

//     fetch(url, {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': token
//       },
//       body: JSON.stringify({ product_id: productId })
//     })
//     .then(response => response.json())
//     .then(data => {
//       if (data.success) {
//         // Toggle ikon pada mobile
//         this.classList.toggle('active');
//         icon.classList.toggle('bi-heart');
//         icon.classList.toggle('bi-heart-fill');

//         const desktopBtn = document.querySelector(`.mobile-wishlist-btn[data-product-id="${productId}"]`);
//         if (desktopBtn) {
//           const desktopIcon = desktopBtn.querySelector('i');
//           desktopBtn.classList.toggle('active', icon.classList.contains('bi-heart-fill'));
//           desktopIcon.classList.remove('bi-heart', 'bi-heart-fill');
//           desktopIcon.classList.add(icon.classList.contains('bi-heart-fill') ? 'bi-heart-fill' : 'bi-heart');
//         }
//       } else {
//         alert(data.message || 'Failed to Update Wishlist');
//       }
//     })
//     .catch(error => {
//       console.error(error);
//       alert('An Error Occured When Updating Wishlist');
//     });
//   });
// });

document.querySelectorAll('.wishlist-btn').forEach(button => {
  button.addEventListener('click', function () {
    if (this.classList.contains('loading')) return; // Cegah spam klik
    this.classList.add('loading'); // Tandai tombol sedang loading

    const productId = this.dataset.productId;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const icon = this.querySelector('i');
    const isWishlisted = icon.classList.contains('bi-heart-fill');
    const url = isWishlisted ? '/wishlist/remove' : '/wishlist/add';

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Toggle ikon pada mobile
        this.classList.toggle('active');
        icon.classList.toggle('bi-heart');
        icon.classList.toggle('bi-heart-fill');

        // Sinkronisasi dengan tombol desktop
        const desktopBtn = document.querySelector(`.mobile-wishlist-btn[data-product-id="${productId}"]`);
        if (desktopBtn) {
          const desktopIcon = desktopBtn.querySelector('i');
          desktopBtn.classList.toggle('active', icon.classList.contains('bi-heart-fill'));
          desktopIcon.classList.remove('bi-heart', 'bi-heart-fill');
          desktopIcon.classList.add(icon.classList.contains('bi-heart-fill') ? 'bi-heart-fill' : 'bi-heart');
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Failed!',
          text: data.message || 'Failed to update wishlist.',
          confirmButtonText: 'OK'
        });
      }
    })
    .catch(error => {
      console.error(error);
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'An error occurred while updating the wishlist.',
        confirmButtonText: 'OK'
      });
    })
    .finally(() => {
      this.classList.remove('loading'); // Aktifkan kembali tombol
    });
  });
});

    // -------------------------------
    // Replace Feather Icons (jika digunakan)
    // -------------------------------
    if (typeof feather !== 'undefined') {
      feather.replace();
    }
  });
  </script>

<div class="you-may-also-like-section">
  <h2 class="text-xl font-semibold mb-4">You May Also Like</h2>
  <div class="horizontal-scroll-wrapper">
    @forelse ($youMayAlsoLike as $related)
      <a href="{{ url('detail_sepatu/' . $related->product_id) }}" class="product-link">
        <div class="product-card"
          style="--bg-color: {{ $related->color_code_bg ?? '#fff' }}; --font-color: {{ $related->color_font ?? '#000' }};">
          <img src="{{ asset('image/sepatu/kiri/' . $related->image_kiri) }}"
            alt="{{ $related->product_name }}">
          <h3>{{ $related->product_name }}</h3>
          <p>Rp. {{ number_format($related->price, 0, ',', '.') }}</p>
        </div>
      </a>
    @empty
      <p>No product recommendations available.</p>
    @endforelse
  </div>
</div>

<div class="product-review-section mx-5 mt-10 bg-white border border-black rounded-lg p-5">
  <section>
    <h2 class="text-2xl font-bold mb-4">
        Reviews ★★★★★ ({{ $totalReviews }})
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="col-span-2">
        <div class="space-y-2">
            @for ($star = 5; $star >= 1; $star--)
                @php
                    $count = $ratingCounts[$star] ?? 0;
                    $widthPercent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                @endphp
                <div class="flex items-center gap-2">
                    <div class="w-12 text-left text-m justify-between" id="stars">
                        {{ $star }} star{{ $star > 1 ? 's' : '' }}
                    </div>
    
                    <div class="flex-1 bg-gray-200 h-3 rounded-full overflow-hidden">
                        <div class="bg-black h-full" style="width: {{ $widthPercent }}%;"></div>
                    </div>
    
                    <div class="w-6 text-sm text-right">
                        {{ $count }}
                    </div>
                </div>
            @endfor
        </div>
    </div>

        <div>
            <p class="text-lg text-gray-800">Overall Rating</p>
            <p class="text-5xl font-bold leading-tight">{{ number_format($averageRating, 1) }}</p>
            <div class="flex items-center gap-1 mb-2">
              @php
              $fullStars = floor(number_format($averageRating, 1));
              $halfStar = ($averageRating - $fullStars) >= 0.5;
              $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            @endphp
            
            @for ($i = 0; $i < $fullStars; $i++)
                <i class="bi bi-star-fill" style="color: black;"></i>
            @endfor
            
            @if ($halfStar)
                <i class="bi bi-star-half" style="color: black;"></i>
            @endif
            
            @for ($i = 0; $i < $emptyStars; $i++)
                <i class="bi bi-star" style="color: black;"></i>
            @endfor
            </span>
            </div>
        </div>
    </div>
</section>

<div class="flex flex-wrap items-center justify-between mb-4 mt-4 gap-4">
  <p id="review-count-indicator" class="text-sm text-gray-600 m-0 flex-shrink-0">
    Showing 1 - {{ min(3, count($reviews)) }} of {{ count($reviews) }} Reviews
  </p>

  <div class="flex items-center gap-2 flex-shrink-0">
    <label for="star-filter" class="text-sm text-gray-700">Filter by Stars:</label>
    <select id="star-filter" class="border border-gray-300 rounded px-2 py-1 text-sm">
      <option value="all">All Stars</option>
      <option value="5">5 Stars</option>
      <option value="4">4 Stars</option>
      <option value="3">3 Stars</option>
      <option value="2">2 Stars</option>
      <option value="1">1 Star</option>
    </select>
  </div>
</div>

<button id="add-review-btn">
    Add Review
</button>
<div id="review-form" class="mt-4 hidden">
    <form action="{{ route('product.addReview', $product->product_id) }}" method="POST">
        @csrf

        <div class="mb-2">
        <label class="block text-sm font-medium">Rating</label>
        <div class="star-rating flex flex-row-reverse justify-end text-5xl">
            <input type="radio" id="star5" name="rating" value="5" required>
            <label for="star5" class="cursor-pointer text-5xl text-gray-300 hover:text-yellow-400">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4" class="cursor-pointer text-5xl text-gray-300 hover:text-yellow-400">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3" class="cursor-pointer text-5xl text-gray-300 hover:text-yellow-400">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2" class="cursor-pointer text-5xl text-gray-300 hover:text-yellow-400">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1" class="cursor-pointer text-5xl text-gray-300 hover:text-yellow-400">&#9733;</label>
        </div>
    </div>

        <div class="mb-2">
            <label for="review_title" class="block text-sm font-medium">Review Title</label>
            <input type="text" name="review_title" id="review_title" class="border rounded w-full px-2 py-1" required>
        </div>
        <div class="mb-2">
            <label for="comment" class="block text-sm font-medium">Review</label>
            <textarea name="comment" id="comment" rows="3" class="border rounded w-full px-2 py-1" required></textarea>
        </div>
        <button type="submit" id="submitReview">
            Submit Review
        </button>

        <div id="loader" class="loader-overlay">
      <div class="loader"></div>
    </div>
    </form>
</div>

  @php
    function maskedName($name) {
      $visible = substr($name, 0, 3);
      $hiddenLength = strlen($name) - 3;
      return $visible . str_repeat('*', max(0, $hiddenLength));
    }
  @endphp

@forelse ($reviews as $index => $review)
<div
  class="review-item py-4 border-b last:border-b-0 border-gray-300 {{ $index >= 3 ? 'hidden' : '' }}"
  data-rating="{{ round($review->rating) }}"
>

  <div class="flex items-center justify-between mb-1">
    <div class="font-semibold text-gray-800">{{ maskedName($review->user->name) }}</div>
    <div class="product-rating text-yellow-500 text-sm flex items-center" title="{{ $review->rating }} out of 5 stars ">
      @php
        $fullStars = round($review->rating);
        $fullStars = max(0, min(5, $fullStars));
        $emptyStars = 5 - $fullStars;
      @endphp

      @for ($i = 0; $i < $fullStars; $i++)
        <i class="bi bi-star-fill" style="color: black; font-size:12px;"></i>
      @endfor

      @for ($i = 0; $i < $emptyStars; $i++)
        <i class="bi bi-star" style="color: black; font-size:12px;"></i>
      @endfor
    </div>
  </div>

  @if ($review->review_title)
    <h5 class="text-gray-600 italic">{{ $review->review_title }}</h5>
  @endif

  <p class="text-gray-700">{{ $review->comment }}</p>
  <div class="text-sm text-gray-400 mt-1">
    Reviewed on {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}
  </div>
</div>
@empty
<p class="text-gray-500">No reviews yet for this product</p>
@endforelse

<div class="flex justify-center space-x-2 mt-4">
  <button id="show-more-btn" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800 hidden">
    Show More
  </button>
  <button id="show-less-btn" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 hidden">
    Show Less
  </button>
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const btnMore = document.getElementById('show-more-btn');
    const btnLess = document.getElementById('show-less-btn');
    const reviews = document.querySelectorAll('.review-item');
    const starFilter = document.getElementById('star-filter');

    let visibleCount = 3;
    const increment = 5;

    const showWithSlide = (el) => {
      el.style.maxHeight = '0px';
      el.classList.remove('hidden');
      el.style.overflow = 'hidden';
      el.style.transition = 'max-height 0.4s ease';

      requestAnimationFrame(() => {
        el.style.maxHeight = el.scrollHeight + 'px';
      });

      setTimeout(() => {
        el.style.maxHeight = '';
        el.style.overflow = '';
        el.style.transition = '';
      }, 400);
    };

    const hideWithSlide = (el, delay = 0) => {
      setTimeout(() => {
        el.style.maxHeight = el.scrollHeight + 'px';
        el.style.overflow = 'hidden';
        el.style.transition = 'max-height 0.4s ease';

        requestAnimationFrame(() => {
          el.style.maxHeight = '0px';
        });

        setTimeout(() => {
          el.classList.add('hidden');
          el.style.maxHeight = '';
          el.style.overflow = '';
          el.style.transition = '';
        }, 400);
      }, delay);
    };

    const getFilteredReviews = () => {
      const selected = starFilter ? starFilter.value : 'all';
      return Array.from(reviews).filter(review => {
        const rating = parseInt(review.dataset.rating);
        return selected === 'all' || rating === parseInt(selected);
      });
    };

    const updateReviewIndicator = (filteredTotal) => {
  const indicator = document.getElementById('review-count-indicator');
  if (!indicator) return;

  if (filteredTotal === 0) {
    indicator.textContent = 'No reviews found.';
  } else {
    indicator.textContent = `Showing 1 - ${Math.min(visibleCount, filteredTotal)} of ${filteredTotal} Reviews`;
  }
};

    const updateVisibleReviews = () => {
  const filtered = getFilteredReviews();
  const noReviewMessage = document.getElementById('no-review-message');

  // Reset
  reviews.forEach(r => r.classList.add('hidden'));

  if (filtered.length === 0) {
    if (!noReviewMessage) {
      const p = document.createElement('p');
      p.id = 'no-review-message';
      p.className = 'text-gray-500';
      p.textContent = 'No reviews for this rating.';
      document.querySelector('.product-review-section').appendChild(p);
    }
    btnMore.classList.add('hidden');
    btnLess.classList.add('hidden');
    updateReviewIndicator(0);
    return;
  }

  // Remove message if previously added
  if (noReviewMessage) noReviewMessage.remove();

  for (let i = 0; i < Math.min(visibleCount, filtered.length); i++) {
    showWithSlide(filtered[i]);
  }

  updateReviewIndicator(filtered.length);

  // Handle buttons
  if (filtered.length > 3) {
    btnMore.classList.toggle('hidden', visibleCount >= filtered.length);
    btnLess.classList.toggle('hidden', visibleCount < filtered.length);
  } else {
    btnMore.classList.add('hidden');
    btnLess.classList.add('hidden');
  }
};

    btnMore.addEventListener('click', () => {
      const filtered = getFilteredReviews();
      const targetCount = Math.min(visibleCount + increment, filtered.length);

      for (let i = visibleCount; i < targetCount; i++) {
        showWithSlide(filtered[i]);
      }

      visibleCount = targetCount;
      updateReviewIndicator(filtered.length);

      if (visibleCount >= filtered.length) {
        btnMore.classList.add('hidden');
        btnLess.classList.remove('hidden');
      }
    });

    btnLess.addEventListener('click', () => {
      const filtered = getFilteredReviews();
      let delay = 0;
      const delayIncrement = 80;

      for (let i = visibleCount - 1; i >= 3; i--) {
        if (filtered[i]) hideWithSlide(filtered[i], delay);
        delay += delayIncrement;
      }

      visibleCount = 3;
      updateReviewIndicator(filtered.length);
      btnMore.classList.remove('hidden');
      btnLess.classList.add('hidden');

      setTimeout(() => {
        document.querySelector('.product-review-section').scrollIntoView({ behavior: 'smooth' });
      }, delay + 200);
    });

    if (starFilter) {
      starFilter.addEventListener('change', () => {
        visibleCount = 3;
        updateVisibleReviews();
      });
    }

    // Inisialisasi pertama kali
    updateVisibleReviews();
  });
</script>


<div id="popupMessage" class="popup hidden">
  <div class="popup-content">
    <div class="popup-icon" id="popupIcon">✔️</div>
    <div class="popup-text" id="popupText">Pesan</div>
    <button onclick="closePopup()">OK</button>
  </div>
</div>
<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
</script>

<script>
document.querySelectorAll('.add-cart').forEach(button => {
    button.addEventListener('click', function() {
      const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
    const selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;
        if (!selectedSize || !selectedColorCode) {
      Swal.fire({
        icon: 'warning',
        title: 'Please select',
        text: 'Please select both size and color before adding to cart.',
        confirmButtonText: 'OK'
      });
      return;
    }

    const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    cartModal.show();
    });
});

document.querySelectorAll('.mobile-add-cart').forEach(button => {
    button.addEventListener('click', function() {
        const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
    const selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;
        if (!selectedSize || !selectedColorCode) {
      Swal.fire({
        icon: 'warning',
        title: 'Please select',
        text: 'Please select both size and color before adding to cart.',
        confirmButtonText: 'OK'
      });
      return;
    }

    const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    cartModal.show();
    });
});

let selectedSize = null;
let selectedColor = null;

// Update size saat diklik
document.querySelectorAll('.size-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');

    selectedSize = btn.getAttribute('data-size');

    const modalSizeElem = document.getElementById('modalSelectedSize');
    if (modalSizeElem) {
      modalSizeElem.textContent = selectedSize;
    }
  });
});

// Update color saat diklik
document.querySelectorAll('.color-circle').forEach(circle => {
  circle.addEventListener('click', () => {
    document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
    circle.classList.add('selected');

    selectedColor = circle.getAttribute('data-color-name');

    // Update teks color di modal
    const modalColorElem = document.getElementById('modalSelectedColor');
    if (modalColorElem) {
      modalColorElem.textContent = selectedColor;
    }

    // Update gambar modal berdasarkan warna terpilih
    const modalImgKiri = document.getElementById('modalShoeImageKiri');
    if (modalImgKiri) {
      modalImgKiri.src = circle.getAttribute('data-image-kiri');
    }

    // Kalau mau update gambar lain, contoh:
    // const modalImgAtas = document.getElementById('modalShoeImageAtas');
    // if(modalImgAtas) modalImgAtas.src = circle.getAttribute('data-image-atas');
  });
});

// Saat tombol Add To Cart diklik
const addToCartBtn = document.getElementById('addToCartBtn');
if (addToCartBtn) {
  addToCartBtn.addEventListener('click', () => {
    // Auto-select default size jika belum dipilih
    if (!selectedSize) {
      const firstSizeBtn = document.querySelector('.size-btn');
      if (firstSizeBtn) {
        firstSizeBtn.classList.add('selected');
        selectedSize = firstSizeBtn.getAttribute('data-size');
      }
    }

    // Auto-select default color jika belum dipilih
    if (!selectedColor) {
      const firstColorCircle = document.querySelector('.color-circle');
      if (firstColorCircle) {
        firstColorCircle.classList.add('selected');
        selectedColor = firstColorCircle.getAttribute('data-color-name');
        selectedColorCode = firstColorCircle.getAttribute('data-color-code');

        // Update gambar modal juga
        const modalImgKiri = document.getElementById('modalShoeImageKiri');
        if (modalImgKiri) {
          modalImgKiri.src = firstColorCircle.getAttribute('data-image-kiri');
        }
      }
    }

    const match = stockData.find(item =>
      item.size.toString() === selectedSize?.toString() &&
      item.color_code.toLowerCase() === selectedColorCode?.toLowerCase()
    );
    selectedStock = match ? match.stock : 0;

    // Update teks modal size, color, dan stock
    const modalSizeElem = document.getElementById('modalSelectedSize');
    if (modalSizeElem) modalSizeElem.textContent = selectedSize || '-';

    const modalColorElem = document.getElementById('modalSelectedColor');
    if (modalColorElem) modalColorElem.textContent = selectedColor || '-';

    const modalStockElem = document.getElementById('modalSelectedStock');
    if (modalStockElem) modalStockElem.textContent = selectedStock ?? '-';

    // Tampilkan modal bootstrap
    const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    cartModal.show();
  });
}

const confirmAddToCartBtn = document.getElementById('confirmAddToCart');
if (confirmAddToCartBtn) {
  confirmAddToCartBtn.addEventListener('click', () => {
    const productId = document.getElementById('addToCartBtn').dataset.productId;
    const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
    const selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;
    const quantity = document.getElementById('inputQuantity')?.value || 1;
    const modalStockElem = document.getElementById('modalSelectedStock');
    const availableStock = modalStockElem ? parseInt(modalStockElem.textContent) : 0;

    if (!selectedSize || !selectedColorCode) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops!',
        text: 'Please select the size and color first',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
      });
      return;
    }

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('size', selectedSize);
    formData.append('color_code', selectedColorCode);
    formData.append('quantity', quantity);

    fetch('/cart/add', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
  if (data.success) {
    // ✅ Tutup modal
    const modalElem = document.getElementById('cartModal');
    if (modalElem) {
      const bootstrapModal = bootstrap.Modal.getOrCreateInstance(modalElem);
      bootstrapModal.hide();
    }

    setTimeout(() => {
      document.getElementById("loader").style.display = "none";

      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Product successfully added to the cart!',
        showCancelButton: true,
        confirmButtonColor: '#000000',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Continue Shopping',
        cancelButtonText: 'View Cart'
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.cancel) {
          window.location.href = '/cart';
        }
      });
    }, 300);
  } else {
    // Cek apakah error karena stok
    const isStockError = data.message && data.message.toLowerCase().includes('stok tidak mencukupi');
    document.getElementById("loader").style.display = "none";
    Swal.fire({
      icon: 'error',
      title: isStockError ? 'Insufficient stock!' : 'Failed!',
      text: data.message || 'An error occurred while adding to cart',
      confirmButtonColor: '#d33',
      confirmButtonText: 'Cancel'
    });
  }
})
    .catch(err => {
      console.error('Fetch Error:', err);

      document.getElementById("loader").style.display = "none";

      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'A connection error occurred',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
      });
    });
  });
}

    document.getElementById('add-review-btn').addEventListener('click', function() {
        document.getElementById('review-form').classList.toggle('hidden');
    });

document.addEventListener("DOMContentLoaded", function () {
    const confirmButton = document.getElementById("confirmAddToCart");
    if (confirmButton) {
      confirmButton.addEventListener("click", function () {
        document.getElementById("loader").style.display = "flex";
      });
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    const submitBtn = document.getElementById("submitReview");
    const reviewForm = document.getElementById("review-form");

    if (submitBtn && reviewForm) {
      reviewForm.addEventListener("submit", function () {
        document.getElementById("loader").style.display = "flex";
      });
    }
  });

</script>


@endsection