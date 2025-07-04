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
    <link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">

  <style>
    * {
        font-family: 'Red Hat Text', sans-serif;
    }
   
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
    font-family: 'Red Hat Text', sans-serif;
    font-size: 3.5rem;
    font-weight: 510;
    margin-bottom: 30px;
    }


    .carousel-caption-center p {
    font-family: 'Red Hat Text', sans-serif;
    font-size: 1.2rem;
    margin: 1rem 0;
    margin-bottom: 50px;
    }


    .carousel-caption-center a {
    color: black;
    text-decoration: none;
    }


    @media (max-width: 992px) {
    .carousel-caption-center h2 {
        font-size: 2rem;
        margin-top: -20px;
    }


    .carousel-caption-center p {
        font-size: 1rem;
        margin-bottom: -10px;
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
        margin-top: -10px;
    }
    .carousel-caption-center a {
        font-size: 0.7rem;
    }
    }


    @media (max-width: 576px) {
    .carousel-caption-center h2 {
        font-size: 1.2rem;
        margin-top: -10px;
    }


    .carousel-caption-center p{
        font-size: 0.5rem;
        margin-top: -20px;
    }
    .carousel-caption-center a {
        font-size: 0.5rem;
    }
    }


    @media (max-width: 414px){
        .carousel-caption-center h2 {
        font-size: 1.2rem;
        margin-top: -30px;
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
        height: 100%;
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
  gap: 8px;
  font-family: sans-serif;
}


.slider-values {
  display: flex;
  justify-content: space-between;
  width: 200px;
  font-size: 14px;
}


.slider-container {
  position: relative;
  width: 200px;
  height: 30px;
}


input[type="range"] {
  position: absolute;
  pointer-events: none;
  -webkit-appearance: none;
  width: 100%;
  height: 5px;
  margin: 0;
  background: none;
  z-index: 2;
}


input[type="range"]::-webkit-slider-thumb {
  pointer-events: all;
  width: 14px;
  height: 14px;
  background: black;
  border-radius: 50%;
  cursor: pointer;
  -webkit-appearance: none;
}


.slider-track {
  position: absolute;
  height: 5px;
  background: #ddd;
  top: 10%;
  transform: translateY(-50%);
  width: 100%;
  z-index: 1;
  border-radius: 5px;
}


.slider-track::after {
  content: "";
  position: absolute;
  height: 100%;
  background: black;
  left: 0;
  right: 0;
  z-index: 3;
  border-radius: 5px;
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
        margin-top: -50px;
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
    .filter-bar {
        top: 58px;
        font-size: 12px;
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
        justify-content: left;
        gap: 1rem;
        padding: 0 1rem;
    }


    .product-card {
        margin-right: 0px;
        width: 180px;
        height: 400px;
    }


    .container-fluid {
        margin-top: -15px;
    }
}

.product-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 100%;
    height: 350px;
    max-width: 270px;
    padding: 15px;
    margin-left: -20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s, background-color 0.3s;
    display: flex;
    flex-direction: column;
}

      .pagination {
        display: flex;
        justify-content: end;
        gap: 6px;
    }

    .pagination li {
        list-style: none;
    }

    .pagination li a,
    .pagination li span {
        padding: 6px 12px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
    }

        .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-right: 30px;
    }
    .pagination .page-item .page-link {
        /* padding: 0.375rem 0.75rem; */
        font-size: 0.875rem;
    }
    .form-select-sm {
        font-size: 0.875rem;
        /* padding: 0.25rem 
        0.5rem; */
    }
    
  .pagination li.active a {
      background-color: #444 !important;
      color: white !important;
      border-color: #444 !important;
      transition: background-color 0.3s ease;
  }

  .pagination li.active a:hover {
      background-color: black !important;
      color: white !important;
  }

@media (max-width: 1200px){
    .product-card{
        height: 300px;
    }
}

@media (max-width: 1024px){
    .product-card{
        height: 270px;
    }
}

@media (max-width: 990px){
    .product-card{
        height: 300px;
    }
}

@media (max-width: 795px){
    .product-card{
        height: 220px;
    }
}

@media (max-width: 787px){
    .product-card{
        height: 350px;
    }
}

@media (max-width: 520px){
    .product-card{
        height: 300px;
    }
}

@media (max-width: 440px){
    .product-card{
        height: 250px;
    }
}

  </style>
</head>
<body>
<div class="container-fluid px-0" id="car">
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('image/image_carousel/runningcollection.png') }}" alt="Running">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Running</h2>
          <p>Nike running shoes combine lightweight design, responsive cushioning, and innovative technology for optimal running performance.</p>
          {{-- <a href="#" style="color: #5E4E47;">View Collection →</a> --}}
        </div>
      </div>


      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/casualcollection.png') }}" alt="Casual">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Casual</h2>
          <p>Nike casual shoes combine modern design, making them perfect for everything from running errands to meeting up with friends.</p>
          {{-- <a href="#" style="color: #8C1D1D;">View Collection →</a> --}}
        </div>
      </div>


      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/basketballcollection.png') }}" alt="Basketball">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Basketball</h2>
          <p>Nike basketball shoes blend dynamic support, explosive cushioning, and cutting-edge innovation to elevate your game.</p>
          {{-- <a href="#" style="color: #303034;">View Collection →</a> --}}
        </div>
      </div>


      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/trainingcollection.png') }}" alt="Training">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Training</h2>
          <p>Nike training shoes deliver a perfect blend of stability, support, and flexibility, making them ideal for a wide range of workouts.</p>
          {{-- <a href="#" style="color: #23AA97;">View Collection →</a> --}}
        </div>
      </div>


      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/soccercollection.png') }}" alt="Soccer">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Soccer</h2>
          <p>Nike soccer boots are engineered for precision touch, agile traction, and lightweight speed, giving players the control they need.</p>
          {{-- <a href="#" style="color: #035573;">View Collection →</a> --}}
        </div>
      </div>


      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/sandalscollection.png') }}" alt="Sandals">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Sandals</h2>
          <p>Nike sandals provide lightweight comfort and effortless style, making them an excellent choice for casual wear and relaxing at home.</p>
          {{-- <a href="#" style="color: #6E5B59;">View Collection →</a> --}}
        </div>
      </div>


    </div>
  </div>
  {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="margin-bottom:70px;">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>


  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="margin-bottom:70px;">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button> --}}
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
            <option class="sort" value="">Sort by</option>
            <option value="newest">Newest</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
        </select>
    </div>


    <div class="price-filter">
    <label>Price</label>
    <div class="slider-values">
      <span>Rp. <span id="minPriceVal">{{ $minPrice }}k</span></span>
      <span>Rp. <span id="maxPriceVal">{{ $maxPrice }}k</span></span>
    </div>
    <div class="slider-container">
      <input type="range" name="min" id="minPrice" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="{{ $minPrice }}" step="100">
      <input type="range" name="max" id="maxPrice" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="{{ $maxPrice }}" step="100">
      <div class="slider-track"></div>
    </div>
</div>


</div>
    <div class="d-flex justify-content-between align-items-center d-md-none mb-3" style="margin-left: 20px">
        <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilter">
            <i class="bi bi-filter"></i> Filter
        </button>
    </div>


<div class="product-container d-flex">
    <aside class="filter-sidebar d-none d-md-block me-3">
        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Category</div>
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
            <div class="filter-title" onclick="toggleFilter(this)">Color</div>
            <div class="filter-content">
                @foreach ($colors as $color)
                    <label>
                        <input type="checkbox" name="color[]" value="{{ $color->color_name }}"
                            {{ in_array($color->color_name, request()->input('color', [])) ? 'checked' : '' }}>
                        <span class="color-box" style="background-color: {{ $color->color_code }};"></span>
                        {{ $color->color_name }}
                    </label><br>
                @endforeach
            </div>
        </div>




        {{-- <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Size</div>
            <div class="filter-content">
                @foreach ($sizes as $size)
                    <label>
                        <input type="checkbox" name="size[]" value="{{ $size->size }}"
                            {{ in_array($size->size, request()->input('size', [])) ? 'checked' : '' }}>
                        {{ $size->size }}
                    </label><br>
                @endforeach
            </div>
        </div> --}}

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


    <main id="productResults" class="flex-grow-1">
        @include('partials.product_list', ['products' => $products])
    </main>
</div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilter">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Category</div>
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
            <div class="filter-title" onclick="toggleFilter(this)">Color</div>
            <div class="filter-content">
                @foreach ($colors as $color)
                    <label>
                        <input type="checkbox" name="color[]" value="{{ $color->color_name }}"
                            {{ in_array($color->color_name, request()->input('color', [])) ? 'checked' : '' }}>
                        <span class="color-box" style="background-color: {{ $color->color_code }};"></span>
                        {{ $color->color_name }}
                    </label><br>
                @endforeach
            </div>
        </div>


        {{-- <div class="filter-group">
            <div class="filter-title" onclick="toggleFilter(this)">Size</div>
            <div class="filter-content">
                @foreach ($sizes as $size)
                    <label>
                        <input type="checkbox" name="size[]" value="{{ $size->size }}"
                            {{ in_array($size->size, request()->input('size', [])) ? 'checked' : '' }}>
                        {{ $size->size }}
                    </label><br>
                @endforeach
            </div>
        </div>  --}}

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
    <script>
  // fungsi untuk log semua warna yang dicentang
  function logCheckedColors() {
    const checkedColors = Array.from(document.querySelectorAll('input[name="color[]"]:checked'))
                               .map(el => el.value);
    console.log('Checked colors:', checkedColors);
  }


  // pasang event listener ke semua checkbox color
  document.querySelectorAll('input[name="color[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', logCheckedColors);
  });
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function () {
    const minSlider = document.getElementById("minPrice");
    const maxSlider = document.getElementById("maxPrice");
    const minVal = document.getElementById("minPriceVal");
    const maxVal = document.getElementById("maxPriceVal");
    const searchToggle = document.getElementById('searchToggle');
    const filterBar = document.querySelector('.filter-bar');
    const searchInput = document.getElementById('searchInput');

    let currentPage = 1;
    let currentEntries = parseInt($('#entries').val()) || 8;

    function updateValues() {
        if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
            [minSlider.value, maxSlider.value] = [maxSlider.value, minSlider.value];
        }
        minVal.textContent = minSlider.value + 'k';
        maxVal.textContent = maxSlider.value + 'k';
    }

    function fetchData(url = null, forcePageCheck = false) {
        if (!url) {
            url = new URL("{{ route('product.list') }}", window.location.origin);
            url.searchParams.set('entries', currentEntries);
            url.searchParams.set('page', currentPage);
        } else {
            url = new URL(url, window.location.origin);
            currentPage = parseInt(url.searchParams.get('page')) || 1;
            currentEntries = parseInt(url.searchParams.get('entries')) || currentEntries;
        }

        $.ajax({
            url: url.toString(),
            method: 'GET',
            data: $('#filterForm').serialize(),
            success: function (response) {
    $('#productResults').html(response);

    const container = document.getElementById('productContainer');
    let totalProducts = parseInt(container?.dataset.totalProducts || 0);
    let maxPage = Math.ceil(totalProducts / currentEntries);

    if (currentPage > maxPage) {
        currentPage = maxPage || 1;
        fetchData(null, false);
        return;
    }

    // Hanya sembunyikan pagination, bukan "show entries"
if ($('#productResults .pagination').length === 0 || maxPage <= 1) {
    $('#paginationWrapper .pagination').parent().hide(); // sembunyikan hanya bagian pagination <nav>
} else {
    $('#paginationWrapper .pagination').parent().show(); // tampilkan lagi
}

    attachPaginationEvents();
    rebindProductEvents();
},
            error: function () {
                alert('Gagal memuat produk. Silakan coba lagi.');
            }
        });
    }

    function attachPaginationEvents() {
        $('#productResults .pagination a').off('click').on('click', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) fetchData(url);
        });
    }

    function rebindProductEvents() {
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function () {
                const bgColor = this.getAttribute('data-bg-color');
                this.style.backgroundColor = bgColor;
            });
            card.addEventListener('mouseleave', function () {
                this.style.backgroundColor = '';
            });
        });
    }

    // Fungsi ubah entries
    window.changeEntries = function (newEntries) {
        currentEntries = parseInt(newEntries);

        const container = document.getElementById('productContainer');
        const totalProducts = parseInt(container?.dataset.totalProducts || 0);
        const maxPage = Math.ceil(totalProducts / currentEntries);

        if (currentPage > maxPage) {
            currentPage = maxPage;
        }

        fetchData(null, true);
    };

    window.toggleFilter = function (element) {
        const group = element.parentElement;
        group.classList.toggle('active');
    }

    searchToggle?.addEventListener('click', () => {
        filterBar?.classList.toggle('show-search');
        if (filterBar?.classList.contains('show-search')) {
            searchInput?.focus();
        }
    });

    minSlider?.addEventListener("input", function () {
        updateValues();
        fetchData();
    });

    maxSlider?.addEventListener("input", function () {
        updateValues();
        fetchData();
    });

    $('#filterForm input, #filterForm select').on('input change', function () {
        currentPage = 1;
        fetchData();
    });

    updateValues();
    fetchData();
});
</script>


</body>
</html>
@endsection