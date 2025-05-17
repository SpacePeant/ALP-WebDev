@extends('base.base2')

@section('title', 'Blog')

@section('content')
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Blog</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"/>
    @vite(['resources/css/blog.css', 'resources/js/app.js'])
  </head>

  <body>

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


    <main>
      <section>
        <h3 class="articles-title">All articles</h3>
        
        <div class="grid" id="blogGrid">
          @foreach ($articles->take(6) as $article)
            <a href="{{ url('/articles/' . $article->id) }}" style="text-decoration: none; color: inherit;">
              <article>
                <img src="{{ asset('image/image_article/' . $article->filename) }}" alt="{{ $article->title }}">
                <h4>{{ $article->title }}</h4>
                <p>{{ $article->description }}</p>
              </article>
            </a>
          @endforeach
        </div>


        <div class="load-button">
          <button id="loadMoreBtn" data-offset="6">Load more</button>
        </div>
      </section>
    </main>

  </body>
  </html>
@endsection