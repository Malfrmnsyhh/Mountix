@extends('layouts.app')

@section('title', 'Daftar Gunung - Mountix')

@section('content')
<div class="bg-primary pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Jelajahi Gunung Indonesia</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Temukan berbagai pilihan gunung dengan jalur pendakian terbaik untuk petualangan Anda.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Filters Sidebar -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white p-6 rounded-2xl shadow-md sticky top-24">
                <h3 class="font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="filter" class="w-5 h-5 mr-2"></i> Filter
                </h3>
                
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-3">Cari Nama</label>
                        <input type="text" id="search-input" placeholder="Nama gunung..." 
                            class="w-full px-4 py-2 bg-neutral-light border border-transparent rounded-lg focus:border-primary focus:bg-white focus:outline-none transition-all text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-3">Lokasi</label>
                        <select id="location-filter" class="w-full px-4 py-2 bg-neutral-light border border-transparent rounded-lg focus:border-primary focus:bg-white focus:outline-none transition-all text-sm appearance-none">
                            <option value="">Semua Lokasi</option>
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Jawa Tengah">Jawa Tengah</option>
                            <option value="Jawa Timur">Jawa Timur</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-3">Status</label>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm text-neutral-dark/80 cursor-pointer">
                                <input type="radio" name="status" value="" checked class="w-4 h-4 text-primary focus:ring-primary border-neutral-light mr-3">
                                Semua
                            </label>
                            <label class="flex items-center text-sm text-neutral-dark/80 cursor-pointer">
                                <input type="radio" name="status" value="1" class="w-4 h-4 text-primary focus:ring-primary border-neutral-light mr-3">
                                Buka
                            </label>
                            <label class="flex items-center text-sm text-neutral-dark/80 cursor-pointer">
                                <input type="radio" name="status" value="0" class="w-4 h-4 text-primary focus:ring-primary border-neutral-light mr-3">
                                Tutup
                            </label>
                        </div>
                    </div>

                    <button id="apply-filters" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all text-sm">
                        Terapkan
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow">
            <!-- Grid Container -->
            <div id="gunung-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                <!-- Loading State -->
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-neutral-dark/40">
                    <i data-lucide="loader-2" class="w-12 h-12 animate-spin mb-4"></i>
                    <p>Memuat data gunung...</p>
                </div>
            </div>

            <!-- Empty State (Hidden) -->
            <div id="empty-state" class="hidden py-20 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-neutral-light rounded-full flex items-center justify-center mb-6">
                    <i data-lucide="search-x" class="w-10 h-10 text-neutral-dark/20"></i>
                </div>
                <h3 class="text-xl font-bold text-neutral-dark">Gunung Tidak Ditemukan</h3>
                <p class="text-neutral-dark/60 mt-2">Coba ubah kata kunci atau filter pencarian Anda.</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadGunungs();

        document.getElementById('apply-filters').addEventListener('click', () => loadGunungs());
    });

    async function loadGunungs() {
        const grid = document.getElementById('gunung-grid');
        const emptyState = document.getElementById('empty-state');
        
        // Show loading
        grid.innerHTML = `
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-neutral-dark/40">
                <i data-lucide="loader-2" class="w-12 h-12 animate-spin mb-4"></i>
                <p>Memuat data gunung...</p>
            </div>
        `;
        emptyState.classList.add('hidden');

        // Prepare params
        const params = {
            nama: document.getElementById('search-input').value,
            lokasi: document.getElementById('location-filter').value,
            status_buka: document.querySelector('input[name="status"]:checked').value
        };

        try {
            const response = await window.gunungService.getGunungs(params);
            const gunungs = response.data;

            if (gunungs.length === 0) {
                grid.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            grid.innerHTML = gunungs.map(gunung => `
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:scale-105 transition-transform duration-300">
                    <div class="relative h-48">
                        <img src="${gunung.foto_cover || 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'}" alt="${gunung.nama}" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 ${gunung.status_buka ? 'bg-success' : 'bg-danger'} text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            ${gunung.status_buka ? 'Buka' : 'Tutup'}
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-secondary text-sm font-medium mb-2">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                            ${gunung.lokasi}
                        </div>
                        <h3 class="text-xl font-bold text-neutral-dark mb-1">${gunung.nama}</h3>
                        <p class="text-xs text-neutral-dark/40 mb-4">${gunung.ketinggian}</p>
                        
                        <div class="flex items-center justify-between border-t border-neutral-light pt-4">
                            <div>
                                <span class="text-xs text-neutral-dark/60 block">Status Jalur</span>
                                <span class="text-sm font-bold text-primary">${gunung.jalur_count || 0} Jalur Tersedia</span>
                            </div>
                            <a href="/gunung/${gunung.id}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');

            // Re-init lucide icons for new content
            lucide.createIcons();

        } catch (error) {
            console.error(error);
            window.showAlert('Gagal memuat data gunung', 'danger');
        }
    }
</script>
@endpush
@endsection
