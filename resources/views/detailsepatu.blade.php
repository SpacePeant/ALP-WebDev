<?php 
    require_once 'db_connect.php';
    $conn = getConnectionToDatabase();
    session_start();
    $product_id = $_GET['id'] ?? null;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_GET['user_id']) ? $_GET['user_id'] : 1);
if ($product_id) {
    $sql = "SELECT 
                p.id AS product_id,
                p.name AS product_name,
                p.gender,
                p.price,
                c.name AS category_name,
                pc.color_code,
                pc.color_name,
                pc.color_code_bg,
                pci.image_atas,
                pci.image_bawah,
                pci.image_kiri,
                pci.image_kanan
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            LEFT JOIN product_color pc ON p.id = pc.product_id AND pc.is_primary = TRUE
            LEFT JOIN product_color_image pci ON pc.id = pci.color_id
            WHERE p.status = 'active' AND p.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

} else {
    echo "<p>ID produk tidak valid.</p>";
}

$color_options = [];
$color_query = "SELECT color_code FROM product_color WHERE product_id = $product_id";
$color_result = mysqli_query($conn, $color_query);
while ($row = mysqli_fetch_assoc($color_result)) {
    $color_options[] = $row;
}

// Dapatkan size options
$size_options = [];
$size_query = "SELECT pv.size
               FROM product_variant pv 
               JOIN product_color pc ON pc.id = pv.color_id
               WHERE pv.product_id = $product_id
               GROUP BY pv.size
               ORDER BY pv.size";
$size_result = mysqli_query($conn, $size_query);
while ($row = mysqli_fetch_assoc($size_result)) {
    $size_options[] = $row;
}

// Dapatkan size options
$size_stock = [];
$size_stock_query = "SELECT pv.size, stock, color_code,color_code_bg, image_atas, image_bawah, image_kanan, image_kiri
               FROM product_variant pv 
               JOIN product_color pc ON pc.id = pv.color_id
               LEFT JOIN product_color_image pci ON pc.id = pci.color_id
               WHERE pv.product_id = $product_id
               GROUP BY pv.size,2,3,4,5,6,7,8
               ORDER BY pv.size,2,3;";
$stock_result = mysqli_query($conn, $size_stock_query);
while ($row = mysqli_fetch_assoc($stock_result)) {
    $size_stock[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
  $product_id = $_POST['product_id'] ?? null;
  $size = $_POST['size'] ?? null;
  $color_code = $_POST['color_code'] ?? null;
  $user_id = $_SESSION['user_id'] ?? null;

  if (!$product_id || !$size || !$color_code || !$user_id) {
      echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
      exit;
  }

  // Ambil product_color_id dari color_code
  $stmtColor = $conn->prepare("SELECT id, color_name FROM product_color WHERE product_id = ? AND color_code = ?");
  $stmtColor->bind_param("is", $product_id, $color_code);
  $stmtColor->execute();
  $resultColor = $stmtColor->get_result();
  $color = $resultColor->fetch_assoc();

  if (!$color) {
      echo json_encode(['success' => false, 'message' => 'Warna tidak ditemukan']);
      exit;
  }

  $product_color_id = $color['id'];
  $color_name = $color['color_name'];

  // Ambil product_variant_id dari size
  $stmtVariant = $conn->prepare("SELECT id FROM product_variant WHERE product_id = ? AND size = ?");
  $stmtVariant->bind_param("is", $product_id, $size);
  $stmtVariant->execute();
  $resultVariant = $stmtVariant->get_result();
  $variant = $resultVariant->fetch_assoc();

  if (!$variant) {
      echo json_encode(['success' => false, 'message' => 'Ukuran tidak ditemukan']);
      exit;
  }

  $product_variant_id = $variant['id'];

  $quantity = 1;

  // Cek apakah item sudah ada di cart berdasarkan kombinasi
  $checkStmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE customer_id = ? AND product_id = ? AND product_color_id = ? AND product_variant_id = ?");
  $checkStmt->bind_param("iiii", $user_id, $product_id, $product_color_id, $product_variant_id);
  $checkStmt->execute();
  $checkResult = $checkStmt->get_result();
  $existingItem = $checkResult->fetch_assoc();

  if ($existingItem) {
      // Update quantity
      $newQuantity = $existingItem['quantity'] + $quantity;
      $updateStmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
      $updateStmt->bind_param("ii", $newQuantity, $existingItem['id']);
      if ($updateStmt->execute()) {
          echo json_encode(['success' => true, 'message' => 'Jumlah diperbarui']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Gagal memperbarui jumlah']);
      }
  } else {
      // Insert baru
      $insertStmt = $conn->prepare("INSERT INTO cart_items (customer_id, product_id, product_color_id, product_variant_id, quantity) VALUES (?, ?, ?, ?, ?)");
      $insertStmt->bind_param("iiiii", $user_id, $product_id, $product_color_id, $product_variant_id, $quantity);
      if ($insertStmt->execute()) {
          echo json_encode(['success' => true, 'message' => 'Item ditambahkan ke keranjang']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Gagal menambahkan ke keranjang']);
      }
  }

  exit;
}

$isWishlisted = false;

if ($product_id) {
    $conn = getConnectionToDatabase();
    $stmt = $conn->prepare("SELECT id FROM wishlists WHERE customer_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $isWishlisted = $result->num_rows > 0;
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Page - Air Jordan 1 Low</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    html, body {
    margin: 0;
    padding: 0;
    overflow: hidden; /* Hilangkan scroll */
    height: 100vh;     /* Tinggi sesuai viewport */
    font-family: 'Red Hat Text', sans-serif;
}

.product-wrapper {
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(to bottom, #ffffff, #CFCFCF);
  font-family: 'Red Hat Text', sans-serif;
  margin: 0;
}

.product-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  box-sizing: border-box;
}

.product-page {
  display: flex;
  align-items: flex-start;
  gap: 40px;
  max-width: 1200px;
  width: 100%;
  justify-content: center;
  align-items: center;
}

.left-section {
  width: 100px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.main-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.main-image img {
  width: 150%;
  height: auto;
  transition: 0.3s ease;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.right-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.thumbnail-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.thumbnail {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 12px;
  border: 2px solid transparent;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.2s ease;
  background-color: white;
}

.circle-bg {
  position: absolute;
  width: 320px;
  height: 320px;
  background-color: #791c24;
  border-radius: 50%;
  z-index: 1;
}
.thumbnail.active {
  border: 2px solid #333;
  opacity: 1;
  border-color: black;
}

.thumbnail:hover {
  opacity: 1;
}

.main-image img {
  width: 110%;
  z-index: 2;
  position: relative;
}

.right-section {
  flex: 1;
}

.category {
  color: #777;
  margin-bottom: 10px;
}

.product-name {
  font-size: 36px;
  font-weight: bold;
  margin: 0;
}

.rating {
  font-size: 18px;
  color: gold;
  margin: 8px 0;
}

.amount-sold {
  color: #444;
  margin-bottom: 10px;
}

.price {
  font-size: 24px;
  font-weight: 300;
  color: black;
  margin-bottom: 20px;
}

.color-options {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.color-circle {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  cursor: pointer;
  border: 2px solid #ddd;
  transition: transform 0.2s;
}

.color-circle:hover {
  transform: scale(1.1);
}

.size-title {
  font-weight: bold;
  margin-bottom: 10px;
}

.size-options {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 30px;
}

.size-btn {
  padding: 8px 16px;
  border: 1px solid black;
  background: white;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.3s;
}

.size-btn.selected {
  background: black;
  color: white;
}

.actions {
  display: flex;
  gap: 10px;
  align-items: center;
}

.buy-now,
.add-cart {
  padding: 10px 20px;
  background: black;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.add-cart {
  background: #444;
}

.wishlist {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}
.back-to-collection {
    position: fixed;
    top: 20px;
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
.color-circle.selected {
    border: 2px solid #000; 
}
.size-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.popup {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex; justify-content: center; align-items: center;
  z-index: 999;
  animation: fadeIn 0.3s ease;
}

.popup.hidden {
  display: none;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.popup-content {
  background: #fff;
  padding: 30px 40px;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  text-align: center;
  max-width: 400px;
  width: 90%;
  animation: popIn 0.3s ease;
}

@keyframes popIn {
  0% { transform: scale(0.95); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

.popup-icon {
  font-size: 40px;
  margin-bottom: 15px;
}

.popup-text {
  font-size: 18px;
  margin-bottom: 20px;
  color: #333;
}

.popup-content button {
  padding: 10px 24px;
  background-color: #4CAF50;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.popup-content button:hover {
  background-color: #45a049;
}
#mainShoeImage {
    transition: opacity 0.3s ease;
    opacity: 1;
}

#mainShoeImage.fade-out {
    opacity: 0;
}

  </style>
</head>
<body>
<a href="javascript:void(0);" onclick="history.back();" class="back-to-collection" title="Kembali ke koleksi">
  <i data-feather="corner-down-left"></i>
</a>
    <div class="product-wrapper">
    <div class="product-page">
  <?php if ($product): ?>
    <div class="left-section">
        <div class="thumbnail-list">
            <img src="sepatu/atas/<?= htmlspecialchars($product['image_atas']) ?>" class="thumbnail active" alt="Tampak Atas">
            <img src="sepatu/bawah/<?= htmlspecialchars($product['image_bawah']) ?>" class="thumbnail" alt="Tampak Bawah">
            <img src="sepatu/kiri/<?= htmlspecialchars($product['image_kiri']) ?>" class="thumbnail" alt="Tampak Kiri">
            <img src="sepatu/kanan/<?= htmlspecialchars($product['image_kanan']) ?>" class="thumbnail" alt="Tampak Kanan">
        </div>
    </div>

    <div class="main-image">
        <div class="circle-bg" style="background-color: <?= htmlspecialchars($product['color_code_bg']) ?>;"></div>
        <img id="mainShoeImage" src="sepatu/atas/<?= htmlspecialchars($product['image_atas']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" />
    </div>
<?php else: ?>
    <p>Produk tidak ditemukan.</p>
<?php endif; ?>

<div class="right-section">
    <?php if ($product): ?>
        <p class="category">
            <?php echo htmlspecialchars(ucfirst($product['gender'])) . " " . htmlspecialchars($product['category_name']) . " Shoes"; ?>
        </p>

        <h1 class="product-name">
            <?php echo nl2br(htmlspecialchars($product['product_name'])); ?>
        </h1>

        <p class="price">Rp. <?php echo number_format($product['price'], 0, ',', '.'); ?></p>


        <div class="color-options">
    <?php 
    if (!empty($color_options)) {
        foreach ($color_options as $index => $color) {
            $selected = ($index === 0) ? ' selected' : ''; // Tandai warna pertama sebagai default
            echo '<div 
                    class="color-circle' . $selected . '" 
                    data-color-code="' . htmlspecialchars($color['color_code']) . '"
                    style="background-color:' . htmlspecialchars($color['color_code']) . ';"
                  ></div>';
        }
    }
    ?>
</div>

        

        <p class="size-title">Select Size</p>

        <div class="size-options">
    <?php 
    if (!empty($size_options)) {
        foreach ($size_options as $index => $size) {
            $selected = ($index === 0) ? ' selected' : '';
            echo '<button class="size-btn' . $selected . '" data-size="' . htmlspecialchars($size['size']) . '">
                    EU ' . htmlspecialchars($size['size']) . '
                  </button>';
        }
    } else {
        echo '<p class="no-size">Size not available</p>';
    }
    ?>
</div>
<p id="stockInfo" class="stock-info">Stock: -</p>


        <div class="actions">
            <button class="buy-now">Buy Now</button>
            <button class="add-cart" 
                  id="addToCartBtn"
                  data-product-id="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
              Add To Cart
          </button>
          <button class="wishlist-btn" id="wishlistBtn" data-product-id="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
            <i class="bi <?= $isWishlisted ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
          </button>
        </div>
    <?php else: ?>
        <p>Produk tidak ditemukan.</p>
    <?php endif; ?>
</div>
    </div>

    <div id="popupMessage" class="popup hidden">
  <div class="popup-content">
    <div class="popup-icon" id="popupIcon">✔️</div>
    <div class="popup-text" id="popupText">Pesan</div>
    <button onclick="closePopup()">OK</button>
  </div>
</div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const stockData = <?php echo json_encode($size_stock); ?>;
    let selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;
    let selectedColorCodeBg = document.querySelector('.color-circle.selected')?.dataset.colorCodeBg;

    // Mengubah warna circle-bg sesuai dengan color_code_bg
    if (selectedColorCodeBg) {
        document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg;
    }

    // Fungsi untuk memperbarui status tombol size (enabled/disabled)
    const updateSizeButtons = () => {
        document.querySelectorAll('.size-btn').forEach(btn => {
            const size = btn.dataset.size;
            const match = stockData.find(item => item.size === size && item.color_code === selectedColorCode && parseInt(item.stock) > 0);

            if (match) {
                btn.disabled = false;
                btn.classList.remove('disabled');
            } else {
                btn.disabled = true;
                btn.classList.remove('selected');
                btn.classList.add('disabled');
            }
        });
    };

    // Fungsi untuk menampilkan informasi stok
    const showStockAlert = () => {
        const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;

        if (selectedSize && selectedColorCode) {
            const match = stockData.find(item => item.size === selectedSize && item.color_code === selectedColorCode);

            if (match) {
                document.getElementById('stockInfo').textContent = 'Stock: ' + match.stock;
            } else {
                document.getElementById('stockInfo').textContent = 'Stock: 0';
            }
        } else {
            document.getElementById('stockInfo').textContent = 'Stock: -';
        }
    };

    // Event listener untuk perubahan warna
    document.querySelectorAll('.color-circle').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedColorCode = this.dataset.colorCode;
            selectedColorCodeBg = this.dataset.colorCodeBg;

            // Mengubah warna background circle-bg sesuai dengan color_code_bg yang dipilih
            document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg;

            updateSizeButtons();
            showStockAlert();
        });
    });

    let activePosition = 'atas'; // posisi terakhir dilihat (default "atas")

    // Data gambar (dari PHP)
    const imageSet = <?= json_encode($size_stock); ?>;
    const mainImage = document.getElementById('mainShoeImage');
    const thumbnails = document.querySelectorAll('.thumbnail');

    document.querySelectorAll('.color-circle').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');

            selectedColorCode = this.dataset.colorCode;
            selectedColorCodeBg = this.dataset.colorCodeBg;

            // Mengubah warna background circle-bg sesuai dengan color_code_bg yang dipilih
            document.querySelector('.circle-bg').style.backgroundColor = selectedColorCodeBg;

            // Cari gambar yang sesuai dengan warna yang dipilih
            const selectedImage = imageSet.find(item => item.color_code === selectedColorCode);

            if (selectedImage) {
                thumbnails[0].src = 'sepatu/atas/' + selectedImage.image_atas;
                thumbnails[1].src = 'sepatu/bawah/' + selectedImage.image_bawah;
                thumbnails[2].src = 'sepatu/kiri/' + selectedImage.image_kiri;
                thumbnails[3].src = 'sepatu/kanan/' + selectedImage.image_kanan;

                function changeMainImageWithFade(newSrc) {
    mainImage.classList.add('fade-out');
    setTimeout(() => {
        mainImage.src = newSrc;
        mainImage.onload = () => {
            mainImage.classList.remove('fade-out');
        };
    }, 200); // beri jeda 200ms untuk efek fade out
}
switch (activePosition) {
    case 'atas':
        changeMainImageWithFade(thumbnails[0].src);
        break;
    case 'bawah':
        changeMainImageWithFade(thumbnails[1].src);
        break;
    case 'kiri':
        changeMainImageWithFade(thumbnails[2].src);
        break;
    case 'kanan':
        changeMainImageWithFade(thumbnails[3].src);
        break;
}
            }
        });
    });
    

    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', function () {
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            activePosition = ['atas', 'bawah', 'kiri', 'kanan'][index];

            mainImage.src = this.src;
        });
    });

    document.querySelectorAll('.size-btn').forEach(el => {
        el.addEventListener('click', function () {
            if (this.disabled) return; 
            document.querySelectorAll('.size-btn').forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            showStockAlert();
        });
    });

    updateSizeButtons();
    document.querySelector('.size-btn:not([disabled])')?.click();
});

document.addEventListener('DOMContentLoaded', function () {
        const colorCircles = document.querySelectorAll('.color-circle');
        const bgCircle = document.querySelector('.circle-bg');

        colorCircles.forEach(circle => {
            circle.addEventListener('click', function () {
                colorCircles.forEach(c => c.classList.remove('selected'));

                this.classList.add('selected');

                const colorCode = this.getAttribute('data-color-code');

                const imageSet = <?= json_encode($size_stock); ?>;
                const selectedImage = imageSet.find(item => item.color_code === colorCode);
                if (selectedImage) {
                    bgCircle.style.backgroundColor = selectedImage.color_code_bg;
                }
            });
        });
    });
</script>
<script>
document.querySelectorAll('.thumbnail').forEach(thumbnail => {
    thumbnail.addEventListener('click', function () {
        const mainImg = document.getElementById('mainShoeImage');
        mainImg.src = this.src;

        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        const altText = this.alt.toLowerCase();
        if (altText.includes("kiri")) {
            mainImg.style.transform = "rotate(-28deg)";
        } 
        else if(altText.includes("kanan")){
            mainImg.style.transform = "rotate(28deg)";
        }
        else {
            mainImg.style.transform = "rotate(0deg)";
        }
    });
});
</script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>

<script>
document.getElementById('wishlistBtn').addEventListener('click', function () {
    const button = this;
    const icon = button.querySelector('i');
    const productId = button.getAttribute('data-product-id');

    fetch('add_to_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'added') {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        } else if (data.status === 'removed') {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        }
    })
    .catch(err => console.error('Error:', err));
});
</script>

<script>
  function closePopup() {
    document.getElementById('popupMessage').classList.add('hidden');
}

  document.getElementById('addToCartBtn').addEventListener('click', function () {
    const productId = this.dataset.productId;
    const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
    const selectedColorCode = document.querySelector('.color-circle.selected')?.dataset.colorCode;
    

    if (!selectedSize || !selectedColorCode) {
      Swal.fire({
    icon: 'warning',
    title: 'Oops!',
    text: 'Silakan pilih ukuran dan warna terlebih dahulu.',
    confirmButtonColor: '#d33',
    confirmButtonText: 'OK'
  });
  return;
    }

    const formData = new FormData();
    formData.append('action', 'add_to_cart');
    formData.append('product_id', productId);
    formData.append('size', selectedSize);
    formData.append('color_code', selectedColorCode);
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
      
      if (data.success) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Produk berhasil ditambahkan ke keranjang!',
      confirmButtonColor: '#133052',
      confirmButtonText: 'Lanjut Belanja'
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: data.message,
      confirmButtonColor: '#d33',
      confirmButtonText: 'Coba Lagi'
    });
  }

    })
    .catch(err => {
        console.error('Error:', err);
    });
});
</script>
</body>
</html>