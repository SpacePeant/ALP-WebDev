@extends('base.baseadmin')
@section('content')

@php
    $user_id = $user_id ?? null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      font-family: 'Red Hat Display', sans-serif;
      background-color: #fff;
    }

    .container {
        padding: 40px;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      text-align: center;
      margin-top: 20px;
      margin-bottom: 30px;
    }

    .add-product {
      font-weight: 500;
      font-size: 16px;
      margin-bottom: 20px;
      display: inline-block;
      color: #000;
      text-decoration: none;
    }

    .product-card {
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 16px;
      text-align: center;
      background-color: #fff;
      position: relative;
    }

    .product-card img {
      width: 100%;
      max-width: 180px;
      height: auto;
      margin-bottom: 12px;
    }

    .product-name {
      font-weight: 500;
      margin-bottom: 4px;
    }

    .product-color {
      font-size: 14px;
      color: #888;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .dropdown-toggle::after {
      display: none;
    }

    .dropdown-menu {
      min-width: 100px;
    }

    .dropdown-container {
      position: absolute;
      top: 10px;
      right: 14px;
    }

    .dropdown-container .btn {
      padding: 0;
      background: none;
      border: none;
    }

    .custom-dropdown {
    position: absolute;
    top: 10px;
    right: 14px;
    }

    .custom-dropdown-toggle {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    }

    .custom-dropdown-menu {
    display: none;
    position: absolute;
    top: 30px;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    min-width: 100px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    z-index: 1000;
    flex-direction: column;
    }

    .custom-dropdown-menu a {
    padding: 8px 12px;
    text-decoration: none;
    display: block;
    color: #000;
    }

    .custom-dropdown-menu a:hover {
    background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<div class="container">
<h1>Product</h1>

  <a href="{{ route('addproduct') }}" class="add-product">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-1A6 6 0 1 1 8 2a6 6 0 0 1 0 12z"/>
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
    Add New Product
  </a>

  <div class="product-grid mt-4">
   @forelse ($products as $product)
            <div class="product-card">
                <div class="dropdown-container custom-dropdown">
                    <button class="custom-dropdown-toggle" onclick="toggleDropdown(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <div class="custom-dropdown-menu">
                        <a href="{{ route('product.edit', ['id' => $product->id, 'color_id' => $product->color_id]) }}">Edit</a>
                        <a href="#" class="text-danger" onclick="confirmDelete({{ $product->id }})">Delete</a>
                    </div>
                </div>

                <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" class="product-img me-3" alt="{{ $product->name }}">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-color">Color: {{ $product->color_name }}</div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
  </div>
</div>
  

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  function toggleDropdown(btn) {
    const dropdown = btn.nextElementSibling;
    // Tutup semua dropdown lain
    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
      if (menu !== dropdown) menu.style.display = 'none';
    });
    // Toggle dropdown ini
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  }

  // Tutup dropdown saat klik di luar
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.custom-dropdown')) {
      document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
      });
    }
  });

  function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this product?')) {
      window.location.href = '/products/delete/' + id;
    }
  }
</script>
</body>
</html>

@endsection