@extends('layouts.app')

@section('title', 'Daftar Gunung - Mountix')

@section('content')

<div class="bg-primary pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-3xl md:text-4xl font-bold mb-3 tracking-tight">Jelajahi Keindahan Gunung di Pulau Jawa</h1>
        <p class="text-neutral-light/60 text-sm md:text-base max-w-xl mx-auto leading-relaxed">
            Temukan jalur pendakian terbaik dan rencanakan petualangan Anda dengan mudah.
        </p>
    </div>
</div>

<section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filters Sidebar -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-neutral-light sticky top-24">
                <h3 class="font-bold text-primary mb-5 flex items-center text-sm uppercase tracking-wider">
                    <i data-lucide="filter" class="w-4 h-4 mr-2"></i> Filter
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-neutral-dark/60 uppercase mb-2">Cari Nama</label>
                        <input type="text" id="search-input" placeholder="Nama gunung..." 
                            class="w-full px-4 py-2.5 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-neutral-dark/60 uppercase mb-2">Lokasi</label>
                        <select id="location-filter" class="w-full px-4 py-2.5 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all text-sm appearance-none">
                            <option value="">Semua Lokasi</option>
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Jawa Tengah">Jawa Tengah</option>
                            <option value="Jawa Timur">Jawa Timur</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-neutral-dark/60 uppercase mb-2">Status</label>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm text-neutral-dark/80 cursor-pointer group">
                                <input type="radio" name="status" value="" checked class="w-4 h-4 text-primary focus:ring-primary border-neutral-light mr-3">
                                <span class="group-hover:text-primary transition-colors">Semua</span>
                            </label>
                            <label class="flex items-center text-sm text-neutral-dark/80 cursor-pointer group">
                                <input type="radio" name="status" value="1" class="w-4 h-4 text-primary focus:ring-primary border-neutral-light mr-3">
                                <span class="group-hover:text-primary transition-colors">Buka</span>
                            </label>
                            <label class="flex items-center text-sm text-neutral-dark/80 cursor-pointer group">
                                <input type="radio" name="status" value="0" class="w-4 h-4 text-primary focus:ring-primary border-neutral-light mr-3">
                                <span class="group-hover:text-primary transition-colors">Tutup</span>
                            </label>
                        </div>
                    </div>

                    <button id="apply-filters" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all text-sm shadow-md shadow-primary/10">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow">
            <!-- Grid Container -->
            <div id="gunung-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Loading State -->
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-neutral-dark/40">
                    <i data-lucide="loader-2" class="w-10 h-10 animate-spin mb-4 text-primary"></i>
                    <p class="text-sm font-medium tracking-wide">Mengambil data gunung...</p>
                </div>
            </div>

            <!-- Empty State (Hidden) -->
            <div id="empty-state" class="hidden py-20 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-neutral-light rounded-full flex items-center justify-center mb-6">
                    <i data-lucide="search-x" class="w-8 h-8 text-neutral-dark/20"></i>
                </div>
                <h3 class="text-lg font-bold text-neutral-dark">Gunung Tidak Ditemukan</h3>
                <p class="text-sm text-neutral-dark/60 mt-2">Coba gunakan kata kunci atau filter yang berbeda.</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek autentikasi secara client-side
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '/login?redirect=/gunung';
            return;
        }

        loadGunungs();
        document.getElementById('apply-filters').addEventListener('click', () => loadGunungs());
    });

    async function loadGunungs() {
        const grid = document.getElementById('gunung-grid');
        const emptyState = document.getElementById('empty-state');
        
        grid.innerHTML = `
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-neutral-dark/40">
                <i data-lucide="loader-2" class="w-10 h-10 animate-spin mb-4 text-primary"></i>
                <p class="text-sm font-medium tracking-wide">Memuat data gunung...</p>
            </div>
        `;
        emptyState.classList.add('hidden');

        const statusVal = document.querySelector('input[name="status"]:checked').value;
        const params = {
            nama: document.getElementById('search-input').value,
            lokasi: document.getElementById('location-filter').value
        };
        
        if (statusVal !== "") {
            params.status_buka = statusVal;
        }

        try {
            // Kita panggil API /api/v1/gunung yang datanya dari DB Admin
            const response = await window.apiClient.get('/gunung', { params });
            const gunungs = response.data.data; // Laravel Resource biasanya membungkus dalam 'data'

            if (!gunungs || gunungs.length === 0) {
                grid.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            grid.innerHTML = gunungs.map(gunung => {
                const imageUrl = (gunung.foto_cover && !gunung.foto_cover.startsWith('http')) 
                    ? `/storage/${gunung.foto_cover}` 
                    : (gunung.foto_cover || 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800');

                return `
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-light overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="relative h-44">
                        <img src="${imageUrl}" alt="${gunung.nama}" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3 ${gunung.status_buka ? 'bg-success' : 'bg-danger'} text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">
                            ${gunung.status_buka ? 'Buka' : 'Tutup'}
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center text-secondary text-[10px] font-black uppercase tracking-widest mb-2">
                            <i data-lucide="map-pin" class="w-3 h-3 mr-1"></i>
                            ${gunung.lokasi}
                        </div>
                        <h3 class="text-lg font-bold text-primary mb-1">${gunung.nama}</h3>
                        <div class="flex items-center text-xs text-neutral-dark/40 mb-4">
                            <i data-lucide="mountain-snow" class="w-3 h-3 mr-1"></i>
                            ${gunung.ketinggian} MDPL
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-neutral-light pt-4">
                            <div>
                                <span class="text-[10px] text-neutral-dark/40 font-bold uppercase block">Ketersediaan</span>
                                <span class="text-xs font-bold text-neutral-dark">${gunung.jalurs_count || 0} Jalur Pendakian</span>
                            </div>
                            <a href="/gunung/${gunung.id}" class="bg-primary text-white p-2.5 rounded-xl hover:bg-secondary transition-all shadow-md shadow-primary/5 group">
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `}).join('');

            lucide.createIcons();

        } catch (error) {
            console.error(error);
            grid.innerHTML = '';
            window.showAlert('Gagal mengambil data dari server.', 'danger');
        }
    }
</script>
@endpush
@endsection
