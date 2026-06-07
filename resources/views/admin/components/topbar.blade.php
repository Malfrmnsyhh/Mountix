<nav class="fixed top-0 z-50 w-full bg-white border-b border-neutral-light">
    <div class="px-4 py-3 lg:px-6 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 text-sm text-neutral-dark md:hidden rounded-lg hover:bg-neutral-light focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <span class="sr-only">Open sidebar</span>
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <a href="{{ route('home') }}" class="flex ml-2 md:mr-24 items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <i data-lucide="mountain" class="text-white w-5 h-5"></i>
                    </div>
                    <span class="self-center text-xl font-bold whitespace-nowrap text-primary">Mountix <span class="text-[10px] bg-secondary/10 text-secondary px-2 py-0.5 rounded-full ml-1">Admin</span></span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ml-3">
                    <div class="flex items-center gap-3 px-3 py-1.5 rounded-full bg-neutral-light border border-neutral-light/50">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-neutral-dark">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-neutral-dark/60">Administrator</p>
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
