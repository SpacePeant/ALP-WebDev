import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  const blogGrid = document.getElementById('blogGrid');

  if (!loadMoreBtn || !blogGrid) return;

  loadMoreBtn.addEventListener('click', () => {
    const offset = parseInt(loadMoreBtn.getAttribute('data-offset'));

    fetch(`/load-more-blogs?offset=${offset}`)
      .then(res => res.json())
      .then(blogs => {
        if (blogs.length === 0) {
          loadMoreBtn.textContent = "No more articles";
          loadMoreBtn.disabled = true;
          return;
        }

        blogs.forEach(blog => {
          const articleLink = document.createElement('a');
          articleLink.href = `/articles/${blog.id}`;
          articleLink.style.textDecoration = 'none';
          articleLink.style.color = 'inherit';
                
          const article = document.createElement('article');
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
      });
  });
});

