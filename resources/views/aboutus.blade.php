@extends('base.base')

@section('title', 'About Us')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">

  <title>About Us</title>
  <style>
    body {
      margin: 0;
      font-family: 'Red Hat Text', sans-serif;
    }

    /* OUR STORY Section */
    .story-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 80px 10%;
      gap: 40px;
      flex-wrap: wrap;
      margin-left: 50px;
    }

    .story-text {
      flex: 1;
      min-width: 280px;
      display: flex;
      flex-direction: column;
      position: relative; 
      padding-left: 60px; 
    }
    .story-text h2 {
      font-weight: 700;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .story-text::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background: #000;
    }

    .story-text h2::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background: #000;
    }

    .story-text p {
      color: #777;
      font-size: 18px;
      line-height: 1.6;
      margin: 0;
    }

    .story-images {
      margin-left: 20px;
      flex: 1;
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .story-slice {
      width: 100px;
      height: 230px;
      background-image: url('image/image_carousel/ourstory.png') ; /* ganti dengan gambar kamu */
      background-size: cover;
      background-position: center;
    }

    .story-slice.left {
      border-top-left-radius: 30px;
      border-bottom-left-radius: 30px;
      background-position: left center;
    }

    .story-slice.center {
      background-position: center center;
    }

    .story-slice.right {
      border-top-right-radius: 30px;
      border-bottom-right-radius: 30px;
      background-position: right center;
    }


    /* OUR MISSION with background image */
    .mission-section {
      background: url('image/image_carousel/bg_mission.png') no-repeat center center;
      background-size: cover;
      padding: 230px 10%;
      padding-bottom: 100px;
      text-align: center;
      color: #000;
      position: relative;
    }

    .mission-content h2 {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 80px;
    }

        .mission-cards {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      padding: 0 10%;
    }

    .mission-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      padding: 40px 25px;
      width: 220px; /* Lebar card lebih pendek */
      height: 300px; /* Lebih panjang */
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center; /* Menyusun isi card ke tengah vertikal */
    }

.mission-card .icon {
  font-size: 32px;
  margin-bottom: 20px;
  color: #000;
}

.mission-card h3 {
  font-size: 18px;
  font-weight: 800;
  margin-bottom: 12px;
  color: #000;
  line-height: 1.4;
}

.mission-card p {
  font-size: 14px;
  color: #888;
  line-height: 1.5;
  max-width: 240px;
  margin: 0 auto; /* Menyusun paragraf ke tengah secara horizontal */
}

    /* OUR VISION with background image */
    .vision-section {
    background: url('image/image_carousel/bg_vision.png') no-repeat center center;
    background-size: 100% 408px;
    height: 408px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #000;
    margin-top: -110px;
    padding-bottom: -100px;
    }

    .vision-section h2 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    }

    .vision-section p {
    font-size: 16px;
    color: #444;
    max-width: 400px;
    margin: 0 auto;
    }

.stats-overlay {
  position: relative;
  top: -50px; /* posisi naik, adjust sesuai kebutuhan */
  z-index: 2;
}

.stats-overlay .row {
  margin-left: auto;
  margin-right: auto;
  max-width: 1140px; /* biar rata dengan konten lain */
}



    /* Responsive */
    @media (max-width: 768px) {
      .story-section {
        flex-direction: column;
        text-align: center;
      }

      .story-text h2::before {
        display: none;
      }

      .story-images {
        justify-content: center;
        flex-direction: column;
      }

      .mission-cards {
        flex-direction: column;
        align-items: center;
      }
    }

    /* quotes */

    .quote-section {
      background: url('image/quotes.png') no-repeat center center;
      background-size: cover;
      height: 500px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      text-align: center;
      color: white;
    }

    .quote-text {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 600;
      max-width: 800px;
      position: relative;
      padding: 0 20px;
    }

    .quote-text::before,
    .quote-text::after {
      font-size: 48px;
      color: white;
      position: absolute;
    }

    .quote-text::before {
      content: "“";
      left: -40px;
      top: -20px;
    }

    .quote-text::after {
      content: "”";
      right: -40px;
      bottom: -20px;
    }

    @media (max-width: 768px) {
      .quote-text {
        font-size: 24px;
      }

      .quote-text::before,
      .quote-text::after {
        font-size: 36px;
      }

      .quote-text::before {
        left: -20px;
      }

      .quote-text::after {
        right: -20px;
      }

        .story-section {
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        margin-left: 0;
      }

      .story-text {
        padding-left: 0;
        text-align: center;
      }

      .story-text::before {
        display: none;
      }

      .story-images {
        flex-direction: row;
        flex-wrap: nowrap;
        gap: 5px;
        overflow-x: auto;
      }

      .story-slice {
        flex: 0 0 auto;
        width: 90px;
        height: 200px;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 15px !important;
      }
        .vision-section {
          background-size: cover !important;
          background-position: center center !important;
          height: auto;
          padding: 100px 20px;
      }
    }

  </style>
</head>
<body>

  <!-- Our Story section -->
  <section class="story-section">
  <div class="story-text">
    <h2>OUR STORY</h2>
    <p>
      Brrrr is a store dedicated to offering innovative athletic footwear exclusively from Nike, inspiring both performance and style.
    </p>
  </div>
  <div class="story-images">
    <div class="story-slice left"></div>
    <div class="story-slice center"></div>
    <div class="story-slice right"></div>
  </div>
</section>


  <!-- Our Mission Section -->
  <section class="mission-section">
    <div class="mission-content">
      <h2>OUR MISSION</h2>
      <div class="mission-cards">
        <div class="mission-card">
        <div class="icon"><i class="bi bi-geo-alt"></i></div>
          <h3>Empower <br>Every Step</h3>
          <p>Deliver shoes that <br> boost confidence</p>
        </div>
        <div class="mission-card">
        <div class="icon"><i class="bi bi-bar-chart-fill"></i></div>
          <h3>Innovate <br>With Style</h3>
          <p>Blend performance, comfort, and bold design</p>
        </div>
        <div class="mission-card">
        <div class="icon"><i class="bi bi-send"></i></div>
          <h3>Support <br>Planet</h3>
          <p>Promote inclusivity and eco-friendly practices</p>
        </div>
      </div>
    </div>
  </section>

  <div class="stats-overlay container-fluid px-3">
  <div class="row bg-black text-white text-center py-4">
    <div class="col-6 col-md-3 mb-3 mb-md-0">
      <h3 class="fw-bold mb-0">60+</h3>
      <p class="mb-0">Years Exp.</p>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
      <h3 class="fw-bold mb-0">100K+</h3>
      <p class="mb-0">Happy Clients</p>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
      <h3 class="fw-bold mb-0">200+</h3>
      <p class="mb-0">Achievements</p>
    </div>
    <div class="col-6 col-md-3">
      <h3 class="fw-bold mb-0">79K+</h3>
      <p class="mb-0">Professionals</p>
    </div>
  </div>
</div>


  <!-- Our Vision Section -->
  <section class="vision-section">
    <h2>OUR VISION</h2>
    <p>
      To inspire movement and confidence in every step, through bold design and accessible innovation for all
    </p>
  </section>

  <!-- quotes -->
  <section class="quote-section">
    <div class="quote-text">
      <i>From casual strolls to bold steps,<br>we've got you covered</i>
    </div>
  </section>

</body>
</html>
@endsection








































































{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      align-items: flex-start;
    }

  .form-container, .image-container {
    background: #ffffff;
    border: 1px solid #E1E1E1;
    border-radius: 10px;
    padding: 40px;
    width: 500px;
  }

    .form-container {
        background: #ffffff;
  border: 1px solid #E1E1E1;
  border-radius: 10px;
  padding: 30px;
  flex: 1 1 500px;
  max-width: 600px;
    }

    .image-container {
      background: #ffffff;
  border: 1px solid #E1E1E1;
  width: 100%;
  box-sizing: border-box;
  border-radius: 10px;
  padding: 30px;
  flex: 1 1 500px;
  max-width: 600px;
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

     /* .size-options {
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
    } */

     .gender-options {
    display: flex;
    flex-direction: row;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap; 
  }

  .gender-options label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    white-space: nowrap;
  }
    .price-stock {
      display: flex;
      gap: 20px;
    }

    .price-stock input {
      width: 125px;
    }

    .main-image {
       display: block;
  width: 100%;
  max-width: 100%;
  height: auto;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 10px;
    }

    .thumbnails {
      display: flex;
  justify-content: space-between;
  gap: 0;
  margin-bottom: 15px;
    }

    .thumbnails img {
      width: calc(100% / 4);
  height: auto;
  object-fit: cover;
  border: 2px solid transparent;
  border-radius: 10px;
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

    .btn-black { 
    background-color: black !important; 
    color: white !important; 
    border-radius: 0; 
    border: none; 
    margin-bottom: 10px;
  }
  .btn-black:hover { 
    background-color: black !important; 
    color: white !important; 
  }

    @media (max-width: 1200px) {
  .main-container {
    flex-direction: column;
    gap: 20px;
  }

  .form-container,
  .image-container {
    width: 100%;
    max-width: 100%;
  }

  .price-stock {
    flex-direction: column;
  }

  .price-stock input {
    width: 100%;
  }

  .thumbnails img {
    width: 22%;
  }

  .save-btn {
    width: 100%;
    float: none;
  }

  .btn.mt-3 {
    width: 100%;
  }
}

    /* Responsive adjustments for tablet and phone */
@media (max-width: 768px) {
   /* .size-options {
    grid-template-columns: repeat(2, 1fr);
  } */

  .main-container {
    flex-direction: column;
    /* padding: 10px; */
  }

  .form-container {
    width: 100% !important;
    /* margin-bottom: 20px; */
  }

  .form-group {
    width: 100%;
  }

  .form-group input[type="text"],
  .form-group input[type="number"],
  .form-group input[type="color"],
  .form-group .form-control {
    width: 100%;
  }

  .save-btn {
    width: 100%;
  }

  .image-container img.main-image {
    width: 100%;
    height: auto;
  }

  .thumbnails img {
    width: 22%;
    height: auto;
  }

  .btn.mt-3 {
    width: 100%;
  }
}

@media (max-width: 576px) {
  /* .size-options {
    grid-template-columns: repeat(2, 1fr);
  } */

  .nav-tabs {
    flex-wrap: wrap;
  }

  .nav-link {
    width: 100%;
    margin-bottom: 5px;
  }

  .image-container img.main-image {
    width: 100%;
    height: auto;
  }

  .thumbnails img {
    width: 20%;
    height: auto;
  }

  .btn.mt-3 {
    width: 100%;
  }
}
.back-to-collection {
    position: fixed;
    top: 50px;
    right: 20px;
    background: #fff;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
}
.back-to-collection:hover {
    background: #f0f0f0;
}
  </style>
</head>
<body>
    <?php if (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <a href="{{ route('productadmin') }}" class="back-to-collection" title="Back to cart">
      <i data-feather="corner-down-left"></i>
    </a>
  <h1>Add Product</h1>

  <form method="POST" action="{{ route('addproduct.store') }}" onsubmit="return prepareImageData()" enctype="multipart/form-data">
    @csrf
  <div class="main-container d-flex gap-4 flex-wrap">
    <div class="form-container">
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        
            <select class="form-select custom-select" name="category" required>
        <option value="">Select Category</option>
        <?php foreach ($category as $category): ?>
          <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
        <?php endforeach; ?>
      </select>
      </div>

      <!-- Other form fields -->
      <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Gender</label>
        <div class="gender-options">
            <label><input type="radio" name="gender" value="Men" checked> Men</label>
      <label><input type="radio" name="gender" value="Women"> Women</label>
      <label><input type="radio" name="gender" value="Unisex"> Unisex</label>
        </div>
      </div>

      <div class="form-group">
        <div>
          <label>Price</label>
          <input type="number" name="price" required>
        </div>
      </div>
      <input type="hidden" name="image_json" id="imageJson">
      <button class="save-btn" type="submit" name="save">Save</button>
      <button type="button" class="btn btn-secondary mt-3" onclick="printColorImagesJSON()">Show JSON</button>
    </form>
    </div>

<div class="form-container">
  <label style="display:block; margin-bottom:10px; font-weight:500;">Upload Images per Color</label>

  <!-- Tab Navigation -->
  <ul class="nav nav-tabs" id="colorTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="color-tab-0" data-bs-toggle="tab" data-bs-target="#color-content-0" type="button" role="tab">Color 1</button>
    </li>
  </ul>

  <!-- Tab Contents -->
  <div class="tab-content mt-3" id="colorTabContent">
    <div class="tab-pane fade show active" id="color-content-0" role="tabpanel">
      <div class="image-container">
        <label style="display:block; margin-bottom:10px; font-weight:500;">Upload New Image</label>

        <select id="position-0" class="form-select custom-select" style="margin-bottom:10px;" onchange="enableFileInput(0)">
          <option value="">Select Position</option>
          <option value="atas">Top</option>
          <option value="bawah">Bottom</option>
          <option value="kiri">Left</option>
          <option value="kanan">Right</option>
        </select>

        <input type="file" id="imageInput-0" accept="image/*" disabled style="margin-bottom:10px;" onchange="previewAndStoreImage(0)"><br>

        <img src="{{ asset('image/no_image.png')}}" class="main-image" id="mainImage-0">

        <div class="thumbnails" style="margin-top:10px;">
          <img src="{{ asset('image/no_image.png')}}" id="thumb-0-atas" data-pos="atas"  class="active" onclick="showMainImage(0, 'atas')">
          <img src="{{ asset('image/no_image.png')}}" id="thumb-0-bawah" data-pos="bawah"  onclick="showMainImage(0, 'bawah')">
          <img src="{{ asset('image/no_image.png')}}" id="thumb-0-kiri" data-pos="kiri"  onclick="showMainImage(0, 'kiri')">
          <img src="{{ asset('image/no_image.png')}}" id="thumb-0-kanan" data-pos="kanan"  onclick="showMainImage(0, 'kanan')">
        </div>

        <div class="form-group price-stock mt-4" id="color-content-0">
          <div style="margin-bottom: 10px;">
            <label>Color Name</label>
            <input type="text" name="color_name[]" class="form-control" oninput="updateColorInfo(0)">
          </div>
          <div style="margin-bottom: 10px;">
            <label>Color Code (Hex)</label>
            <input type="text" name="color_code[]" id="hexColor-0" class="form-control" oninput="updateColorInfo(0)">
          </div>
          <div>
            <label>Color Picker</label>
            <input type="color" id="colorPicker-0" value="#ff0000" class="form-control form-control-color" onchange="syncPicker(0)">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Button to Add Tab -->
  <button class="btn mt-3" type="button" onclick="addNewTab()">+ Add Color Tab</button>

</div>
  </div>
<script>
const placeholderImage = "{{ asset('image/no_image.png') }}";

let colorImages = [
  {
    colorIndex: 0,
    color_name: "Red",
    color_code: "#ff0000",
      atas: placeholderImage,
      bawah: placeholderImage,
      kiri: placeholderImage,
      kanan: placeholderImage
  }
];

let tabCount = 1;

function enableFileInput(index) {
  const positionSelect = document.getElementById(`position-${index}`);
  const fileInput = document.getElementById(`imageInput-${index}`);
  fileInput.disabled = (positionSelect.value === '');
}

function previewAndStoreImage(index) {
  const fileInput = document.getElementById(`imageInput-${index}`);
  const position = document.getElementById(`position-${index}`).value;
  const file = fileInput.files[0];
  if (!position || !file) return;

  if (!file.type.startsWith("image/")) {
    alert("File harus berupa gambar (jpeg, png, webp, dll).");
    return;
  }

  const maxSize = 2 * 1024 * 1024; // 2MB
  if (file.size > maxSize) {
    alert("Ukuran gambar maksimal 2MB.");
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    if (!colorImages[index]) {
      colorImages[index] = { colorIndex: index, images: {} };
    }

    // Simpan base64 dan nama file asli ke struktur JSON
    colorImages[index][position] = e.target.result;
    colorImages[index][`${position}_filename`] = file.name;

    // Update thumbnail
    const thumb = document.getElementById(`thumb-${index}-${position}`);
    if (thumb) {
      thumb.src = e.target.result;
    }

    // Update main image jika sesuai
    const mainImage = document.getElementById(`mainImage-${index}`);
    const activeThumb = document.querySelector(`#color-content-${index} .thumbnails img.active`);
    if (activeThumb && activeThumb.dataset.pos === position) {
      mainImage.src = e.target.result;
    }
  };
  reader.readAsDataURL(file);
}


function showMainImage(colorIndex, position) {
  const mainImage = document.getElementById(`mainImage-${colorIndex}`);
  
  // Ambil gambar base64 langsung dari colorImages[colorIndex][position]
  const imgSrc = colorImages[colorIndex]?.[position] || placeholderImage;
  mainImage.src = imgSrc;

  // Update border active thumbnail
  const thumbnails = document.querySelectorAll(`#color-content-${colorIndex} .thumbnails img`);
  thumbnails.forEach(thumb => {
    if (thumb.dataset.pos === position) {
      thumb.classList.add('active');
      thumb.style.border = "2px solid #333";
    } else {
      thumb.classList.remove('active');
      thumb.style.border = "2px solid transparent";
    }
  });
}


function updateColorInfo(index) {
  const wrapper = document.getElementById(`color-content-${index}`);
  const nameInput = wrapper.querySelector('input[name="color_name[]"]');
  const codeInput = document.getElementById(`hexColor-${index}`);

  if (!colorImages[index]) return;

  colorImages[index].color_name = nameInput?.value || '';
  colorImages[index].color_code = codeInput?.value || '';
  
  // Sinkronkan juga ke color picker
  const picker = document.getElementById(`colorPicker-${index}`);
  if (picker && codeInput) picker.value = codeInput.value;
}

function syncPicker(index) {
  const picker = document.getElementById(`colorPicker-${index}`);
  const hexInput = document.getElementById(`hexColor-${index}`);

  if (picker && hexInput) {
    hexInput.value = picker.value;
    updateColorInfo(index);
  }
}


function addNewTab() {
  const newIndex = tabCount;

  // Tambah tab navigation
  const newTab = document.createElement('li');
  newTab.className = 'nav-item';
  newTab.role = 'presentation';
  newTab.innerHTML = `
    <button class="nav-link" id="color-tab-${newIndex}" data-bs-toggle="tab" data-bs-target="#color-content-${newIndex}" type="button" role="tab">
      Color ${newIndex + 1}
    </button>
  `;
  document.getElementById('colorTabs').appendChild(newTab);

  // Tambah tab content
  const newContent = document.createElement('div');
  newContent.className = 'tab-pane fade';
  newContent.id = `color-content-${newIndex}`;
  newContent.role = 'tabpanel';
  newContent.innerHTML = `
  <div class="image-container">
    <label style="display:block; margin-bottom:10px; font-weight:500;">Upload New Image</label>
    <select id="position-${newIndex}" class="form-select custom-select" style="margin-bottom:10px;" onchange="enableFileInput(${newIndex})">
      <option value="">Select Position</option>
      <option value="atas">Top</option>
      <option value="bawah">Bottom</option>
      <option value="kiri">Left</option>
      <option value="kanan">Right</option>
    </select>

    <input type="file" id="imageInput-${newIndex}" accept="image/*" disabled style="margin-bottom:10px;" onchange="previewAndStoreImage(${newIndex})"><br>

    <img src="${placeholderImage}" class="main-image" id="mainImage-${newIndex}">

    <div class="thumbnails" style="margin-top:10px;">
      <img src="${placeholderImage}" id="thumb-${newIndex}-atas" data-pos="atas" class="active" onclick="showMainImage(${newIndex}, 'atas')">
      <img src="${placeholderImage}" id="thumb-${newIndex}-bawah" data-pos="bawah" onclick="showMainImage(${newIndex}, 'bawah')">
      <img src="${placeholderImage}" id="thumb-${newIndex}-kiri" data-pos="kiri" onclick="showMainImage(${newIndex}, 'kiri')">
      <img src="${placeholderImage}" id="thumb-${newIndex}-kanan" data-pos="kanan" onclick="showMainImage(${newIndex}, 'kanan')">
    </div>

    <div class="form-group price-stock mt-4" id="color-form-${newIndex}">
      <div style="margin-bottom: 10px;">
        <label>Color Name</label>
        <input type="text" name="color_name[]" class="form-control" oninput="updateColorInfo(${newIndex})">
      </div>
      <div style="margin-bottom: 10px;">
        <label>Color Code (Hex)</label>
        <input type="text" name="color_code[]" id="hexColor-${newIndex}" class="form-control" oninput="updateColorInfo(${newIndex})">
      </div>
      <div>
        <label>Color Picker</label>
        <input type="color" id="colorPicker-${newIndex}" value="#ff0000" class="form-control form-control-color" onchange="syncPicker(${newIndex})">
      </div>
    </div>
  </div>
`;
  document.getElementById('colorTabContent').appendChild(newContent);

  // Update colorImages array
  colorImages[newIndex] = {
    colorIndex: newIndex,
    color_name: "Red",
    color_code: "#ff0000",
      atas: placeholderImage,
      bawah: placeholderImage,
      kiri: placeholderImage,
      kanan: placeholderImage

  };

  // Aktifkan tab baru
  const newTabBtn = document.getElementById(`color-tab-${newIndex}`);
  newTabBtn.addEventListener('shown.bs.tab', function () {
    // Show main image posisi atas default saat tab aktif
    showMainImage(newIndex, 'atas');
  });

  // Aktifkan tab baru secara manual
  const tabTrigger = new bootstrap.Tab(newTabBtn);
  tabTrigger.show();

  tabCount++;
}

function printColorImagesJSON() {
  console.log(JSON.stringify(colorImages, null, 2));
}
// function updateColorInfo(index) {
//   const nameInput = document.querySelector(`#color-content-${index} input[name="color[]"]`);
//   const codeInput = document.getElementById(`hexColor-${index}`);
//   if (!colorImages[index]) return;

//   colorImages[index].color_name = nameInput ? nameInput.value : '';
//   colorImages[index].color_code = codeInput ? codeInput.value : '';
// }
</script>
<script>
function prepareImageData() {
  const defaultImage = "http://alp-webdev-5.test/image/no_image.png";

  for (let i = 0; i < colorImages.length; i++) {
    const color = colorImages[i];
    const positions = ['atas', 'bawah', 'kiri', 'kanan'];

    for (let pos of positions) {
      if (color[pos] === defaultImage) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          html: `Gambar posisi <b>${pos}</b> untuk warna <b>${color.color_name || 'Tanpa Nama'}</b> belum diganti.`,
          confirmButtonColor: '#d33'
        });
        return false; // ← batalkan submit
      }
    }
  }

  // Jika semua valid, lanjut submit
  document.getElementById("imageJson").value = JSON.stringify(colorImages);
  return true;
}


function printColorImagesJSON() {
  console.log(JSON.stringify(colorImages, null, 2));
  alert("JSON data sudah dicetak ke console.");
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
</script>

</body>
</html>
 --}}
