@extends('base.base1')

@section('content')

@php
    $user_id = $user_id ?? null;
@endphp

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
      <div class="col-auto d-flex align-items-end">
          <button type="submit" class="btn btn-dark">Filter</button>
      </div>
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Fungsi toggle dropdown
  function toggleDropdown(e) {
    const btn = e.currentTarget;
    const orderCard = btn.closest('.order-card');
    const wrapper = orderCard.querySelector('.order-details-wrapper');
    const icon = btn.querySelector('.dropdown-icon');

    // Tutup semua order lain
    document.querySelectorAll('.order-details-wrapper').forEach(function(w) {
      if (w !== wrapper) {
        w.classList.remove('open');
        const otherIcon = w.closest('.order-card')?.querySelector('.dropdown-icon');
        if (otherIcon) otherIcon.textContent = '▼';
      }
    });

    // Toggle current
    wrapper.classList.toggle('open');
    icon.textContent = wrapper.classList.contains('open') ? '▲' : '▼';
  }

  // Bind event listener ke semua tombol "View Order"
  function bindDropdownToggle() {
    const buttons = document.querySelectorAll('.view-order-toggle');
    buttons.forEach(btn => {
      btn.removeEventListener('click', toggleDropdown); // cegah dobel
      btn.addEventListener('click', toggleDropdown);
    });
  }

  // Fungsi fetch orders dengan filter & search via AJAX
  function fetchOrders() {
    // Ambil value filter dan search
    const startDate = document.querySelector('#start_date').value;
    const endDate = document.querySelector('#end_date').value;
    const search = document.querySelector('#search').value;

    // Buat URL dengan query param
    const params = new URLSearchParams();
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);
    if (search) params.append('search', search);

    fetch(`{{ route('order') }}?${params.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      document.querySelector('#orderResults').innerHTML = html;
      bindDropdownToggle(); // Pasang ulang event toggle dropdown setelah update konten
    })
    .catch(err => console.error('Fetch error:', err));
  }

  // Event listener untuk filter tanggal - submit form filter tanpa reload page
  document.querySelector('#filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetchOrders();
  });

  // Event listener untuk input search - debounce agar tidak spam request
  let debounceTimeout;
  document.querySelector('#search').addEventListener('input', function() {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(fetchOrders, 300);
  });

  // Pasang toggle dropdown saat halaman pertama load
  document.addEventListener('DOMContentLoaded', function() {
    bindDropdownToggle();
  });

  document.addEventListener('DOMContentLoaded', function () {
  const tabs = document.querySelectorAll('#orderStatusTabs .nav-link');
  const orderContainer = document.getElementById('orderResults');

  tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
      e.preventDefault();

      // Toggle active class
      tabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');

      const status = this.getAttribute('data-status');

      fetch(`{{ route('order') }}?status=${status}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.text())
      .then(html => {
        orderContainer.innerHTML = html;
      })
      .catch(err => console.error(err));
    });
  });
});
</script>
@endpush
