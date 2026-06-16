<footer class="footer">
  <div class="section-container">
    <div class="footer-grid">

      {{-- Brand --}}
      <div class="footer-brand-section">
        <a href="/" class="logo mb-4">
          <span class="logo-text text-white">MOUNTIX</span>
        </a>
        <p class="footer-description">
          Platform reservasi pendakian gunung di Pulau Jawa yang aman, mudah, dan terpercaya.
          Kelola booking, cek kuota jalur, dan dapatkan e-ticket digital langsung dari ponsel Anda.
        </p>
        <div class="footer-socials">
          <a href="https://www.instagram.com/malfrmnsyy/" class="social-link" aria-label="Instagram" target="_blank" rel="noopener">Instagram</a>
          <a href="https://web.facebook.com/bliyut.poll"  class="social-link" aria-label="Facebook"  target="_blank" rel="noopener">Facebook</a>
          <a href="https://github.com/Malfrmnsyhh"        class="social-link" aria-label="Github"    target="_blank" rel="noopener">GitHub</a>
        </div>
      </div>

      {{-- Navigasi --}}
      <div class="footer-links">
        <h3 class="footer-heading">Navigasi</h3>
        <ul class="footer-list">
          <li><a href="{{ route('home') }}"        class="footer-link">Beranda</a></li>
          <li><a href="{{ route('gunung.index') }}" class="footer-link">Daftar Gunung</a></li>
          <li><a href="{{ route('about') }}"        class="footer-link">Tentang Kami</a></li>
        </ul>
      </div>

      {{-- Kontak --}}
      <div class="footer-contact">
        <h3 class="footer-heading">Kontak Kami</h3>
        <ul class="footer-list">
          <li class="contact-item">
            <span class="contact-icon">📍</span>
            <span>Kec. Mojowarno, Kab. Jombang, Jawa Timur</span>
          </li>
          <li class="contact-item">
            <span class="contact-icon">📞</span>
            <span>+62 858-1310-5123</span>
          </li>
          <li class="contact-item">
            <span class="contact-icon">✉️</span>
            <span>muhakmal597@gmail.com</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} MOUNTIX &mdash; Platform Ticketing Pendakian Gunung</p>
    </div>
  </div>
</footer>
