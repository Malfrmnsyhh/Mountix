# 🛠️ IMPLEMENTATION GUIDE - LANGKAH DEMI LANGKAH
## Mountix Frontend Refactor

---

## 📋 PRE-IMPLEMENTATION CHECKLIST

Sebelum mulai coding, pastikan:

- [ ] Read `instruksi.md` - main instruction file
- [ ] Read `design-specifications.md` - untuk styling details
- [ ] Backup existing files (git commit kalo pakai git)
- [ ] Understand current Laravel Blade template structure
- [ ] Identify which Blade file untuk homepage (likely `resources/views/index.blade.php` or `resources/views/home.blade.php`)
- [ ] Check if project uses Tailwind CSS atau custom CSS
- [ ] Identify CSS file location (likely `resources/css/app.css` or `public/css/style.css`)
- [ ] Identify JavaScript location (likely `resources/js/app.js` or `public/js/script.js`)

---

## 🚀 PHASE 1: NAVBAR/HEADER REFACTOR

### Step 1.1: Update HTML Structure di Blade Template

**File**: `resources/views/components/navbar.blade.php` (create if doesn't exist)

```blade
<header class="navbar">
  <!-- Logo Section -->
  <div class="navbar-brand">
    <a href="/" class="logo">
      <span class="logo-icon">⛰️</span>
      <span class="logo-text">MOUNTIX</span>
    </a>
  </div>

  <!-- Main Navigation -->
  <nav class="navbar-menu" id="navbarMenu">
    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
    <a href="/gunung" class="nav-link {{ request()->is('gunung') ? 'active' : '' }}">Gunung</a>
    <a href="#about" class="nav-link">Tentang Kami</a>
  </nav>

  <!-- Auth Controls -->
  <div class="navbar-actions">
    <!-- GUEST STATE -->
    @guest
    <div class="auth-guest" id="authGuest">
      <a href="/login" class="btn btn-secondary">Masuk</a>
      <a href="/register" class="btn btn-primary">Daftar</a>
    </div>
    @endguest

    <!-- AUTHENTICATED STATE -->
    @auth
    <div class="auth-user" id="authUser">
      <a href="/profile?tab=booking" class="nav-link">
        <span>🗓️</span>
        <span>Booking Saya</span>
      </a>
      <div class="dropdown">
        <button class="btn btn-profile" id="profileBtn">
          <span class="user-avatar">👤</span>
          <span class="user-name">{{ auth()->user()->name }}</span>
          <span class="dropdown-icon">▼</span>
        </button>
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="/profile" class="dropdown-item">Profil Saya</a>
          <a href="/profile?tab=booking" class="dropdown-item">Booking Saya</a>
          <a href="/profile?tab=eticket" class="dropdown-item">E-Ticket Aktif</a>
          <hr class="dropdown-divider">
          <a href="/logout" class="dropdown-item danger">Keluar</a>
        </div>
      </div>
    </div>
    @endauth
  </div>

  <!-- Mobile Menu Toggle -->
  <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</header>
```

### Step 1.2: Tambahkan CSS untuk Navbar

**File**: `resources/css/app.css` (atau file CSS utama kamu)

```css
/* ==================== NAVBAR STYLES ==================== */

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: var(--spacing-4) var(--spacing-6);
  background-color: var(--bg-primary);
  border-bottom: 1px solid var(--border-color);
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: var(--shadow-sm);
}

.navbar-brand {
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
  flex-shrink: 0;
  min-width: max-content;
}

.logo {
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
  text-decoration: none;
  font-weight: 700;
  font-size: var(--text-xl);
  color: var(--primary-dark);
  transition: color 0.2s;
}

.logo:hover {
  color: var(--primary-main);
}

.logo-icon {
  font-size: 24px;
}

.navbar-menu {
  display: flex;
  gap: var(--spacing-8);
  align-items: center;
  margin: 0 auto;
}

.nav-link {
  text-decoration: none;
  color: var(--gray-800);
  font-size: var(--text-base);
  font-weight: 500;
  transition: all 0.2s;
  position: relative;
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
}

.nav-link:hover {
  color: var(--primary-main);
}

.nav-link.active {
  color: var(--primary-main);
}

.nav-link.active::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  right: 0;
  height: 2px;
  background-color: var(--primary-main);
}

.navbar-actions {
  display: flex;
  align-items: center;
  gap: var(--spacing-4);
}

/* ==================== BUTTON STYLES ==================== */

.btn {
  padding: var(--spacing-2) var(--spacing-4);
  border-radius: var(--radius-md);
  border: none;
  font-size: var(--text-sm);
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
}

.btn:hover:not(:disabled) {
  transform: translateY(-2px);
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-primary {
  background-color: var(--accent-main);
  color: white;
  box-shadow: 0 2px 8px rgba(0, 168, 107, 0.2);
}

.btn-primary:hover:not(:disabled) {
  background-color: var(--accent-hover);
  box-shadow: 0 6px 20px rgba(0, 168, 107, 0.4);
}

.btn-secondary {
  background-color: transparent;
  color: var(--primary-main);
  border: 2px solid var(--primary-main);
}

.btn-secondary:hover:not(:disabled) {
  background-color: var(--primary-light);
  color: white;
  border-color: var(--primary-light);
}

/* ==================== DROPDOWN MENU ==================== */

.dropdown {
  position: relative;
}

.btn-profile {
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
  background-color: var(--gray-100);
  color: var(--gray-900);
  border: 1px solid var(--border-color);
  padding: var(--spacing-2) var(--spacing-3);
  cursor: pointer;
}

.btn-profile:hover {
  background-color: var(--gray-50);
  border-color: var(--primary-main);
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: var(--primary-light);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
}

.user-name {
  font-weight: 600;
  max-width: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.dropdown-icon {
  font-size: 12px;
  transition: transform 0.2s;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  margin-top: var(--spacing-2);
  background-color: var(--bg-primary);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  min-width: 200px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.2s;
  pointer-events: none;
}

.dropdown-menu.show {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
  pointer-events: auto;
}

.dropdown-item {
  display: block;
  padding: var(--spacing-3) var(--spacing-4);
  color: var(--gray-800);
  text-decoration: none;
  font-size: var(--text-sm);
  transition: all 0.2s;
  cursor: pointer;
}

.dropdown-item:hover {
  background-color: var(--gray-100);
  color: var(--primary-main);
}

.dropdown-item.danger:hover {
  background-color: #FEE2E2;
  color: var(--error);
}

.dropdown-divider {
  margin: var(--spacing-2) 0;
  border: none;
  border-top: 1px solid var(--border-color);
}

/* ==================== MOBILE MENU ==================== */

.navbar-toggle {
  display: none;
  flex-direction: column;
  background: none;
  border: none;
  cursor: pointer;
  gap: 4px;
  padding: 0;
}

.navbar-toggle span {
  width: 24px;
  height: 2px;
  background-color: var(--gray-900);
  transition: all 0.3s;
  display: block;
}

.navbar-toggle.active span:nth-child(1) {
  transform: rotate(45deg) translate(6px, 6px);
}

.navbar-toggle.active span:nth-child(2) {
  opacity: 0;
}

.navbar-toggle.active span:nth-child(3) {
  transform: rotate(-45deg) translate(6px, -6px);
}

/* ==================== RESPONSIVE DESIGN ==================== */

@media (max-width: 1023px) {
  .navbar-menu {
    gap: var(--spacing-6);
  }
}

@media (max-width: 767px) {
  .navbar {
    flex-wrap: wrap;
    padding: var(--spacing-4);
  }

  .navbar-brand {
    order: 1;
  }

  .navbar-toggle {
    display: flex;
    order: 3;
  }

  .navbar-menu {
    display: none;
    width: 100%;
    flex-direction: column;
    gap: var(--spacing-4);
    margin-top: var(--spacing-4);
    order: 4;
  }

  .navbar-menu.show {
    display: flex;
  }

  .navbar-actions {
    flex-direction: column;
    width: 100%;
    gap: var(--spacing-2);
    order: 2;
  }

  .auth-guest {
    display: flex;
    gap: var(--spacing-2);
    width: 100%;
  }

  .auth-guest .btn {
    flex: 1;
    padding: var(--spacing-2) var(--spacing-3);
  }

  .auth-user {
    width: 100%;
  }

  .nav-link {
    padding: var(--spacing-2) 0;
  }

  .nav-link.active::after {
    bottom: 0;
  }
}
```

### Step 1.3: Tambahkan JavaScript untuk Navbar Interactivity

**File**: `resources/js/navbar.js` (create new file)

```javascript
document.addEventListener('DOMContentLoaded', function() {
  // Mobile Menu Toggle
  const navbarToggle = document.getElementById('navbarToggle');
  const navbarMenu = document.getElementById('navbarMenu');

  if (navbarToggle && navbarMenu) {
    navbarToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      navbarToggle.classList.toggle('active');
      navbarMenu.classList.toggle('show');
    });

    // Close menu when clicking on a link
    const navLinks = navbarMenu.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        navbarToggle.classList.remove('active');
        navbarMenu.classList.remove('show');
      });
    });
  }

  // Dropdown Menu Toggle
  const profileBtn = document.getElementById('profileBtn');
  const dropdownMenu = document.getElementById('dropdownMenu');

  if (profileBtn && dropdownMenu) {
    profileBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdownMenu.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
      dropdownMenu.classList.remove('show');
    });

    // Prevent closing when clicking inside dropdown
    dropdownMenu.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }

  // Close menu when clicking outside
  document.addEventListener('click', function() {
    if (navbarToggle && navbarMenu) {
      navbarToggle.classList.remove('active');
      navbarMenu.classList.remove('show');
    }
  });

  // Active link indicator
  const currentPage = window.location.pathname;
  document.querySelectorAll('.nav-link').forEach(link => {
    if (link.getAttribute('href') === currentPage || 
        link.getAttribute('href') === '/' && currentPage === '/') {
      link.classList.add('active');
    }
  });
});
```

**Tambahkan di `resources/js/app.js` atau import file:**

```javascript
// app.js
import './navbar.js';
```

### Step 1.4: Include Component di Blade Template

**File**: `resources/views/layouts/app.blade.php` atau `resources/views/app.blade.php`

```blade
@include('components.navbar')

<main>
  @yield('content')
</main>
```

### Step 1.5: Test Navbar

- [ ] Navbar tampil dengan benar pada desktop
- [ ] Guest state (Masuk/Daftar buttons) tampil jika user tidak login
- [ ] Auth state (Booking Saya/Profile dropdown) tampil jika user login
- [ ] Mobile menu toggle berfungsi
- [ ] Dropdown menu buka dan tutup
- [ ] Links navigasi active indicator bekerja
- [ ] Mobile responsive view bagus

---

## 🎭 PHASE 2: HERO SECTION REDESIGN

### Step 2.1: Update Hero HTML

**File**: `resources/views/components/hero.blade.php` (create if doesn't exist)

```blade
<section class="hero">
  <div class="hero-background">
    <img 
      src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1920&q=80"
      alt="Mountain landscape hero"
      class="hero-image"
      loading="eager"
    >
    <div class="hero-overlay"></div>
  </div>

  <div class="hero-content">
    <div class="hero-inner">
      <h1 class="hero-title">
        Booking Pendakian Gunung <span class="highlight">Impian Anda</span>
      </h1>

      <p class="hero-subtitle">
        Cepat, Aman, Terpercaya
      </p>

      <p class="hero-description">
        Temukan jalur terbaik dari 50+ destinasi pendakian dan kelola booking Anda 
        dalam genggaman. Tanpa antri, tanpa ribet, cukup melalui ponsel Anda.
      </p>

      <div class="hero-actions">
        <a href="/gunung" class="btn btn-primary btn-lg">
          <span>🏔️</span>
          <span>Temukan Gunung Pilihan</span>
        </a>
        <button class="btn btn-secondary btn-lg" id="videoDemo">
          <span>▶️</span>
          <span>Tonton Demo</span>
        </button>
      </div>

      <div class="hero-trust">
        <div class="trust-item">
          <span class="trust-icon">✓</span>
          <span>2,500+ pendaki telah mempercayai Mountix</span>
        </div>
        <div class="trust-item">
          <span class="trust-icon">✓</span>
          <span>Garansi uang kembali 100%</span>
        </div>
        <div class="trust-item">
          <span class="trust-icon">✓</span>
          <span>Dukungan 24/7 siap membantu</span>
        </div>
      </div>
    </div>
  </div>

  <div class="hero-scroll" id="scrollIndicator">
    <span>Scroll untuk selengkapnya</span>
    <span class="scroll-arrow">↓</span>
  </div>
</section>
```

### Step 2.2: CSS untuk Hero Section

**File**: Tambahkan ke `resources/css/app.css`

```css
/* ==================== HERO SECTION ==================== */

.hero {
  position: relative;
  height: 100vh;
  min-height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.hero-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.hero-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    135deg,
    rgba(27, 94, 32, 0.5) 0%,
    rgba(0, 0, 0, 0.4) 50%,
    rgba(0, 0, 0, 0.3) 100%
  );
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: white;
  max-width: 700px;
  padding: var(--spacing-6);
  margin-top: -100px;
}

.hero-inner {
  animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-title {
  font-size: clamp(28px, 8vw, 48px);
  font-weight: 800;
  line-height: var(--line-height-tight);
  margin-bottom: var(--spacing-2);
  letter-spacing: var(--letter-spacing-tight);
}

.hero-title .highlight {
  color: var(--secondary-main);
  display: block;
}

.hero-subtitle {
  font-size: clamp(18px, 5vw, 28px);
  font-weight: 600;
  margin-bottom: var(--spacing-4);
  color: var(--secondary-light);
  letter-spacing: var(--letter-spacing-wide);
  text-transform: uppercase;
  opacity: 0.95;
}

.hero-description {
  font-size: clamp(14px, 3vw, 18px);
  line-height: var(--line-height-relaxed);
  margin-bottom: var(--spacing-8);
  color: rgba(255, 255, 255, 0.9);
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.hero-actions {
  display: flex;
  gap: var(--spacing-4);
  justify-content: center;
  margin-bottom: var(--spacing-12);
  flex-wrap: wrap;
}

.btn-lg {
  padding: var(--spacing-4) var(--spacing-8);
  font-size: var(--text-lg);
  gap: var(--spacing-2);
}

.hero .btn-primary {
  background-color: var(--accent-main);
  box-shadow: 0 4px 15px rgba(0, 168, 107, 0.3);
}

.hero .btn-primary:hover {
  background-color: var(--accent-hover);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 168, 107, 0.4);
}

.hero .btn-secondary {
  background-color: rgba(255, 255, 255, 0.15);
  border-color: white;
  color: white;
  backdrop-filter: blur(10px);
}

.hero .btn-secondary:hover {
  background-color: rgba(255, 255, 255, 0.25);
  border-color: var(--secondary-light);
}

/* Trust Badges */
.hero-trust {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-3);
  align-items: center;
  padding-top: var(--spacing-8);
  border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.trust-item {
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
  font-size: var(--text-sm);
  color: rgba(255, 255, 255, 0.85);
}

.trust-icon {
  color: var(--secondary-main);
  font-weight: bold;
  font-size: var(--text-lg);
  flex-shrink: 0;
}

/* Scroll Indicator */
.hero-scroll {
  position: absolute;
  bottom: var(--spacing-6);
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  color: white;
  cursor: pointer;
  animation: pulse 2s infinite;
  font-size: var(--text-sm);
}

.scroll-arrow {
  display: block;
  font-size: 20px;
  animation: bounce 2s infinite;
  margin-top: var(--spacing-2);
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(8px);
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 0.5;
  }
  50% {
    opacity: 1;
  }
}

/* Responsive Design */
@media (max-width: 1024px) {
  .hero {
    min-height: 400px;
  }

  .hero-title {
    font-size: 32px;
  }

  .hero-subtitle {
    font-size: 20px;
  }
}

@media (max-width: 767px) {
  .hero {
    min-height: 300px;
    align-items: flex-start;
    padding-top: 80px;
  }

  .hero-content {
    padding: var(--spacing-4);
    margin-top: 0;
  }

  .hero-title {
    font-size: 24px;
  }

  .hero-subtitle {
    font-size: 16px;
    margin-bottom: var(--spacing-3);
  }

  .hero-description {
    font-size: 14px;
    margin-bottom: var(--spacing-6);
  }

  .hero-actions {
    flex-direction: column;
    gap: var(--spacing-3);
    margin-bottom: var(--spacing-8);
  }

  .btn-lg {
    width: 100%;
    padding: var(--spacing-3) var(--spacing-6);
    font-size: var(--text-base);
  }

  .hero-trust {
    gap: var(--spacing-2);
    padding-top: var(--spacing-6);
  }

  .trust-item {
    font-size: var(--text-xs);
  }

  .hero-scroll {
    display: none;
  }
}
```

### Step 2.3: JavaScript untuk Hero Interactivity

**File**: `resources/js/hero.js` (create new file)

```javascript
document.addEventListener('DOMContentLoaded', function() {
  // Video Demo Button
  const videoDemo = document.getElementById('videoDemo');
  if (videoDemo) {
    videoDemo.addEventListener('click', () => {
      // Implement modal atau navigate ke demo
      alert('Video demo akan segera hadir');
    });
  }

  // Scroll Indicator
  const scrollIndicator = document.getElementById('scrollIndicator');
  if (scrollIndicator) {
    scrollIndicator.addEventListener('click', () => {
      const gununPopuler = document.querySelector('.gunung-populer');
      if (gununPopuler) {
        gununPopuler.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }

  // Parallax Effect (optional)
  window.addEventListener('scroll', () => {
    const hero = document.querySelector('.hero');
    if (hero) {
      const scrollTop = window.scrollY;
      const heroImage = hero.querySelector('.hero-image');
      if (heroImage && scrollTop < window.innerHeight) {
        heroImage.style.transform = `translateY(${scrollTop * 0.5}px)`;
      }
    }
  });
});
```

**Include di `resources/js/app.js`:**

```javascript
import './hero.js';
```

### Step 2.4: Include Component di HomePage

**File**: `resources/views/index.blade.php` atau homepage template kamu

```blade
@extends('layouts.app')

@section('content')
  @include('components.hero')
  <!-- Other sections akan ditambah di phase selanjutnya -->
@endsection
```

### Step 2.5: Test Hero Section

- [ ] Hero section tampil full screen
- [ ] Background image load dengan baik
- [ ] Text readable dan centered dengan baik
- [ ] CTA buttons responsive dan clickable
- [ ] Trust badges tampil dengan benar
- [ ] Mobile view: text ukuran sesuai, buttons stack vertical
- [ ] Scroll indicator berfungsi (smooth scroll)
- [ ] Parallax effect berfungsi (jika diimplementasikan)

---

## 🏔️ PHASE 3: GUNUNG POPULER SECTION

### Step 3.1: Create Mountain Card Component

**File**: `resources/views/components/mountain-card.blade.php` (create new)

```blade
<div class="mountain-card">
  <!-- Status Badge -->
  @php
    $badgeClass = 'tersedia';
    $badgeText = '✓ Tersedia';
    
    if ($gunung->kuota_sisa <= 5 && $gunung->kuota_sisa > 0) {
      $badgeClass = 'limited';
      $badgeText = '⚠️ Terbatas';
    } elseif ($gunung->kuota_sisa <= 0) {
      $badgeClass = 'soldout';
      $badgeText = '✗ Penuh';
    }
  @endphp

  <div class="card-badge {{ $badgeClass }}">
    {{ $badgeText }}
  </div>

  <!-- Card Image -->
  <div class="card-image">
    <img 
      src="{{ asset('storage/' . $gunung->image) }}"
      alt="{{ $gunung->nama }}"
      class="image"
      loading="lazy"
    >
    <div class="card-overlay"></div>
  </div>

  <!-- Card Content -->
  <div class="card-content">
    <!-- Header with Title & Rating -->
    <div class="card-header">
      <h3 class="card-title">{{ $gunung->nama }}</h3>
      <div class="card-rating">
        <span class="stars">
          @for ($i = 0; $i < 5; $i++)
            {{ $i < floor($gunung->rating) ? '★' : ($i < ceil($gunung->rating) ? '⯨' : '☆') }}
          @endfor
        </span>
        <span class="rating-value">{{ number_format($gunung->rating, 1) }}</span>
      </div>
    </div>

    <!-- Location -->
    <p class="card-location">
      📍 {{ $gunung->kabupaten }}, {{ $gunung->provinsi }}
    </p>

    <!-- Reviews Count -->
    <p class="card-reviews">
      ({{ $gunung->jumlah_review ?? 0 }} ulasan)
    </p>

    <!-- Price Range -->
    <div class="card-price">
      <span>Dari</span>
      <span class="price">Rp {{ number_format($gunung->harga_min, 0, ',', '.') }}</span>
    </div>

    <!-- Action Buttons -->
    <div class="card-actions">
      <button 
        class="btn btn-secondary btn-sm"
        data-mountain-id="{{ $gunung->id }}"
        onclick="checkAvailability({{ $gunung->id }})"
      >
        🗓️ Lihat Ketersediaan
      </button>
      <a href="/gunung/{{ $gunung->id }}" class="btn btn-secondary btn-sm">
        Detail →
      </a>
    </div>
  </div>
</div>
```

### Step 3.2: Create Gunung Populer Section Component

**File**: `resources/views/components/gunung-populer.blade.php` (create new)

```blade
<section class="gunung-populer" id="gununPopuler">
  <div class="section-container">
    <!-- Section Header -->
    <div class="section-header">
      <div>
        <h2 class="section-title">Gunung Populer</h2>
        <p class="section-subtitle">
          Destinasi favorit para pendaki bulan ini. Pilih rute terbaik untuk petualangan Anda.
        </p>
      </div>
      <a href="/gunung" class="btn btn-link">
        Lihat Semua
        <span>→</span>
      </a>
    </div>

    <!-- Mountains Grid -->
    <div class="mountains-grid">
      @forelse($gununPopuler as $gunung)
        @include('components.mountain-card', ['gunung' => $gunung])
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px;">
          <p>Belum ada gunung yang tersedia</p>
        </div>
      @endforelse
    </div>

    <!-- CTA to see all -->
    <div class="section-footer">
      <a href="/gunung" class="btn btn-primary btn-lg">
        Lihat Semua Destinasi
        <span>→</span>
      </a>
    </div>
  </div>
</section>
```

### Step 3.3: Add CSS untuk Mountain Cards

**File**: Tambahkan ke `resources/css/app.css`

```css
/* ==================== GUNUNG POPULER SECTION ==================== */

.section-container {
  max-width: 1280px;
  margin: 0 auto;
  padding: var(--spacing-12) var(--spacing-6);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: var(--spacing-12);
  gap: var(--spacing-6);
}

.section-title {
  font-size: clamp(24px, 6vw, 36px);
  font-weight: 800;
  color: var(--gray-900);
  margin-bottom: var(--spacing-2);
  letter-spacing: var(--letter-spacing-tight);
}

.section-subtitle {
  font-size: var(--text-lg);
  color: var(--gray-700);
  line-height: var(--line-height-relaxed);
  max-width: 500px;
}

.btn-link {
  color: var(--primary-main);
  text-decoration: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
  padding: var(--spacing-2) var(--spacing-3);
  transition: all 0.2s;
  border-radius: var(--radius-md);
  white-space: nowrap;
}

.btn-link:hover {
  background-color: var(--gray-100);
  transform: translateX(4px);
}

/* Mountains Grid */
.mountains-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: var(--spacing-6);
  margin-bottom: var(--spacing-12);
}

/* Mountain Card */
.mountain-card {
  background: var(--bg-primary);
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-md);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  height: 100%;
  position: relative;
}

.mountain-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}

/* Card Badge */
.card-badge {
  position: absolute;
  top: var(--spacing-3);
  right: var(--spacing-3);
  z-index: 2;
  padding: var(--spacing-2) var(--spacing-3);
  border-radius: var(--radius-full);
  font-size: var(--text-xs);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: var(--letter-spacing-wide);
}

.card-badge.tersedia {
  background-color: rgba(16, 185, 129, 0.2);
  color: #10B981;
  border: 1px solid #10B981;
}

.card-badge.limited {
  background-color: rgba(245, 158, 11, 0.2);
  color: #F59E0B;
  border: 1px solid #F59E0B;
}

.card-badge.soldout {
  background-color: rgba(239, 68, 68, 0.2);
  color: #EF4444;
  border: 1px solid #EF4444;
}

/* Card Image */
.card-image {
  position: relative;
  overflow: hidden;
  height: 200px;
  background-color: #E5E7EB;
}

.card-image .image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.3s ease;
}

.mountain-card:hover .card-image .image {
  transform: scale(1.05);
}

.card-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0),
    rgba(0, 0, 0, 0.3)
  );
}

/* Card Content */
.card-content {
  padding: var(--spacing-4);
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: var(--spacing-3);
  margin-bottom: var(--spacing-3);
}

.card-title {
  font-size: var(--text-xl);
  font-weight: 700;
  color: var(--gray-900);
  margin: 0;
  flex-grow: 1;
}

.card-rating {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 2px;
  flex-shrink: 0;
}

.stars {
  color: #F59E0B;
  font-size: var(--text-sm);
  white-space: nowrap;
}

.rating-value {
  font-size: var(--text-sm);
  font-weight: 600;
  color: var(--gray-900);
}

.card-location {
  font-size: var(--text-sm);
  color: var(--gray-700);
  margin: 0 0 var(--spacing-2) 0;
}

.card-reviews {
  font-size: var(--text-xs);
  color: #999999;
  margin: 0 0 var(--spacing-3) 0;
}

.card-price {
  margin: var(--spacing-3) 0;
  padding: var(--spacing-3);
  background-color: var(--gray-100);
  border-radius: var(--radius-md);
  display: flex;
  align-items: baseline;
  gap: var(--spacing-2);
}

.card-price span:first-child {
  font-size: var(--text-xs);
  color: var(--gray-700);
}

.price {
  font-size: var(--text-lg);
  font-weight: 700;
  color: var(--primary-main);
}

/* Card Actions */
.card-actions {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-2);
  margin-top: auto;
}

.btn-sm {
  padding: var(--spacing-2) var(--spacing-3);
  font-size: var(--text-sm);
  width: 100%;
}

/* Section Footer */
.section-footer {
  display: flex;
  justify-content: center;
  padding-top: var(--spacing-6);
  border-top: 1px solid var(--border-color);
}

/* Responsive Design */
@media (max-width: 1024px) {
  .mountains-grid {
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: var(--spacing-4);
  }

  .section-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .btn-link {
    order: -1;
  }
}

@media (max-width: 767px) {
  .section-container {
    padding: var(--spacing-8) var(--spacing-4);
  }

  .section-title {
    font-size: 24px;
  }

  .mountains-grid {
    grid-template-columns: 1fr;
    gap: var(--spacing-4);
  }

  .section-header {
    gap: var(--spacing-3);
  }

  .card-image {
    height: 150px;
  }

  .btn-sm {
    padding: var(--spacing-2) var(--spacing-2);
    font-size: 12px;
  }
}
```

### Step 3.4: Update Homepage to Include Section

**File**: `resources/views/index.blade.php`

```blade
@extends('layouts.app')

@section('content')
  @include('components.hero')
  
  @include('components.gunung-populer', ['gununPopuler' => $gununPopuler])
  
  <!-- Other sections akan ditambah nanti -->
@endsection
```

### Step 3.5: Update HomeController untuk Supply Data

**File**: `app/Http/Controllers/HomeController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Gunung;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch popular mountains (example: top 6 by booking count)
        $gununPopuler = Gunung::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(6)
            ->get();

        return view('index', [
            'gununPopuler' => $gununPopuler
        ]);
    }
}
```

### Step 3.6: Test Gunung Populer Section

- [ ] 6 mountain cards ditampilkan dalam grid
- [ ] Cards responsive: 3 col (desktop), 2 col (tablet), 1 col (mobile)
- [ ] Badge status tampil dengan warna correct
- [ ] Hover effect berfungsi (scale image + card elevation)
- [ ] Rating stars tampil dengan benar
- [ ] Price formatting benar (Rp format)
- [ ] Action buttons clickable
- [ ] Mobile view: cards stack single column
- [ ] Images load properly

---

## ✅ FINAL TESTING CHECKLIST

### Device Testing
- [ ] Desktop (1920px) - full resolution
- [ ] Laptop (1366px) - standard laptop
- [ ] Tablet (768px - 1024px) - iPad, Android tablets
- [ ] Mobile (375px - 767px) - iPhone, Android phones

### Browser Testing
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Chrome Mobile
- [ ] Safari Mobile

### Performance Testing
- [ ] Lighthouse Performance Score > 80
- [ ] Lighthouse SEO Score > 90
- [ ] Lighthouse Accessibility Score > 95
- [ ] Images optimized (< 200KB total)
- [ ] CSS minified
- [ ] No console errors

### UX Testing
- [ ] Navigation smooth dan intuitif
- [ ] All links working
- [ ] No broken images
- [ ] Text readable on all devices
- [ ] Form inputs accessible
- [ ] Buttons clickable on mobile (min 44px)

---

## 🚀 DEPLOYMENT CHECKLIST

- [ ] All code committed to git
- [ ] No console errors in production
- [ ] CSS changes applied correctly
- [ ] JavaScript working as expected
- [ ] Images loading from CDN/storage
- [ ] Responsive design verified
- [ ] Cross-browser testing complete
- [ ] Performance metrics acceptable
- [ ] Ready for production deploy

---

## 📞 TROUBLESHOOTING

### Images Not Loading
- Check image path in storage folder
- Verify `php artisan storage:link` executed
- Check file permissions
- Fallback images in CSS

### CSS Not Applying
- Check CSS file is linked in Blade template
- Verify CSS class names match HTML
- Clear browser cache (Ctrl+Shift+Delete)
- Run `npm run dev` atau `php artisan view:clear`

### JavaScript Not Working
- Check script tags di Blade template
- Verify function names match
- Check browser console for errors
- Ensure JavaScript file is linked correctly

### Responsive Not Working
- Verify viewport meta tag present
- Check media query breakpoints
- Test with DevTools responsive mode
- Clear cache and refresh

---

**Document Version**: 1.0  
**Last Updated**: June 2026  
**Status**: Ready for Implementation

