<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Blog</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"/>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/blog.css', 'resources/js/app.js']); ?>

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

      <?php $__currentLoopData = $carouselImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
        <img src="<?php echo e(asset('image/image_carousel/' . $image->filename)); ?>" class="d-block w-100" alt="Slide">
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

  
  <main>
    <section>
      <h3 class="articles-title">All articles</h3>
      <div class="grid" id="blogGrid">
        <?php $__currentLoopData = $articles->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article>
            <img src="<?php echo e(asset('image/image_article/' . $article->filename)); ?>" alt="<?php echo e($article->title); ?>">
            <h4><?php echo e($article->title); ?></h4>
            <p><?php echo e($article->description); ?></p>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    
      <div class="load-button">
        <button id="loadMoreBtn" data-offset="6">Load more</button>
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
<?php /**PATH C:\Users\ASUS\Herd\webdev_week9_hw\resources\views/blog.blade.php ENDPATH**/ ?>