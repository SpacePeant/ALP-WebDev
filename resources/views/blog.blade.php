@extends('base.base2')

@section('title', 'Blog')

@section('content')
{{-- @php
    $isAdmin = session()->has('user_id') && !session()->has('user_email');
@endphp --}}
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
  {{-- <?php
    // if (Session::has('user_id') && !Session::has('user_email')) {
    //     echo("admin");
    // }

    // if (Session::has('user_id') && Session::has('user_email')) {
    //    echo("customer");
    // }
  ?> --}}
  <body>
    
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        @foreach ($carouselImages as $index => $image)
          <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <img src="{{ asset('image/image_carousel/' . $image->filename) }}" class="d-block w-100" alt="Slide">
            <div class="carousel-caption d-none d-md-block">
              <h4>Release</h4>
              <h2>{{ $image->title1 }}</h2>
              <h2>{{ $image->title2 }}</h2>
                <p>{{ $image->description }}</p>
            </div>
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
        
          {{-- @if ($isAdmin)
            <div style="text-align: right; margin-bottom: 20px;">
              <button data-bs-toggle="modal" data-bs-target="#createArticleModal">Create Article</button>
            </div>
          @endif --}}

          <div class="grid" id="blogGrid">
            @foreach ($articles->take(6) as $article)
              <a href="{{ url('/articles/' . $article->id) }}" style="text-decoration: none; color: inherit; position: relative;">
                <article>
                  <div class="dots-container" tabindex="0" aria-label="More options" role="button" title="More options">
                    <div class="dots-menu" aria-hidden="true">⋮</div>
                    <div class="popup-menu" role="menu">
                      <button class="edit-btn" type="button" role="menuitem" onclick="event.stopPropagation(); alert('Edit article {{ $article->id }}');">Edit</button>
                      <button class="delete-btn" type="button" role="menuitem" onclick="event.stopPropagation(); alert('Delete article {{ $article->id }}');">Delete</button>
                    </div>
                  </div>
                  <img src="{{ asset('image/image_article/' . $article->filename) }}" alt="{{ $article->title }}">
                  <h4>{{ $article->title }}</h4>
                  <p>{{ $article->description }}</p>
                </article>
              </a>
            @endforeach
          </div>
          

        

        <!-- Edit Article Modal -->
        <div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form id="editArticleForm" enctype="multipart/form-data">
              @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Article</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="editArticleId" name="id">
                  <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" id="editTitle" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" id="editDescription" class="form-control" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label>Article</label>
                    <textarea name="article" id="editArticleText" class="form-control" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label>Image (optional)</label>
                    <input type="file" name="image" class="form-control">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- Edit Article Modal -->

        <div class="load-button">
          <button id="loadMoreBtn" data-offset="6">Load more</button>
        </div>
      </section>
    </main>

  </body>
  </html>
@endsection


