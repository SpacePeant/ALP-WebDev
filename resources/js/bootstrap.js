import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');

    if (carousel && nextBtn && prevBtn) {
        // Clone items for infinite loop effect
        const items = carousel.querySelectorAll('.carousel-item');
        items.forEach(item => {
            const clone = item.cloneNode(true);
            carousel.appendChild(clone);
        });

        // Scroll by one full item width (or container width)
        const scrollStep = carousel.offsetWidth;

        // Next / Prev manual scroll
        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: scrollStep, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -scrollStep, behavior: 'smooth' });
        });

        // Auto-scroll loop to the left
        setInterval(() => {
            carousel.scrollBy({ left: scrollStep, behavior: 'smooth' });

            // If scrolled past original + clones, reset
            if (carousel.scrollLeft >= carousel.scrollWidth / 2) {
                carousel.scrollTo({ left: 0 });
            }
        }, 5000);
    }
});
