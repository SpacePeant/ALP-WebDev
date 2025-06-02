@php
    // Mengambil data session user_id dan user_name
    $user_id = session('user_id', 1); // default 1 jika tidak ada
    $user_name = session('user_name', 'Guest');
@endphp

<style>
  /* Reset dan dasar */
  * {
    box-sizing: border-box;
  }

  .navbar a,
  .menu-mobile a {
    text-decoration: none;
    color: black;
  }

  .icons a {
    color: black;
  }

  button {
    cursor: pointer;
    border: none;
    background: none;
  }

  /* Layout desktop */
  .layout-desktop {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    background: #fff;
  }

  .layout-desktop .logo img {
    height: 30px;
  }

  .layout-desktop nav.navbar a {
    margin: 0 15px;
    font-weight: 500;
  }

  .layout-desktop nav.navbar a:hover {
    border-bottom: 2px solid black;
  }

  .layout-desktop .icons {
    display: flex;
    gap: 20px;
    font-size: 15px;
  }

  /* Layout mobile (default hidden) */
  .layout-mobile {
    display: none;
    flex-direction: column;
    padding: 10px 20px;
    background: #fff;
  }
  
  .layout-mobile .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .layout-mobile .top-bar .left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

  .layout-mobile .top-bar .logo img {
    height: 30px;
  }

  .layout-mobile #burger {
    font-size: 24px;
  }

  .layout-mobile nav.menu-mobile {
    margin-top: 15px;
    flex-direction: column;
    gap: 10px;
    display: none;
  }

  .layout-mobile nav.menu-mobile.show {
    display: flex;
  }

  .layout-mobile nav.menu-mobile a {
    font-weight: 500;
    padding: 8px 0;
    border-bottom: 1px solid #ddd;
  }

  .layout-mobile nav.menu-mobile a:last-child {
    border-bottom: none;
  }

  /* Responsive trigger */
  @media (max-width: 768px) {
    .layout-desktop {
      display: none;
    }

    .layout-mobile {
      display: flex;
    }
  }

  /* User dropdown shared styles */
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
    margin-top: 5px;
  }

  .user-dropdown-menu .log {
    background-color: #f44336;
    color: white;
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
  header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 9999;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  transition: background-color 0.5s ease, box-shadow 0.5s ease;
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
<header>
  <!-- Desktop Layout -->
  <div class="layout-desktop">
    <div class="logo">
      <img src="{{ asset('image/logo2.png') }}" alt="Logo" />
    </div>

    <nav class="navbar">
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <a href="{{ route('orderadmin') }}">Order</a>
      <a href="{{ route('productadmin') }}">Product</a>
      <a href="{{ route('report') }}">Report</a>
      <a href="{{ route('showadmin')}}">Blog</a>

    </nav>

    <div class="icons">
      <div class="user-dropdown">
        <a href="#" id="userIconDesktop"><i data-feather="user"></i></a>
        <div class="user-dropdown-menu" id="userDropdownDesktop">
          <p>Hi, {{ $user_name }}!</p>
          <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="log">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Layout -->
  <div class="layout-mobile">
    <div class="top-bar">
      <div class="left">
        <button id="burger"><i data-feather="menu"></i></button>

        <div class="logo">
          <img src="{{ asset('image/logo2.png') }}" alt="Logo" />
        </div>
      </div>
      <div class="icons">
        <div class="user-dropdown">
          <a href="#" id="userIconMobile"><i data-feather="user"></i></a>
          <div class="user-dropdown-menu" id="userDropdownMobile">
            <p>Hi, {{ $user_name }}!</p>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="log">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <nav class="menu-mobile" id="mobileMenu">
      <a href="#">Dashboard</a>
      <a href="{{ route('orderadmin') }}">Order</a>
      <a href="{{ route('productadmin') }}">Product</a>
    </nav>
  </div>
</header>
    <!-- Link FontAwesome buat icon -->
   @push('scripts')
<!-- Font Awesome Kit -->
<script src="https://kit.fontawesome.com/yourfontawesomekit.js" crossorigin="anonymous"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  feather.replace();

  // Burger menu toggle
  const burger = document.getElementById('burger');
  const mobileMenu = document.getElementById('mobileMenu');

  if (burger && mobileMenu) {
    burger.addEventListener('click', function () {
      mobileMenu.classList.toggle('show');
    });
  }

  // User dropdown desktop
  const userIconDesktop = document.getElementById('userIconDesktop');
  const userDropdownDesktop = document.getElementById('userDropdownDesktop');

  if (userIconDesktop && userDropdownDesktop) {
    userIconDesktop.addEventListener('click', function (e) {
      e.preventDefault();
      userDropdownDesktop.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
      if (!userIconDesktop.contains(e.target) && !userDropdownDesktop.contains(e.target)) {
        userDropdownDesktop.classList.remove('show');
      }
    });
  }

  // User dropdown mobile
  const userIconMobile = document.getElementById('userIconMobile');
  const userDropdownMobile = document.getElementById('userDropdownMobile');

  if (userIconMobile && userDropdownMobile) {
    userIconMobile.addEventListener('click', function (e) {
      e.preventDefault();
      userDropdownMobile.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
      if (!userIconMobile.contains(e.target) && !userDropdownMobile.contains(e.target)) {
        userDropdownMobile.classList.remove('show');
      }
    });
  }

  // Logout form submit
  const userIcon = document.getElementById("userIcon");
  const userDropdown = document.getElementById("userDropdown");

  if (userIcon && userDropdown) {
    userIcon.addEventListener("click", function (e) {
      e.preventDefault();
      userDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (e) {
      if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.remove("show");
      }
    });
  }

  function logout() {
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm) {
      logoutForm.submit();
    }
  }
</script>
@endpush