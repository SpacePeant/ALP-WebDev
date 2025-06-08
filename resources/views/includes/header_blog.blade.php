@php
use Illuminate\Support\Facades\Session;
$user_name = Session::get('user_name', 'Guest');
@endphp
<link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
<style>
  /* RESET dan dasar */
  * {
    box-sizing: border-box;
  }

  /* LAYOUT DESKTOP */
  .layout-desktop {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background-color: transparent;
    z-index: 30;
  }

  .layout-desktop .logo {
    visibility: hidden; /* disembunyikan di desktop */
    margin-right: 50px;
  }
  .layout-desktop .logo img{
        height: 30px;
  }
  .layout-desktop nav.menu a {
    margin: 0 15px;
    color: black;
    font-weight: 500;
    text-decoration: none;
  }

  .layout-desktop nav.menu a:hover {
    border-bottom: 2px solid black;
  }

  .layout-desktop .icons a {
    color: black;
    font-size: 20px;
  }
 .layout-desktop .icons {
      display: flex;
      gap: 30px;
      font-size: 15px;
    }
  /* LAYOUT MOBILE */
  .layout-mobile {
    display: none;
    flex-direction: column;
    padding: 10px 20px;
    background-color: #fff;
    position: relative;
    z-index: 20;
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
    .layout-mobile .top-bar .icons {
      display: flex;
      gap: 20px;
      font-size: 15px;
    }
  .layout-mobile .top-bar .icons a{
   color:black;
  }

  .layout-mobile #burger {
    font-size: 28px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
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
    border-bottom: 1px solid #ddd;
    padding: 8px 0;
    text-decoration: none;
    color: black;
    font-weight: 500;
  }

  /* USER DROPDOWN (untuk keduanya) */
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
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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

  /* RESPONSIVE */
  @media (max-width: 768px) {
    .layout-desktop {
      display: none;
    }

    .layout-mobile {
      display: flex;
    }

    .layout-mobile .logo {
      display: block;
    }
  }

  /* ABOUT SECTION */
  .about-section {
    width: 100%;
    max-width: 1450px;
    height: 408px;
    margin: 0 auto;
    background: url('{{ asset('image/image_carousel/bg_blog.png') }}') no-repeat center center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border-radius: 10px;
    margin-bottom: 30px;
    z-index: 1;
  }

  .about-overlay h1 {
    font-family: 'Playfair Display', serif;
    font-size: 60px;
    font-weight: 700;
    color: black;
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

header.default {
  background-color: transparent;
  box-shadow: none;
  transition: background-color 0.5s ease, box-shadow 0.5s ease;
}

header.scrolled {
  background-color: white; 
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  transition: background-color 0.5s ease, box-shadow 0.5s ease;
}


header.scrolled .layout-desktop {
  background-color: white; 
  transition: background-color 0.5s ease, box-shadow 0.5s ease;
}

header.default .layout-desktop{
  background-color: transparent; 
  transition: background-color 0.5s ease, box-shadow 0.5s ease;
}
.header.default.layout-mobile.menu-mobile{
  background-color: white;
}
header.scrolled .layout-desktop .logo {
  visibility: visible;
  opacity: 1;
  transition: background-color 0.5s ease, box-shadow 0.5s ease;
}
</style>

<header class="default">
  <!-- Desktop Header -->
  <div class="layout-desktop">
    <div class="logo">
      <!-- Hidden logo di desktop -->
      <img src="{{ asset('image/logo2.png') }}" alt="Logo" />
    </div>

    <nav class="menu">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('about') }}">About</a>
      <a href="{{ route('blog') }}">Blog</a>
      <a href="{{ route('detail') }}">Collection</a>
    </nav>

    <div class="icons">
      <a href="{{ route('wishlist') }}"><i data-feather="heart"></i></a>
      <a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i></a>

      <div class="user-dropdown">
        <a href="#" id="userIconDesktop"><i data-feather="user"></i></a>
        <div class="user-dropdown-menu" id="userDropdownDesktop">
          <p>Hi, {{ Session::get('user_name', 'Guest') }}!</p>
          <button onclick="window.location='{{ route('profile.edit') }}'">Account</button>
          <button onclick="window.location='{{ route('order') }}'">My Orders</button>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="log" type="submit">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Header -->
  <div class="layout-mobile">
    <div class="top-bar">
      <div class="left">
        <button id="burger"><i data-feather="menu"></i></button>
        <div class="logo">
          <img src="{{ asset('image/logo2.png') }}" alt="Logo" />
        </div>
      </div>
      <div class="icons">
        <a href="{{ route('wishlist') }}"><i data-feather="heart"></i></a>
        <a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i></a>
        <div class="user-dropdown">
          <a href="#" id="userIconMobile"><i data-feather="user"></i></a>
          <div class="user-dropdown-menu" id="userDropdownMobile">
            <p>Hi, {{ Session::get('user_name', 'Guest') }}!</p>
            <button onclick="window.location='{{ route('profile.edit') }}'">Account</button>
            <button onclick="window.location='{{ route('order') }}'">My Orders</button>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="log" type="submit">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <nav class="menu-mobile" id="mobileMenu">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('about') }}">About</a>
      <a href="{{ route('blog') }}">Blog</a>
      <a href="{{ route('detail') }}">Collection</a>
    </nav>
  </div>
</header>

<!-- About Section -->
<header class="about-section">
  <div class="about-overlay">
    <h1>Blog</h1>
  </div>
</header>

<!-- JS Feather Icons & Interaksi -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();

  // Dropdown dan Burger
  const burger = document.getElementById('burger');
  const mobileMenu = document.getElementById('mobileMenu');
  const userIconDesktop = document.getElementById('userIconDesktop');
  const userDropdownDesktop = document.getElementById('userDropdownDesktop');
  const userIconMobile = document.getElementById('userIconMobile');
  const userDropdownMobile = document.getElementById('userDropdownMobile');

  burger.addEventListener('click', () => {
    mobileMenu.classList.toggle('show');
    userDropdownMobile.classList.remove('show');
  });

  userIconDesktop.addEventListener('click', (e) => {
    e.preventDefault();
    userDropdownDesktop.classList.toggle('show');
    userDropdownMobile.classList.remove('show');
  });

  userIconMobile.addEventListener('click', (e) => {
    e.preventDefault();
    userDropdownMobile.classList.toggle('show');
    userDropdownDesktop.classList.remove('show');
  });

  document.addEventListener('click', (e) => {
    if (!userIconDesktop.contains(e.target) && !userDropdownDesktop.contains(e.target)) {
      userDropdownDesktop.classList.remove('show');
    }
    if (!userIconMobile.contains(e.target) && !userDropdownMobile.contains(e.target)) {
      userDropdownMobile.classList.remove('show');
    }
  });
</script>
<script>
  window.addEventListener('scroll', function() {
  const header = document.querySelector('header');
  console.log('Scroll Y:', window.scrollY); // debug

  if (window.scrollY > 50) {
    header.classList.add('scrolled');
    header.classList.remove('default');
  } else {
    header.classList.remove('scrolled');
    header.classList.add('default');
  }
});
</script>
