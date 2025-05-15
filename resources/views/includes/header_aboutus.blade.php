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

  position: absolute;
  top: 0;
  width: 100%;
  z-index: 10;
  background: transparent;
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

.navbar {
    margin-left:150px;
}
.icons {
  display: flex;
  gap: 20px;
  font-size: 24px;
}

.about-section {
  width: 100%;
  max-width: 1450px; /* batasi lebar sesuai gambar */
  height: 408px;      /* tinggi sesuai gambar */
  margin: 0 auto;
  background: url('image/image_carousel/bg_aboutus.png') no-repeat center center;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.about-overlay h1 {
  font-family: 'Playfair Display', serif;
  font-size: 60px;
  font-weight: 700;
  color: #000;
  margin: 0;
  z-index: 2;
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

      </div>
      <nav class="navbar">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('about') }}">About</a>
      <a href="{{ route('blog') }}">Blog</a>
      <a href="{{ route('collection') }}">Collection</a>
  </nav>
      <div class="icons">
        <a href=""><i data-feather="star"></i></a>
        <a href=""><i data-feather="shopping-cart"></i></a>
        <a href=""><i data-feather="user"></i></a>
      </div>
    </header>

    <header class="about-section">
  <div class="about-overlay">
    <h1>About Us</h1>
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