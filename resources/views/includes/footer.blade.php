<style>
    /* FOOTER */

.footer {
  background-color: #fff;
  font-family: "Red Hat Text", sans-serif;
  color: #666;
}

.footer-container {
  margin: 0px 10px 0px 100px;
  padding: 50px 20px 20px 20px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 80px;
  align-items: flex-start;
}

.footer-about {
  max-width: 300px;
}
.footer-about img{
  width:120px;
  margin-bottom: 20px;
}

.footer-logo {
  width: 100px;
  margin-bottom: 20px;
}

.footer-about p {
  font-size: 16px;
  line-height: 1.6;
}

.footer-links h4,
.footer-contact h4 {
  font-size: 16px;
  color: #000;
  margin-bottom: 15px;
}

.footer-links ul,
.footer-contact ul {
  list-style: none;
  padding: 0;
}

.footer-links ul li,
.footer-contact ul li {
  margin-bottom: 10px;
  font-size: 15px;
}

.footer-links ul li a {
  color: #666;
  text-decoration: none;
}

.footer-links ul li a:hover {
  text-decoration: underline;
}

.footer-contact ul li i {
  margin-right: 10px;
}

.footer-bottom {
  text-align: center;
  margin-top: 40px;
  padding-top: 20px;
  padding-bottom: 15px;
  font-size: 14px;
  border-top: 1px solid #eee;
  background-color: #f7f7f7;
}

/* Responsive */
@media (max-width: 768px) {
  .footer-container {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 480px) {
  .footer-container {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .footer-about,
  .footer-links,
  .footer-contact {
    align-items: center;
  }
}
</style>

<footer class="footer">
      <div class="footer-container">
        <div class="footer-about">
          <img src="{{ asset('image/logo2.png') }}" alt="Logo" />
          <p>
            Brrrr is a store dedicated to offering innovative athletic footwear exclusively from Nike, inspiring both performance and style.
          </p>
        </div>
        <div class="footer-links">
          <h4>COMPANY</h4>
          <ul>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('blog') }}">Blog</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>SHOP</h4>
          <ul>
            <li><a href="{{ route('detail') }}">Collection</a></li>
            <li><a href="{{ route('order') }}">My Orders</a></li>
            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>CONTACT</h4>
          <ul>
            <li><i class="fa-regular fa-envelope"></i> brrrr@gmail.com</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>Copyright © 2025 Brrrr. All rights reserved.</p>
      </div>
    </footer>