@extends('base.base1')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Wishlist</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Red Hat Text', sans-serif;
    }
    #my-wishlist-title {
      font-family: 'Playfair Display';
      margin-top:100px;
    }
    .iss{
      margin-top:100px;
    }
    #list-wishlist {
      width: 80%;
      margin-bottom: 100px;
    }
    .wishlist-item {
      padding: 20px 0;
      border-bottom: 1px solid #ccc;
      align-items: center;
    }
    .wishlist-item i{
      color:rgb(158, 22, 22);
    }
    .wishlist-img {
      width: 100px;
      /* Anda bisa tambahkan gambar produk di sini */
    }
    .wishlist-info h5 {
      margin: 0;
      font-weight: 400;
    }
    .wishlist-info p {
      margin: 0;
      color: #555;
    }
    .btn-view {
      background-color: black;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 0px;
    }
    .btn-view:hover {
      background-color: black;
      color: white;
    }
    .delete-icon {
      font-size: 24px;
      cursor: pointer;
      color: gray;
    }
    .delete-icon:hover {
      color: black;
    }
  </style>
</head>
<body>
  <div class="iss"></div>
  <h1 id="my-wishlist-title" class="fw-bold mb-3 my-5 mx-5">My Wishlist</h1>
  <div id="list-wishlist" class="container">
    @foreach ($wishlists as $item)
        <div class="row wishlist-item mb-3 pb-3 border-bottom align-items-center">
            <div class="col-auto">
                <i class="fas fa-trash delete-icon" data-product-id="{{ $item->product_id }}"></i>
            </div>
            <div class="col-auto">
                <img src="{{ asset('image/sepatu/kiri/' . $item->image_kiri) }}" class="wishlist-img" width="100">
            </div>
            <div class="col wishlist-info">
                <h5>{{ $item->name }}</h5>
            </div>
            <div class="col-auto">
                <a href="{{ url('detail_sepatu/' . $item->product_id) }}" class="btn btn-view">View Product</a>
            </div>
        </div>
        @endforeach
  </div>

  <script>
    document.querySelectorAll('.delete-icon').forEach(icon => {
      icon.addEventListener('click', function () {
        const productId = this.dataset.productId;
        const row = this.closest('.wishlist-item');
  
        fetch("{{ url('wishlist/delete') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(result => {
          if (result.success) {
            row.remove();
          } else {
            alert(result.message || "Gagal menghapus item dari wishlist.");
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
      });
    });
  </script>
</body>
</html>
@endsection