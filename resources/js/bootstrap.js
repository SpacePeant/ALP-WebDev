import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');
  
    if (carousel && nextBtn && prevBtn) {
      nextBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: carousel.offsetWidth, behavior: 'smooth' });
      });
  
      prevBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -carousel.offsetWidth, behavior: 'smooth' });
      });
  
      // Optional auto-scroll every 5 seconds
      setInterval(() => {
        carousel.scrollBy({ left: carousel.offsetWidth, behavior: 'smooth' });
      }, 5000);
    }
  });
  
