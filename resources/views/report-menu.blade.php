@extends('base.baseadmin')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">
<!-- Versi CDN Font Awesome 6 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
        font-family: 'Red Hat Display', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        /* padding: 40px 20px; */
        color: #212529;
        margin-bottom: 50px;
        }
        .container{
            margin-top : 100px;
        }

        .dashboard-container {
      max-width: 1200px;
      margin: auto;
      margin-top : 100px;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      margin-bottom: 40px;
      margin-top:120px;
      text-align: center;
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

#hi{
    margin-top : 3px;
}


    </style>
</head>
<body>

<div class="dashboard-container px-3 px-sm-4 px-md-0">

    <h1>Sales Report</h1>
  <!-- Filter: Year and Month -->
  <div class="row mb-3" id="taun">
    <p class="col-auto" id="hi">Year:</p>
    <div class="col-auto">
      <select id="yearSelect" class="form-select" onchange="handleFilterChange()">
        <!-- Diisi dengan JavaScript -->
      </select>
    </div>
    <p class="col-auto" id="hi">Month:</p>
    <div class="col-auto">
      <select id="monthSelect" class="form-select" onchange="handleFilterChange()">
        <option value="">All Months</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
    </div>

    <!-- Tombol PDF -->
    <div class="col-auto d-flex align-items-end gap-2" style="margin-bottom:10px;">
            <a id="pdf-button"
                  href="#"
                  class="btn btn-danger d-none"
                  target="_blank">
                    <i class="fa fa-file-pdf"></i> Download PDF
            </a>
        </div>
  </div>

  <div id="dashboardContent"></div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const currentYear = new Date().getFullYear();
    const yearSelect = document.getElementById('yearSelect');
    for (let y = currentYear; y >= 2020; y--) {
      const opt = document.createElement('option');
      opt.value = y;
      opt.textContent = y;
      yearSelect.appendChild(opt);
    }

    yearSelect.value = currentYear; // default year
    document.getElementById('monthSelect').value = ''; // default month = All

    // Trigger fetch when year/month changed
    function handleFilterChange() {
      const year = document.getElementById('yearSelect').value;
      const month = document.getElementById('monthSelect').value;
      fetchDashboardData(year, month);
    }

    let salesChart;
let bestSellerChartInstance; // Tambahkan ini

    function fetchDashboardData(year, month = '') {
  let url = `/reportt?year=${year}`;
  if (month) url += `&month=${month}`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      console.log('Fetched data:', data);
      renderDashboard(data);
      renderSalesChart(data.data.labels, data.data.sales.map(Number));
      renderBestSellerChart(data.bestSellers);
    })
    .catch(err => console.error('Error fetching dashboard data:', err));
}

    function renderDashboard(data) {
      const { balance, totalSold, stockAvailable, productStock, bestSellers } = data;

      const bestSellerHTML = bestSellers.map(item => `
        <li>${item.name} - ${item.total_sold} pcs</li>
      `).join('');

      const productStockHTML = productStock.map(p => `
        <li>${p.name} - ${p.total_stock} in stock</li>
      `).join('');

      dashboardContent.innerHTML = `
        <div class="row g-4 mb-5">
          <div class="col-md-6">
            <div class="card-stat">
              <div class="card-title">Balance</div>
              <div class="stat-value">Rp. ${formatNumber(balance)}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card-stat">
              <div class="card-title">Total Sold</div>
              <div class="stat-value">${totalSold} pcs</div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-5">
            <div class="card-box">
              <div class="section-title">Sales Chart</div>
              <canvas id="salesChart"></canvas>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card-box">
              <div class="section-title">Best Sellers</div>
              <canvas id="bestSellerChart"></canvas>
            </div>
          </div>
        </div>
      `;
    }

    function renderSalesChart(labels, values) {
      const canvas = document.getElementById('salesChart');
      const ctx = canvas.getContext('2d');

      const gradient = ctx.createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, 'rgba(13,110,253,0.4)');
      gradient.addColorStop(1, 'rgba(13,110,253,0)');

      if (salesChart) salesChart.destroy();

      salesChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [{
            label: 'Sales (Rp)',
            data: values,
            fill: true,
            backgroundColor: gradient,
            borderColor: '#0d6efd',
            tension: 0.4,
            pointRadius: 4
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: ctx => 'Rp ' + formatNumber(ctx.parsed.y)
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1 }
            },
            x: { grid: { display: false } }
          }
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

    function formatNumber(num) {
      return new Intl.NumberFormat('id-ID').format(num);
    }

    // Initial load
    fetchDashboardData(currentYear);
  </script>
</div>

<script>
// Isi opsi tahun secara dinamis (misal 2020 sampai tahun ini)
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');
    const pdfButton = document.getElementById('pdf-button');

    // Generate tahun dari 2020 sampai tahun sekarang

    function updatePDFButton() {
        const year = yearSelect.value;
        const month = monthSelect.value;

        // Cek minimal tahun harus dipilih
        if (year) {
            pdfButton.classList.remove('d-none');

            // URL PDF: tambahkan parameter month kalau dipilih
            let url = `/report/sales/pdf?year=${year}`;
            if (month) {
                url += `&month=${month}`;
            }
            pdfButton.href = url;
        } else {
            pdfButton.classList.add('d-none');
            pdfButton.href = "#";
        }
    }

    // Panggil sekali saat load agar tombol sesuai kondisi awal
    updatePDFButton();

    // Pasang event listener untuk kedua select
    yearSelect.addEventListener('change', updatePDFButton);
    monthSelect.addEventListener('change', updatePDFButton);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
@endsection