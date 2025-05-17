@extends('base.base')

@section('title', 'About Us')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


  <title>About Us</title>
  <style>
    body {
      margin: 0;
      font-family: 'Red Hat Text', sans-serif;
    }

    /* OUR STORY Section */
    .story-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 80px 10%;
      gap: 40px;
      flex-wrap: wrap;
      margin-left: 50px;
    }

    .story-text {
      flex: 1;
      min-width: 280px;
      display: flex;
      flex-direction: column;
      position: relative; 
      padding-left: 60px; 
    }
    .story-text h2 {
      font-weight: 700;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .story-text::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background: #000;
    }

    .story-text h2::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background: #000;
    }

    .story-text p {
      color: #777;
      font-size: 18px;
      line-height: 1.6;
      margin: 0;
    }

    .story-images {
      margin-left: 20px;
      flex: 1;
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .story-slice {
      width: 100px;
      height: 230px;
      background-image: url('image/image_carousel/ourstory.png') ; /* ganti dengan gambar kamu */
      background-size: cover;
      background-position: center;
    }

    .story-slice.left {
      border-top-left-radius: 30px;
      border-bottom-left-radius: 30px;
      background-position: left center;
    }

    .story-slice.center {
      background-position: center center;
    }

    .story-slice.right {
      border-top-right-radius: 30px;
      border-bottom-right-radius: 30px;
      background-position: right center;
    }


    /* OUR MISSION with background image */
    .mission-section {
      background: url('image/image_carousel/bg_mission.png') no-repeat center center;
      background-size: cover;
      padding: 230px 10%;
      padding-bottom: 100px;
      text-align: center;
      color: #000;
      position: relative;
    }

    .mission-content h2 {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 80px;
    }

        .mission-cards {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      padding: 0 10%;
    }

    .mission-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      padding: 40px 25px;
      width: 220px; /* Lebar card lebih pendek */
      height: 300px; /* Lebih panjang */
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center; /* Menyusun isi card ke tengah vertikal */
    }

.mission-card .icon {
  font-size: 32px;
  margin-bottom: 20px;
  color: #000;
}

.mission-card h3 {
  font-size: 18px;
  font-weight: 800;
  margin-bottom: 12px;
  color: #000;
  line-height: 1.4;
}

.mission-card p {
  font-size: 14px;
  color: #888;
  line-height: 1.5;
  max-width: 240px;
  margin: 0 auto; /* Menyusun paragraf ke tengah secara horizontal */
}

    /* OUR VISION with background image */
    .vision-section {
    background: url('image/image_carousel/bg_vision.png') no-repeat center center;
    background-size: 100% 408px;
    height: 408px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #000;
    margin-top: -110px;
    padding-bottom: -100px;
    }

    .vision-section h2 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    }

    .vision-section p {
    font-size: 16px;
    color: #444;
    max-width: 400px;
    margin: 0 auto;
    }

.stats-overlay {
  position: relative;
  top: -50px; /* posisi naik, adjust sesuai kebutuhan */
  z-index: 2;
}

.stats-overlay .row {
  margin-left: auto;
  margin-right: auto;
  max-width: 1140px; /* biar rata dengan konten lain */
}



    /* Responsive */
    @media (max-width: 768px) {
      .story-section {
        flex-direction: column;
        text-align: center;
      }

      .story-text h2::before {
        display: none;
      }

      .story-images {
        justify-content: center;
        flex-direction: column;
      }

      .mission-cards {
        flex-direction: column;
        align-items: center;
      }
    }

    /* quotes */

    .quote-section {
      background: url('image/quotes.png') no-repeat center center;
      background-size: cover;
      height: 500px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      text-align: center;
      color: white;
    }

    .quote-text {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 600;
      max-width: 800px;
      position: relative;
      padding: 0 20px;
    }

    .quote-text::before,
    .quote-text::after {
      font-size: 48px;
      color: white;
      position: absolute;
    }

    .quote-text::before {
      content: "“";
      left: -40px;
      top: -20px;
    }

    .quote-text::after {
      content: "”";
      right: -40px;
      bottom: -20px;
    }

    @media (max-width: 768px) {
      .quote-text {
        font-size: 24px;
      }

      .quote-text::before,
      .quote-text::after {
        font-size: 36px;
      }

      .quote-text::before {
        left: -20px;
      }

      .quote-text::after {
        right: -20px;
      }

        .story-section {
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        margin-left: 0;
      }

      .story-text {
        padding-left: 0;
        text-align: center;
      }

      .story-text::before {
        display: none;
      }

      .story-images {
        flex-direction: row;
        flex-wrap: nowrap;
        gap: 5px;
        overflow-x: auto;
      }

      .story-slice {
        flex: 0 0 auto;
        width: 90px;
        height: 200px;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 15px !important;
      }
        .vision-section {
          background-size: cover !important;
          background-position: center center !important;
          height: auto;
          padding: 100px 20px;
      }
    }

  </style>
</head>
<body>

  <!-- Our Story section -->
  <section class="story-section">
  <div class="story-text">
    <h2>OUR STORY</h2>
    <p>
      Brrr iku perusahaan sing dodolan macem-macem sepatu kaca sing bisa nggawe sampeyan ayu kaya Cinderella.
    </p>
  </div>
  <div class="story-images">
    <div class="story-slice left"></div>
    <div class="story-slice center"></div>
    <div class="story-slice right"></div>
  </div>
</section>


  <!-- Our Mission Section -->
  <section class="mission-section">
    <div class="mission-content">
      <h2>OUR MISSION</h2>
      <div class="mission-cards">
        <div class="mission-card">
        <div class="icon"><i class="bi bi-geo-alt"></i></div>
          <h3>Empower <br>Every Step</h3>
          <p>Deliver shoes that inspire movement and boost confidence</p>
        </div>
        <div class="mission-card">
        <div class="icon"><i class="bi bi-bar-chart-fill"></i></div>
          <h3>Innovate <br>With Style</h3>
          <p>Blend performance, comfort, and bold design</p>
        </div>
        <div class="mission-card">
        <div class="icon"><i class="bi bi-send"></i></div>
          <h3>Support Planet</h3>
          <p>Promote inclusivity and eco-friendly practices</p>
        </div>
      </div>
    </div>
  </section>

  <div class="stats-overlay container-fluid px-3">
  <div class="row bg-black text-white text-center py-4">
    <div class="col-6 col-md-3 mb-3 mb-md-0">
      <h3 class="fw-bold mb-0">60+</h3>
      <p class="mb-0">Years Exp.</p>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
      <h3 class="fw-bold mb-0">100K+</h3>
      <p class="mb-0">Happy Clients</p>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
      <h3 class="fw-bold mb-0">200+</h3>
      <p class="mb-0">Achievements</p>
    </div>
    <div class="col-6 col-md-3">
      <h3 class="fw-bold mb-0">79K+</h3>
      <p class="mb-0">Professionals</p>
    </div>
  </div>
</div>


  <!-- Our Vision Section -->
  <section class="vision-section">
    <h2>OUR VISION</h2>
    <p>
      To inspire movement and confidence in every step, through bold design and accessible innovation for all
    </p>
  </section>

  <!-- quotes -->
  <section class="quote-section">
    <div class="quote-text">
      <i>Tetaplah Menyerah dan <br> Janganlah Berusaha</i>
    </div>
  </section>

</body>
</html>
@endsection