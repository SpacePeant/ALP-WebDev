<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
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





.loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255,255,255,0.8);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #555;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
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
<div id="loader" class="loader-overlay">
      <div class="loader"></div>
    </div>
  <form id="productForm" method="POST" action="{{ route('addproduct.store') }}" onsubmit="return prepareImageData()" enctype="multipart/form-data">
    @csrf

          {{-- Loader --}}
    <div id="loader" class="loader-overlay">
      <div class="loader"></div>
    </div>
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
      <button id="save-btn" class="save-btn" type="submit" name="save" id="save-btn">Save</button>
      {{-- <button type="button" class="btn btn-secondary mt-3" onclick="printColorImagesJSON()">Show JSON</button> --}}
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("productForm");
    const saveBtn = document.getElementById("save-btn");

    if (form && saveBtn) {
        form.addEventListener("submit", function (e) {
            e.preventDefault(); // Cegah submit default dulu

            // Panggil prepareImageData(), hanya lanjut jika true
            if (prepareImageData()) {
                document.getElementById("loader").style.display = "flex";
                form.submit(); // Submit secara manual jika lolos
            }
        });
    }
});
</script>

</body>
</html>

