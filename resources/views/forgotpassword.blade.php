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
    .resetpass-form {
      max-width: 400px;
      width: 100%;
      padding: 40px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    .resetpass-form .logo {
      width: 50px;
      margin: 0 auto 20px;
      display: block;
    }
    .resetpass-form .form-control {
      height: 45px;
      border-radius: 10px;
    }
    .resetpass-form .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      padding: 10px;
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
<body style="min-height: 100vh;" class="d-flex align-items-center justify-content-center">
  <div class="resetpass-form text-center">
    <img src="{{ asset('image/logo.png') }}" class="logo" alt="Nike Logo">
    <h3 class="fw-bold">Reset Password</h3>
    <small>We'll email you a link to reset your password</small>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <div id="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>

    <form method="POST" id="forgotForm">
        @csrf
      <div class="mt-4 mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <button type="submit" class="btn btn-black w-100">Send Email</button>
    </form>
  </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("forgotForm");
      form.addEventListener("submit", function () {
        document.getElementById("loader").style.display = "flex";
      });
    });

     document.getElementById('forgotForm').addEventListener('submit', function(e) {
    e.preventDefault(); 

    window.location.href = "{{ route('login') }}";
  });
  </script>

</html>