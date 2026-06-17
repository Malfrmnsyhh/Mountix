@extends('layouts.app')

@section('title', 'E-Ticket Saya - Mountix')

@section('content')
{{-- Header --}}
<div class="bg-primary pt-10 pb-10">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">E-Ticket Saya</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Semua e-ticket pendakian Anda yang sudah aktif dan siap digunakan.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Loading State --}}
    <div id="eticket-loading" class="py-20 text-center bg-white rounded-3xl border border-neutral-light">
        <div class="animate-spin inline-block w-8 h-8 border-[3px] border-current border-t-transparent text-primary rounded-full mb-4"></div>
        <p class="text-sm font-medium text-neutral-dark/40">Memuat e-ticket Anda...</p>
    </div>

    {{-- Content Container --}}
    <div id="eticket-container" class="hidden space-y-6"></div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        await loadETickets();
    });

    async function loadETickets() {
        const loading = document.getElementById('eticket-loading');
        const container = document.getElementById('eticket-container');

        try {
            const response = await window.apiClient.get('/booking');
            let allBookings = response.data.data || response.data;
            if (!Array.isArray(allBookings)) allBookings = [];

            // Filter booking yang sudah selesai / tiket terbit
            const bookings = allBookings.filter(b => ['ticket_issued', 'verified', 'success', 'completed'].includes(b.status));

            loading.classList.add('hidden');
            container.classList.remove('hidden');

            if (bookings.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-neutral-light">
                        <div class="bg-neutral-light w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="ticket-x" class="w-10 h-10 text-neutral-dark/20"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-neutral-dark mb-2">Belum Ada E-Ticket</h2>
                        <p class="text-neutral-dark/60 mb-8">E-ticket akan tersedia setelah pembayaran Anda diverifikasi.</p>
                        <a href="/booking" class="inline-flex items-center bg-secondary text-white px-8 py-3 rounded-2xl font-bold hover:bg-secondary/90 transition-all shadow-lg shadow-secondary/20">
                            Lihat Booking Saya <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                        </a>
                    </div>`;
                lucide.createIcons();
                return;
            }

            container.innerHTML = bookings.map(b => `
                <div class="bg-white rounded-3xl shadow-sm border border-neutral-light overflow-hidden hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row">
                        {{-- Left: Info --}}
                        <div class="p-8 md:w-2/3 border-b md:border-b-0 md:border-r border-neutral-light">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <span class="bg-neutral-light text-neutral-dark px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                        ${b.kode_booking}
                                    </span>
                                    <span class="text-xs text-neutral-dark/40 italic">
                                        ${new Date(b.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'short', year:'numeric'})}
                                    </span>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border bg-success text-white border-success">
                                    Selesai
                                </span>
                            </div>

                            <div class="flex items-start gap-6">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-neutral-light">
                                    <img src="${b.jalur?.gunung?.foto_cover || 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400'}"
                                         class="w-full h-full object-cover" alt="${b.jalur?.gunung?.nama || 'Gunung'}">
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-primary mb-1">${b.jalur?.gunung?.nama || 'Gunung Tidak Ditemukan'}</h3>
                                    <p class="text-sm text-neutral-dark/60 mb-4 flex items-center gap-1">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-secondary"></i>
                                        ${b.jalur?.nama_jalur || 'Jalur Tidak Ditemukan'}
                                    </p>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <div>
                                            <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Tanggal</span>
                                            <span class="text-sm font-bold text-neutral-dark">${b.tanggal_naik}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Peserta</span>
                                            <span class="text-sm font-bold text-neutral-dark">${b.jumlah_orang} Orang</span>
                                        </div>
                                        <div class="hidden md:block">
                                            <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Total Tiket</span>
                                            <span class="text-sm font-black text-primary italic">${b.jumlah_orang} Tiket</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right: QR Preview + Action --}}
                        <div class="p-8 md:w-1/3 bg-neutral-light/20 flex flex-col justify-center items-center gap-5">
                            <div class="bg-white p-3 rounded-2xl shadow-md border border-neutral-light">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${b.kode_booking}"
                                     alt="QR Code" class="w-24 h-24 opacity-80">
                            </div>
                            <a href="/eticket/${b.id}"
                               class="w-full bg-primary text-white py-3 rounded-2xl text-center font-bold hover:bg-secondary transition-all shadow-md text-sm flex items-center justify-center gap-2">
                                <i data-lucide="ticket" class="w-4 h-4"></i>
                                Lihat E-Ticket
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');

            lucide.createIcons();

        } catch (error) {
            console.error(error);
            loading.classList.add('hidden');
            container.classList.remove('hidden');
            container.innerHTML = `
                <div class="bg-white p-12 rounded-3xl text-center border border-neutral-light text-danger font-bold italic">
                    Gagal memuat data e-ticket.
                </div>`;
        }
    }
</script>
@endpush
@endsection
