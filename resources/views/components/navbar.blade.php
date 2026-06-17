<header class="navbar">
  <!-- Logo Section -->
  <div class="navbar-brand">
    <a href="/" class="logo">
      <span class="logo-text">MOUNTIX</span>
    </a>
  </div>

  <!-- Main Navigation (Hidden on mobile) -->
  <nav class="navbar-menu" id="navbarMenu">
    <a href="/" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
    <a href="/gunung" class="nav-link {{ request()->routeIs('gunung.*') ? 'active' : '' }}">Gunung</a>
    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
  </nav>

  <!-- Auth Controls — tersembunyi hingga JS memutuskan state yang benar -->
  {{-- Fix CLS: sembunyikan dulu, JS akan tampilkan setelah cek auth --}}
  <div class="navbar-actions invisible opacity-0 transition-opacity duration-150" id="navbarActions">
    <!-- GUEST STATE -->
    <div class="auth-guest" id="authGuest" style="display: none; gap: 12px;">
      <a href="/login" class="btn btn-secondary">Masuk</a>
      <a href="/register" class="btn btn-primary">Daftar</a>
    </div>

    <!-- AUTHENTICATED STATE -->
    <div class="auth-user" id="authUser" style="display: none;">
      <div class="dropdown">
        <button class="btn btn-profile" id="profileBtn"
          aria-haspopup="true"
          aria-expanded="false"
          aria-controls="dropdownMenu">
          <span class="user-avatar text-white">👤</span>
          <span class="user-name" id="userName">{{ auth()->user()->name ?? 'User' }}</span>
          <span class="dropdown-icon"><i data-lucide="chevron-down"></i></span>
        </button>
        <div class="dropdown-menu" id="dropdownMenu" role="menu">
          <a href="/profile" class="dropdown-item" role="menuitem">Profil Saya</a>
          <a href="/booking" class="dropdown-item" role="menuitem">Booking Saya</a>
          <a href="/eticket" class="dropdown-item" role="menuitem">E-Ticket Aktif</a>
          @if(auth()->check() && auth()->user()->role === 'admin')
            <hr class="dropdown-divider">
            <a href="/admin" class="dropdown-item font-bold text-primary-main" role="menuitem">Admin Panel</a>
          @endif
          <hr class="dropdown-divider">
          <button onclick="handleLogout()" class="dropdown-item danger w-full text-left" role="menuitem">Keluar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Menu Toggle -->
  <button class="navbar-toggle" id="navbarToggle"
    aria-label="Toggle menu"
    aria-expanded="false"
    aria-controls="navbarMenu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</header>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('auth_token');
    const user = JSON.parse(localStorage.getItem('user') || 'null');

    const navbarActions = document.getElementById('navbarActions');
    const authGuest = document.getElementById('authGuest');
    const authUser = document.getElementById('authUser');
    const userNameEl = document.getElementById('userName');

    if (token && user) {
      // User memiliki JWT token yang valid di localStorage → tampilkan state user
      if (authGuest) authGuest.style.display = 'none';
      if (authUser) authUser.style.display = 'flex';
      if (userNameEl) userNameEl.textContent = user.name;
    } else {
      // Tidak ada token → tampilkan state guest
      if (authGuest) authGuest.style.display = 'flex';
      if (authUser) authUser.style.display = 'none';
    }

    // Setelah state ditentukan, hapus invisible agar tidak ada CLS flicker
    if (navbarActions) {
      navbarActions.classList.remove('invisible', 'opacity-0');
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

