<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  @vite(['resources/css/login.css'])
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }
    .forgot-form {
      max-width: 400px;
      width: 100%;
      padding: 40px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    .forgot-form .logo {
      width: 50px;
      margin: 0 auto 20px;
      display: block;
    }
    .forgot-form .form-control {
      height: 45px;
      border-radius: 10px;
    }
    .forgot-form .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      padding: 10px;
    }
    .forgot-form .login-link {
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
  </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="forgot-form text-center">
    <img src="{{ asset('image/logg.png') }}" class="logo" alt="Logo">
    <h3 class="mb-4 fw-bold">Forgot Password</h3>

    {{-- Session status --}}
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        {{ $errors->first('email') }}
      </div>
    @endif

    <div class="mb-3 text-muted" style="font-size: 0.9rem;">
      Forgot your password? No problem. Just enter your email and we’ll send you a password reset link.
    </div>

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus value="{{ old('email') }}">
      </div>

      <button type="submit" class="btn btn-black w-100">Send Reset Link</button>
    </form>

    <div class="login-link mt-3">
      <small><a href="{{ route('login') }}">Back to login</a></small>
    </div>
  </div>
</body>
</html>
