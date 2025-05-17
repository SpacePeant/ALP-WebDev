@extends('base.baseadmin')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Red Hat Display', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      /* padding: 40px 20px; */
      color: #212529;
      margin-bottom: 50px;
    }

    h1 {
        margin-top: 40px;
    }

    h1, h2 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      margin-bottom: 40px;
      text-align: center
    }

    .dashboard-container {
      max-width: 1200px;
      margin: auto;
    }

    /* Statistik cards */
    .card-stat {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 24px 30px;
      text-align: center;
      transition: box-shadow 0.3s ease;
    }
    .card-stat:hover {
      box-shadow: 0 6px 14px rgba(0,0,0,0.1);
    }
    .card-stat .card-title {
      font-weight: 600;
      font-size: 1.1rem;
      color: #6c757d;
      margin-bottom: 12px;
      letter-spacing: 0.04em;
    }
    .card-stat .stat-value {
      font-size: 2rem;
      font-weight: 700;
    }
    /* .text-success { color: #198754 !important; }
    .text-primary { color: #0d6efd !important; }
    .text-warning { color: #ffc107 !important; } */

    /* Section titles */
    .section-title {
      font-weight: 700;
      font-size: 1.3rem;
      margin-bottom: 24px;
      border-bottom: 2px solid black;
      display: inline-block;
      padding-bottom: 4px;
    }

    /* Cards for chart and stock */
    .card-box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 24px;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    /* Table custom for stock */
    .table-custom {
      margin-bottom: 0;
      border-collapse: separate;
      border-spacing: 0 8px;
      width: 100%;
      font-size: 0.95rem;
      color: #495057;
    }
    .table-custom td {
      border: none;
      padding: 12px 10px;
      background: #f8f9fa;
      border-radius: 8px;
      vertical-align: middle;
    }
    .table-custom tr + tr td {
      margin-top: 8px;
    }
    .table-custom td:first-child {
      font-weight: 600;
    }
    .table-custom td.text-end {
      font-weight: 700;
    }

    /* Best Seller badges */
    .product-name {
      font-weight: 600;
    }
    .product-badge {
      background-color: black;
      color: #fff;
      border-radius: 50px;
      padding: 6px 16px;
      font-weight: 700;
      font-size: 0.9rem;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }

    .card-box::-webkit-scrollbar {
  width: 6px;
}

.card-box::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}

.card-box::-webkit-scrollbar-track {
  background-color: #f1f1f1;
}

    /* Responsive spacing */

/* Untuk layar >= 768px (Tablet dan ke atas) */
@media (min-width: 768px) {
  .g-4 > [class*="col-"] {
    margin-bottom: 0;
  }
}

/* Untuk layar >= 576px dan < 768px (HP lebar atau phablet) */
@media (max-width: 767.98px) and (min-width: 576px) {
  .g-4 > [class*="col-"] {
    margin-bottom: 20px;
  }

  .card-stat, .card-box {
    padding: 20px;
  }

  .stat-value {
    font-size: 1.6rem;
  }
}

/* Untuk layar < 576px (HP kecil) */
@media (max-width: 575.98px) {
  .g-4 > [class*="col-"] {
    margin-bottom: 20px;
  }

  .card-stat, .card-box {
    padding: 16px;
  }

  .stat-value {
    font-size: 1.4rem;
  }

  .section-title {
    font-size: 1.1rem;
  }

  .product-badge {
    font-size: 0.8rem;
    padding: 4px 12px;
  }
}

  </style>
</head>
<body>
  <div class="dashboard-container px-3 px-sm-4 px-md-0">
    <h1>Dashboard</h1>

   <!-- Statistik -->
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="card-stat">
        <div class="card-title">Balance</div>
        <div class="stat-value">Rp. {{ number_format($balance, 0, ',', '.') }}</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-stat">
        <div class="card-title">Total Sold</div>
        <div class="stat-value">{{ $totalSold }} pairs</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-stat">
        <div class="card-title">Stock Available</div>
        <div class="stat-value">{{ $stockAvailable }} pairs</div>
      </div>
    </div>
  </div>

  <!-- Chart & Stok Produk -->
  <div class="row g-4 mb-5">
    <!-- Chart -->
    <div class="col-md-8">
      <div class="card-box">
        <div class="section-title">Daily Sales Chart</div>
        <canvas id="salesChart"></canvas>
      </div>
    </div>

    <!-- Product Stock -->
    <div class="col-md-4">
  <div class="card-box" style="max-height: 500px; display: flex; flex-direction: column;">
    <!-- Judul dipisah dari area scroll -->
    <div class="section-title" id="product-stock" style="flex-shrink: 0;">Product Stock</div>

    <!-- Area scroll hanya untuk tabel -->
    <div style="overflow-y: auto; flex-grow: 1;">
      <table class="table-custom">
        <tbody>
          @foreach($productStock as $product)
            <tr>
              <td>{{ $product->name }}</td>
              <td class="text-end">{{ $product->total_stock }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

  </div>

  <!-- Best Seller -->
  <div class="row">
    <div class="col-12">
      <div class="card-box">
        <div class="section-title">Best Seller</div>
        <div class="row g-3">
          @foreach($bestSellers as $product)
            <div class="col-md-4 d-flex justify-content-between align-items-center">
              <div class="product-name">{{ $product->name }}</div>
              <span class="product-badge">{{ $product->total_sold }} sold</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>


  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [{
      label: 'Shoes Sold',
      data: [5, 9, 7, 12, 8, 15, 10],
      fill: true,
    //   backgroundColor: 'rgba(30, 60, 120, 0.2)', // biru tua transparan
    //   borderColor: '#1e3c78', // biru tua solid
    backgroundColor: 'rgba(34, 139, 84, 0.15)', // hijau gelap transparan
      borderColor: '#228b54', // hijau gelap solid
      tension: 0.3,
      pointRadius: 5,
      pointBackgroundColor: '#228b54',
      borderWidth: 3,
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 2,
          color: 'cccccc'  // abu-abu terang untuk angka y-axis
        },
      },
      x: {
        grid: {
          display: false
        },
        ticks: {
          color: 'cccccck'  // abu-abu terang untuk label x-axis
        }
      }
    },
    plugins: {
      legend: {
        display: true,
        labels: {
          color: 'cccccc',  // warna teks legend abu terang
          font: { weight: '600' }
        }
      }
    },
    interaction: {
      intersect: false,
      mode: 'nearest',
    }
  }
});

const ctx = document.getElementById('salesChart').getContext('2d');

  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($labels),
      datasets: [{
        label: 'Shoes Sold',
        data: @json($data),
        fill: true,
        backgroundColor: 'rgba(34, 139, 84, 0.15)',
        borderColor: '#228b54',
        tension: 0.3,
        pointRadius: 5,
        pointBackgroundColor: '#228b54',
        borderWidth: 3,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true },
        x: { grid: { display: false } }
      }
    }
  });
  </script>
</body>
</html>

@endsection