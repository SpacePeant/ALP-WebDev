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
<script src="https://cdn.tailwindcss.com"></script>
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
      margin-top: 80px;
      margin-bottom: 30px;
    }

    .add-product {
      font-weight: 500;
      font-size: 16px;
      margin-bottom: 20px;
      display: flex;
      color: #000;
      text-decoration: none;
    }

    .add-product p{
      margin-left:10px;
      margin-top: -3px;
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

    @keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to   { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out forwards;
}
.product-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.product-card:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
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
    <p>Add New Product</p>
  </a>

  <div class="product-grid mt-4">
   @forelse ($products as $product)
            <div class="product-card" onclick="showVariants({{ $product->color_id }})">
                <div class="dropdown-container custom-dropdown">
                    <button class="custom-dropdown-toggle" onclick="event.stopPropagation(); toggleDropdown(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <div class="custom-dropdown-menu">
                        <a href="{{ route('product.edit', ['id' => $product->id, 'color_id' => $product->color_id]) }}" onclick="event.stopPropagation()">Edit</a>
                        <a href="#" class="text-danger" onclick="event.stopPropagation(); confirmDelete({{ $product->color_id }})">Delete</a>
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

<div id="variantModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 overflow-y-auto">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[60vh] p-6 relative animate-fadeIn overflow-y-auto">
    <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl font-bold">&times;</button>
    <h3 class="text-xl font-semibold mb-2">Product Detail</h3>

    <div class="mb-4 text-sm text-gray-700 flex gap-4 items-center">
      <img id="productImage" src="" alt="Product Image" class="w-24 h-24 object-contain rounded-md border" />
      <div>
        <p><strong>Product Name:</strong> <span id="productName"></span></p>
        <p><strong>Color:</strong> <span id="productColor"></span></p>
        <p><strong>Category:</strong> <span id="productCategory"></span></p>
      </div>
    </div>

    <table class="w-full text-left border-collapse text-sm text-gray-700">
      <thead>
        <tr>
          <th class="border-b py-2">Size</th>
          <th class="border-b py-2">Stock</th>
        </tr>
      </thead>
      <tbody id="variantTable">
        <!-- Rows will be inserted here -->
      </tbody>
    </table>
  </div>
</div>

<script>
function showVariants(color_id) {
  fetch(`/product/${color_id}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('variantTable');
      tbody.innerHTML = '';

      if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2" class="py-2">No variants found.</td></tr>';
        // Clear texts and image if no data
        document.getElementById('productName').textContent = '-';
        document.getElementById('productColor').textContent = '-';
        document.getElementById('productCategory').textContent = '-';
        document.getElementById('productImage').src = '';
      } else {
        const item = data[0];
        document.getElementById('productName').textContent = item.product_name || '-';
        document.getElementById('productColor').textContent = item.color_name || '-';
        document.getElementById('productCategory').textContent = item.category_name || '-';

        // Set image, pastikan path gambarnya valid
        if (item.image_kiri) {
          document.getElementById('productImage').src = '/image/sepatu/kiri/' + item.image_kiri;
        } else {
          document.getElementById('productImage').src = ''; // kosongkan jika tidak ada gambar
        }


        data.forEach(item => {
          tbody.innerHTML += `<tr>
            <td class="py-2 border-b">${item.size}</td>
            <td class="py-2 border-b">${item.stock}</td>
          </tr>`;
        });
      }

      const modal = document.getElementById('variantModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');

      // Disable scroll body saat modal aktif
      document.body.style.overflow = 'hidden';
    });
}

function closeModal() {
  const modal = document.getElementById('variantModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');

  // Enable scroll body saat modal ditutup
  document.body.style.overflow = '';
}
</script>
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  // function confirmDelete(id) {
  //   if (confirm('Are you sure you want to delete this product?')) {
  //     window.location.href = '/products/delete/' + id;
  //   }
  // }

  function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This item will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/products/delete/' + id;
        }
    });
}

</script>
</body>
</html>

@endsection