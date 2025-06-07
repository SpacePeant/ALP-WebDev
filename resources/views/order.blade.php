@extends('base.base1')

@section('content')

@php
    $user_id = $user_id ?? null;
@endphp
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="container">
  <h1 class="text-center mb-4">Orders</h1>

  <div class="d-flex justify-content-between flex-wrap" style="margin-bottom: 20px">

  <form method="GET" action="{{ route('order') }}" id="filterForm" class="d-flex justify-content-end mb-4 gap-3 flex-wrap" style="margin-top: 50px;">
      <div class="col-auto">
          <label for="start_date" class="form-label">From</label>
          <input type="date" id="start_date" name="start_date" class="form-control"
              value="{{ request('start_date') }}">
      </div>
      <div class="col-auto">
          <label for="end_date" class="form-label">To</label>
          <input type="date" id="end_date" name="end_date" class="form-control"
              value="{{ request('end_date') }}">
      </div>
      {{-- <div class="col-auto d-flex align-items-end">
          <button type="submit" class="btn btn-filter">Filter</button>
      </div> --}}
</form>

<form method="GET" action="{{ route('order') }}" id="searchForm" class="d-flex align-items-end gap-2 flex-wrap" style="margin-bottom: 20px">
    <div class="d-flex align-items-end gap-2">
        <div>
            <input type="text" name="search" id="search" class="form-control" placeholder="Search Product Name"
                value="{{ request('search') }}">
        </div>
    </div>

    {{-- Hidden input agar tetap menyertakan filter tanggal saat search --}}
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
</form>
</div>

<ul class="nav nav-tabs mb-3" id="orderStatusTabs">
  <li class="nav-item">
    <a class="nav-link {{ $filter == null ? 'active' : '' }}" href="#" data-status="">All</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $filter == 'Paid' ? 'active' : '' }}" href="#" data-status="Paid">Paid</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $filter == 'Pending' ? 'active' : '' }}" href="#" data-status="Pending">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $filter == 'Expired' ? 'active' : '' }}" href="#" data-status="Expired">Expired</a>
  </li>
</ul>

<div id="orderResults">
  @include('partials.ordercust', ['orders' => $orders])
</div>

@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
   body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }

  .container {
    padding: 40px;
    margin-top: 100px;
  }

  h1 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    margin-bottom: -50px;
    text-align: center;
  }

  .order-card {
    background-color: #fff;
    border-radius: 12px;
    border: 1px solid #ddd;
    padding: 24px;
    margin-bottom: 20px;
  }

  .order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
  }

    .status-btn {
    font-size: 14px;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1px solid transparent;
    display: inline-block;
    text-align: center;
    }

    .status-success {
    background-color: #d4edda;
    color: #3c763d;
    border-color: #c3e6cb;
    }

    .status-pending {
    background-color: #fff3cd;
    color: #856404;
    border-color: #ffeeba;
    }

    .status-failed {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
    }

    .status-unknown {
    background-color: #e2e3e5;
    color: #383d41;
    border-color: #d6d8db;
    }

    .pay-now-btn {
      text-decoration: none;
      background-color: #444;
      color: #fff;
      border-color: #444;
    }

    .pay-now-btn:hover {
      background-color: black;
      border-color: black;
      color: #fff;
    }

    .btn-filter {
      background-color: #444;
      color: #fff;
    }

    .btn-filter:hover {
      background-color: black;
      color: #fff;
    }

  .view-order-toggle {
    font-weight: 500;
    color: #6c757d;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    margin-bottom: 90px;
  }

  .view-order-toggle .dropdown-icon {
    transition: transform 0.3s ease;
    display: inline-block;
    margin-left: 6px;
  }

  .view-order-toggle[aria-expanded="true"] .dropdown-icon {
    transform: rotate(180deg);
  }

  .product-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-top: 1px solid #eee;
  }

  .product-item img {
    width: 80px;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 16px;
  }

  .product-info {
    flex-grow: 1;
  }

  .product-qty-price {
    text-align: right;
    white-space: nowrap;
  }

  hr {
    margin: 20px 0;
  }

  .order-details-wrapper {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease;
  }

  .order-details-wrapper.open {
    max-height: 1000px;
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
.nav-link {
      color: black;
    }

    .nav-link:hover {
      color: black;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // ==========================
    // Variabel global
    // ==========================
    let currentStatus = "{{ request('status') ?? '' }}";
    let currentPage = 1;
    let currentSearch = $('#search').val() || '';
    let currentStartDate = $('#start_date').val() || '';
    let currentEndDate = $('#end_date').val() || '';
    let currentEntries = parseInt($('#entries').val()) || 5;

    // ==========================
    // Toggle dropdown detail pesanan
    // ==========================
    function toggleDropdown(e) {
        const btn = e.currentTarget;
        const orderCard = btn.closest('.order-card');
        const wrapper = orderCard.querySelector('.order-details-wrapper');
        const icon = btn.querySelector('.dropdown-icon');

        document.querySelectorAll('.order-details-wrapper').forEach(function(w) {
            if (w !== wrapper) {
                w.classList.remove('open');
                const otherIcon = w.closest('.order-card')?.querySelector('.dropdown-icon');
                if (otherIcon) otherIcon.textContent = '▼';
            }
        });

        wrapper.classList.toggle('open');
        icon.textContent = wrapper.classList.contains('open') ? '▲' : '▼';
    }

    function bindDropdownToggle() {
        const buttons = document.querySelectorAll('.view-order-toggle');
        buttons.forEach(btn => {
            btn.removeEventListener('click', toggleDropdown);
            btn.addEventListener('click', toggleDropdown);
        });
    }

    // ==========================
    // AJAX Fetch Orders
    // ==========================
    function fetchOrders(params = {}) {
        let data = {
            status: currentStatus,
            page: currentPage,
            search: currentSearch,
            start_date: currentStartDate,
            end_date: currentEndDate,
            entries: currentEntries
        };

        data = {...data, ...params};

        Object.keys(data).forEach(key => {
            if (!data[key]) delete data[key];
        });

        $.ajax({
            url: "{{ route('order') }}",
            type: "GET",
            data: data,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (response) {
                $('#paginationWrapper').remove();
                $('#orderResults').html(response);
                bindDropdownToggle();
                bindTabAndPagination();
                bindEntriesDropdown();
            },
            error: function () {
                alert('Gagal memuat data pesanan.');
            }
        });
    }

    function bindTabAndPagination() {
        $('#orderStatusTabs .nav-link').off('click').on('click', function (e) {
            e.preventDefault();
            currentStatus = $(this).data('status') || '';
            currentPage = 1;

            $('#orderStatusTabs .nav-link').removeClass('active');
            $(this).addClass('active');

            fetchOrders();
        });

        $('#orderResults').find('.pagination a').off('click').on('click', function (e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'));
            const params = Object.fromEntries(url.searchParams.entries());
            currentPage = parseInt(params.page) || 1;
            fetchOrders(params);
        });
    }

    // ==========================
    // Entry dropdown dengan validasi halaman
    // ==========================
    function bindEntriesDropdown() {
        $('#entries').off('change').on('change', function () {
            const newEntries = parseInt($(this).val()) || 5;

            // Ambil total orders dari elemen #total-orders
            const totalOrders = parseInt($('#total-orders').text()) || 0;

            const newMaxPage = Math.ceil(totalOrders / newEntries);
            if (currentPage > newMaxPage) {
                currentPage = newMaxPage;
            }

            currentEntries = newEntries;
            fetchOrders();
        });
    }

    // ==========================
    // Filter form & search input
    // ==========================
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        currentSearch = $('#search').val();
        currentStartDate = $('#start_date').val();
        currentEndDate = $('#end_date').val();
        currentPage = 1;
        fetchOrders();
    });

    let debounceTimeout;
    $('#search').on('input', function () {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            currentSearch = $(this).val();
            currentPage = 1;
            fetchOrders();
        }, 300);
    });

    $('#start_date, #end_date').on('change', function () {
        currentStartDate = $('#start_date').val();
        currentEndDate = $('#end_date').val();
        currentPage = 1;
        fetchOrders();
    });

    // ==========================
    // Inisialisasi awal
    // ==========================
    bindDropdownToggle();
    bindTabAndPagination();
    bindEntriesDropdown();
    fetchOrders();
});
</script>
@endpush




