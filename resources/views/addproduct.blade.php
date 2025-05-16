<?php
// // Koneksi ke database
// $conn = new mysqli(
//     'mysql-182f6de3-bernardofkowe-263b.k.aivencloud.com',
//     'avnadmin',
//     'AVNS_c98rz9H_eLwhrcG3ekc',
//     'defaultdb',
//     11040
// );

// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

// // Ambil data kategori dari database
// $sql = "SELECT id, name FROM category";
// $result = $conn->query($sql);

// // Cek apakah ada kategori
// $categories = [];
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $categories[] = $row;
//     }
// } else {
//     echo "Tidak ada kategori.";
// }

   

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
//     $name = $_POST['name'];
//     $category_id = $_POST['category'];
//     $description = $_POST['description'];
//     $price = $_POST['price'];
//     $color_name = $_POST['color'];
//     $color_code = $_POST['color_code'];
//     $sizes = $_POST['size'] ?? [];
//     $gender = $_POST['gender'] ?? 'Unisex';

//     // Insert ke tabel product
//     $stmt = $conn->prepare("INSERT INTO product (name, gender, description, price, status, category_id) VALUES (?, ?, ?, ?, 1, ?)");
//     $stmt->bind_param("sssdi", $name, $gender, $description, $price, $category_id);
//     $stmt->execute();
//     $product_id = $stmt->insert_id;
//     $stmt->close();

//     // Insert ke product_color
//     $stmt = $conn->prepare("INSERT INTO product_color (product_id, color_name, color_code, is_primary) VALUES (?, ?, ?, 0)");
//     $stmt->bind_param("iss", $product_id, $color_name, $color_code);
//     $stmt->execute();
//     $color_id = $stmt->insert_id;
//     $stmt->close();

//     // Insert ke product_variant
//     $stmt = $conn->prepare("INSERT INTO product_variant (product_id, color_id, size, stock) VALUES (?, ?, ?, 0)");
//     foreach ($sizes as $size) {
//         $stmt->bind_param("iii", $product_id, $color_id, $size);
//         $stmt->execute();
//     }
//     $stmt->close();

//     $success = "Product saved successfully!";
// }

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
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
    width: 500px;
  }

    .form-container {
      width: 600px;
    }

    .image-container {
      width: 520px;
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
      width: 125px;
    }

    .main-image {
      width: 100%;
      max-height: 300px;
      object-fit: contain;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .thumbnails {
      display: flex;
      gap: 10px;
    }

    .thumbnails img {
      width: 102px;
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

    .size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    }

    .size-options label {
    font-size: 14px;
    cursor: pointer;
    margin-right: 15px;
    }

    .size-options input[type="checkbox"] {
    margin-right: 5px;
    }
  </style>
</head>
<body>
    <?php if (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

  <h1>Add Product</h1>

  <form method="POST" action="{{ route('addproduct.store') }}">
    @csrf
  <div class="main-container">
    <div class="form-container">
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        {{-- <pre>{{ print_r($categories, true) }}</pre> --}}
       <select class="form-select custom-select" name="category" required>
  <option value="">Select Category</option>
  <?php foreach ($categories as $category): ?>
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
    <label>Size</label>
    <div class="size-options">
        <label>
        <input type="checkbox" name="size[]" value="36"> EU 36
        </label>
        <label>
        <input type="checkbox" name="size[]" value="37">EU 37
        </label>
        <label>
        <input type="checkbox" name="size[]" value="38">EU 38
        </label>
        <label>
        <input type="checkbox" name="size[]" value="39">EU 39
        </label>
        <label>
        <input type="checkbox" name="size[]" value="40">EU 40
        </label>
        <label>
        <input type="checkbox" name="size[]" value="41">EU 41
        </label>
        <label>
        <input type="checkbox" name="size[]" value="42">EU 42
        </label>
        <label>
        <input type="checkbox" name="size[]" value="43">EU 43
        </label>
        <label>
        <input type="checkbox" name="size[]" value="44">EU 44
        </label>
        <label>
        <input type="checkbox" name="size[]" value="45">EU 45
        </label>
    </div>
    </div>


      <div class="form-group">
        <label>Gender</label>
        <div class="gender-options">
            <input type="radio" name="gender" value="Men" checked> Men
            <input type="radio" name="gender" value="Women"> Women
            <input type="radio" name="gender" value="Unisex"> Unisex
        </div>
      </div>

      <div class="form-group">
        <div>
          <label>Price</label>
          <input type="number" name="price" required>
        </div>
      </div>

      <!-- <div class="form-group price-stock">
        <div>
          <label>Color</label>
          <input type="text" name="color" required>
        </div>
        <div>
            <label>Selected Color (Hex)</label>
        <input type="text" name="color_code" id="hexColor" value="#ff0000" required>
        </div>
        <div>
            <label>Color Code (Hex)</label>
            <input type="color" id="colorPicker" value="#ff0000">
        </div>
      </div> -->
    <button class="save-btn" type="submit" name="save">Save</button>
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
        <img src="{{ asset('image/no_image.png')}}" class="main-image" id="mainImage-0">
        <div class="thumbnails">
          <img src="{{ asset('image/no_image.png')}}" class="active">
          <img src="{{ asset('image/no_image.png')}}">
          <img src="{{ asset('image/no_image.png')}}">
          <img src="{{ asset('image/no_image.png')}}">
        </div>

        <div class="form-group price-stock mt-4">
          <div style="margin-bottom: 10px;">
            <label>Color</label>
            <input type="text" name="color[]" required class="form-control">
          </div>
          <div style="margin-bottom: 10px;">
            <label>Selected Color (Hex)</label>
            <input type="text" name="color_code[]" id="hexColor-0" value="#ff0000" required class="form-control">
          </div>
          <div>
            <label>Color Picker</label>
            <input type="color" id="colorPicker-0" value="#ff0000" class="form-control form-control-color" onchange="syncColor(0)">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Button to Add Tab -->
  <button class="btn mt-3" onclick="addNewTab()">+ Add Color Tab</button>
</div>

  </div>

<a href="{{ route('productadmin') }}" class="btn btn-outline-secondary position-absolute top-0 end-0 m-3 p-2">
  <i class="bi bi-arrow-left"></i>
</a>

  <script>

  let tabCount = 1;

function addNewTab() {
  const tabId = `color-${tabCount}`;

  // Create new tab button
  const newTab = document.createElement('li');
  newTab.className = 'nav-item';
  newTab.role = 'presentation';
  newTab.innerHTML = `
    <button class="nav-link" id="color-tab-${tabCount}" data-bs-toggle="tab" data-bs-target="#color-content-${tabCount}" type="button" role="tab">Color ${tabCount + 1}</button>
  `;
  document.getElementById('colorTabs').appendChild(newTab);

  // Create new tab content
  const newContent = document.createElement('div');
  newContent.className = 'tab-pane fade';
  newContent.id = `color-content-${tabCount}`;
  newContent.role = 'tabpanel';
  newContent.innerHTML = `
    <div class="image-container">
        <label style="display:block; margin-bottom:10px; font-weight:500;">Upload New Image</label>
        <img src="{{ asset('image/no_image.png')}}" class="main-image" id="mainImage-0">
        <div class="thumbnails">
          <img src="{{ asset('image/no_image.png')}}" class="active">
          <img src="{{ asset('image/no_image.png')}}">
          <img src="{{ asset('image/no_image.png')}}">
          <img src="{{ asset('image/no_image.png')}}">
        </div>

        <div class="form-group price-stock mt-4">
          <div style="margin-bottom: 10px;">
            <label>Color</label>
            <input type="text" name="color[]" required class="form-control">
          </div>
          <div style="margin-bottom: 10px;">
            <label>Selected Color (Hex)</label>
            <input type="text" name="color_code[]" id="hexColor-0" value="#ff0000" required class="form-control">
          </div>
          <div>
            <label>Color Picker</label>
            <input type="color" id="colorPicker-0" value="#ff0000" class="form-control form-control-color" onchange="syncColor(0)">
          </div>
        </div>
      </div>
  `;
  document.getElementById('colorTabContent').appendChild(newContent);

  tabCount++;
  }

  function syncColor(index) {
    const picker = document.getElementById(`colorPicker-${index}`);
    const hexInput = document.getElementById(`hexColor-${index}`);
     if (picker && hexInput) hexInput.value = picker.value;
  }

  document.addEventListener('DOMContentLoaded', () => {
  // Pasang listener di container tab-content
  const tabContent = document.getElementById('colorTabContent');

  tabContent.addEventListener('click', e => {
    // Cegah kalau bukan klik di <img> dalam .thumbnails
    if (!e.target.matches('.thumbnails img')) return;

    const thumb     = e.target;
    const pane      = thumb.closest('.image-container');
    const mainImage = pane.querySelector('.main-image');

    // Ganti src main image
    mainImage.src = thumb.src;

    // Reset dan set class active
    pane.querySelectorAll('.thumbnails img')
        .forEach(img => img.classList.remove('active'));
    thumb.classList.add('active');
  });
});

  // function setMainImage(thumbnail, tabIndex) {
  //   const mainImage = document.getElementById(mainImage-${tabIndex});
  //   if (!mainImage) return;

  //   // Ganti src
  //   mainImage.src = thumbnail.src;

  //   // Update border active
  //   const thumbs = thumbnail.parentNode.querySelectorAll('img');
  //   thumbs.forEach(img => img.classList.remove('active'));
  //   thumbnail.classList.add('active');
  // }
    // Mendapatkan elemen input color dan text
    // const colorPicker = document.getElementById('colorPicker');
    // const hexColor = document.getElementById('hexColor');

    // // Menangani perubahan pada color picker
    // colorPicker.addEventListener('input', function () {
    //     // Ambil nilai hex dari color picker
    //     const hexValue = colorPicker.value;
        
    //     // Update nilai hex ke input
    //     hexColor.value = hexValue;
    // });
    // // Handle size button active state
    // document.querySelectorAll('.size-btn').forEach(btn => {
    //   btn.addEventListener('click', () => {
    //     document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    //     btn.classList.add('active');
    //   });
    // });

    // Handle image preview
    function setMainImage(thumbnail) {
      document.getElementById('mainImage').src = thumbnail.src;
      document.querySelectorAll('.thumbnails img').forEach(img => img.classList.remove('active'));
      thumbnail.classList.add('active');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

