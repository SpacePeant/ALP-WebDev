@php
    $user_id = $user_id ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Red Hat Display', sans-serif;
      margin: 0;
      padding: 40px;
      background: #fff;
      color: #000;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      text-align: center;
      margin-top: 40px;
      margin-bottom: 50px;
    }

    .main-container {
      display: flex;
      gap: 40px;
      justify-content: center;
    }

    .form-container, .image-container {
      background: #ffffff;
      border: 1px solid #E1E1E1;
      border-radius: 10px;
      padding: 40px;
    }

    .form-container {
      width: 600px;
    }

    .image-container {
      width: 600px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-size: 14px;
      font-weight: 500;
      display: block;
      margin-bottom: 8px;
    }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 12px;
      font-size: 14px;
    }

    .size-options {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .size-btn {
      border: 1px solid #000;
      padding: 8px 14px;
      cursor: pointer;
      font-size: 14px;
    }

    .size-btn.active {
      background: #000;
      color: #fff;
    }

    .gender-options {
      display: flex;
      gap: 20px;
      margin-top: 10px;
    }

    .gender-options label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: normal;
    }

    .price-stock {
      display: flex;
      gap: 20px;
    }

    .price-stock input {
      width: 100%;
    }

    .main-image {
      width: 100%;
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .thumbnails {
      display: flex;
      gap: 10px;
    }

    .thumbnails img {
      width: 120px;
      border-radius: 10px;
      border: 1px solid #E1E1E1;
      cursor: pointer;
    }

    .thumbnails img.active {
      border-color: black;
      border: 2px solid;
    }

    .save-btn {
      margin-top: 30px;
      float: right;
      padding: 8px 20px;
      background: black;
      border: none;
      color: white;
    }

    .custom-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20width='16'%20height='16'%20fill='black'%20class='bi%20bi-caret-down-fill'%20viewBox='0%200%2016%2016'%3E%3Cpath%20d='M7.247%2011.14%203.451%206.658C2.885%206.013%203.345%205%204.204%205h7.592c.86%200%201.319%201.013.753%201.658l-3.796%204.482a1%201%200%200%201-1.506%200z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 32px;
    }

  </style>
</head>
<body>

  <h1>Edit Product</h1>

  <div class="main-container">
  <div class="form-container">
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="ukuran" id="selectedSize" value="{{ $product->size }}">

      <div class="form-group">
        <label>Name</label>
        <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->name) }}">
      </div>

        <div class="form-group">
        <label>Category</label>
        <select name="kategori" class="form-select custom-select">
            <option value="1" @selected($product->category_id == 1)>Running</option>
            <option value="2" @selected($product->category_id == 2)>Casual</option>
            <option value="3" @selected($product->category_id == 3)>Basketball</option>
            <option value="4" @selected($product->category_id == 4)>Training</option>
            <option value="5" @selected($product->category_id == 5)>Soccer</option>
            <option value="6" @selected($product->category_id == 6)>Sandals</option>
        </select>
        </div>

      <div class="form-group">
        <label>Description</label>
        <input type="text" name="deskripsi" value="{{ old('deskripsi', $product->description) }}">
      </div>

    <div class="form-group">
        <label>Size</label>
        <div class="size-options">
            @php
                $selectedSize = old('ukuran', $product->size ?? null);
            @endphp

            @for ($i = 36; $i <= 45; $i++)
                @php
                    $active = ($selectedSize == $i) ? 'active' : '';
                @endphp
                <div class="size-btn {{ $active }}" onclick="document.getElementById('selectedSize').value = '{{ $i }}'">EU {{ $i }}</div>
            @endfor
        </div>
    </div>

    <input type="hidden" name="ukuran" id="selectedSize" value="{{ $selectedSize }}">

    <div class="form-group">
        <label>Gender</label>
        <div class="gender-options">
            <label>
                <input type="radio" name="gender" value="Men" {{ old('gender', $product->gender) == 'Men' ? 'checked' : '' }}> Men
            </label>
            <label>
                <input type="radio" name="gender" value="Women" {{ old('gender', $product->gender) == 'Women' ? 'checked' : '' }}> Women
            </label>
            <label>
                <input type="radio" name="gender" value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'checked' : '' }}> Unisex
            </label>
        </div>
    </div>

    <div class="form-group price-stock">
        <div>
            <label>Price</label>
            <input type="text" name="harga" value="{{ old('harga', $product->price) }}">
        </div>
        <div>
            <label>Stock</label>
            <input type="number" name="stok" value="{{ old('stok', $product->stock) }}">
        </div>
    </div>


      <!-- Tambahkan input upload image jika ingin edit -->
      <!-- <input type="file" name="image"> -->

      <button type="submit" class="save-btn">Save</button>
    </form>
  </div>
  <div class="image-container">
  <form action="update_image.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="color_id" value="{{ $color_id }}">

<!-- Optional: Kirim product_id juga jika perlu -->
<input type="hidden" name="product_id" value="{{ old('product_id', $id) }}">
    <label style="display:block; margin-bottom:10px; font-weight:500;">Upload New Image</label>

    <!-- Input Jenis Gambar -->
    <select name="position" required style="margin-bottom:10px;">
      <option value="">-- Pilih Posisi Gambar --</option>
      <option value="atas">Atas</option>
      <option value="kiri">Kiri</option>
      <option value="kanan">Kanan</option>
      <option value="bawah">Bawah</option>
    </select>

    <!-- Input File -->
    <input type="file" name="image" accept="image/*" required style="margin-bottom:10px;"><br>

    <!-- Tombol Submit -->
    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
  </form>

  <!-- Preview Utama -->
<img src="{{ asset('image/sepatu/atas/' . $product->image_atas) }}" class="main-image" id="mainImage" style="margin-top:20px;">

<div class="thumbnails">
  <img src="{{ asset('image/sepatu/atas/' . $product->image_atas) }}" class="active" onclick="setMainImage(this)">
  <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" onclick="setMainImage(this)">
  <img src="{{ asset('image/sepatu/kanan/' . $product->image_kanan) }}" onclick="setMainImage(this)">
  <img src="{{ asset('image/sepatu/bawah/' . $product->image_bawah) }}" onclick="setMainImage(this)">
</div>
  </div>
</div>
</div>

<a href="{{ route('productadmin') }}" class="btn btn-outline-secondary position-absolute top-0 end-0 m-3 p-2">
  <i class="bi bi-arrow-left"></i>
</a>

<form action="{{ route('product.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- input fields -->
</form>


  <script>
    // Handle size button active state
    document.querySelectorAll('.size-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
      });
    });

    // Handle image preview
    function setMainImage(thumbnail) {
      document.getElementById('mainImage').src = thumbnail.src;
      document.querySelectorAll('.thumbnails img').forEach(img => img.classList.remove('active'));
      thumbnail.classList.add('active');
    }

    document.querySelectorAll('.size-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('selectedSize').value = btn.innerText.replace('EU ', '');
  });
});

const sizeStockMap = <?= json_encode($sizeStock); ?>;

document.querySelectorAll('.size-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    // update tombol aktif
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // update hidden input
    const size = btn.innerText.replace('EU ', '');
    document.getElementById('selectedSize').value = size;

    // update stok sesuai ukuran
    const stockInput = document.querySelector('input[name="stok"]');
    if (sizeStockMap[size]) {
      stockInput.value = sizeStockMap[size];
    } else {
      stockInput.value = 0;
    }
  });
});
  </script>

</body>
</html>