# 📋 INSTRUKSI REFACTOR FRONTEND - MOUNTIX HOMEPAGE

**Target**: Refactor halaman beranda (homepage) Mountix untuk meningkatkan visual appeal, UX clarity, dan conversion rate.

**Scope**: Frontend visual & layout ONLY - JANGAN UBAH backend logic, routing, atau database queries.

**Focus Area**: Homepage/Beranda - dari header sampai footer

---

## 🎯 PRIORITAS EKSEKUSI

```
PHASE 1 (HIGH PRIORITY):
├─ 1. Navbar/Header refactor (guest vs auth states)
├─ 2. Hero section redesign (copy + CTA buttons)
└─ 3. "Gunung Populer" section expansion (6 cards in grid)

PHASE 2 (MEDIUM PRIORITY):
├─ 4. "Tentang Kami" section layout improvement
├─ 5. "Mengapa Memilih Mountix" feature cards with icons
└─ 6. Footer enhancement

PHASE 3 (NICE-TO-HAVE):
├─ 7. Booking process flow visual
├─ 8. Loading & empty states
└─ 9. Animation & micro-interactions
```

---

## 🎨 DESIGN SYSTEM (ESTABLISH FIRST)

### Color Palette
```css
:root {
  /* Primary - Mountain/Nature theme */
  --primary-dark: #1B5E20;        /* Deep forest green */
  --primary-main: #2E7D32;        /* Main green */
  --primary-light: #66BB6A;       /* Light green */
  
  /* Secondary - Energy/Adventure */
  --secondary-main: #FF8C42;      /* Mountain orange/sunset */
  --secondary-light: #FFB74D;     /* Lighter orange */
  
  /* Accent - Call-to-action */
  --accent-main: #00A86B;         /* Emerald green (action) */
  --accent-hover: #00916D;        /* Darker on hover */
  
  /* Neutral */
  --gray-900: #1F2937;            /* Dark text */
  --gray-800: #374151;            /* Secondary text */
  --gray-700: #4B5563;            /* Tertiary text */
  --gray-100: #F9FAFB;            /* Light backgrounds */
  --gray-50: #FFFFFF;             /* Pure white */
  
  /* Status colors */
  --success: #10B981;             /* Available */
  --warning: #F59E0B;             /* Limited quota */
  --error: #EF4444;               /* Sold out */
  
  /* Semantic */
  --bg-primary: #FFFFFF;
  --bg-secondary: #F9FAFB;
  --border-color: #E5E7EB;
  --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
  --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
  --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
}
```

### Typography
```css
:root {
  /* Font sizes */
  --text-xs: 12px;
  --text-sm: 14px;
  --text-base: 16px;
  --text-lg: 18px;
  --text-xl: 20px;
  --text-2xl: 24px;
  --text-3xl: 30px;
  --text-4xl: 36px;
  
  /* Line heights */
  --line-height-tight: 1.2;
  --line-height-normal: 1.5;
  --line-height-relaxed: 1.75;
  
  /* Letter spacing */
  --letter-spacing-tight: -0.5px;
  --letter-spacing-normal: 0px;
  --letter-spacing-wide: 0.5px;
}
```

### Spacing
```css
:root {
  --spacing-2: 8px;
  --spacing-3: 12px;
  --spacing-4: 16px;
  --spacing-6: 24px;
  --spacing-8: 32px;
  --spacing-10: 40px;
  --spacing-12: 48px;
  --spacing-16: 64px;
  --spacing-20: 80px;
}
```

### Border Radius
```css
:root {
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 12px;
  --radius-xl: 16px;
  --radius-full: 9999px;
}
```

---

## 📱 RESPONSIVE BREAKPOINTS

```css
/* Mobile First Approach */
0px - 639px      : Mobile (base)
640px - 767px    : Small tablet
768px - 1023px   : Tablet
1024px - 1279px  : Desktop
1280px+          : Large desktop

Classes pattern (Tailwind-like):
- Default: mobile
- sm: 640px
- md: 768px
- lg: 1024px
- xl: 1280px
```

---

## 🔧 PHASE 1: NAVBAR/HEADER REFACTOR

### Current Problem
- Menu items berantakan (Beranda, Gunung, Tentang Kami tercampur dengan auth controls)
- Dropdown menu tampil inconsistently based on auth state
- "Admin Panel" tidak seharusnya visible untuk semua user

### Target Structure

#### FOR GUEST USERS (Not Authenticated)
```
[LOGO: MOUNTIX]          [Beranda] [Gunung] [Tentang Kami]          [Masuk] [Daftar]
```

#### FOR AUTHENTICATED USERS
```
[LOGO: MOUNTIX]          [Beranda] [Gunung] [Tentang Kami]    [Booking Saya] [Profil▼]
                                                                                [Keluar]
```

#### FOR ADMIN USERS (Optional: different header entirely)
```
[LOGO: MOUNTIX] [🏠 Dashboard]     [Gunung] [Users] [Bookings] [Reports]    [Admin▼]
```

### Implementation Details

#### HTML Structure
```html
<header class="navbar">
  <!-- Logo Section -->
  <div class="navbar-brand">
    <a href="/" class="logo">
      <span class="logo-icon">⛰️</span>
      <span class="logo-text">MOUNTIX</span>
    </a>
  </div>

  <!-- Main Navigation (Hidden on mobile) -->
  <nav class="navbar-menu" id="navbarMenu">
    <a href="/" class="nav-link active">Beranda</a>
    <a href="/gunung" class="nav-link">Gunung</a>
    <a href="#about" class="nav-link">Tentang Kami</a>
  </nav>

  <!-- Auth Controls -->
  <div class="navbar-actions">
    <!-- GUEST STATE -->
    <div class="auth-guest" id="authGuest">
      <a href="/login" class="btn btn-secondary">Masuk</a>
      <a href="/register" class="btn btn-primary">Daftar</a>
    </div>

    <!-- AUTHENTICATED STATE -->
    <div class="auth-user" id="authUser" style="display: none;">
      <a href="/profile?tab=booking" class="nav-link">
        <span>🗓️</span>
        <span>Booking Saya</span>
      </a>
      <div class="dropdown">
        <button class="btn btn-profile" id="profileBtn">
          <span class="user-avatar">👤</span>
          <span class="user-name" id="userName">Nama User</span>
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
  </div>

  <!-- Mobile Menu Toggle -->
  <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</header>
```

#### CSS Styling
```css
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
}

.logo {
  display: flex;
  align-items: center;
  gap: var(--spacing-2);
  text-decoration: none;
  font-weight: 700;
  font-size: var(--text-xl);
  color: var(--primary-dark);
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
  transition: color 0.2s;
  position: relative;
}

.nav-link:hover,
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

/* Buttons */
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

.btn-primary {
  background-color: var(--accent-main);
  color: white;
}

.btn-primary:hover {
  background-color: var(--accent-hover);
  box-shadow: var(--shadow-md);
}

.btn-secondary {
  background-color: transparent;
  color: var(--primary-main);
  border: 2px solid var(--primary-main);
}

.btn-secondary:hover {
  background-color: var(--primary-light);
  color: white;
}

/* Dropdown */
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
}

.btn-profile:hover {
  background-color: var(--gray-50);
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: var(--primary-light);
  display: flex;
  align-items: center;
  justify-content: center;
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
  transition: background-color 0.2s;
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

/* Mobile Navigation */
.navbar-toggle {
  display: none;
  flex-direction: column;
  background: none;
  border: none;
  cursor: pointer;
  gap: 4px;
}

.navbar-toggle span {
  width: 24px;
  height: 2px;
  background-color: var(--gray-900);
  transition: all 0.3s;
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

/* Responsive Design */
@media (max-width: 767px) {
  .navbar {
    flex-wrap: wrap;
    padding: var(--spacing-4);
  }

  .navbar-menu {
    display: none;
    width: 100%;
    flex-direction: column;
    gap: var(--spacing-4);
    margin-top: var(--spacing-4);
    order: 3;
  }

  .navbar-menu.show {
    display: flex;
  }

  .navbar-toggle {
    display: flex;
  }

  .navbar-actions {
    flex-direction: column;
    width: 100%;
    gap: var(--spacing-2);
  }

  .auth-guest {
    display: flex;
    gap: var(--spacing-2);
    width: 100%;
  }

  .auth-guest .btn {
    flex: 1;
  }

  .auth-user {
    width: 100%;
  }
}
```

#### JavaScript Logic
```javascript
// Mobile Menu Toggle
const navbarToggle = document.getElementById('navbarToggle');
const navbarMenu = document.getElementById('navbarMenu');

if (navbarToggle) {
  navbarToggle.addEventListener('click', () => {
    navbarToggle.classList.toggle('active');
    navbarMenu.classList.toggle('show');
  });
}

// Dropdown Menu
const profileBtn = document.getElementById('profileBtn');
const dropdownMenu = document.getElementById('dropdownMenu');

if (profileBtn) {
  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
  });

  document.addEventListener('click', () => {
    dropdownMenu.classList.remove('show');
  });
}

// Active Link Indicator
const currentPage = window.location.pathname;
document.querySelectorAll('.nav-link').forEach(link => {
  if (link.getAttribute('href') === currentPage) {
    link.classList.add('active');
  }
});

// Detect if user is authenticated (get from server/session)
function updateAuthState(isAuthenticated, userName = '') {
  const authGuest = document.getElementById('authGuest');
  const authUser = document.getElementById('authUser');
  const userNameEl = document.getElementById('userName');

  if (isAuthenticated) {
    authGuest.style.display = 'none';
    authUser.style.display = 'flex';
    if (userName) userNameEl.textContent = userName;
  } else {
    authGuest.style.display = 'flex';
    authUser.style.display = 'none';
  }
}

// Call this from your Blade template or API response
// updateAuthState({{ auth()->check() ? 'true' : 'false' }}, '{{ auth()->user()->name ?? '' }}');
```

---

## 🎭 PHASE 2: HERO SECTION REDESIGN

### Current Problem
- Copy terlalu generic: "Jelajahi Puncak Tertinggi Bersama Mountix"
- CTA tidak menarik: "Cari Sekarang" (no urgency)
- Tidak ada trust elements atau value proposition yang jelas
- Background image terlalu plain

### Target Design

```
┌─────────────────────────────────────────────────────────┐
│                   HERO SECTION                          │
│                                                         │
│  [Background Image - Mountain landscape - high quality] │
│  Overlay: Dark gradient (rgba 0,0,0,0.4)               │
│                                                         │
│  Centered content:                                      │
│  ┌─────────────────────────────────────────────────┐  │
│  │ Booking Pendakian Gunung Impian Anda            │  │
│  │ Cepat, Aman, Terpercaya                         │  │
│  │                                                 │  │
│  │ Temukan jalur terbaik dari 50+ destinasi        │  │
│  │ dan kelola booking Anda dalam genggaman.        │  │
│  │                                                 │  │
│  │ [Temukan Gunung Pilihan] [Lihat Video Demo]    │  │
│  │                                                 │  │
│  │ ✓ 2,500+ pendaki telah mempercayai kami        │  │
│  │ ✓ Garansi uang kembali 100% jika tidak puas    │  │
│  └─────────────────────────────────────────────────┘  │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

### HTML Structure
```html
<section class="hero">
  <div class="hero-background">
    <img 
      src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1920&q=80"
      alt="Mountain landscape"
      class="hero-image"
    >
    <div class="hero-overlay"></div>
  </div>

  <div class="hero-content">
    <div class="hero-inner">
      <!-- Main Heading -->
      <h1 class="hero-title">
        Booking Pendakian Gunung <span class="highlight">Impian Anda</span>
      </h1>

      <!-- Subheading -->
      <p class="hero-subtitle">
        Cepat, Aman, Terpercaya
      </p>

      <!-- Description -->
      <p class="hero-description">
        Temukan jalur terbaik dari 50+ destinasi pendakian dan kelola booking Anda 
        dalam genggaman. Tanpa antri, tanpa ribet, cukup melalui ponsel Anda.
      </p>

      <!-- CTA Buttons -->
      <div class="hero-actions">
        <a href="/gunung" class="btn btn-primary btn-lg">
          <span>🏔️</span>
          <span>Temukan Gunung Pilihan</span>
        </a>
        <button class="btn btn-secondary btn-lg" id="videoDemo">
          <span>▶️</span>
          <span>Tonton Demo (2 menit)</span>
        </button>
      </div>

      <!-- Trust Badges -->
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

  <!-- Scroll Indicator (optional) -->
  <div class="hero-scroll" id="scrollIndicator">
    <span>Scroll untuk selengkapnya</span>
    <span class="scroll-arrow">↓</span>
  </div>
</section>
```

### CSS Styling
```css
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
  font-size: var(--text-4xl);
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
  font-size: var(--text-2xl);
  font-weight: 600;
  margin-bottom: var(--spacing-4);
  color: var(--secondary-light);
  letter-spacing: var(--letter-spacing-wide);
  text-transform: uppercase;
  opacity: 0.95;
}

.hero-description {
  font-size: var(--text-lg);
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

/* Override button styles for hero */
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
    font-size: var(--text-3xl);
  }

  .hero-subtitle {
    font-size: var(--text-xl);
  }

  .hero-description {
    font-size: var(--text-base);
  }
}

@media (max-width: 767px) {
  .hero {
    min-height: 300px;
    align-items: flex-start;
    padding-top: var(--spacing-20);
  }

  .hero-content {
    padding: var(--spacing-4);
  }

  .hero-title {
    font-size: var(--text-2xl);
  }

  .hero-subtitle {
    font-size: var(--text-lg);
    margin-bottom: var(--spacing-3);
  }

  .hero-description {
    font-size: var(--text-sm);
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

### JavaScript Enhancement
```javascript
// Video Demo Modal (if needed)
const videoDemo = document.getElementById('videoDemo');
if (videoDemo) {
  videoDemo.addEventListener('click', () => {
    // Open modal with YouTube/Vimeo video
    // atau implementasi sesuai kebutuhan
    alert('Video demo akan dibuka');
  });
}

// Smooth scroll indicator
const scrollIndicator = document.getElementById('scrollIndicator');
if (scrollIndicator) {
  scrollIndicator.addEventListener('click', () => {
    document.querySelector('.gunung-populer')?.scrollIntoView({ 
      behavior: 'smooth' 
    });
  });
}

// Parallax effect (optional nice-to-have)
window.addEventListener('scroll', () => {
  const hero = document.querySelector('.hero');
  if (hero) {
    const scrollTop = window.scrollY;
    const parallaxElement = hero.querySelector('.hero-image');
    if (parallaxElement) {
      parallaxElement.style.transform = `translateY(${scrollTop * 0.5}px)`;
    }
  }
});
```

---

## 🏔️ PHASE 3: "GUNUNG POPULER" SECTION EXPANSION

### Current Problem
- Hanya 1 kartu yang ditampilkan, padahal section name "Gunung Populer" (plural)
- Tidak ada grid layout yang proper
- Looks incomplete & tidak impressive

### Target Design

```
┌──────────────────────────────────────────────────────┐
│  Gunung Populer                              [Lihat] │
│  Destinasi favorit para pendaki bulan ini.  [Semua] │
│                                                      │
│  ┌──────────────┬──────────────┬──────────────┐     │
│  │              │              │              │     │
│  │   [CARD]     │   [CARD]     │   [CARD]     │     │
│  │              │              │              │     │
│  ├──────────────┼──────────────┼──────────────┤     │
│  │              │              │              │     │
│  │   [CARD]     │   [CARD]     │   [CARD]     │     │
│  │              │              │              │     │
│  └──────────────┴──────────────┴──────────────┘     │
│                                                      │
│         [Lihat Semua Destinasi →]                   │
└──────────────────────────────────────────────────────┘

Card Detail (Mobile: 1 col, Tablet: 2 col, Desktop: 3 col):
┌────────────────────────────┐
│  ⭐ Tersedia                 │
│  [Image - 200px height]     │
│  ────────────────────────   │
│  Lawu            ⭐⭐⭐⭐     │
│  Magetan, Jawa Timur       │
│                            │
│  📊 Rating: 4.0 (125 reviews) │
│  Dari Rp 20.000 - 450.000  │
│                            │
│  [🗓️ Lihat Ketersediaan]    │
│  [→ Detail Gunung]         │
└────────────────────────────┘
```

### HTML Structure
```html
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
      <!-- Card 1 (repeat this structure 6 times) -->
      <div class="mountain-card">
        <!-- Status Badge -->
        <div class="card-badge tersedia">✓ Tersedia</div>

        <!-- Image Container -->
        <div class="card-image">
          <img 
            src="https://mountix-production.up.railway.app/storage/gunung/xyZY3iZy8ntNr3RWuoPyUwERnnPGPOgTsJCa5IBM.jpg"
            alt="Gunung Lawu"
            class="image"
          >
          <div class="card-overlay"></div>
        </div>

        <!-- Content -->
        <div class="card-content">
          <!-- Title & Rating -->
          <div class="card-header">
            <h3 class="card-title">Gunung Lawu</h3>
            <div class="card-rating">
              <span class="stars">★★★★☆</span>
              <span class="rating-value">4.0</span>
            </div>
          </div>

          <!-- Location -->
          <p class="card-location">📍 Magetan, Jawa Timur</p>

          <!-- Rating & Reviews -->
          <p class="card-reviews">(125 ulasan)</p>

          <!-- Price Range -->
          <div class="card-price">
            <span>Dari</span>
            <span class="price">Rp 20.000</span>
          </div>

          <!-- CTA Buttons -->
          <div class="card-actions">
            <button class="btn btn-secondary btn-sm" data-mountain-id="13">
              🗓️ Lihat Ketersediaan
            </button>
            <a href="/gunung/13" class="btn btn-secondary btn-sm">
              Detail →
            </a>
          </div>
        </div>
      </div>

      <!-- Card 2-6 (sama seperti Card 1, data diisi dari backend) -->
      <!-- ... -->
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

### CSS Styling
```css
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
  font-size: var(--text-3xl);
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
  color: var(--success);
  border: 1px solid var(--success);
}

.card-badge.limited {
  background-color: rgba(245, 158, 11, 0.2);
  color: var(--warning);
  border: 1px solid var(--warning);
}

.card-badge.soldout {
  background-color: rgba(239, 68, 68, 0.2);
  color: var(--error);
  border: 1px solid var(--error);
}

/* Card Image */
.card-image {
  position: relative;
  overflow: hidden;
  height: 200px;
  background-color: var(--gray-200);
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
}

.stars {
  color: var(--warning);
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
  color: var(--gray-600);
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
    font-size: var(--text-2xl);
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
}
```

### Backend Data Structure (Blade Template)
```blade
<section class="gunung-populer" id="gununPopuler">
  <div class="section-container">
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

    <div class="mountains-grid">
      @foreach($gunungPopuler as $gunung)
        <div class="mountain-card">
          <div class="card-badge {{ $gunung->status === 'tersedia' ? 'tersedia' : ($gunung->status === 'limited' ? 'limited' : 'soldout') }}">
            {{ $gunung->status === 'tersedia' ? '✓ Tersedia' : ($gunung->status === 'limited' ? '⚠️ Terbatas' : '✗ Penuh') }}
          </div>

          <div class="card-image">
            <img 
              src="{{ asset('storage/' . $gunung->image) }}"
              alt="{{ $gunung->nama }}"
              class="image"
            >
            <div class="card-overlay"></div>
          </div>

          <div class="card-content">
            <div class="card-header">
              <h3 class="card-title">{{ $gunung->nama }}</h3>
              <div class="card-rating">
                <span class="stars">{{ str_repeat('★', floor($gunung->rating)) }}{{ $gunung->rating % 1 >= 0.5 ? '⯨' : '' }}{{ str_repeat('☆', 5 - ceil($gunung->rating)) }}</span>
                <span class="rating-value">{{ number_format($gunung->rating, 1) }}</span>
              </div>
            </div>

            <p class="card-location">📍 {{ $gunung->lokasi }}</p>
            <p class="card-reviews">({{ $gunung->total_reviews ?? 0 }} ulasan)</p>

            <div class="card-price">
              <span>Dari</span>
              <span class="price">Rp {{ number_format($gunung->harga_min, 0, ',', '.') }}</span>
            </div>

            <div class="card-actions">
              <button class="btn btn-secondary btn-sm" data-mountain-id="{{ $gunung->id }}" onclick="checkAvailability({{ $gunung->id }})">
                🗓️ Lihat Ketersediaan
              </button>
              <a href="/gunung/{{ $gunung->id }}" class="btn btn-secondary btn-sm">
                Detail →
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="section-footer">
      <a href="/gunung" class="btn btn-primary btn-lg">
        Lihat Semua Destinasi
        <span>→</span>
      </a>
    </div>
  </div>
</section>
```

---

## 🎯 EXECUTION CHECKLIST

### PHASE 1: Navbar
- [ ] Create navbar HTML structure (guest & auth states)
- [ ] Style navbar with CSS (colors, spacing, responsive)
- [ ] Implement dropdown menu JavaScript
- [ ] Test mobile hamburger menu
- [ ] Test navbar on all screen sizes
- [ ] Ensure proper auth state detection

### PHASE 2: Hero Section
- [ ] Update hero copy & CTA buttons
- [ ] Adjust background image & overlay
- [ ] Style hero title, subtitle, description
- [ ] Create trust badges
- [ ] Add scroll indicator animation
- [ ] Test responsiveness on mobile/tablet
- [ ] Add parallax effect (optional)

### PHASE 3: Gunung Populer
- [ ] Fetch 6-12 mountains from database
- [ ] Create mountain card component
- [ ] Implement CSS grid layout
- [ ] Add card hover animations
- [ ] Ensure proper badge styling
- [ ] Test card layout on all breakpoints
- [ ] Add "Lihat Semua" link

### Testing Checklist
- [ ] Desktop (1920px+)
- [ ] Laptop (1280px - 1920px)
- [ ] Tablet (768px - 1024px)
- [ ] Mobile (375px - 767px)
- [ ] Lighthouse Performance score > 80
- [ ] SEO score > 90
- [ ] Accessibility score > 95
- [ ] Cross-browser testing (Chrome, Firefox, Safari, Edge)

---

## 📋 NOTES FOR CLI AGENT

1. **Do NOT modify backend logic** - only frontend files
2. **CSS Framework**: Use CSS that matches existing stack (Tailwind/custom)
3. **Color System**: Apply color variables from DESIGN SYSTEM section
4. **Responsive First**: Mobile-first approach, always test on mobile
5. **Performance**: Optimize images, minimize CSS/JS
6. **SEO**: Maintain semantic HTML structure
7. **Browser Support**: Support latest 2 versions of major browsers
8. **Accessibility**: WCAG 2.1 AA standards minimum

---

## 🚀 NEXT STEPS AFTER PHASE 1-3

After completing all three phases, proceed with:
- Phase 4: "Tentang Kami" section redesign
- Phase 5: "Mengapa Memilih Mountix" feature cards
- Phase 6: Footer enhancement
- Phase 7: Booking process visual flow
- Phase 8: Loading & empty states
- Phase 9: Animation & micro-interactions

