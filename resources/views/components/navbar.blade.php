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
    <a href="/" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
    <a href="/gunung" class="nav-link {{ request()->routeIs('gunung.*') ? 'active' : '' }}">Gunung</a>
    <a href="/#about" class="nav-link">Tentang Kami</a>
  </nav>

  <!-- Auth Controls -->
  <div class="navbar-actions">
    <!-- GUEST STATE -->
    <div class="auth-guest" id="authGuest" style="{{ auth()->check() ? 'display: none;' : 'display: flex;' }}">
      <a href="/login" class="btn btn-secondary">Masuk</a>
      <a href="/register" class="btn btn-primary">Daftar</a>
    </div>

    <!-- AUTHENTICATED STATE -->
    <div class="auth-user" id="authUser" style="{{ auth()->check() ? 'display: flex;' : 'display: none;' }}">
      <a href="/profile?tab=booking" class="nav-link hidden md:flex items-center gap-2">
        <span>🗓️</span>
        <span>Booking Saya</span>
      </a>
      <div class="dropdown">
        <button class="btn btn-profile" id="profileBtn">
          <span class="user-avatar text-white">👤</span>
          <span class="user-name" id="userName">{{ auth()->user()->name ?? 'User' }}</span>
          <span class="dropdown-icon">▼</span>
        </button>
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="/profile" class="dropdown-item">Profil Saya</a>
          <a href="/profile?tab=booking" class="dropdown-item">Booking Saya</a>
          <a href="/profile?tab=eticket" class="dropdown-item">E-Ticket Aktif</a>
          @if(auth()->check() && auth()->user()->role === 'admin')
            <hr class="dropdown-divider">
            <a href="/admin" class="dropdown-item font-bold text-primary-main">Admin Panel</a>
          @endif
          <hr class="dropdown-divider">
          <button onclick="handleLogout()" class="dropdown-item danger w-full text-left">Keluar</button>
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

@push('scripts')
<script>
  // Detect if user is authenticated via JWT in localStorage
  document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('auth_token');
    const user = JSON.parse(localStorage.getItem('user'));
    
    const authGuest = document.getElementById('authGuest');
    const authUser = document.getElementById('authUser');
    const userNameEl = document.getElementById('userName');

    // If we have a token in localStorage but Blade says not authenticated,
    // we might want to trust the token for UI purposes, but usually Blade is more reliable for SSR.
    // However, the GEMINI.md instructions emphasize JWT in JavaScript.
    
    if (token && user) {
      if (authGuest) authGuest.style.display = 'none';
      if (authUser) authUser.style.display = 'flex';
      if (userNameEl) userNameEl.textContent = user.name;
    }
  });

  async function handleLogout() {
    try {
      await fetch('/logout', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      });
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
  }
</script>
@endpush
