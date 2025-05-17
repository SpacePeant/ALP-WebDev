@php
    use Illuminate\Support\Facades\Session;
    $user_name = Session::get('user_name', 'Guest');
@endphp

<style>
    * {
      box-sizing: border-box;
    }
    .menu a {
      text-decoration: none;
      color: black;
    }
    .menu-mobile a{
      text-decoration: none;
      color: black;
    }
    .icons a{
      color:black;
    }
    button {
      cursor: pointer;
      border: none;
      background: none;
    }

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
    .layout-desktop nav.menu a {
      margin: 0 15px;
      font-weight: 500;
    }
    .layout-desktop nav.menu a:hover {
      border-bottom: 2px solid black;
    }
    .layout-desktop .icons {
      display: flex;
      gap: 30px;
      font-size: 15px;
    }

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
    .layout-mobile .top-bar .logo img {
      height: 30px;
    }
    .layout-mobile .top-bar .icons {
      display: flex;
      gap: 30px;
      font-size: 15px;
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

    @media (max-width: 768px) {
      .layout-desktop {
        display: none;
      }
      .layout-mobile {
        display: flex;
      }
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
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
      padding: 15px;
      z-index: 100;
      width: 200px;

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
  z-index: 1000;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>

<header>
  <!-- Desktop Layout -->
  <div class="layout-desktop">
    <div class="logo">
      <img src="{{ asset('image/logo2.png') }}" alt="Logo" />
    </div>

    <nav class="menu">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('about') }}">About</a>
      <a href="{{ route('blog') }}">Blog</a>
      <a href="{{ route('detail') }}">Collection</a>
    </nav>

    <div class="icons">
      <a href="{{ route('wishlist') }}"><i data-feather="star"></i></a>
      <a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i></a>

      <div class="user-dropdown">
        <a href="#" id="userIconDesktop"><i data-feather="user"></i></a>
        <div class="user-dropdown-menu" id="userDropdownDesktop">
          <p>Hi, {{ $user_name }}!</p>
          <button onclick="window.location='{{ route('profile.show') }}'">Account</button>
          <button>Help</button>
          <button>Send Feedback</button>
          <button>FAQ</button>
          <form action="{{ route('logout') }}" method="POST">
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
      <button id="burger"><i data-feather="menu"></i></button>

      <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" />
      </div>

      <div class="icons">
        <a href="{{ route('wishlist') }}"><i data-feather="star"></i></a>
        <a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i></a>

        <div class="user-dropdown">
          <a href="#" id="userIconMobile"><i data-feather="user"></i></a>
          <div class="user-dropdown-menu" id="userDropdownMobile">
            <p>Hi, {{ $user_name }}!</p>
            <button onclick="window.location='{{ route('profile.show') }}'">Account</button>
            <button>Help</button>
            <button>Send Feedback</button>
            <button>FAQ</button>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="log">Logout</button>
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

@push('scripts')
<script>
  feather.replace();

  // Burger menu toggle
  const burger = document.getElementById('burger');
  const mobileMenu = document.getElementById('mobileMenu');

  burger.addEventListener('click', function() {
    mobileMenu.classList.toggle('show');
  });

  // User dropdown desktop
  const userIconDesktop = document.getElementById('userIconDesktop');
  const userDropdownDesktop = document.getElementById('userDropdownDesktop');

  userIconDesktop.addEventListener('click', function(e) {
    e.preventDefault();
    userDropdownDesktop.classList.toggle('show');
  });

  document.addEventListener('click', function(e) {
    if (!userIconDesktop.contains(e.target) && !userDropdownDesktop.contains(e.target)) {
      userDropdownDesktop.classList.remove('show');
    }
  });

  // User dropdown mobile
  const userIconMobile = document.getElementById('userIconMobile');
  const userDropdownMobile = document.getElementById('userDropdownMobile');

  userIconMobile.addEventListener('click', function(e) {
    e.preventDefault();
    userDropdownMobile.classList.toggle('show');
  });

  document.addEventListener('click', function(e) {
    if (!userIconMobile.contains(e.target) && !userDropdownMobile.contains(e.target)) {
      userDropdownMobile.classList.remove('show');
    }
  });
</script>
@endpush