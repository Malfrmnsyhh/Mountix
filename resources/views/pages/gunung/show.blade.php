@extends('layouts.app')

@section('title', 'Detail Gunung - Mountix')

@section('content')
<div id="loading-overlay" class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center">
    <i data-lucide="loader-2" class="w-12 h-12 animate-spin text-primary mb-4"></i>
    <p class="text-neutral-dark/60 font-medium">Memuat detail gunung...</p>
</div>

<!-- Hero Detail -->
<section id="mountain-hero" class="relative h-[500px] flex items-end pb-20 text-white">
    <div class="absolute inset-0 z-0">
        <img id="gunung-cover" src="" alt="Gunung" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 w-full">
        <div class="flex flex-wrap items-center gap-4 mb-6">
            <span id="gunung-lokasi-badge" class="bg-secondary text-white px-4 py-1.5 rounded-full text-sm font-bold flex items-center">
                <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> <span id="gunung-lokasi"></span>
            </span>
            <span id="gunung-status-badge" class="px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider"></span>
        </div>
        <h1 id="gunung-nama" class="text-4xl md:text-6xl font-bold mb-4 tracking-tight"></h1>
        <div class="flex items-center text-lg text-neutral-light/80 space-x-6">
            <span class="flex items-center"><i data-lucide="mountain" class="w-5 h-5 mr-2 text-secondary"></i> <span id="gunung-ketinggian"></span></span>
            <span class="flex items-center"><i data-lucide="star" class="w-5 h-5 mr-2 text-warning fill-current"></i> 4.8 (120 Review)</span>
        </div>
    </div>
</section>

<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
        <!-- Left: Description & Info -->
        <div class="lg:col-span-2 space-y-12">
            <div>
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="info" class="w-6 h-6 mr-3"></i> Deskripsi Gunung
                </h2>
                <p id="gunung-deskripsi" class="text-neutral-dark/70 leading-relaxed text-lg"></p>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="scroll-text" class="w-6 h-6 mr-3"></i> Syarat Pendakian
                </h2>
                <div id="gunung-syarat" class="bg-white p-8 rounded-2xl shadow-sm border border-neutral-light text-neutral-dark/70 leading-relaxed italic"></div>
            </div>

            <!-- Routes Table -->
            <div>
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="map" class="w-6 h-6 mr-3"></i> Jalur Pendakian Tersedia
                </h2>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-neutral-light">
                    <table class="w-full text-left">
                        <thead class="bg-neutral-light border-b border-neutral-dark/5">
                            <tr>
                                <th class="px-6 py-4 text-sm font-bold text-neutral-dark">Nama Jalur</th>
                                <th class="px-6 py-4 text-sm font-bold text-neutral-dark">Estimasi</th>
                                <th class="px-6 py-4 text-sm font-bold text-neutral-dark text-right">Harga</th>
                                <th class="px-6 py-4 text-sm font-bold text-neutral-dark text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="jalur-list" class="divide-y divide-neutral-light">
                            <!-- Jalur rows inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Fast Booking Card -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-neutral-light sticky top-24">
                <h3 class="text-xl font-bold text-primary mb-6">Booking Sekarang</h3>
                <div class="space-y-6">
                    <div class="p-4 bg-neutral-light rounded-2xl">
                        <span class="text-xs text-neutral-dark/40 block mb-1">Mulai dari</span>
                        <span id="gunung-min-price" class="text-2xl font-black text-primary"></span>
                        <span class="text-neutral-dark/40 text-sm">/ orang</span>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center text-sm text-neutral-dark/70">
                            <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-success"></i>
                            Konfirmasi Instan
                        </div>
                        <div class="flex items-center text-sm text-neutral-dark/70">
                            <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-success"></i>
                            E-Ticket Digital
                        </div>
                        <div class="flex items-center text-sm text-neutral-dark/70">
                            <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-success"></i>
                            Customer Support 24/7
                        </div>
                    </div>

                    <button onclick="scrollToJalur()" class="w-full bg-secondary text-white py-4 rounded-2xl font-bold hover:bg-secondary/90 transition-all shadow-lg shadow-secondary/20">
                        Pilih Jalur & Tanggal
                    </button>
                    
                    <p class="text-[10px] text-center text-neutral-dark/40 px-4">
                        Dengan mengklik tombol di atas, Anda menyetujui semua peraturan pendakian yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const id = "{{ $id }}";

    document.addEventListener('DOMContentLoaded', function() {
        loadDetail();
    });

    async function loadDetail() {
        try {
            const response = await window.gunungService.getGunungDetail(id);
            const gunung = response.data;

            // Update UI
            document.getElementById('gunung-cover').src = gunung.foto_cover || 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1920';
            document.getElementById('gunung-nama').textContent = gunung.nama;
            document.getElementById('gunung-lokasi').textContent = gunung.lokasi;
            document.getElementById('gunung-ketinggian').textContent = gunung.ketinggian;
            document.getElementById('gunung-deskripsi').textContent = gunung.deskripsi;
            document.getElementById('gunung-syarat').innerHTML = `<p>${gunung.syarat_pendakian.replace(/\n/g, '<br>')}</p>`;

            const statusBadge = document.getElementById('gunung-status-badge');
            if (gunung.status_buka) {
                statusBadge.textContent = 'Buka';
                statusBadge.className = 'px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider bg-success text-white';
            } else {
                statusBadge.textContent = 'Tutup';
                statusBadge.className = 'px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider bg-danger text-white';
            }

            // Jalur List
            const jalurList = document.getElementById('jalur-list');
            if (gunung.jalur && gunung.jalur.length > 0) {
                jalurList.innerHTML = gunung.jalur.map(j => `
                    <tr class="hover:bg-neutral-light/50 transition-colors">
                        <td class="px-6 py-6">
                            <span class="font-bold text-neutral-dark block">${j.nama_jalur}</span>
                            <span class="text-xs text-neutral-dark/40">${j.deskripsi || 'Jalur pendakian resmi'}</span>
                        </td>
                        <td class="px-6 py-6 text-sm text-neutral-dark/60">
                            <i data-lucide="clock" class="w-4 h-4 inline mr-1"></i> ${j.estimasi_jam} Jam
                        </td>
                        <td class="px-6 py-6 text-right">
                            <span class="font-black text-primary">Rp ${new Intl.NumberFormat('id-ID').format(j.harga_per_orang)}</span>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <button onclick="bookJalur(${j.id})" class="bg-primary text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-primary/90 transition-all">
                                Pilih
                            </button>
                        </td>
                    </tr>
                `).join('');
                
                const minPrice = Math.min(...gunung.jalur.map(j => j.harga_per_orang));
                document.getElementById('gunung-min-price').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(minPrice)}`;
            } else {
                jalurList.innerHTML = '<tr><td colspan="4" class="px-6 py-10 text-center text-neutral-dark/40">Tidak ada jalur tersedia</td></tr>';
                document.getElementById('gunung-min-price').textContent = 'N/A';
            }

            // Hide loading
            document.getElementById('loading-overlay').classList.add('hidden');
            lucide.createIcons();

        } catch (error) {
            console.error(error);
            window.showAlert('Gagal memuat detail gunung', 'danger');
        }
    }

    function scrollToJalur() {
        document.getElementById('jalur-list').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function bookJalur(jalurId) {
        // Kirim gunung_id agar halaman booking tidak perlu N+1 API loop
        window.location.href = `/booking/create?gunung_id=${id}&jalur_id=${jalurId}`;
    }
</script>
@endpush
@endsection
