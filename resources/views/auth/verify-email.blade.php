<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verify Email</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  @vite(['resources/css/login.css'])
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }
    .verify-form {
      max-width: 450px;
      width: 100%;
      padding: 40px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    .verify-form .logo {
      width: 50px;
      margin: 0 auto 20px;
      display: block;
    }
    .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      padding: 10px;
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
  <div class="verify-form text-center">
    <img src="{{ asset('image/logg.png') }}" class="logo" alt="Logo">
    <h3 class="mb-4 fw-bold">Email Verification</h3>

    {{-- Pesan status --}}
    <div class="mb-3 text-sm text-muted">
      Thank you for signing up! Before you get started, please verify your email address through the link we sent to your email.
If you haven't received the email, we can resend it for you.
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="alert alert-success text-sm">
        A new verification link has been sent to your email address.
      </div>
    @endif

    {{-- Loader --}}
    <div id="loader" class="loader-overlay">
      <div class="loader"></div>
    </div>

    {{-- Form Resend Email --}}
    <form method="POST" id="resendForm" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="btn btn-black w-100 mb-3">Resend Verification Email</button>
    </form>

    {{-- Form Logout --}}
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-link text-decoration-none text-muted w-100">Back to login</button>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("resendForm");
      form.addEventListener("submit", function () {
        document.getElementById("loader").style.display = "flex";
      });
    });
  </script>
</body>
</html>
