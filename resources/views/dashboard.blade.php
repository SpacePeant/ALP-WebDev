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
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">

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
        margin-top: 120px;
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
      font-weight: 500;
      font-size: 1.1rem;
      color: #6c757d;
      margin-bottom: 12px;
      letter-spacing: 0.04em;
    }

    /* .text-success { color: #198754 !important; }
    .text-primary { color: #0d6efd !important; }
    .text-warning { color: #ffc107 !important; } */

    /* Section titles */
    .section-title {
      font-size: 1.2rem;
      font-weight: 500;
      margin-bottom: 20px;
      border-bottom: 1px solid #000;
      padding-bottom: 6px;
      color: #111;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 500;
      color: #111;
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
      font-weight: 500;
    }
    .table-custom td.text-end {
      font-weight: 500;
    }

    /* Best Seller badges */
    .product-name {
      font-weight: 500;
    }
    .product-badge {
      background-color: black;
      color: #fff;
      border-radius: 50px;
      padding: 6px 16px;
      font-weight: 500;
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

.container{
  margin-top:150px;
}

  </style>
</head>
<body>
  <div class="dashboard-container px-3 px-sm-4 px-md-0">
  <h1>Dashboard</h1>

  <div class="d-flex justify-content-end mb-3">
  <select id="filterSelect" class="form-select w-auto">
    <option value="week" selected>This Week</option>
    <option value="month">This Month</option>
    <option value="year">This Year</option>
  </select>
</div>

<div id="dashboardContent"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const dashboardContent = document.getElementById('dashboardContent');
  let salesChart;

  function fetchDashboardData(filter = 'week') {
    fetch(`/dashboard/filter?filter=${filter}`)
      .then(res => res.json())
      .then(data => {
        renderDashboard(data);
        renderChart(data.data.labels, data.data.sales.map(Number));
      })
      .catch(err => console.error('Error fetching dashboard data:', err));
  }

  function renderDashboard(data) {
    const { balance, totalSold, stockAvailable, productStock, bestSellers } = data;

    dashboardContent.innerHTML = `
      <!-- Statistik -->
      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="card-stat">
            <div class="card-title">Balance</div>
            <div class="stat-value">Rp. ${formatNumber(balance)}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-stat">
            <div class="card-title">Total Sold</div>
            <div class="stat-value">${totalSold} pairs</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-stat">
            <div class="card-title">Stock Available</div>
            <div class="stat-value">${stockAvailable} pairs</div>
          </div>
        </div>
      </div>

      <!-- Chart & Product Stock -->
      <div class="row g-4 mb-5">
        <div class="col-md-8">
          <div class="card-box">
            <div class="section-title">Daily Sales Chart</div>
            <canvas id="salesChart"></canvas>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box" style="max-height: 500px; display: flex; flex-direction: column;">
            <div class="section-title" style="flex-shrink: 0;">Product Stock</div>
            <div style="overflow-y: auto; flex-grow: 1;">
              <table class="table-custom">
                <tbody>
                  ${productStock.map(p => `
                    <tr>
                      <td>${p.name}</td>
                      <td class="text-end">${p.total_stock}</td>
                    </tr>`).join('')}
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
              ${bestSellers.map(p => `
                <div class="col-md-4 d-flex justify-content-between align-items-center">
                  <div class="product-name">${p.name}</div>
                  <span class="product-badge">${p.total_sold} sold</span>
                </div>`).join('')}
            </div>
          </div>
        </div>
      </div>
    `;
  }

  function renderChart(labels, values) {
    const canvas = document.getElementById('salesChart');
    if (!canvas) {
      console.warn('Canvas #salesChart tidak ditemukan');
      return;
    }
    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(13,110,253,0.4)');
    gradient.addColorStop(1, 'rgba(13,110,253,0)');

    if (salesChart) salesChart.destroy();

    salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Units Sold',
          data: values,
          fill: true,
          backgroundColor: gradient,
          borderColor: '#0d6efd',
          tension: 0.4,
          pointBackgroundColor: '#0d6efd',
          pointBorderColor: '#fff',
          pointRadius: 5,
          pointHoverRadius: 7,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            mode: 'index',
            intersect: false,
            padding: 10,
            backgroundColor: 'rgba(0,0,0,0.75)',
            titleFont: { weight: 'bold', size: 14 },
            bodyFont: { size: 13 },
            callbacks: {
              label: function(context) {
                return context.parsed.y + ' pairs';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 1 },
            grid: { color: 'rgba(0,0,0,0.05)' }
          },
          x: { grid: { display: false } }
        },
        animation: { duration: 1200, easing: 'easeOutQuart' }
      }
    });
  }

  function formatNumber(numberStr) {
    const number = parseFloat(numberStr);
    return number.toLocaleString('id-ID');
  }

  // Event listener
  const filterSelect = document.getElementById('filterSelect');
  if (filterSelect) {
    filterSelect.addEventListener('change', () => {
      fetchDashboardData(filterSelect.value);
    });
  }

  // First load
  fetchDashboardData('week');
});
</script>
</body>
</html>

@endsection