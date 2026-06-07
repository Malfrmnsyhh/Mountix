<nav class="bg-primary text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                    MOUNT<span class="text-secondary">IX</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('home') }}" class="hover:text-secondary transition-colors duration-250">Beranda</a>
                <a href="{{ route('gunung.index') }}" class="hover:text-secondary transition-colors duration-250">Gunung</a>
                <a href="#" class="hover:text-secondary transition-colors duration-250">Tentang Kami</a>
                
                <div id="nav-auth-links" class="flex items-center space-x-4 border-l border-white/20 pl-8">
                    <!-- Dynamic Auth Links via JS -->
                    <div id="nav-guest" class="hidden">
                        <a href="{{ route('login') }}" class="hover:text-secondary transition-colors duration-250">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-secondary px-4 py-2 rounded-md hover:bg-secondary/90 transition-colors duration-250 ml-4">Daftar</a>
                    </div>
                    <div id="nav-user" class="hidden flex items-center space-x-4">
                        <span id="nav-user-name" class="text-sm font-medium"></span>
                        <div class="relative group">
                            <button class="flex items-center space-x-1 hover:text-secondary transition-colors">
                                <i data-lucide="user-circle"></i>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </button>
                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white text-neutral-dark rounded-md shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 bg-primary/5 text-primary font-bold hover:bg-primary/10">Admin Panel</a>
                                    <hr class="my-1 border-neutral-light">
                                @endif
                                <div id="nav-admin-link" class="hidden">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 bg-primary/5 text-primary font-bold hover:bg-primary/10">Admin Panel</a>
                                    <hr class="my-1 border-neutral-light">
                                </div>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-neutral-light">Profil Saya</a>
                                <a href="{{ route('booking.index') }}" class="block px-4 py-2 hover:bg-neutral-light">Booking Saya</a>
                                <hr class="my-1 border-neutral-light">
                                <button onclick="logout()" class="w-full text-left block px-4 py-2 hover:bg-danger/10 text-danger">Keluar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" class="text-white hover:text-secondary focus:outline-none">
                    <i data-lucide="menu"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('auth_token');
        const user = JSON.parse(localStorage.getItem('user'));
        
        const guestNav = document.getElementById('nav-guest');
        const userNav = document.getElementById('nav-user');
        const adminLink = document.getElementById('nav-admin-link');
        const userNameElem = document.getElementById('nav-user-name');

        if (token && user) {
            userNameElem.textContent = user.name;
            userNav.classList.remove('hidden');
            
            // Show admin link if role is admin
            if (user.role === 'admin') {
                adminLink.classList.remove('hidden');
            }
        } else {
            guestNav.classList.remove('hidden');
        }
    });

    function logout() {
        // Simple logout for now, can be expanded to call API
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
        window.location.href = '/login';
    }
</script>
@endpush
