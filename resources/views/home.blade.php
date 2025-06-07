@extends('base.base1')


@section('title', 'Home')


@section('content')


<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Carousel Grid Bootstrap</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Red+Hat+Text:wght@400;500&display=swap" rel="stylesheet">


    <style>
      * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Red Hat Text", sans-serif;
    }


#carouselExample{
  margin-top :100px;
}

/* CAROUSEL */


#carouselExample{
  margin-top :100px;
}


.haha {
  display: flex;
  margin: 0px 60px 20px 60px;
}


.besar {
  margin-right: 20px;
}


.kecil {
  margin-bottom: 20px;
}


.carousel-image-large {
  height: 100%;
  width: 100%;
  border-radius: 10px;
}


.carousel-image-small {
  height: auto;
  width: 100%;
  border-radius: 10px;
}


/* EMAIL ME */


.wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  margin-bottom: 50px;
}


.coupon-container {
  position: relative;
  background: #f5f5f5;
  padding: 40px;
  width: 70%;
  max-width: 1000px;
  border-radius: 10px;
  overflow: hidden;
}


.background-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-family: "Playfair Display", serif;
  font-size: 200px;
  color: #ddd;
  opacity: 0.3;
  white-space: nowrap;
  pointer-events: none;
  user-select: none;
  z-index: 0;
}


.content {
  position: relative;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 1;
}


.coupon-text h1 {
  font-size: 25px;
  margin: 0;
  color: #000;
  font-weight: bold;
}


.coupon-text p {
  font-size: 18px;
  color: #737373;
  margin-top: 10px;
}


.playfair {
  font-family: "Playfair Display", serif;
}


.email-button {
  background: #000;
  color: #fff;
  border: none;
  padding: 15px 30px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
}


/* NEW */


.newbrand {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  width: 100%;
}

.product-container {
  position: relative;
  background: #f5f5f5;
  padding: 40px;
  width: 100%;
  overflow: hidden;
  transition: 0.7s;
  max-height: 500px;
}

.product-container::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background-color: {{ $newestProduct->color_code_bg }};
  opacity: 0;
  transition: opacity 0.7s ease;
  z-index: 0;
}

.product-container:hover::before {
  opacity: 0.8;
}

.product-container > * {
  position: relative;
  z-index: 1;
}

.product-container:hover .bekatas,
.product-container:hover .bekbawah {
  color: #000;
  transition: 0.7s;
}

.product-container:hover .product-info h2 {
  color: {{ $newestProduct->color_font }};
  transition: 0.7s;
}

.bekatas,
.bekbawah {
  position: absolute;
  top: 80%;
  transform: translate(-50%, -50%);
  font-family: "Playfair Display", serif;
  font-size: 160px;
  color: #ddd;
  opacity: 0.3;
  white-space: nowrap;
  pointer-events: none;
  user-select: none;
  z-index: 0;
  transition: 0.7s;
}


.bekatas {
  position: absolute;
  top: 65px;
  margin-left: 250px;
}


.bekbawah {
  margin-left: 500px;
}


.product-content {
  position: relative;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 1;
}


.product-content {
  height: 100%;
  display: flex;
  align-items: center;
}
  
.product-image img {
  transition: transform 0.5s ease;
  transform-origin: center;
}

.product-container:hover .product-image img {
  transform: rotate(-20deg) scale(1.75);
}

.product-image img {
  width: auto;
  transform: scale(1.75);
  transform-origin: center;
  margin-left: 200px;
}


.product-info {
  text-align: right;
  margin-right: 100px;
  transition: 0.7s;
}


.product-info h2 {
  font-size: 32px;
  color: #555;
  font-weight: 700;
  margin-bottom: 20px;
  transition: 0.7s;
}


.shop-button {
  background: #000;
  color: #fff;
  border: none;
  padding: 15px 30px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease;
}


.shop-button:hover {
  background: #333;
}


/* KEPO */


.kepo {
  background-image: url("image/kepo.png");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  padding: 20px;
}


.cta-content {
  z-index: 2;
  color: #fff;
}


.cta-content h1 {
  font-size: 48px;
  font-weight: 800;
  margin: 60px;
}


.cta-button {
  background-color: #e26d5c;
  color: #fff;
  padding: 12px 30px;
  text-decoration: none;
  font-weight: 600;
  font-size: 16px;
  border-radius: 4px;
  transition: background 0.3s;
}


.cta-button:hover {
  background-color: #cf5a49;
}


/* Responsive */
@media (max-width: 768px) {
  .cta-content h1 {
    font-size: 32px;
  }


  .cta-button {
    padding: 10px 20px;
    font-size: 14px;
  }
}


.color-filter {
  margin-bottom: 20px;
}


.color-filter h3 {
  color: #e26d5c;
  border-left: 4px solid #e26d5c;
  padding-left: 8px;
  margin-bottom: 10px;
}


.colors {
  display: grid;
  grid-template-columns: repeat(6, 30px);
  gap: 10px;
}


.color {
  width: 30px;
  height: 30px;
  border: 1px solid #ccc;
  border-radius: 4px;
  cursor: pointer;
  transition: transform 0.2s;
}


.color::before {
  content: "";
  display: block;
  width: 100%;
  height: 100%;
  border-radius: 4px;
  background-color: inherit;
}


.color {
  background-color: var(--color, transparent);
}


.color:hover {
  transform: scale(1.1);
}


.background-area {
  margin-top: 30px;
  padding: 50px;
  background-color: #f5f5f5;
  text-align: center;
  transition: background-color 0.5s ease;
  border-radius: 8px;
}


.top-product h2{
      margin:30px 80px 20px 90px
}
.ttop-product h2{
      margin:30px 80px 20px 90px
}


    .product-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 240px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s, background-color 0.3s;
        position: relative;
    }


    .product-card img {
        max-width: 100%;
        height: auto;
        transform: rotate(-28deg);
        border-radius: 4px;
        transition: transform 0.3s ease-in-out;
    }


    .product-card:hover img {
        transform: rotate(0deg);
    }


.product-card:hover {
    background-color: var(--bg-color);
    color: var(--font-color);
}


.product-card:hover h3,
.product-card:hover p {
    color: var(--font-color);
}
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        background-color: var(--bg-color);
    }


    .product-card h3 {
        transition: all 0.3s ease;
        font-size: 18px;
        margin: 10px 0;
        color: inherit;
        color: #333;
    }


    .product-card p {
        transition: all 0.3s ease;
        font-size: 16px;
        color: #333;
    }
    .overflow-x-auto::-webkit-scrollbar {
    display: none;
}


.horizontal-scroll-wrapper, .horizontal-scroll-wrapperr {
  display: flex;
  gap: 100px;
  overflow-x: auto;
  padding: 1rem 40px;
  scroll-snap-type: x mandatory;
  margin: 0px 40px;
}


.horizontal-scroll-wrapperr{
  justify-content:center;
}


.horizontal-scroll-wrapper::-webkit-scrollbar,
.horizontal-scroll-wrapperr::-webkit-scrollbar {
  display: none;
}


.product-link {
  flex: 0 0 auto;
  width: 200px;
  scroll-snap-align: start;
  text-decoration:none;
}
.top-product {
    display: none;
  }
@media screen and (max-width: 1250px) {
  .top-product {
    display: block;
  }


  .ttop-product {
    display: none;
  }
}


.HUHU h5 {
  font-size: 20px;
}
.HUHU p {
  font-size: 16px;
}
#best h3{
  font-size: 32px;
}


/* Medium screen: max 1250px */
@media screen and (max-width: 1250px) {
  .HUHU h5 {
    font-size: 16px;
  }


  .HUHU p {
    font-size: 14px;
  }


  #best h3{
    font-size: 24px;
  }
  .product-info h2{
    font-size: 25px;
  }
}


/* Small screen: max 992px */
@media screen and (max-width: 992px) {
  .HUHU h5 {
    font-size: 14px;
  }


  .HUHU p {
    font-size: 13px;
  }


  #best h3{
    font-size: 20px;
  }
  .product-info h2{
    font-size: 20px;
  }
  .product-image img {
  margin-left: 110px;
  width: 200px;
}
.shop-button{
  font-size: 14px;
}
}


/* Extra small screen: max 700px */
@media screen and (max-width: 700px) {
  .HUHU h5 {
    font-size: 12px;
  }


  .HUHU p {
    font-size: 12px;
  }


  #best h3{
    font-size: 18px;
  }


  .coupon-text h1{
    font-size:20px;
  }
  .coupon-text p{
    font-size:15px;
  }
  .email-button{
    font-size:13px;
  }
  .product-info h2{
    font-size: 16px;
  }
  .product-image img {
  margin-left: 60px;
}
.shop-button{
  font-size: 10px;
  padding: 10px 30px;
}
}


/* Very small screens: max 500px */
@media screen and (max-width: 576px) {
  .HUHU h5 {
    font-size: 10px;
  }


  .HUHU p {
    font-size: 10px;
  }


  #best h3{
    font-size: 14px;
  }


  .coupon-text h1{
    font-size:17px;
  }
  .coupon-text p{
    font-size:12px;
  }
  .email-button{
    font-size:10px;
  }
  .product-info h2{
    font-size: 16px;
  }
  .product-image img {
  margin-left: 60px;
  width: 150px;
}
.shop-button{
  font-size: 6px;
  padding: 5px 20px;
}
}

@media (max-width: 500px) {
  .product-content {
    margin-right: -100px;
  }

  .product-image img {
    width: 110px;
    margin-left: 20px;
  }

  .product-info h2 {
    font-size: 13px;
    line-height: 1.2;
    margin: 0;
  }

  .shop-button {
    font-size: 10px;
    padding: 4px 12px;
    white-space: nowrap; /* Jangan pecah ke bawah */
  }
}
    </style>
    <!-- Bootstrap CSS -->
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Text:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>


    <div class="container my-5">
      <div
        id="carouselExample"
        class="carousel slide"
        data-bs-ride="carousel"
        data-bs-interval="2000"
      >
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="haha">
              <div class="besar">
                <a href="{{ route('detail') }}">
                <img
                  src="image/carohome1.png"
                  alt="Gambar 1"
                  class="carousel-image-large"
                />
                </a>
              </div>
              <div class="hihi">
                <div class="kecil">
                  <div class="">
                    <a href="{{ route('detail') }}">
                    <img
                      src="image/carohome4.png"
                      alt="Gambar 2"
                      class="carousel-image-small"
                    />
                    </a>
                  </div>
                </div>
                <div class="temankecil">
                  <div class="">
                    <a href="{{ route('detail') }}">
                    <img
                      src="image/carohome7.png"
                      alt="Gambar 3"
                      class="carousel-image-small"
                    />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="carousel-item">
            <div class="haha">
              <div class="besar">
                <a href="{{ route('detail') }}">
                <img
                  src="image/carohome2.png"
                  alt="Gambar 1"
                  class="carousel-image-large"
                />
              </a>
              </div>
              <div class="hihi">
                <div class="kecil">
                  <div class="">
                    <a href="{{ route('detail') }}">
                    <img
                      src="image/carohome5.png"
                      alt="Gambar 2"
                      class="carousel-image-small"
                    />
                    </a>
                  </div>
                </div>
                <div class="temankecil">
                  <div class="">
                    <a href="{{ route('detail') }}">
                    <img
                      src="image/carohome8.png"
                      alt="Gambar 3"
                      class="carousel-image-small"
                    />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="carousel-item">
            <div class="haha">
              <div class="besar">
                <a href="{{ route('detail') }}">
                <img
                  src="image/carohome3.png"
                  alt="Gambar 1"
                  class="carousel-image-large"
                />
                </a>
              </div>
              <div class="hihi">
                <div class="kecil">
                  <div class="">
                    <a href="{{ route('detail') }}">
                    <img
                      src="image/carohome6.png"
                      alt="Gambar 2"
                      class="carousel-image-small"
                    />
                    </a>
                  </div>
                </div>
                <div class="temankecil">
                  <div class="">
                    <a href="{{ route('detail') }}">
                    <img
                      src="image/carohome9.png"
                      alt="Gambar 3"
                      class="carousel-image-small"
                    />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    {{-- <div class="wrapper">
      <div class="coupon-container">
        <div class="background-text">10% OFF</div>


        <div class="content row">
          <div class="coupon-text col-8">
            <h1>10% OFF Discount Coupons</h1>
            <p>Subscribe us to get 10% OFF on all the purchases</p>
          </div>
          <button class="email-button col-3">EMAIL ME</button>
        </div>
      </div>
    </div> --}}


    <div class="newbrand">
      <div class="product-container">
        <div class="bekatas">NEW</div>
        <div class="bekbawah" style="padding-bottom: 40px">ITEM</div>
<div class="product-content d-flex align-items-center" style="height: 100%;">
  <div class="product-image me-4">
    <img src="{{ asset('image/sepatu/kiri/' . $newestProduct->image_kiri) }}" 
         alt="{{ $newestProduct->name }}" 
         class="img-fluid rotated-img" 
         style="max-height: 250px; object-fit: contain;" />
  </div>

  <div class="product-info">
    <h2>{{ $newestProduct->name }}</h2>
    <button class="shop-button" 
            onclick="window.location.href='{{ route('detail_sepatu.show', ['id' => $newestProduct->id]) }}'">
      SHOP NOW
    </button>
  </div>
</div>
      </div>
    </div>


    <div class="top-product flex flex-col items-center justify-center text-center mt-10 mb-5">
      <h2 class="text-xl font-bold mb-4" style = "margin-top: 60px;"><strong>Best Seller</strong></h2>
      <div class="horizontal-scroll-wrapper">
        @forelse ($topProduct as $related)
          <a href="{{ url('detail_sepatu/' . $related->product_id) }}" class="product-link">
            <div class="product-card"
              style="--bg-color: {{ $related->color_code_bg ?? '#fff' }}; --font-color: {{ $related->color_font ?? '#000' }};">
              <img src="{{ asset('image/sepatu/kiri/' . $related->image_kiri) }}"
                alt="{{ $related->product_name }}">
              <h3>{{ $related->product_name }}</h3>
              <p>Rp. {{ number_format($related->price, 0, ',', '.') }}</p>
            </div>
          </a>
        @empty
          <p>Tidak ada rekomendasi produk.</p>
        @endforelse
      </div>
    </div>


    <div class="ttop-product flex flex-col items-center justify-center text-center mt-10 mb-5">
      <h2 class="text-xl font-semibold mb-4" style = "margin-top: 60px;"><strong>Best Seller</strong></h2>
      <div class="horizontal-scroll-wrapperr">
        @forelse ($topProduct as $related)
          <a href="{{ url('detail_sepatu/' . $related->product_id) }}" class="product-link">
            <div class="product-card"
              style="--bg-color: {{ $related->color_code_bg ?? '#fff' }}; --font-color: {{ $related->color_font ?? '#000' }};">
              <img src="{{ asset('image/sepatu/kiri/' . $related->image_kiri) }}"
                alt="{{ $related->product_name }}">
              <h3>{{ $related->product_name }}</h3>
              <p>Rp. {{ number_format($related->price, 0, ',', '.') }}</p>
            </div>
          </a>
        @empty
          <p>No product recommendations available.</p>
        @endforelse
      </div>
    </div>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<div class="container py-5">
  <div class="row align-items-center">
    <!-- Gambar (satu gambar utuh) -->
    <div class="col-6 mb-4 mb-lg-0 text-center">
      <img src="{{ asset('image/huhah.png') }}" alt="Shoes" class="img-fluid rounded">
    </div>
    <div class="col-1 mb-4 mb-lg-0 text-center">
     
    </div>  
    <!-- Teks fitur -->
    <div class="col-5" id="best">
      <h3 class="fw-bold mb-4">DESIGNED TO<br>PERFORM</h3>


      <div class="mb-4 d-flex">
        <div class="me-3">
          <i class="bi bi-clock-history fs-3 text-dark"></i>
        </div>
        <div class="HUHU">
          <h5 class="fw-bold mb-1">All-Day Comfort</h5>
          <p class="mb-0">Soft insoles and breathable design keep feet fresh and comfy.</p>
        </div>
      </div>


      <div class="mb-4 d-flex">
        <div class="me-3">
          <i class="bi bi-link-45deg fs-3 text-dark"></i>
        </div>
        <div class="HUHU">
          <h5 class="fw-bold mb-1">Durable & Stylish</h5>
          <p class="mb-0">Built to last with looks that fit any style.</p>
        </div>
      </div>


      <div class="d-flex">
        <div class="me-3">
          <i class="bi bi-award fs-3 text-dark"></i>
        </div>
        <div class="HUHU">
          <h5 class="fw-bold mb-1">Premium Quality Materials</h5>
          <p class="mb-0">Made with top-tier materials for lasting wear.</p>
        </div>
      </div>
    </div>
  </div>
</div>


    <section class="kepo">
      <div class="cta-content">
        <h1>WANT TO KNOW US MORE?</h1>
        <a href="{{ route('about') }}" class="cta-button">EXPLORE NOW</a>
      </div>
    </section>


    <!-- Link FontAwesome buat icon -->
    <script
      src="https://kit.fontawesome.com/yourfontawesomekit.js"
      crossorigin="anonymous"
    ></script>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
      feather.replace();
    </script>
  </body>
</html>
@endsection
