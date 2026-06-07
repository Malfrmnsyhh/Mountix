<aside id="sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 transition-transform -translate-x-full md:translate-x-0 border-r border-neutral-light bg-white pt-20">
    <div class="h-full overflow-y-auto px-4 py-4">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            
            <li class="pt-4 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40 px-3">Data Management</span>
            </li>
            
            <li>
                <a href="{{ route('admin.gunung.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.gunung.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="mountain" class="w-5 h-5 {{ request()->routeIs('admin.gunung.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Gunung</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.jalur.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.jalur.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="map" class="w-5 h-5 {{ request()->routeIs('admin.jalur.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Jalur</span>
                </a>
            </li>
            
            {{-- 
            <li>
                <a href="{{ route('admin.fasilitas.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.fasilitas.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="tent" class="w-5 h-5 {{ request()->routeIs('admin.fasilitas.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Fasilitas</span>
                </a>
            </li>
            --}}

            <li class="pt-4 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40 px-3">Transaction</span>
            </li>

            <li>
                <a href="{{ route('admin.booking.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.booking.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="calendar-check" class="w-5 h-5 {{ request()->routeIs('admin.booking.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Booking</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.payment.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.payment.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="credit-card" class="w-5 h-5 {{ request()->routeIs('admin.payment.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Payment Monitor</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.eticket.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.eticket.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="ticket" class="w-5 h-5 {{ request()->routeIs('admin.eticket.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">E-Ticket</span>
                </a>
            </li>

            <li class="pt-4 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40 px-3">System</span>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'text-neutral-dark hover:bg-neutral-light' }} transition-all group">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-neutral-dark/60 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Users</span>
                </a>
            </li>
        </ul>

        <div class="mt-10 pt-10 border-t border-neutral-light">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center p-3 rounded-xl text-danger hover:bg-danger/10 transition-all group">
                    <i data-lucide="log-out" class="w-5 h-5 text-danger/60 group-hover:text-danger"></i>
                    <span class="ml-3 font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
