{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }
    .signup-form {
      max-width: 400px;
      width: 100%;
      padding: 40px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    .signup-form .logo {
      width: 50px;
      margin: 0 auto 20px;
      display: block;
    }
    .signup-form .form-control {
      height: 45px;
      border-radius: 10px;
    }
    .signup-form .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      padding: 10px;
    }
    .signup-form .login-link {
      text-align: center;
      margin-top: 15px;
    }
    a {
      text-decoration: none;
      color: #000000;
      font-weight: bold;
    }
    h3 {
      margin-top: -15px;
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
<body style="min-height: 100vh;" class="d-flex align-items-center justify-content-center">
  <div class="signup-form text-center">
    <img src="{{ asset('image/logg.png') }}" class="logo" alt="Logo">
    <h3 class="mb-4 fw-bold">Create Account</h3>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul class="mb-0">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <div id="loader" class="loader-overlay" style="display: none;">
  <div class="loader"></div>
</div>

    <form method="POST" action="{{ route('signup.submit') }}" id="registerForm">
      @csrf
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required autofocus>
      </div>
      <div class="mb-3">
        <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') }}" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
      </div>
      <div class="mb-3">
        <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" value="{{ old('phone_number') }}" 
        inputmode="numeric"
        pattern="[0-9]*"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        maxlength="15" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn btn-black w-100">Sign Up</button>
    </form>

    <div class="login-link mt-3">
      <small>Already have an account? <a href="{{ route('login') }}">Log in</a></small>
    </div>
  </div>
<script>
document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("registerForm");
      form.addEventListener("submit", function () {
        document.getElementById("loader").style.display = "flex";
      });
    });
</script>
</body>
</html>