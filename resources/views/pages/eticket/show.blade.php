@extends('layouts.app')

@section('title', 'E-Ticket - Mountix')

@section('content')
<div id="loading-overlay" class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center">
    <i data-lucide="loader-2" class="w-12 h-12 animate-spin text-primary mb-4"></i>
    <p class="text-neutral-dark/60 font-medium">Menyiapkan E-Ticket Anda...</p>
</div>

<div class="bg-primary pt-32 pb-40">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">E-Ticket Pendakian</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Tunjukkan tiket ini kepada petugas di basecamp saat melakukan check-in.</p>
    </div>
</div>

<section class="max-w-4xl mx-auto px-4 -mt-32 pb-24 relative z-10">
    <div id="tickets-container" class="space-y-12">
        <!-- Tickets will be inserted here -->
    </div>

    <div class="mt-12 flex justify-center space-x-4">
        <button onclick="window.print()" class="flex items-center px-8 py-4 bg-white text-primary border-2 border-primary font-bold rounded-2xl hover:bg-neutral-light transition-all print:hidden">
            <i data-lucide="printer" class="w-5 h-5 mr-3"></i> Cetak Tiket
        </button>
        <a href="{{ route('booking.index') }}" class="flex items-center px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 print:hidden">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-3"></i> Kembali
        </a>
    </div>
</section>

@push('scripts')
<script>
    const bookingId = "{{ $booking_id }}";

    document.addEventListener('DOMContentLoaded', async function() {
        await loadTickets();
    });

    async function loadTickets() {
        try {
            // Fetch booking detail first to get header info
            const bookingResponse = await window.bookingService.getBookingDetail(bookingId);
            const booking = bookingResponse.data;

            // Fetch actual tickets from the new endpoint we identified in BookingController.php
            // Route was: Route::get('booking/{booking}/ticket', [BookingController::class, 'ticket']);
            // But we'll use the apiClient directly since we don't have it in bookingService yet.
            const ticketResponse = await window.apiClient.get(`/booking/${bookingId}/ticket`);
            const tickets = ticketResponse.data.data;

            const container = document.getElementById('tickets-container');
            
            if (tickets.length === 0) {
                container.innerHTML = `
                    <div class="bg-white p-12 rounded-3xl shadow-xl text-center">
                        <i data-lucide="alert-circle" class="w-16 h-16 text-warning mx-auto mb-6"></i>
                        <h2 class="text-2xl font-bold text-primary mb-2">Tiket Belum Tersedia</h2>
                        <p class="text-neutral-dark/60">E-Ticket akan muncul di sini setelah pembayaran Anda disetujui oleh admin.</p>
                    </div>
                `;
            } else {
                container.innerHTML = tickets.map(tkt => `
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-neutral-light flex flex-col md:flex-row print:shadow-none print:border-neutral-dark/20">
                        <!-- Left Part: Ticket Info -->
                        <div class="flex-grow p-10 md:border-r-2 md:border-dashed border-neutral-light">
                            <div class="flex justify-between items-start mb-10">
                                <div>
                                    <h2 class="text-3xl font-black text-primary leading-tight">MOUNTIX <span class="text-secondary text-base font-bold ml-2">OFFICIAL TICKET</span></h2>
                                    <p class="text-xs text-neutral-dark/40 uppercase tracking-widest mt-1">Gunung ${booking.jalur.gunung.nama}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-neutral-dark/40 uppercase block">Ticket ID</span>
                                    <span class="text-sm font-mono font-bold text-primary">${tkt.qr_code}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-y-8 gap-x-12">
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase block mb-1">Nama Pendaki</span>
                                    <span class="text-lg font-bold text-neutral-dark">${tkt.nama_lengkap}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase block mb-1">Jalur Pendakian</span>
                                    <span class="text-lg font-bold text-neutral-dark">${booking.jalur.nama_jalur}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase block mb-1">Tanggal Naik</span>
                                    <span class="text-lg font-bold text-neutral-dark">${booking.tanggal_naik}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase block mb-1">Tanggal Turun</span>
                                    <span class="text-lg font-bold text-neutral-dark">${booking.tanggal_turun}</span>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-neutral-light/50 flex items-center text-xs text-neutral-dark/40 space-x-6">
                                <span class="flex items-center"><i data-lucide="info" class="w-4 h-4 mr-2"></i> Bawa KTP Asli</span>
                                <span class="flex items-center"><i data-lucide="info" class="w-4 h-4 mr-2"></i> Tunjukkan QR Code</span>
                            </div>
                        </div>

                        <!-- Right Part: QR Code Area -->
                        <div class="w-full md:w-64 bg-neutral-light/30 flex flex-col items-center justify-center p-10 space-y-4">
                            <div class="bg-white p-4 rounded-2xl shadow-md border border-neutral-light">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${tkt.qr_code}" alt="QR Code" class="w-32 h-32">
                            </div>
                            <span class="text-[10px] text-neutral-dark/40 font-bold uppercase tracking-widest">Scan to Check-in</span>
                        </div>
                    </div>
                `).join('');
            }

            lucide.createIcons();
            document.getElementById('loading-overlay').classList.add('hidden');
        } catch (error) {
            console.error(error);
            window.showAlert('Gagal memuat e-ticket.', 'danger');
        }
    }
</script>
@endpush

<style>
@media print {
    body { background: white !important; }
    nav, footer { display: none !important; }
    main { padding: 0 !important; margin: 0 !important; }
    .pt-32, .pb-40 { padding: 0 !important; background: none !important; color: black !important; }
    .text-white { color: black !important; }
    .-mt-32 { margin-top: 2rem !important; }
    .shadow-2xl { border: 1px solid #eee !important; }
}
</style>
@endsection
