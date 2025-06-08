<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  @vite(['resources/css/login.css'])
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }
    .login-form {
      max-width: 400px;
      width: 100%;
      padding: 40px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    .login-form .logo {
      width: 50px;
      margin: 0 auto 20px;
      display: block;
    }
    .login-form .form-control {
      height: 45px;
      border-radius: 10px;
    }
    .login-form .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      padding: 10px;
    }
    .login-form .login-link {
      text-align: center;
      margin-top: 15px;
    }
    h3 {
      margin-top: -15px;
    }
    a {
      text-decoration: none;
      color: #000000;
      font-weight: bold;
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
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="login-form text-center">
    <img src="{{ asset('image/logg.png') }}" class="logo" alt="Logo">
    <h3 class="mb-4 fw-bold">Log In</h3>

    {{-- Error message --}}
    @if ($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Loader --}}
    <div id="loader" class="loader-overlay">
      <div class="loader"></div>
    </div>

    <form method="POST" id="loginForm" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="d-flex justify-content-between mt-2">
          <div class="form-check text-start">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember" style="font-size: 0.9rem;">Remember me</label>
          </div>
          <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 0.9rem;">Forgot password?</a>
        </div>
      </div>
      <button type="submit" class="btn btn-black w-100">Log In</button>
      <a href="{{ url('auth/google') }}" class="btn btn-danger">
          <i class="fa fa-google"></i> Login with Google
      </a>

    </form>

    <div class="login-link mt-3">
      <small>Don't have an account yet? <a href="{{ route('register') }}">Sign up</a></small>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("loginForm");
      form.addEventListener("submit", function () {
        document.getElementById("loader").style.display = "flex";
      });
    });
  </script>
</body>
</html>
