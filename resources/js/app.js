import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  const blogGrid = document.getElementById('blogGrid');

  if (!loadMoreBtn || !blogGrid) return;

  let isLoading = false; // Protection flag

  loadMoreBtn.addEventListener('click', () => {
    if (isLoading) return; // Prevent double click
    isLoading = true;
    loadMoreBtn.disabled = true;

    const offset = parseInt(loadMoreBtn.getAttribute('data-offset'));

    fetch(`/load-more-blogs?offset=${offset}`)
      .then(res => res.json())
      .then(blogs => {
        if (blogs.length === 0) {
          loadMoreBtn.textContent = "No more articles";
          return;
        }

        blogs.forEach(blog => {
          // Avoid adding the same blog twice by checking for existing ID
          if (document.getElementById(`blog-${blog.id}`)) return;

          const articleLink = document.createElement('a');
          articleLink.href = `/articles/${blog.id}`;
          articleLink.style.textDecoration = 'none';
          articleLink.style.color = 'inherit';

          const article = document.createElement('article');
          article.id = `blog-${blog.id}`;
          article.innerHTML = `
            <img src="${blog.image_url}" alt="${blog.title}">
            <h4>${blog.title}</h4>
            <p>${blog.excerpt}</p>
          `;

          articleLink.appendChild(article);
          blogGrid.appendChild(articleLink);
        });

        loadMoreBtn.setAttribute('data-offset', offset + blogs.length);
      })
      .catch(error => {
        console.error("Failed to load more blogs:", error);
      })
      .finally(() => {
        isLoading = false;
        if (loadMoreBtn.textContent !== "No more articles") {
          loadMoreBtn.disabled = false;
        }
      });
  });
});

function openEditModal(id) {
    $.get(`/articles/${id}/edit`, function(data) {
        $('#editArticleId').val(data.id);
        $('#editTitle').val(data.title);
        $('#editDescription').val(data.description);
        $('#editArticleText').val(data.article);
        $('#editArticleModal').modal('show');
    });
}

$('#editArticleForm').on('submit', function(e) {
    e.preventDefault();
    let id = $('#editArticleId').val();
    let formData = new FormData(this);

    $.ajax({
        url: `/articles/${id}/update`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#editArticleModal').modal('hide');
            alert(response.message);
            location.reload();
        },
        error: function(err) {
            alert('Failed to update article');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const dotsContainers = document.querySelectorAll('.dots-container');

  function closeAllPopups(except = null) {
    dotsContainers.forEach(container => {
      if (container !== except) {
        container.querySelector('.popup-menu').classList.remove('show');
      }
    });
  }

  dotsContainers.forEach(container => {
    const popupMenu = container.querySelector('.popup-menu');

    // Toggle popup menu on click
    container.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const isShown = popupMenu.classList.contains('show');
      closeAllPopups(container);
      if (!isShown) {
        popupMenu.classList.add('show');
      } else {
        popupMenu.classList.remove('show');
      }
    });

    // Close popup on keyboard Escape key
    container.addEventListener('keydown', function (e) {
      if (e.key === "Escape") {
        popupMenu.classList.remove('show');
        container.blur();
      }
    });
  });

  // Close all popups if clicked outside
  document.addEventListener('click', function () {
    closeAllPopups();
  });
});
