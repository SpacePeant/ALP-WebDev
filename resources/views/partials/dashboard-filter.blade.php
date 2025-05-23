<!-- Statistik -->
<div class="row g-4 mb-5">
  <div class="col-md-4">
    <div class="card-stat">
      <div class="card-title">Balance</div>
      <div class="stat-value" id="stat-balance">Loading...</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat">
      <div class="card-title">Total Sold</div>
      <div class="stat-value" id="stat-total-sold">Loading...</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-stat">
      <div class="card-title">Stock Available</div>
      <div class="stat-value" id="stat-stock-available">Loading...</div>
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
      <div class="section-title" id="product-stock-title" style="flex-shrink: 0;">Product Stock</div>
      <div id="product-stock-list" style="overflow-y: auto; flex-grow: 1;">
        <!-- Akan diisi via JS -->
      </div>
    </div>
  </div>
</div>

<!-- Best Seller -->
<div class="row">
  <div class="col-12">
    <div class="card-box">
      <div class="section-title">Best Seller</div>
      <div class="row g-3" id="best-seller-list">
        <!-- Akan diisi via JS -->
      </div>
    </div>
  </div>
</div>