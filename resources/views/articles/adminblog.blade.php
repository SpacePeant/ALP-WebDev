@extends('base.baseadmin')

@section('title', 'Blog')

@section('content')
@php
    $isAdmin = session()->has('user_id') && !session()->has('user_email');
@endphp
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Blog</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"/>
    <link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    @vite(['resources/css/AdminBlog.css', 'resources/js/app.js'])

  </head>

  <body>
    <main>
      <section>
        <h1 class="text-center mb-4" style="font-family: 'Playfair Display', serif;
  font-weight: 700;
  margin-bottom: 40px;
  margin-top:100px;
  text-align: center;">All Articles</h1>
        
         <div class="d-flex justify-content-start mb-4">
            <button id = "button-add"class="btn btn-dark btn-sm px-4 rounded-0" data-bs-toggle="modal" data-bs-target="#createArticleModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-1A6 6 0 1 1 8 2a6 6 0 0 1 0 12z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
              </svg>
              <span>Create Article</span>
            </button>
          </div>
          
          <div class="grid" id="blogGrid">
            @foreach ($articles as $article)
              <div class="article-card">
                <div class="dropdown-container custom-dropdown">
  <button class="custom-dropdown-toggle" onclick="event.stopPropagation(); toggleDropdown(this)">
    <i class="bi bi-three-dots-vertical"></i>
  </button>
  <div class="custom-dropdown-menu">
    <button
      class="custom-dropdown-button"
      data-bs-toggle="modal"
      data-bs-target="#editArticleModal"
      data-id="{{ $article->id }}"
      data-title="{{ $article->title }}"
      data-description="{{ $article->description }}"
      id = "edit"
      data-article="{{ $article->article }}"
      onclick="event.stopPropagation()">
      
      Edit
    </button>
    <form action="{{ route('articles.destroy', ['id' => $article->id]) }}" method="POST" onsubmit="return confirm('Delete this article?');" style="display: inline; ">
      @csrf
      @method('DELETE')
      <button
        type="submit"
        class="custom-dropdown-button custom-dropdown-delete"
        id = "delet"
        onclick="event.stopPropagation()">
        Delete
      </button>
    </form>
  </div>
</div>

<style>

/* Style the delete button red */
.custom-dropdown-button #delet {
  text-color:rgb(255, 0, 25);
  background-color: rgb(255, 255, 255); /* Bootstrap danger color */
  border: none;
  align-items : center;
}

#delet {
  color:rgb(255, 0, 25);
  background-color: rgb(255, 255, 255); /* Bootstrap danger color */
  border: none;
  align-items : center;
  text-align : center;
}

#edit{
  align-items : center;
  text-align : center;
}

.custom-dropdown-delete:hover {
  background-color: #c82333;
}
</style>

              
                {{-- Clickable article link --}}
                <a href="{{ url('/admin/articles/' . $article->id) }}" style="text-decoration: none; color: inherit;">
                  <article>
                    <img src="{{ asset('image/image_article/' . $article->filename) }}" alt="{{ $article->title }}">
                    <h4>{{ $article->title }}</h4>
                    <p>{{ $article->description }}</p>
                  </article>
                </a>
              </div>
            @endforeach
          </div>


        <!-- Modal -->
          <div class="modal fade" id="createArticleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">New Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label>Title</label>
                      <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label>Description</label>
                      <p>short description/hook for about the article</p>
                      <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label>Article</label>
                      <textarea name="article" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label>Image</label>
                      <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn text-white bg-black border-0 rounded-0">Submit</button>
                    <button type="button" class="btn text-white bg-black border-0 rounded-0" data-bs-dismiss="modal">Close</button>

                  </div>
                </div>
              </form>
            </div>
          </div>

        

        <!-- Edit Article Modal -->
        <div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
            <form id="editArticleForm" enctype="multipart/form-data">
              @csrf
              @method('PUT')
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
                  <button type="submit" class="btn text-white bg-black border-0 rounded-0">Update</button>
                    <button type="button" class="btn text-white bg-black border-0 rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <script>
          function toggleDropdown(button) {
            const dropdownMenu = button.nextElementSibling;
            const isShown = dropdownMenu.style.display === 'block';

            // Close all open dropdowns first
            document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
          
            // Toggle current
            if (!isShown) {
                dropdownMenu.style.display = 'block';
            }
          
            // Close dropdowns if clicked outside
            document.addEventListener('click', function handleOutsideClick(e) {
                if (!button.parentElement.contains(e.target)) {
                    dropdownMenu.style.display = 'none';
                    document.removeEventListener('click', handleOutsideClick);
                }
            });
          }

            const editModal = document.getElementById('editArticleModal');
            editModal.addEventListener('show.bs.modal', event => {
              const button = event.relatedTarget;
            
              // Get data from button
              const id = button.getAttribute('data-id');
              const title = button.getAttribute('data-title');
              const description = button.getAttribute('data-description');
              const article = button.getAttribute('data-article');
            
              // Fill modal fields
              document.getElementById('editArticleId').value = id;
              document.getElementById('editTitle').value = title;
              document.getElementById('editDescription').value = description;
              document.getElementById('editArticleText').value = article;
            });

        </script>

        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const editForm = document.getElementById('editArticleForm');
            const errorBox = document.createElement('div');
            errorBox.className = 'alert alert-danger d-none';
            editForm.prepend(errorBox);
          
            const successBox = document.createElement('div');
            successBox.className = 'alert alert-success d-none';
            editForm.prepend(successBox);
          
            // Populate modal when Edit is clicked
            document.querySelectorAll('.btn-edit').forEach(button => {
              button.addEventListener('click', () => {
                document.getElementById('editArticleId').value = button.dataset.id;
                document.getElementById('editTitle').value = button.dataset.title;
                document.getElementById('editDescription').value = button.dataset.description;
                document.getElementById('editArticleText').value = button.dataset.article;
                errorBox.classList.add('d-none');
                successBox.classList.add('d-none');
              });
            });
          
            // Handle form submission
            editForm.addEventListener('submit', async function (e) {
              e.preventDefault();
            
              const formData = new FormData(this);
              const articleId = formData.get('id');
            
              try {
                const response = await fetch(`/admin/articles/${articleId}`, {
                  method: 'POST', // Use POST for Laravel with _method = PUT
                  headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                  },
                  body: formData
                });
              
                if (!response.ok) {
                  const data = await response.json();
                  let message = data.message || 'Update failed.';
                  if (data.errors) {
                    message += '\n' + Object.values(data.errors).flat().join('\n');
                  }
                  errorBox.textContent = message;
                  errorBox.classList.remove('d-none');
                  return;
                }
              
                successBox.textContent = 'Article edited successfully!';
                successBox.classList.remove('d-none');
                errorBox.classList.add('d-none');
                setTimeout(() => location.reload(), 1500);
              
              } catch (err) {
                console.error(err);
                errorBox.textContent = 'Something went wrong. Please try again.';
                errorBox.classList.remove('d-none');
              }
            });
          });
        </script>




      </section>
    </main>

  </body>
  </html>
@endsection

