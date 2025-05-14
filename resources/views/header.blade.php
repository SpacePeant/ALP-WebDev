<?php
// if (session_status() === PHP_SESSION_NONE) {
//   session_start(); // ✅ Aman, hanya jalan jika session belum aktif
// }
// $user_id = isset($user_id) ? $user_id : (isset($user_id) ? $user_id : 1);
// $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';

// if (isset($_GET['logout'])) {
//   session_unset();
//   session_destroy();
//   header("Location: login.php");
//   exit;
// }
?>

@php
  use Illuminate\Support\Facades\Session;
  $user_name = Session::get('user_name', 'Guest');
@endphp

<style>
    /* HEADER */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 50px;
  background: #fff;
}

.icons a {
  color: #000;
  margin-right: 20px;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo img {
  height: 30px;
}

.navbar a {
  margin: 0 15px;
  text-decoration: none;
  color: black;
  font-weight: 500;
}

.navbar a:hover {
  border-bottom: 2px solid black;
}

.icons {
  display: flex;
  gap: 20px;
  font-size: 15px;
}

.user-dropdown {
  position: relative;
}

.user-dropdown-menu {
  position: absolute;
  top: 120%;
  right: 0;
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  padding: 15px;
  z-index: 100;
  width: 200px;

  /* Animasi */
  opacity: 0;
  transform: translateY(-10px);
  pointer-events: none;
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.user-dropdown-menu.show {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

.user-dropdown-menu p {
  margin: 0 0 10px 0;
  font-weight: bold;
}

.user-dropdown-menu button {
  background-color: white;
  color: black;
  border: none;
  border-radius: 5px;
  padding: 8px 12px;
  width: 100%;
  cursor: pointer;
  text-align: left;
}

.user-dropdown-menu .log {
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 8px 12px;
  width: 100%;
  cursor: pointer;
  text-align: center;
  margin-top: 15px;
}

.user-dropdown-menu button:hover {
  background-color: #484848;
  color: white;
}

.user-dropdown-menu .log:hover {
  background-color: #d32f2f;
}
</style>
<!-- Bootstrap CSS -->
<link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/feather-icons"></script>
<!-- Header -->
<header class="header">
      <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="New Arrivals" />
      </div>
      <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="about_us.php">About</a>
        <a href="#">Blog</a>
        <a href="collection.php">Collection</a>
      </nav>
      <div class="icons">
        <a href="wishlist.php"><i data-feather="star"></i></a>
        <a href="cart.php"><i data-feather="shopping-cart"></i></a>
        <div class="user-dropdown">
        <a href="#" id="userIcon"><i data-feather="user"></i></a>
          <div class="user-dropdown-menu" id="userDropdown">
            <p id="userName">Hi, <?= htmlspecialchars($user_name) ?>!</p>
            <button>Help</button>
            <button>Send Feedback</button>
            <button>FAQ</button>
            <button onclick="logout()" class="log">Logout</button>
          </div>
        </div>
      </div>
    </header>
    <!-- Link FontAwesome buat icon -->
    <script
      src="https://kit.fontawesome.com/yourfontawesomekit.js"
      crossorigin="anonymous"
    ></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      feather.replace();
    </script>

<script>
      const userIcon = document.getElementById("userIcon");
      const userDropdown = document.getElementById("userDropdown");

      userIcon.addEventListener("click", function (e) {
        e.preventDefault();
        userDropdown.classList.toggle("show");
      });

      function logout() {
        window.location.href = "logout.php"; 
      }

      document.addEventListener("click", function (e) {
  if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
    userDropdown.classList.remove("show");
  }
});
    </script>