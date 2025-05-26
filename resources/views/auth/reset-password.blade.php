<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }
    .form-container {
      width: 100%;
      max-width: 500px;
      padding: 50px 40px;
      background-color: #fff;
      border-radius: 20px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
    }
    .form-container .logo {
      width: 60px;
      display: block;
      margin: 0 auto 25px;
    }
    .form-container h4 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 20px;
    }
    .form-container .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      padding: 12px;
      font-weight: 500;
    }
    .form-container .form-control {
      height: 48px;
      border-radius: 10px;
    }
    .form-container .form-group {
      margin-bottom: 20px;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="form-container text-center">
    <img src="{{ asset('image/logg.png') }}" class="logo" alt="Logo">
    <h4>Reset Your Password</h4>

    @if ($errors->any())
      <div class="alert alert-danger text-start">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div class="form-group text-start">
        <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email', $request->email) }}">
      </div>
      <div class="form-group text-start">
        <input type="password" name="password" class="form-control" placeholder="New Password" required>
      </div>
      <div class="form-group text-start">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
      </div>

      <button type="submit" class="btn btn-black w-100">Reset Password</button>
    </form>
  </div>
</body>
</html>