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
<link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
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

#productDetailModal .modal-body {
  max-height: calc(100vh - 200px);
  overflow-y: auto;
  padding: 1rem; /* beri ruang supaya isi tidak mepet */
  border-bottom-left-radius: 12px;
  border-bottom-right-radius: 12px;
  background-color: white;
  box-sizing: border-box;
}

  #productDetailModal .modal-dialog {
   position: fixed;
  top: 120px;
  left: 50%;
  transform: translateX(-50%);
  max-width: 500px;
  width: 90vw;
  max-height: calc(100vh - 160px);
  margin: 0;
  overflow: hidden; /* supaya isi tidak keluar */
  z-index: 1055;
}

#productDetailContent tr.no-border td {
  border: none !important;
  background-color: transparent;
  font-weight: bold;
  font-size: 1.1em;
}

#productDetailModal .modal-content {
  border-radius: 0px;
  overflow: hidden; /* ini aman kalau modal-body diatur */
  background-color: white;
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
  <div class="dashboard-container px-3 px-sm-4 px-md-4">
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
      let bestSellerChartInstance;

      function fetchDashboardData(filter = 'week') {
        fetch(`/dashboard/filter?filter=${filter}`)
          .then(res => res.json())
          .then(data => {
            renderDashboard(data);
            renderSalesChart(data.data.labels, data.data.sales.map(Number));
            renderBestSellerChart(data.bestSellers);
          })
          .catch(err => console.error('Error fetching dashboard data:', err));
      }

      function renderDashboard(data) {
        const { balance, totalSold, stockAvailable, productStock } = data;

        dashboardContent.innerHTML = `
          <!-- Statistik -->
          <div class="row g-4 mb-5">
            <div class="col-md-4">
              <div class="card-stat">
                <div class="card-title">Total Revenue</div>
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

          <!-- Best Seller Bar Chart -->
          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <div class="section-title">Daily Sales Chart</div>
                <canvas id="salesChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Chart & Product Stock -->
          <div class="row g-4 my-5">
            <div class="col-md-8">
              <div class="card-box">
                <div class="section-title">Best Seller Chart</div>
                <canvas id="bestSellerChart"></canvas>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-box" style="max-height: 500px; display: flex; flex-direction: column;">
                <div class="section-title d-flex justify-content-between align-items-center" style="flex-shrink: 0;">
                  <span>Product Stock</span>

                  </div>
                  <div style="overflow-y: auto; flex-grow: 1;">
                    <table class="table-custom">
                      <tbody id="productList">
                        @foreach($productStock as $p)
                          <tr onclick="fetchProductDetail('{{ $p->id }}')" style="cursor:pointer;">
                            <td class="d-flex justify-content-between align-items-center">
                            <span>{{ $p->name }}</span>
                            <span class="text-end">{{ $p->total_stock }}</span>
                          </td>
                        </tr>   
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>

<!-- Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productDetailModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
      
          <tbody id="productDetailContent">
            <!-- Diisi oleh JavaScript -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
        `;
      }

      function renderSalesChart(labels, values) {
        const canvas = document.getElementById('salesChart');
        if (!canvas) return;
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
                callbacks: {
                  label: ctx => 'Rp ' + formatNumber(ctx.parsed.y)
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

      function renderBestSellerChart(bestSellers) {
        const canvas = document.getElementById('bestSellerChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        if (bestSellerChartInstance) bestSellerChartInstance.destroy();

        const labels = bestSellers.map(item => item.name);
        const data = bestSellers.map(item => item.total_sold);

        // Soft color palette
        const softColors = [
          '#A0C4FF', '#BDB2FF', '#FFC6FF',
          '#FFADAD', '#FDFFB6', '#CAFFBF',
          '#9BF6FF', '#FFD6A5', '#E2F0CB'
        ];
        const backgroundColors = labels.map((_, i) => softColors[i % softColors.length]);

        // Chart.js v3+ support for rounded bars
        Chart.defaults.elements.bar.borderRadius = 10;
        Chart.defaults.elements.bar.borderSkipped = false;

        bestSellerChartInstance = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Total Sold',
              data: data,
              backgroundColor: backgroundColors,
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: ctx => `${ctx.parsed.y} pairs`
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1,
                  color: '#333'
                },
                grid: { color: 'rgba(0,0,0,0.05)' }
              },
              x: {
                ticks: {
                  maxRotation: 45,
                  minRotation: 0,
                  autoSkip: true,
                  color: '#333'
                },
                grid: { display: false }
              }
            },
            animation: {
              duration: 1000,
              easing: 'easeOutQuart'
            }
          }
        });
      }

      function formatNumber(numberStr) {
        const number = parseFloat(numberStr);
        return number.toLocaleString('id-ID');
      }

      const filterSelect = document.getElementById('filterSelect');
      if (filterSelect) {
        filterSelect.addEventListener('change', () => {
          fetchDashboardData(filterSelect.value);
        });
      }

      fetchDashboardData('week');
    });

 function fetchProductDetail(productId) {
  fetch(`/product-detail/${productId}`)
    .then(response => response.json())
    .then(data => {
      // Set nama produk di modal title
      document.getElementById('productDetailModalLabel').textContent = `${data.productName}`;

      const variants = data.variants;

      // Group variants by color
      const groupedByColor = {};
      variants.forEach(variant => {
        const color = variant.color_name;
        if (!groupedByColor[color]) {
          groupedByColor[color] = [];
        }
        groupedByColor[color].push({
          size: variant.size,
          stock: variant.stock
        });
      });

      let content = '';
      for (const color in groupedByColor) {
        content += `
          <tr class="no-border" style="border-top: none">
            <td colspan="3"><strong>Color: ${color}</strong></td>
          </tr>
          <tr>
            <th>Size</th>
            <th>Stock</th>
          </tr>
        `;
        groupedByColor[color].forEach(item => {
          content += `
            <tr>
              <td>${item.size}</td>
              <td>${item.stock}</td>
            </tr>
          `;
        });
      }

      document.getElementById('productDetailContent').innerHTML = content;

      const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
      modal.show();
    })
    .catch(err => console.error('Gagal mengambil detail produk:', err));
}

  sortSelect.addEventListener('change', function () {
    const order = this.value;
    const rows = Array.from(tbody.querySelectorAll('tr'));

    const sortedRows = rows.sort((a, b) => {
      const aStock = parseInt(a.querySelector('td span:last-child').textContent.trim());
      const bStock = parseInt(b.querySelector('td span:last-child').textContent.trim());

      if (order === 'asc') {
        return aStock - bStock;
      } else if (order === 'desc') {
        return bStock - aStock;
      } else {
        return 0;
      }
    });

    // Bersihkan dan tambahkan kembali baris yang sudah diurutkan
    tbody.innerHTML = '';
    sortedRows.forEach(row => tbody.appendChild(row));
  });
  </script>
</div>
</body>
</html>

@endsection