@extends('layouts.app')

@section('title', 'Profil Saya - Mountix')

@section('content')
<!-- Header Section -->
<div class="bg-primary pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Pusat Akun Pendaki</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Kelola profil, pantau status booking, dan akses e-ticket Anda dalam satu tempat.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        <!-- Left: Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-neutral-light overflow-hidden sticky top-24">
                <div class="p-8 text-center border-b border-neutral-light bg-neutral-light/10">
                    <div class="w-24 h-24 bg-secondary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-black uppercase shadow-lg border-4 border-white">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <h3 class="text-xl font-bold text-primary">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-neutral-dark/40 font-bold uppercase tracking-widest mt-1">{{ auth()->user()->role }}</p>
                </div>
                <nav class="p-4">
                    <ul class="space-y-2" id="profile-tabs">
                        <li>
                            <button onclick="switchTab('detail')" id="tab-btn-detail" class="w-full flex items-center p-3 rounded-2xl transition-all bg-primary text-white shadow-md shadow-primary/20">
                                <i data-lucide="user" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm font-bold">Detail Profil</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="switchTab('booking')" id="tab-btn-booking" class="w-full flex items-center p-3 rounded-2xl transition-all text-neutral-dark hover:bg-neutral-light">
                                <i data-lucide="calendar" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm font-bold">Booking Saya</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="switchTab('eticket')" id="tab-btn-eticket" class="w-full flex items-center p-3 rounded-2xl transition-all text-neutral-dark hover:bg-neutral-light">
                                <i data-lucide="ticket" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm font-bold">E-Ticket Aktif</span>
                            </button>
                        </li>
                        <hr class="my-4 border-neutral-light">
                        <li>
                            <button onclick="handleLogout()" class="w-full flex items-center p-3 rounded-2xl transition-all text-danger hover:bg-danger/10 font-bold">
                                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm">Keluar Akun</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Right: Tab Contents -->
        <div class="lg:col-span-3">
            <!-- Tab 1: Detail Profil -->
            <div id="tab-content-detail" class="space-y-8 animate-in fade-in duration-500">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light">
                    <div class="flex justify-between items-center mb-10">
                        <h2 class="text-2xl font-bold text-primary flex items-center">
                            <i data-lucide="shield-check" class="w-6 h-6 mr-3 text-secondary"></i> Informasi Akun
                        </h2>
                        <a href="{{ route('profile.edit') }}" class="text-xs font-black uppercase tracking-widest text-secondary hover:underline flex items-center">
                            <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Profil
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Nama Lengkap</label>
                            <p class="text-lg font-bold text-primary">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Email</label>
                            <p class="text-lg font-bold text-primary">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Nomor Telepon</label>
                            <p class="text-lg font-bold text-primary">{{ auth()->user()->phone ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Terdaftar Sejak</label>
                            <p class="text-lg font-bold text-primary">{{ auth()->user()->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Booking Saya -->
            <div id="tab-content-booking" class="hidden space-y-6 animate-in fade-in duration-500">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-primary">Daftar Booking</h2>
                    <span class="text-xs text-neutral-dark/40 font-bold uppercase tracking-widest" id="booking-count-badge">0 Booking</span>
                </div>
                <div id="booking-list-container" class="space-y-4">
                    <!-- Loaded via JS -->
                </div>
            </div>

            <!-- Tab 3: E-Ticket Aktif -->
            <div id="tab-content-eticket" class="hidden space-y-6 animate-in fade-in duration-500">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-primary">E-Ticket Saya</h2>
                    <span class="text-xs text-success font-bold uppercase tracking-widest">Siap Digunakan</span>
                </div>
                <div id="eticket-list-container" class="space-y-6">
                    <!-- Loaded via JS -->
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab') || 'detail';
        switchTab(tab);
    });

    function switchTab(tabName) {
        // Hide all contents
        ['detail', 'booking', 'eticket'].forEach(t => {
            const content = document.getElementById(`tab-content-${t}`);
            const btn = document.getElementById(`tab-btn-${t}`);
            if (content) content.classList.add('hidden');
            if (btn) {
                btn.classList.remove('bg-primary', 'text-white', 'shadow-md', 'shadow-primary/20');
                btn.classList.add('text-neutral-dark', 'hover:bg-neutral-light');
            }
        });

        // Show selected content
        const activeContent = document.getElementById(`tab-content-${tabName}`);
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        
        if (activeContent) activeContent.classList.remove('hidden');
        if (activeBtn) {
            activeBtn.classList.remove('text-neutral-dark', 'hover:bg-neutral-light');
            activeBtn.classList.add('bg-primary', 'text-white', 'shadow-md', 'shadow-primary/20');
        }

        // Load data based on tab
        if (tabName === 'booking') loadMyBookings();
        if (tabName === 'eticket') loadMyETickets();

        if (window.lucide) {
            lucide.createIcons();
        }
    }

    async function loadMyBookings() {
        const container = document.getElementById('booking-list-container');
        if (!container) return;

        container.innerHTML = `
            <div class="py-20 text-center bg-white rounded-3xl border border-neutral-light">
                <div class="animate-spin inline-block w-8 h-8 border-[3px] border-current border-t-transparent text-primary rounded-full mb-4"></div>
                <p class="text-sm font-medium text-neutral-dark/40">Memuat riwayat booking...</p>
            </div>`;

        try {
            const response = await window.apiClient.get('/booking');
            const bookings = response.data.data || response.data;
            document.getElementById('booking-count-badge').textContent = `${bookings.length} Booking`;

            if (bookings.length === 0) {
                container.innerHTML = `
                    <div class="bg-white p-12 rounded-3xl text-center border border-neutral-light">
                        <p class="text-neutral-dark/40 font-bold italic tracking-wide">Belum ada riwayat booking.</p>
                    </div>`;
                return;
            }

            container.innerHTML = bookings.map(b => `
                <div class="bg-white p-6 rounded-3xl border border-neutral-light shadow-sm hover:shadow-md transition-all">
                    <div class="flex flex-col md:flex-row justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-neutral-light flex-shrink-0">
                                <img src="${b.jalur?.gunung?.foto_cover ? b.jalur.gunung.foto_cover : 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=200'}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">${b.kode_booking}</span>
                                <h4 class="text-lg font-bold text-primary">${b.jalur?.gunung?.nama || 'Gunung'}</h4>
                                <p class="text-xs text-neutral-dark/60">${b.jalur?.nama_jalur || 'Jalur'} • ${b.tanggal_naik}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border ${getStatusClass(b.status)}">
                                ${b.status}
                            </span>
                            <a href="/booking/${b.id}" class="bg-neutral-light p-2 rounded-xl hover:bg-primary hover:text-white transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');
            lucide.createIcons();
        } catch (error) {
            console.error(error);
            container.innerHTML = `<div class="bg-white p-12 rounded-3xl text-center border border-neutral-light text-danger font-bold italic">Gagal memuat data booking.</div>`;
        }
    }

    async function loadMyETickets() {
        const container = document.getElementById('eticket-list-container');
        if (!container) return;

        container.innerHTML = `
            <div class="py-20 text-center bg-white rounded-3xl border border-neutral-light">
                <div class="animate-spin inline-block w-8 h-8 border-[3px] border-current border-t-transparent text-primary rounded-full mb-4"></div>
                <p class="text-sm font-medium text-neutral-dark/40">Memuat e-ticket...</p>
            </div>`;

        try {
            const response = await window.apiClient.get('/booking');
            let allBookings = response.data.data || response.data;
            if (!Array.isArray(allBookings)) allBookings = [];

            // Filter booking yang sudah lunas/tiket terbit
            const bookings = allBookings.filter(b => ['ticket_issued', 'verified', 'success', 'completed'].includes(b.status));

            if (bookings.length === 0) {
                container.innerHTML = `
                    <div class="bg-white p-12 rounded-3xl text-center border border-neutral-light">
                        <i data-lucide="ticket-x" class="w-12 h-12 mx-auto text-neutral-dark/20 mb-4"></i>
                        <p class="text-neutral-dark/40 font-bold italic tracking-wide">Tidak ada e-ticket yang aktif saat ini.</p>
                    </div>`;
                lucide.createIcons();
                return;
            }

            container.innerHTML = bookings.map(b => `
                <div class="bg-white p-8 rounded-3xl border-2 border-neutral-light shadow-sm flex flex-col md:flex-row gap-8 items-center relative overflow-hidden group hover:border-primary/20 transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12"></div>
                    
                    <div class="flex-grow space-y-4 w-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-black text-primary uppercase">${b.jalur?.gunung?.nama || 'Gunung'}</h4>
                                <p class="text-xs font-bold text-secondary tracking-widest uppercase">${b.jalur?.nama_jalur || 'Jalur'}</p>
                            </div>
                            <span class="text-[10px] font-black font-mono text-neutral-dark/40">${b.kode_booking}</span>
                        </div>
                        <div class="flex gap-6 text-[10px] font-bold text-neutral-dark/60 uppercase tracking-tighter">
                            <span><i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i> ${b.tanggal_naik}</span>
                            <span><i data-lucide="users" class="w-3 h-3 inline mr-1"></i> ${b.jumlah_orang} Peserta</span>
                        </div>
                        <a href="/eticket/${b.id}" class="inline-flex items-center px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-secondary transition-all">
                            Tampilkan E-Ticket <i data-lucide="external-link" class="w-3 h-3 ml-2"></i>
                        </a>
                    </div>

                    <div class="w-32 h-32 bg-neutral-light/50 rounded-2xl flex items-center justify-center border border-dashed border-neutral-light p-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${b.kode_booking}" class="w-24 h-24 opacity-60">
                    </div>
                </div>
            `).join('');
            lucide.createIcons();
        } catch (error) {
            console.error(error);
            container.innerHTML = `<div class="bg-white p-12 rounded-3xl text-center border border-neutral-light text-danger font-bold italic">Gagal memuat data e-ticket.</div>`;
        }
    }

    function getStatusClass(status) {
        const classes = {
            'draft': 'bg-neutral-light text-neutral-dark border-neutral-light',
            'pending_upload': 'bg-warning/10 text-warning border-warning/20',
            'waiting_verification': 'bg-primary/10 text-primary border-primary/20',
            'verified': 'bg-success/10 text-success border-success/20',
            'ticket_issued': 'bg-success text-white border-success',
            'rejected': 'bg-danger/10 text-danger border-danger/20',
            'cancelled': 'bg-neutral-dark/10 text-neutral-dark border-neutral-dark/20'
        };
        return classes[status] || 'bg-neutral-light text-neutral-dark';
    }
</script>
@endpush
@endsection
