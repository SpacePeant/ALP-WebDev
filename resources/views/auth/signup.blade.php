<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
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
  </style>
</head>
<body style="min-height: 100vh;" class="d-flex align-items-center justify-content-center">
  <div class="signup-form text-center">
    <img src="{{ asset('image/logg.png') }}" class="logo" alt="Nike Logo">
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

      <form method="POST" action="{{ route('signup.submit') }}">
        @csrf
        <div class="mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name" required>
        </div>
        <div class="mb-3">
          <input type="text" name="address" class="form-control" placeholder="Address" required>
        </div>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
          <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
          {{-- <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required> --}}
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-black w-100">Sign Up</button>
      </form>
    <div class="login-link mt-3">
      <small>Already have an account? <a href="{{ route('login') }}">Log in</a></small>
    </div>
  </div>

</body>
</html>