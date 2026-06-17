<section class="hero">
  <div class="hero-background">
    <img 
      src="{{ asset('storage/gunung/hero/hero-gunung.jpg') }}"
      alt="Mountain landscape"
      class="hero-image"
    >
    <div class="hero-overlay"></div>
  </div>

  <div class="hero-content">
    <div class="hero-inner">

      <!-- Eyebrow Label -->
      <div class="hero-eyebrow">
        <span class="eyebrow-dot"></span>
        Platform Booking Pendakian Terbaik.
      </div>

      <!-- Main Heading -->
      <h1 class="hero-title">
        Booking Pendakian Gunung<br>
        <span class="highlight">Impian Anda</span>
      </h1>

      <!-- Trust Badges (replaces plain text subtitle) -->
      <div class="hero-badges">
        <span class="hero-badge">
          <span class="badge-icon">⚡</span> Cepat
        </span>
        <span class="hero-badge">
          <span class="badge-icon">🔒</span> Aman
        </span>
        <span class="hero-badge">
          <span class="badge-icon">✅</span> Terpercaya
        </span>
      </div>

      <!-- Description -->
      <p class="hero-description">
        Temukan jalur terbaik dari seluruh gunung di Pulau Jawa. Kelola booking, 
        peserta, dan e-tiket — tanpa antri, tanpa ribet, cukup dari ponsel.
      </p>

      <!-- CTA Buttons -->
      <div class="hero-actions">
        <a href="/gunung" class="btn btn-hero-primary btn-lg" id="hero-cta-primary">
          Mulai Pendakianmu
          <span class="btn-arrow">→</span>
        </a>
        <a href="#gunungPopuler" class="btn btn-hero-ghost btn-lg" id="hero-cta-secondary">
          Lihat Gunung Populer
        </a>
      </div>
    </div>
  </div>

  <!-- Scroll Indicator -->
  <div class="hero-scroll" id="scrollIndicator">
    <span>Scroll untuk selengkapnya</span>
    <span class="scroll-arrow">↓</span>
  </div>
</section>

<script>
  document.getElementById('hero-cta-secondary').addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.getElementById('gunungPopuler');
    if (!target) return;
    const navbar = document.querySelector('.navbar');
    const offset = navbar ? navbar.offsetHeight : 0;
    const top = target.getBoundingClientRect().top + window.scrollY - offset - 16;
    window.scrollTo({ top, behavior: 'smooth' });
  });
</script>
