<footer class="footer">
  <div class="section-container">
    <div class="footer-grid">
      <!-- Brand & Description -->
      <div class="footer-brand-section">
        <a href="/" class="logo mb-6">
          <span class="logo-icon">⛰️</span>
          <span class="logo-text text-white">MOUNTIX</span>
        </a>
        <p class="footer-description">
          Platform booking pendakian gunung di Indonesia yang aman, mudah, dan terpercaya. 
          Nikmati petualangan Anda tanpa ribet dengan sistem reservasi digital kami.
        </p>
        <div class="footer-socials">
          <a href="#" class="social-link" aria-label="Instagram">Instagram</a>
          <a href="#" class="social-link" aria-label="Facebook">Facebook</a>
          <a href="#" class="social-link" aria-label="Twitter">Twitter</a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="footer-links">
        <h3 class="footer-heading">Navigasi</h3>
        <ul class="footer-list">
          <li><a href="{{ route('home') }}" class="footer-link">Beranda</a></li>
          <li><a href="{{ route('gunung.index') }}" class="footer-link">Daftar Gunung</a></li>
          <li><a href="/#about" class="footer-link">Tentang Kami</a></li>
          <li><a href="#" class="footer-link">Bantuan & FAQ</a></li>
        </ul>
      </div>

      <!-- Services -->
      <div class="footer-links">
        <h3 class="footer-heading">Layanan</h3>
        <ul class="footer-list">
          <li><a href="#" class="footer-link">Booking Online</a></li>
          <li><a href="#" class="footer-link">Cek Kuota Jalur</a></li>
          <li><a href="#" class="footer-link">Verifikasi Manual</a></li>
          <li><a href="#" class="footer-link">E-Ticket Digital</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="footer-contact">
        <h3 class="footer-heading">Kontak Kami</h3>
        <ul class="footer-list">
          <li class="contact-item">
            <span class="contact-icon">📍</span>
            <span>Jl. Pendaki No. 123, Bandung, Jawa Barat</span>
          </li>
          <li class="contact-item">
            <span class="contact-icon">📞</span>
            <span>+62 812-3456-7890</span>
          </li>
          <li class="contact-item">
            <span class="contact-icon">✉️</span>
            <span>support@mountix.com</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} MOUNTIX. All rights reserved. Dibuat dengan ❤️ untuk pendaki Indonesia.</p>
    </div>
  </div>
</footer>
