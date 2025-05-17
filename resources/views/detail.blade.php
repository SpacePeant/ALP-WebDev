@extends('base.base1')

@section('title', 'Home')

@section('content') 

@php
    $user_id = $user_id ?? null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nike Carousel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* CAROUSEL */
    .carousel-image-large {
        height: 100%;
        width: 100%;
    }
    .carousel-item {
    position: relative;
    height: auto;
    margin-top : 70px;
    }

    .carousel-item img {
    width: 100%;
    height: auto; 
    object-fit: contain; 
    }

    .carousel-caption-center {
    margin-top: 30px;
    position: absolute;
    top: 20%;
    left: 10%;
    color: black;
    text-align: left;
    width: 100%;
    max-width: 40%; 
    padding: 0 15px;
    }

    #car{
        margin-bottom: 50px;
    }

    .carousel-caption-center h2 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    font-weight: 500;
    margin-bottom: 30px;
    }

    .carousel-caption-center p {
    font-family: 'Red Hat Text', sans-serif;
    font-size: 1.2rem;
    margin: 1rem 0;
    margin-bottom: 50px;
    }

    .carousel-caption-center a {
    font-family: 'Red Hat Text', sans-serif;
    color: black;
    text-decoration: none;
    }

    @media (max-width: 992px) {
    .carousel-caption-center h2 {
        font-size: 2rem;
    }

    .carousel-caption-center p {
        font-size: 1rem;
        margin-bottom: 25px;
    }

    .carousel-caption-center a {
        font-size: 1rem;
    }
    }

    @media (max-width: 768px) {
    .carousel-caption-center h2 {
        font-size: 1.5rem; 
    }

    .carousel-caption-center p {
        font-size: 0.7rem; 
        margin-bottom: 20px;
    }
    .carousel-caption-center a {
        font-size: 0.7rem; 
    }
    }

    @media (max-width: 576px) {
    .carousel-caption-center h2 {
        font-size: 1.2rem;
    }

    .carousel-caption-center p{
        font-size: 0.5rem;
        margin-bottom: 13px;
    }
    .carousel-caption-center a {
        font-size: 0.5rem;
    }
    }

    body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    /* padding: 20px; */
    }

    h1 {
        text-align: center;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: left;
        gap: 20px;
    }

    .product-card {
        background-color: #fff; 
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 250px;
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
    }

    .product-card p {
        transition: all 0.3s ease;
        font-size: 16px;
        color: #333;
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        margin-top: -50px;
    }

    .filter-bar input[type="text"],
    .filter-bar select {
        padding: 10px 20px;
        border-radius: 30px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .price-filter {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .slider-values {
        display: flex;
        justify-content: space-between;
        width: 200px;
        font-size: 14px;
        margin-bottom: 5px;
    }

    input[type="range"] {
        -webkit-appearance: none;
        width: 200px;
        height: 5px;
        background: #ddd;
        border-radius: 5px;
        outline: none;
        margin: 5px 0;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 14px;
        height: 14px;
        background: black;
        border-radius: 50%;
        cursor: pointer;
    }
    .select-wrapper {
        position: relative;
        display: inline-block;
        width: 220px;
        transition: 1.5s;
    }

    .select-wrapper select {
        width: 100%;
        padding: 8px 40px 8px 12px;
        border: 1px solid #ccc;
        border-radius: 25px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: white;
        transition: 1.5s;
    }

    .select-wrapper::after {
        content: '▼';
        font-size: 12px;
        color: #555;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none; 
    }
    .select-wrapper:hover {
        border-color: black; 
        transition: 1.5s;
    }

    .select-wrapper:hover select {
        border-color: black; 
        transition: 1.5s;
    }

    .product-container {
    display: flex;
    gap: 20px;
    padding-left: 40px;
    margin-bottom: 100px;
}

.filter-sidebar {
    width: 250px;
    min-width: 250px;      
    max-width: 250px;
    padding: 20px;
    border-right: 1px solid #ddd;
    background-color: #fafafa;
}

.filter-bar {
    display: flex;
    gap: 15px;
    align-items: center;
    padding: 10px 40px;
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    position: sticky;
    margin-top: -50px;
    top: 70px;
    z-index: 10;
}

.filter-section {
    margin-bottom: 25px;
}

.filter-section h4 {
    font-size: 18px;
    margin-bottom: 10px;
    border-left: 4px solid black;
    padding-left: 10px;
}

.color-palette {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.color-box {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid #ccc;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
}
.filter-sidebar {
    width: 250px;
    padding-left: 20px;
    background-color: #fafafa;
    border-right: 1px solid #ddd;
}

.filter-group {
    margin-bottom: 15px;
    border-left: 4px solid black;
    padding-left: 10px;
}

.filter-title {
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    padding: 8px 0;
    transition: color 0.2s ease;
}

.filter-title:hover {
    color: #444;
}

.filter-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease;
}

.filter-group.active .filter-content {
    max-height: 300px; /* Sesuaikan dengan konten maksimal */
}

.color-palette {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.color-box {
    display: inline-block;   
    width: 20px;                   
    height: 20px;
    border-radius: 4px;
    margin-right: 6px;
    border: 1px solid #ccc;
    vertical-align: middle;    
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
}
.product-link {
  text-decoration: none;
  color: inherit;
  display: block;
}
.filter-group.warna .filter-content {
    max-height: 0px; /* atau berapa pun yang kamu mau */
    overflow-y: auto;
    padding-right: 5px; /* biar gak ketimpa scrollbar */
}
.filter-group.warna.active .filter-content {
    max-height: 200px;
}

#searchToggle {
    display: none; /* default sembunyi di desktop */
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 8px;
    margin-right: 5px;
}

/* === Mobile only === */
@media (max-width: 768px) {
    .filter-bar {
        flex-wrap: nowrap;
        justify-content: flex-start;
        overflow-x: auto;
        margin-top: -100px;
    }

    #searchToggle {
        display: inline-block; /* tampilkan hanya saat mobile */
    }

    #searchInput {
        display: none;
        flex-shrink: 0;
        width: 200px;
        transition: all 0.3s ease;
    }

    .filter-bar.show-search #searchInput {
        display: inline-block;
        opacity: 1;
        width: 200px;
        margin-right: 10px;
    }

    .select-wrapper {
    flex-shrink: 0;
    min-width: 70px; /* atau lebih besar jika perlu */
}
}

@media (max-width: 768px) {
    .product-container {
        margin-top: 0 !important;
    }

    .filter-sidebar {
        margin-right: 0 !important;
    }

    .offcanvas-body .filter-group {
        margin-bottom: 1rem;
    }

    .product-container {
        flex-direction: column;
    }

    #productResults {
        margin-top: 0.5rem;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Biar card produk ke tengah */
        gap: 1rem; /* Jarak antar kartu */
        padding: 0 1rem; /* Kasih padding samping biar gak mentok layar */
    }

    .product-card {
        margin-right: 80px;
        max-width: 400px; /* atau ukuran sesuai desain kamu */
        width: 100%;
    }
}

  </style>
</head>
<body>
<div class="container-fluid px-0" id="car">
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <img src="{{ asset('image/image_carousel/running.png') }}" alt="Running">
        <div class="carousel-caption-center" style="color: #5E4E47;">
          <h2>Running</h2>
          <p>Nike running shoes combine lightweight design, responsive cushioning, and innovative technology for optimal running performance.</p>
          {{-- <a href="#" style="color: #5E4E47;">View Collection →</a> --}}
        </div>
      </div>

      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/casual.png') }}" alt="Casual">
        <div class="carousel-caption-center" style="color: #8C1D1D;">
          <h2>Casual</h2>
          <p>Nike casual shoes blend sporty style with all-day comfort, making them perfect for everyday wear.</p>
          {{-- <a href="#" style="color: #8C1D1D;">View Collection →</a> --}}
        </div>
      </div>

      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/basketball.png') }}" alt="Basketball">
        <div class="carousel-caption-center" style="color: #303034;">
          <h2>Basketball</h2>
          <p>Nike basketball shoes blend dynamic support, explosive cushioning, and cutting-edge innovation to elevate your game on every court.</p>
          {{-- <a href="#" style="color: #303034;">View Collection →</a> --}}
        </div>
      </div>

      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/training.png') }}" alt="Training">
        <div class="carousel-caption-center" style="color: #23AA97;"> 
          <h2>Training</h2>
          <p>Nike training shoes offer stability, support, and flexibility for a variety of workouts, from gym sessions to cross-training.</p>
          {{-- <a href="#" style="color: #23AA97;">View Collection →</a> --}}
        </div>
      </div>

      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/soccer.png') }}" alt="Soccer">
        <div class="carousel-caption-center" style="color: #035573;">
          <h2>Soccer</h2>
          <p>Nike soccer boots deliver precision touch, agile traction, and lightweight speed to dominate every match.</p>
          {{-- <a href="#" style="color: #035573;">View Collection →</a> --}}
        </div>
      </div>

      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/sandals.png') }}" alt="Sandals">
        <div class="carousel-caption-center" style="color: #6E5B59;">
          <h2>Sandals</h2>
          <p>Nike sandals offer lightweight comfort and easy style, perfect for casual wear, lounging, or post-workout recovery.</p>
          {{-- <a href="#" style="color: #6E5B59;">View Collection →</a> --}}
        </div>
      </div>

    </div>
  </div>
  <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button> -->
</div>

<form method="GET" id="filterForm">

    {{-- Filter Bar: Search, Sort, Price Slider --}}
    <div class="filter-bar">
    <button type="button" id="searchToggle" aria-label="Toggle search" class="d-inline-block d-md-none">
        <i class="bi bi-search"></i>
    </button>

    <input type="text" name="search" placeholder="Search" id="searchInput" />

    <div class="select-wrapper">
        <select name="sort" id="sortSelect" class="select">
            <option class="sort" value="">Sort By</option>
            <option value="newest">Newest</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
        </select>
    </div>

    <div class="price-filter">
        <label>Price</label>
        <div class="slider-values">
            <span>Rp <span id="minPriceVal">500k</span></span>
            <span>Rp <span id="maxPriceVal">8000k</span></span>
        </div>
        <input type="range" name="min" id="minPrice" min="500" max="10000" value="500" step="100" />
        <input type="range" name="max" id="maxPrice" min="500" max="10000" value="8000" step="100" />
    </div>
</div>
{{-- Filter Icon untuk Mobile --}}
{{-- <div class="d-flex justify-content-end d-md-none mb-3">
    <button class="btn btn-outline-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilter">
        <i class="bi bi-filter"></i>
    </button>
</div> --}}

    <div class="d-flex justify-content-between align-items-center d-md-none mb-3" style="margin-left: 20px">
        <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilter">
            <i class="bi bi-filter"></i> Filter
        </button>
    </div>

<div class="product-container d-flex">
    {{-- Sidebar (hanya tampil di desktop) --}}
    <aside class="filter-sidebar d-none d-md-block me-3">
        {{-- Kategori --}}
        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Kategori</div>
            <div class="filter-content">
                @foreach ($categories as $cat)
                    <label>
                        <input type="checkbox" name="category[]" value="{{ $cat }}"
                            {{ in_array($cat, request()->input('category', [])) ? 'checked' : '' }}>
                        {{ $cat }}
                    </label><br>
                @endforeach
            </div>
        </div>

        {{-- Warna --}}
        <div class="filter-group warna">
            <div class="filter-title" onclick="toggleFilter(this)">Warna</div>
            <div class="filter-content">
                @foreach ($colors as $color)
                    <label>
                        <input type="checkbox" name="color[]" value="{{ $color->color_code }}"
                            {{ in_array($color->color_code, request()->input('color', [])) ? 'checked' : '' }}>
                        <span class="color-box" style="background-color: {{ $color->color_code }};"></span>
                        {{ $color->color_name }}
                    </label><br>
                @endforeach
            </div>
        </div>

        {{-- Ukuran --}}
        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Ukuran</div>
            <div class="filter-content">
                @foreach ($sizes as $size)
                    <label>
                        <input type="checkbox" name="size[]" value="{{ $size->size }}"
                            {{ in_array($size->size, request()->input('size', [])) ? 'checked' : '' }}>
                        {{ $size->size }}
                    </label><br>
                @endforeach
            </div>
        </div>

        {{-- Gender --}}
        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Gender</div>
            <div class="filter-content">
                @foreach ($genders as $gender)
                    <label>
                        <input type="checkbox" name="gender[]" value="{{ $gender }}"
                            {{ in_array($gender, request()->input('gender', [])) ? 'checked' : '' }}>
                        {{ $gender }}
                    </label><br>
                @endforeach
            </div>
        </div>
    </aside>

    {{-- Product Results --}}
    <main id="productResults" class="flex-grow-1">
        @include('partials.product_list', ['products' => $products])
    </main>
</div>

{{-- Offcanvas untuk Mobile --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilter">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        {{-- COPY ISI FILTER DARI SIDEBAR --}}
        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Kategori</div>
            <div class="filter-content">
                @foreach ($categories as $cat)
                    <label>
                        <input type="checkbox" name="category[]" value="{{ $cat }}"
                            {{ in_array($cat, request()->input('category', [])) ? 'checked' : '' }}>
                        {{ $cat }}
                    </label><br>
                @endforeach
            </div>
        </div>

        <div class="filter-group warna">
            <div class="filter-title" onclick="toggleFilter(this)">Warna</div>
            <div class="filter-content">
                @foreach ($colors as $color)
                    <label>
                        <input type="checkbox" name="color[]" value="{{ $color->color_code }}"
                            {{ in_array($color->color_code, request()->input('color', [])) ? 'checked' : '' }}>
                        <span class="color-box" style="background-color: {{ $color->color_code }};"></span>
                        {{ $color->color_name }}
                    </label><br>
                @endforeach
            </div>
        </div>

        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Ukuran</div>
            <div class="filter-content">
                @foreach ($sizes as $size)
                    <label>
                        <input type="checkbox" name="size[]" value="{{ $size->size }}"
                            {{ in_array($size->size, request()->input('size', [])) ? 'checked' : '' }}>
                        {{ $size->size }}
                    </label><br>
                @endforeach
            </div>
        </div>

        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Gender</div>
            <div class="filter-content">
                @foreach ($genders as $gender)
                    <label>
                        <input type="checkbox" name="gender[]" value="{{ $gender }}"
                            {{ in_array($gender, request()->input('gender', [])) ? 'checked' : '' }}>
                        {{ $gender }}
                    </label><br>
                @endforeach
            </div>
        </div>
    </div>
</div>


    <button type="submit" style="display:none;"></button>
</form>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const minSlider = document.getElementById("minPrice");
    const maxSlider = document.getElementById("maxPrice");
    const minVal = document.getElementById("minPriceVal");
    const maxVal = document.getElementById("maxPriceVal");

    function updateValues() {
        if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
            [minSlider.value, maxSlider.value] = [maxSlider.value, minSlider.value];
        }
        minVal.textContent = minSlider.value + 'k';
        maxVal.textContent = maxSlider.value + 'k';
    }

    minSlider.addEventListener("input", function() {
        updateValues();
        fetchData(); 
    });
    maxSlider.addEventListener("input", function() {
        updateValues();
        fetchData();
    });

    updateValues(); 

    function fetchData() {
        $.ajax({
            url: '{{ route("product.list") }}', 
            method: 'GET',
            data: $('#filterForm').serialize(),
            success: function(response) {
                $('#productResults').html(response);
            }
        });
    }

    $('#filterForm input, #filterForm select').not('#minPrice, #maxPrice').on('input change', fetchData);

    fetchData();

    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const bgColor = this.getAttribute('data-bg-color');
            this.style.backgroundColor = bgColor;  
        });
        card.addEventListener('mouseleave', function() {
            this.style.backgroundColor = ''; 
        });
    });
});

function toggleFilter(element) {
    const parent = element.parentElement;
    parent.classList.toggle('active');
}
function toggleFilter(element) {
    const group = element.parentElement;
    group.classList.toggle('active');
}

const searchToggle = document.getElementById('searchToggle');
const filterBar = document.querySelector('.filter-bar');
const searchInput = document.getElementById('searchInput');

searchToggle.addEventListener('click', () => {
    filterBar.classList.toggle('show-search');
    if (filterBar.classList.contains('show-search')) {
        searchInput.focus();
    }
});

</script>

</body>
</html>
@endsection