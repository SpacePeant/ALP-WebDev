@extends('base.base1')

@section('title', 'Home')

@section('content') 

@php
    $user_id = $user_id ?? null;
@endphp


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
      body {
        margin: 0;
        font-family: "Segoe UI", sans-serif;
        background-color: #ffffff;
        color: #333;
      }

      .new-arrivals-banner img {
        width: 100%;
        height: auto;
        display: block;
      }

      .product-list {
        display: flex;
        justify-content: center;
        gap: 40px;
        padding: 60px 220px;
        flex-wrap: wrap;
        background-color: #ffffff;
      }

      .product-card {
        background-color: #fff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        width: 240px;
        transition: transform 0.3s ease;
      }

      .product-card:hover {
        transform: translateY(-8px);
      }

      .product-card img {
        width: 200px;
        height: auto;
        margin-bottom: 20px;
      }

      .product-card h5 {
        margin: 10px 0 5px;
        font-weight: 600;
      }

      .product-card p {
        color: #888;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <section class="new-arrivals-banner">
      <img src="{{ asset('images/newarr.png') }}" alt="New Arrivals" />
    </section>

    <!-- Product List -->
    <section class="product-list">
      <div class="product-card">
        <img src="https://via.placeholder.com/200x120?text=City" alt="CITY" />
        <h5>CITY</h5>
        <p>Rp. 1.549.000,00</p>
      </div>
      <div class="product-card">
        <img
          src="https://via.placeholder.com/200x120?text=Alphafly+3"
          alt="Alphafly 3"
        />
        <h5>Alphafly 3</h5>
        <p>Rp. 4.089.000,00</p>
      </div>
      <div class="product-card">
        <img
          src="https://via.placeholder.com/200x120?text=Vaporfly+4"
          alt="Vaporfly 4"
        />
        <h5>Vaporfly 4</h5>
        <p>Rp. 3.899.000,00</p>
      </div>
    </section>

    <section class="new-arrivals-banner">
      <img src="{{ asset('images/newarr.png') }}" alt="New Arrivals" />
    </section>

    <!-- Product List -->
    <section class="product-list">
      <div class="product-card">
        <img src="https://via.placeholder.com/200x120?text=City" alt="CITY" />
        <h5>CITY</h5>
        <p>Rp. 1.549.000,00</p>
      </div>
      <div class="product-card">
        <img
          src="https://via.placeholder.com/200x120?text=Alphafly+3"
          alt="Alphafly 3"
        />
        <h5>Alphafly 3</h5>
        <p>Rp. 4.089.000,00</p>
      </div>
      <div class="product-card">
        <img
          src="https://via.placeholder.com/200x120?text=Vaporfly+4"
          alt="Vaporfly 4"
        />
        <h5>Vaporfly 4</h5>
        <p>Rp. 3.899.000,00</p>
      </div>
      <div class="product-card">
        <img src="https://via.placeholder.com/200x120?text=City" alt="CITY" />
        <h5>CITY</h5>
        <p>Rp. 1.549.000,00</p>
      </div>
      <div class="product-card">
        <img
          src="https://via.placeholder.com/200x120?text=Alphafly+3"
          alt="Alphafly 3"
        />
        <h5>Alphafly 3</h5>
        <p>Rp. 4.089.000,00</p>
      </div>
      <div class="product-card">
        <img
          src="https://via.placeholder.com/200x120?text=Vaporfly+4"
          alt="Vaporfly 4"
        />
        <h5>Vaporfly 4</h5>
        <p>Rp. 3.899.000,00</p>
      </div>
    </section>

    <section class="new-arrivals-banner">
      <a href="collection_detail.php">
        <img src="{{ asset('images/coll.png') }}" alt="New Arrivals" />
      </a>
    </section>

  </body>
</html>
@endsection