<nav class="fixed top-0 z-50 w-full bg-[#1a3009] border-b border-white/10">
    <div class="px-4 py-3 lg:px-6 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 text-sm text-white md:hidden rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20">
                    <span class="sr-only">Open sidebar</span>
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <a href="{{ route('home') }}" class="flex ml-2 md:mr-24 items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i data-lucide="mountain" class="text-[#1a3009] w-5 h-5"></i>
                    </div>
                    <span class="self-center text-xl font-bold whitespace-nowrap text-white">Mountix <span class="text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full ml-1">Admin</span></span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ml-3">
                    <div class="flex items-center gap-3 px-3 py-1.5 rounded-full bg-white/10 border border-white/10">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-white/60">Administrator</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white font-bold text-xs uppercase">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
