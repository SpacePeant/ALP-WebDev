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
 <meta name="csrf-token" content="{{ csrf_token() }}">
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
      width: 220px; /* fixed width sesuai minmax di grid-template-columns */
      box-sizing: border-box;
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
      grid-template-columns: repeat(5, 1fr); /* 5 card per row */
      gap: 30px;
      justify-content: center; /* supaya grid center */
      max-width: calc(5 * 220px + 4 * 20px); /* lebar maksimal sesuai 5 card + gap */
      margin: 0 auto; /* center grid secara horisontal */
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

@media (max-width: 575.98px) {
  .product-grid {
    grid-template-columns: repeat(2, 1fr); /* Tetap 2 kolom */
    gap: 12px;
    padding: 0 12px;
  }

  .container {
    padding: 16px;
  }

  .product-card {
    width: 100%;
    max-width: 100%;
  }

  .product-card img {
    width: 100%;
    height: auto;
  }

  h1 {
    /* font-size: 20px; */
    margin-top: 80px;
    margin-bottom: 20px;
    text-align: center;
  }

  .btn,
  .form-select,
  .form-control {
    font-size: 14px;
  }

  /* Wrapper untuk tombol dan filter: susun vertikal
  .d-flex.justify-content-between.flex-wrap.align-items-end.mb-4 {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
    padding: 0 12px;
  }


  .btn {
    width: 100%;
    justify-content: center;
  }

  .hahi {
    width: 100%;
  }

  .hahi .d-flex {
    flex-direction: column;
    align-items: stretch;
    gap: 8px;
  }

  .hahi .d-flex > select {
    align-self: flex-end;
    width: fit-content;
  }

  .hahi .d-flex > div {
    width: 100%;
    margin: 0;
  }

  #search {
    width: 100%;
  } */
}

/* ≥576px – 767px = 2 kolom */
@media (min-width: 576px) and (max-width: 767.98px) {
  .product-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 0 16px;
  }

  .container {
    padding: 24px;
  }
 h1 {
    /* font-size: 20px; */
    margin-top: 80px;
    margin-bottom: 20px;
    text-align: center;
  }
}

/* ≥768px – 991px = 3 kolom */
@media (min-width: 768px) and (max-width: 991.98px) {
  .product-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    padding: 0 24px;
  }

  .container {
    padding: 32px;
  }

   h1 {
    /* font-size: 20px; */
    margin-top: 80px;
    margin-bottom: 20px;
    text-align: center;
  }
  
}

/* ≥992px – 1199px = 4 kolom */
@media (min-width: 992px) and (max-width: 1199.98px) {
  .product-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    padding: 0 30px;
  }

  .container {
    padding: 36px;
  }
}

/* ≥1200px = 5 kolom */
@media (min-width: 1200px) {
  .product-grid {
    grid-template-columns: repeat(5, 1fr);
    gap: 30px;
    padding: 0; /* sudah center via margin auto */
  }

  .container {
    padding: 40px;
  }
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

    .pagination li.active span {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
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
        /* padding: 0.25rem 0.5rem; */
    }
  </style>
</head>
<body>

<div class="container">
<h1>Product</h1>

<div class="d-flex justify-content-between align-items-end mb-4 d-none d-md-flex">
  <!-- Tombol Add New Product di kiri -->
  <a href="{{ route('addproduct') }}" class="btn d-flex align-items-center gap-2 mb-2" style="height: fit-content; margin-left: 0;">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-1A6 6 0 1 1 8 2a6 6 0 0 1 0 12z"/>
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
    <span>Add New Product</span>
  </a>

  <!-- Wrapper search di kanan -->
  <div class="d-flex align-items-end gap-3">
    <div class="d-flex align-items-center">
      <label for="search_by" class="form-label mb-0 me-2" style="white-space: nowrap;">Search by</label><br>
      <select id="search_by" name="search_by" class="form-select">
        <option value="product_id">Product ID</option>
        <option value="product_name">Product Name</option>
      </select>
    </div>

    <div style="min-width: 200px; margin-right: 10px">
      <label for="search" class="form-label mb-1">&nbsp;</label>
      <input type="text" id="search" name="search" class="form-control" placeholder="Search">
    </div>
  </div>
</div>


<div class="d-block d-md-none mb-4 px-3">

  <div class="row g-2 align-items-center mb-2">
    <!-- Kiri: Tombol Add -->
    <div class="col-6 ps-0">
  <a href="{{ route('addproduct') }}" class="btn w-100 d-flex align-items-center gap-2 ps-1">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-1A6 6 0 1 1 8 2a6 6 0 0 1 0 12z"/>
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
    <span>Add New Product</span>
  </a>
</div>

    <!-- Kanan: Label + Select Search By -->
    <div class="col-6 d-flex align-items-center justify-content-end">
      <label for="search_by_mobile" class="me-2 mb-0 small">Search by</label>
      <select id="search_by_mobile" name="search_by" class="form-select form-select-sm w-auto">
        <option value="product_id">Product ID</option>
        <option value="product_name">Product Name</option>
      </select>
    </div>
  </div>

  <!-- Full Width: Input Search -->
  <div>
    <input type="text" id="search_mobile" name="search" class="form-control" placeholder="Search">
  </div>
</div>

<div id="product-list">
    @include('partials.admin-list', ['products' => $products])
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Fungsi tampilkan variant produk dalam modal
  function showVariants(color_id) {
    fetch(`/product/${color_id}`)
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById('variantTable');
        tbody.innerHTML = '';

        if (data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="2" class="py-2">No variants found.</td></tr>';
          document.getElementById('productName').textContent = '-';
          document.getElementById('productColor').textContent = '-';
          document.getElementById('productCategory').textContent = '-';
          document.getElementById('productImage').src = '';
        } else {
          const item = data[0];
          document.getElementById('productName').textContent = item.product_name || '-';
          document.getElementById('productColor').textContent = item.color_name || '-';
          document.getElementById('productCategory').textContent = item.category_name || '-';
          document.getElementById('productImage').src = item.image_kiri ? '/image/sepatu/kiri/' + item.image_kiri : '';

          data.forEach(item => {
            tbody.innerHTML += `<tr>
              <td class="py-2 border-b">${item.size}</td>
              <td class="py-2 border-b">${item.stock}</td>
            </tr>`;
          });
        }

        // Tampilkan modal dan disable scroll body
        const modal = document.getElementById('variantModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
      });
  }

  // Fungsi tutup modal variant
  function closeModal() {
    const modal = document.getElementById('variantModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }

  // Fungsi toggle dropdown custom
  function toggleDropdown(btn) {
    const dropdown = btn.nextElementSibling;
    // Tutup dropdown lain
    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
      if (menu !== dropdown) menu.style.display = 'none';
    });
    // Toggle dropdown ini
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
  }

  // Tutup dropdown saat klik di luar
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.custom-dropdown')) {
      document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
      });
    }
  });

  // Konfirmasi hapus produk menggunakan SweetAlert2
  function confirmDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This item will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '/products/delete/' + id;
      }
    });
  }

  // Document ready untuk event handling dan AJAX search + pagination
$(document).ready(function () {
    let baseUrl = "{{ route('admin.products.search') }}";
    let currentPage = 1;
    let currentEntries = parseInt($('#entries').val()) || 10;

    function fetchProducts(url = null, forcePageCheck = false) {
        if (!url) {
            url = baseUrl + `?entries=${currentEntries}&page=${currentPage}`;
        }

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: $('#search').val(),
                search_by: $('#search_by').val(),
                entries: currentEntries,
                page: currentPage,
            },
            success: function (data) {
                $('#product-list').html(data);

                // Cek max page dari response, diasumsikan disertakan di <script> di partial
                let maxPage = window.totalPages || null;

                // Jika kita force cek page valid dan maxPage diketahui
                if (forcePageCheck && maxPage !== null) {
                    if (currentPage > maxPage) {
                        currentPage = maxPage;
                        fetchProducts(null, false);  // reload pakai page max
                        return; // hentikan fungsi supaya tidak bind dua kali
                    }
                }

                attachPaginationEvents();
                bindEvents();
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    }

    function attachPaginationEvents() {
        $('#product-list .pagination a').off('click').on('click', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url) {
                const urlObj = new URL(url, window.location.origin);
                currentPage = parseInt(urlObj.searchParams.get('page')) || 1;
                currentEntries = parseInt(urlObj.searchParams.get('entries')) || currentEntries;

                fetchProducts(url);
            }
        });
    }

    function bindEvents() {
        $('#entries').off('change').on('change', function () {
            currentEntries = parseInt($(this).val());

            // jangan reset page ke 1 dulu, tapi cek apakah page valid setelah fetch
            fetchProducts(null, true);
        });

        $('#search').off('keyup').on('keyup', function () {
            currentPage = 1;
            fetchProducts();
        });

        $('#search_by').off('change').on('change', function () {
            currentPage = 1;
            fetchProducts();
        });
    }

    bindEvents();
    fetchProducts();
});


</script>

</body>
</html>

@endsection