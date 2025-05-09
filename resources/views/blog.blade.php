<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Blog</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"/>
  @vite('resources/css/blog.css')


</head>
<body>
  <header>
    <nav>
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#" style="text-decoration: underline;">Blog</a>
      <a href="#">Collection</a>
    </nav>
    <h1>Blog</h1>
    <div class="header-icons">
      <button><i class="fas fa-sync-alt"></i></button>
      <button><i class="fas fa-shopping-cart"></i></button>
      <button><i class="fas fa-user"></i></button>
    </div>
  </header>

  <div class="scroll-carousel">
    <div class="scroll-track" id="carousel-track">
      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/aset_blog1.png') }}" alt="Running">
        <div class="carousel-caption-center" style="color: #ffffff;">
          <h2>Vomero Brings Maximum Cushioning</h2>
          <p>Vomero 18 introduces a new era of comfort.</p>
          <a href="#" style="color: #5E4E47;">View Collection →</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/aset_blog2.png') }}" alt="Basketball">
        <div class="carousel-caption-center" style="color: #8C1D1D;">
          <h2>Casual</h2>
          <p>Nike basketball shoes blend support and innovation.</p>
          <a href="#" style="color: #8C1D1D;">View Collection →</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/aset_blog3.png') }}" alt="Casual">
        <div class="carousel-caption-center" style="color: #303034;">
          <h2>Basketball</h2>
          <p>Nike casual shoes for everyday wear.</p>
          <a href="#" style="color: #303034;">View Collection →</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('image/image_carousel/training.png') }}" alt="Training">
        <div class="carousel-caption-center" style="color: #23AA97;">
          <h2>Training</h2>
          <p>Support and flexibility for all workouts.</p>
          <a href="#" style="color: #23AA97;">View Collection →</a>
        </div>
      </div>
    </div>
  </div>
  

  <main>
    <article class="highlight">
      <img src="https://storage.googleapis.com/a1aa/image/befa6ab1-ccbd-4baf-1a1e-4b42b1eaea8a.jpg" alt="Nike sneakers">
      <div class="text">
        <p style="font-size: 12px;">Release</p>
        <h2>Vomero Brings Maximum Cushioning to New Road Running Lineup</h2>
        <p style="font-size: 12px;">
          Vomero 18 introduces a new era of maximum cushioning for ultimate comfort,
          inviting athletes to run longer, go farther, push their limits and love every run.
        </p>
      </div>
    </article>

    <section>
      <h3 class="articles-title">All articles</h3>
      <div class="grid">
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
        <button>Loading more ...</button>
      </div>
    </section>
  </main>
</body>
</html>
