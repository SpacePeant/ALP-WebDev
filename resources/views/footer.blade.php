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
  gap: 40px;
  align-items: flex-start;
}

.footer-about {
  max-width: 300px;
}

.footer-logo {
  width: 100px;
  margin-bottom: 20px;
}

.footer-about p {
  font-size: 16px;
  line-height: 1.6;
}

.footer-about img {
    height: 30px;
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
          <img src="{{ asset('image/logo.png') }}" alt="New Arrivals" />
          <p>
            Brrr iku perusahaan sing adol macem-macem sepatu kaca sing bisa
            nggawe sampeyan ayu kaya Cinderella.
          </p>
        </div>
        <div class="footer-links">
          <h4>NDUKUNG</h4>
          <ul>
            <li><a href="#">Blog & Artikel Contact</a></li>
            <li><a href="#">Bagan Ukuran</a></li>
            <li><a href="#">Pengiriman & Retur</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>LAYANAN EKSKLUSIF</h4>
          <ul>
            <li><a href="#">Mriksa Pesenan</a></li>
            <li><a href="#">Brrrr Club</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>PERUSAHAAN</h4>
          <ul>
            <li><a href="#">Propile Kene</a></li>
            <li><a href="#">Sopo Awake Dewe?</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h4>CONTACT</h4>
          <ul>
            <li><i class="fa-brands fa-instagram"></i> brrrr</li>
            <li><i class="fa-regular fa-envelope"></i> brrrr@gmail.com</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>Copyright © 2025 Brrrr. All rights reserved.</p>
      </div>
    </footer>