<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Blog</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"/>
  @vite(['resources/css/blog.css', 'resources/js/app.js'])

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
  {{-- <header>
    <nav>
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#" style="text-decoration: underline;">Blog</a>
      <a href="#">Collection</a>
      <a href="#">HAI</a>
    </nav>
    <h1>Blog</h1>
    <div class="header-icons">
      <button><i class="fas fa-sync-alt"></i></button>
      <button><i class="fas fa-shopping-cart"></i></button>
      <button><i class="fas fa-user"></i></button>
    </div>
  </header> --}}

  <!-- Header -->
<header class="header">
      <div class="logo">

      </div>
      <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="#">About</a>
        <a href="#">Blog</a>
        <a href="collection.php">Collection</a>
      </nav>
      <div class="icons">
        <a href=""><i data-feather="star"></i></a>
        <a href=""><i data-feather="shopping-cart"></i></a>
        <a href=""><i data-feather="user"></i></a>
      </div>
    </header>

    <header class="about-section">
  <div class="about-overlay">
    <h1>Blog</h1>
  </div>
</header>

  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
  <div class="carousel-inner">
    
    @foreach ($carouselImages as $index => $image)
    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
      <img src="{{ asset('image/image_carousel/' . $image->filename) }}" class="d-block w-100" alt="Slide">
    </div>
    @endforeach
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

  
</div>
  <main>
    <section>
      <h3 class="articles-title">All articles</h3>
      <div class="grid" id="blogGrid">
        <!-- Repeat this article block for each blog item -->
        <article>
          <img src="https://storage.googleapis.com/a1aa/image/5dd66e70-9a04-419d-1de0-6239ab683fe5.jpg" alt="Man with hat">
          <h4>Alexis Hanquinquant Wins Back-to-Back Gold in Paratriathlon</h4>
          <p>Alexis Hanquinquant has won his second consecutive gold in the Men's PTS4 race.</p>
        </article>

        <article>
          <img src="https://storage.googleapis.com/a1aa/image/b2a7179e-33ac-4305-7b1b-78b0fce3d0bb.jpg" alt="Basketball player">
          <h4>The LeBron XXII Applies the Pressure</h4>
          <p>The LeBron XXII features lockdown support for powerful movement in an agile design.</p>
        </article>

        <article>
          <img src="https://storage.googleapis.com/a1aa/image/b3ce2935-aa19-4f9a-7acc-1b901ee2c734.jpg" alt="Jordan shoes">
          <h4>Air Jordan V El Grito Pays Homage to Mexican Culture</h4>
          <p>Jordan Brand's latest release represents a shared identity and pride in Mexico.</p>
        </article>

        <!-- Add remaining articles as needed using the same format -->

      </div>

      <div class="load-button">
        <button id="loadMoreBtn" data-offset="3">Load more ...</button>
      </div>
    </section>
  </main>

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
