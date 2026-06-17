<aside id="sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 transition-transform -translate-x-full md:translate-x-0 border-r border-white/10 bg-[#1a3009] pt-20">
    <div class="h-full overflow-y-auto px-4 py-4">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            
            <li class="pt-4 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-white/40 px-3">Data Management</span>
            </li>
            
            <li>
                <a href="{{ route('admin.gunung.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.gunung.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="mountain" class="w-5 h-5 {{ request()->routeIs('admin.gunung.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Gunung</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.jalur.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.jalur.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="map" class="w-5 h-5 {{ request()->routeIs('admin.jalur.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Jalur</span>
                </a>
            </li>
            
            <li class="pt-2">
                <a href="{{ route('admin.gunung-populer.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.gunung-populer.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="star" class="w-5 h-5 {{ request()->routeIs('admin.gunung-populer.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Gunung Populer</span>
                </a>
            </li>
            
            <li class="pt-4 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-white/40 px-3">Transaction</span>
            </li>

            <li>
                <a href="{{ route('admin.booking.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.booking.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="calendar-check" class="w-5 h-5 {{ request()->routeIs('admin.booking.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Booking</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.payment.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.payment.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="credit-card" class="w-5 h-5 {{ request()->routeIs('admin.payment.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Payment Monitor</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.eticket.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.eticket.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="ticket" class="w-5 h-5 {{ request()->routeIs('admin.eticket.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">E-Ticket</span>
                </a>
            </li>

            <li class="pt-4 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-white/40 px-3">System</span>
            </li>

            <li>
                <a href="{{ route('admin.payment-method.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.payment-method.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="settings-2" class="w-5 h-5 {{ request()->routeIs('admin.payment-method.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Metode Bayar</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white font-bold border border-white/20' : 'text-white/70 hover:bg-white/5 hover:text-white' }} transition-all group">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-white/50 group-hover:text-white' }}"></i>
                    <span class="ml-3">Users</span>
                </a>
            </li>
        </ul>

        <div class="mt-10 pt-10 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST" onsubmit="localStorage.removeItem('auth_token'); localStorage.removeItem('user');">
                @csrf
                <button type="submit" class="flex w-full items-center p-3 rounded-xl text-[#ff7b7b] hover:bg-[#ff7b7b]/10 transition-all group">
                    <i data-lucide="log-out" class="w-5 h-5 text-[#ff7b7b]/80 group-hover:text-[#ff7b7b]"></i>
                    <span class="ml-3 font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
