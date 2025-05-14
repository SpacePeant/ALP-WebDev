<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  @vite(['resources/css/login.css'])
</head>
<body style="min-height: 100vh;" class="d-flex align-items-center justify-content-center">
  <div class="login-form text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg" class="logo" alt="Nike Logo">
    <h3 class="mb-4 fw-bold">Log In</h3>

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Loader --}}
    <div id="loader" class="loader-overlay">
      <div class="loader"></div>
    </div>

    {{-- Form login --}}
    <form method="POST" id="loginForm" action="{{ route('login.submit') }}">
      @csrf
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-black w-100">Log In</button>
    </form>

    <div class="login-link mt-3">
      <small>Don't have an account yet? <a href="{{ url('/signup') }}">Sign up</a></small>
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
