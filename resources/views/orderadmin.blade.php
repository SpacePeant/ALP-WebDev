@extends('base.baseadmin')

@section('content')

@php
    $user_id = $user_id ?? null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Red Hat Display', sans-serif;
      background-color: #f8f9fa;
    }

    .container {
        padding: 40px;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      margin-bottom: 40px;
      margin-top:100px;
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

    .status-delivered {
      background-color: #d4edda;
      color: #3c763d;
      border-color: #c3e6cb;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
      border-color: #ffeeba;
    }

    .view-order-toggle {
      font-weight: 500;
      color: #6c757d;
      background: none;
      border: none;
      padding: 0;
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

.status-btn {
    font-size: 14px;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1px solid transparent;
    display: inline-block;
    text-align: center;
    text-decoration: none;
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
    } */

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
</head>
<body>

<div class="container">
  <h1 class="text-center mb-4">Orders</h1>
  <div class="d-flex justify-content-center gap-4 mb-4">
    <!-- Completed Orders -->
    <div class="border rounded p-4 shadow-sm d-flex align-items-center" style="width: 250px;">
      <div class="rounded-circle bg-success bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
        <i class="bi bi-bag-check-fill text-success fs-3"></i>
      </div>
      <div class="ms-3">
        <h4 class="mb-0">{{ $completedOrders }}</h4>
        <small class="text-muted">Completed Orders</small>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="border rounded p-4 shadow-sm d-flex align-items-center" style="width: 250px;">
      <div class="rounded-circle bg-warning bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
        <i class="bi bi-wallet2 text-warning fs-3"></i>
      </div>
      <div class="ms-3">
        <h4 class="mb-0">{{ $pendingOrders }}</h4>
        <small class="text-muted">Pending Payments</small>
      </div>
    </div>
  </div>

<div class="d-flex justify-content-between flex-wrap">
<form method="GET" action="{{ route('admin.orders') }}" id="filterForm" class="d-flex justify-content-end mb-4 gap-3 flex-wrap" style="margin-top: 50px;">
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
          <button type="submit" class="btn btn-dark">Filter</button>
      </div> --}}
</form>

<form method="GET" action="{{ route('admin.orders') }}" id="searchForm" class="d-flex align-items-end gap-2 flex-wrap" style="margin-bottom: 20px">
    <div class="d-flex align-items-end gap-2">
        <div>
            <label for="search_by" class="form-label">Search by</label>
            <select name="search_by" id="search_by" class="form-select">
                <option value="order_id" {{ request('search_by') == 'order_id' ? 'selected' : '' }}>Order ID</option>
                <option value="customer_name" {{ request('search_by') == 'customer_name' ? 'selected' : '' }}>Customer Name</option>
            </select>
        </div>
        <div>
            <input type="text" name="search" id="search" class="form-control" placeholder="Search"
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

<div id="order-container">
  @include('partials.order-filter', ['orders' => $orders, 'orderDetails' => $orderDetails])
</div>

  <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let orderContainer = document.getElementById('order-container');
    let filterForm = document.getElementById('filterForm');
    let searchInput = document.getElementById('search');
    let searchBy = document.getElementById('search_by');
    let startDate = document.getElementById('start_date');
    let endDate = document.getElementById('end_date');
    let statusTabs = document.querySelectorAll('#orderStatusTabs .nav-link');
    let entriesSelect = document.getElementById('entries');

    // currentPage dan totalOrders global
    let currentPage = 1;
    let totalOrders = 0;

    // Helper function ambil semua parameter filter dari UI saat ini
    function getFilterParams() {
        const params = new URLSearchParams();

        if (searchInput && searchInput.value.trim() !== '') {
            params.set('search', searchInput.value.trim());
        }
        if (searchBy && searchBy.value) {
            params.set('search_by', searchBy.value);
        }
        if (startDate && startDate.value) {
            params.set('start_date', startDate.value);
        }
        if (endDate && endDate.value) {
            params.set('end_date', endDate.value);
        }
        if (entriesSelect && entriesSelect.value) {
            params.set('entries', entriesSelect.value);
        }
        if (currentPage && currentPage > 1) {
            params.set('page', currentPage);
        }

        const activeTab = document.querySelector('#orderStatusTabs .nav-link.active');
        if (activeTab && activeTab.getAttribute('data-status')) {
            params.set('status', activeTab.getAttribute('data-status'));
        }

        return params;
    }

    function toggleDropdown(e) {
        const btn = e.currentTarget;
        const orderCard = btn.closest('.order-card');
        const wrapper = orderCard.querySelector('.order-details-wrapper');
        const icon = btn.querySelector('.dropdown-icon');

        document.querySelectorAll('.order-details-wrapper').forEach(w => {
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
        document.querySelectorAll('.view-order-toggle').forEach(btn => {
            btn.removeEventListener('click', toggleDropdown); // Unbind dulu
            btn.addEventListener('click', toggleDropdown);    // Bind ulang
        });
    }

    function bindEntriesSelect() {
        entriesSelect = document.getElementById('entries');
        if (entriesSelect) {
            entriesSelect.removeEventListener('change', handleEntriesChange);
            entriesSelect.addEventListener('change', handleEntriesChange);
        }
    }

    function handleEntriesChange() {
        const newEntries = parseInt(entriesSelect.value);
        const newMaxPage = Math.ceil(totalOrders / newEntries);
        const targetPage = currentPage <= newMaxPage ? currentPage : newMaxPage;

        const params = new URLSearchParams();
        if (searchInput) params.set('search', searchInput.value);
        if (searchBy) params.set('search_by', searchBy.value);
        if (startDate) params.set('start_date', startDate.value);
        if (endDate) params.set('end_date', endDate.value);
        const activeTab = document.querySelector('#orderStatusTabs .nav-link.active');
        if (activeTab) params.set('status', activeTab.getAttribute('data-status'));

        params.set('entries', newEntries);
        if (targetPage > 1) params.set('page', targetPage);

        fetchOrders(params.toString());
    }

    function fetchOrders(params = '') {
        const url = "{{ route('admin.orders.filter') }}?" + params;
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            orderContainer.innerHTML = html;

            // Update totalOrders dari elemen tersembunyi di HTML
            const totalElement = document.getElementById('total-orders');
            if (totalElement) totalOrders = parseInt(totalElement.textContent);

            // Rebind event handlers setelah reload konten
            bindDropdownToggle();
            bindEntriesSelect();
        })
        .catch(err => console.error('AJAX error:', err));
    }

    // Handle pagination link clicks
    document.addEventListener('click', function(e) {
        if (e.target.matches('.pagination a')) {
            e.preventDefault();
            const url = new URL(e.target.href);
            currentPage = parseInt(url.searchParams.get('page')) || 1;

            fetchOrders(getFilterParams().toString());
        }
    });

    // Filter form submit
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            currentPage = 1; // reset halaman 1
            fetchOrders(getFilterParams().toString());
        });
    }

    // Debounce untuk search input dan filter tanggal
    let debounceTimeout;
    function doSearch() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            currentPage = 1; // reset halaman 1
            fetchOrders(getFilterParams().toString());
        }, 300);
    }

    if (searchInput) searchInput.addEventListener('input', doSearch);
    if (searchBy) searchBy.addEventListener('change', doSearch);
    if (startDate) startDate.addEventListener('change', doSearch);
    if (endDate) endDate.addEventListener('change', doSearch);

    // Tab status click
    statusTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            statusTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentPage = 1; // reset halaman 1
            fetchOrders(getFilterParams().toString());
        });
    });

    // Initial setup
    bindDropdownToggle();
    bindEntriesSelect();

    const totalElement = document.getElementById('total-orders');
    if (totalElement) totalOrders = parseInt(totalElement.textContent);
    currentPage = 1;
});
</script>


</body>
</html>

@endsection