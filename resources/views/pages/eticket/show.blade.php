@extends('layouts.app')

@section('title', 'E-Ticket - Mountix')

@section('content')
<div id="loading-overlay" class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-primary mb-4"></div>
    <p class="text-neutral-dark/60 font-black uppercase tracking-widest text-xs">Menyiapkan E-Ticket...</p>
</div>

<div class="bg-primary pt-28 pb-12 print:hidden">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-3xl md:text-4xl font-bold mb-3 tracking-tight">E-Ticket Pendakian</h1>
        <p class="text-neutral-light/60 text-sm md:text-base max-w-xl mx-auto leading-relaxed italic">Wajib dibawa dan ditunjukkan saat registrasi ulang di basecamp.</p>
    </div>
</div>

<section class="max-w-4xl mx-auto px-4 -mt-12 pb-24 relative z-10 print:mt-0 print:pb-0">
    <div id="tickets-container" class="space-y-12">
        <!-- Tickets will be inserted here via JS -->
    </div>

    <div class="mt-12 flex justify-center space-x-4 print:hidden">
        <button onclick="window.print()" class="flex items-center px-8 py-4 bg-white text-primary border-2 border-primary font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-neutral-light transition-all shadow-xl">
            <i data-lucide="printer" class="w-5 h-5 mr-3"></i> Cetak Tiket (PDF)
        </button>
        <a href="{{ route('profile.show') }}?tab=booking" class="flex items-center px-8 py-4 bg-primary text-white font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-secondary transition-all shadow-xl">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-3"></i> Kembali ke Profil
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
        const container = document.getElementById('tickets-container');
        try {
            // Kita gunakan data dari window.apiClient yang sudah kita inject
            const response = await window.apiClient.get(`/booking/${bookingId}`);
            const b = response.data.data || response.data;
            
            // Cek apakah statusnya sudah issued/success
            if (!['success', 'ticket_issued', 'completed', 'verified'].includes(b.status)) {
                container.innerHTML = `
                    <div class="bg-white p-12 rounded-3xl shadow-xl text-center border-2 border-dashed border-warning/20">
                        <i data-lucide="clock" class="w-16 h-16 text-warning mx-auto mb-6"></i>
                        <h2 class="text-2xl font-bold text-primary mb-2 uppercase">Tiket Belum Terbit</h2>
                        <p class="text-neutral-dark/60 italic">Pembayaran Anda sedang dalam proses verifikasi admin. Silakan cek kembali nanti.</p>
                    </div>`;
                lucide.createIcons();
                document.getElementById('loading-overlay').classList.add('hidden');
                return;
            }

            if (!b.members || b.members.length === 0) {
                container.innerHTML = `<p class="text-center text-danger font-bold uppercase">Data peserta tidak ditemukan.</p>`;
                document.getElementById('loading-overlay').classList.add('hidden');
                return;
            }

            container.innerHTML = b.members.map(m => `
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-neutral-light flex flex-col md:flex-row print:shadow-none print:border-neutral-dark/20 print:mb-8">
                    <!-- Bagian Kiri: Info Tiket -->
                    <div class="flex-grow p-8 md:p-12 md:border-r-2 md:border-dashed border-neutral-light relative">
                        <!-- Watermark -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
                            <h1 class="text-9xl font-black -rotate-12 uppercase tracking-tighter">MOUNTIX</h1>
                        </div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-12">
                                <div>
                                    <h2 class="text-3xl font-black text-primary leading-tight tracking-tighter uppercase">MOUNTIX <span class="text-secondary text-sm font-bold block tracking-[0.3em] mt-1">OFFICIAL PASS</span></h2>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-neutral-dark/40 uppercase font-black block">ID BOOKING</span>
                                    <span class="text-base font-mono font-black text-primary">${b.kode_booking}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase font-black block mb-1">Nama Pendaki</span>
                                    <span class="text-xl font-black text-primary uppercase">${m.nama_lengkap}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase font-black block mb-1">Gunung - Jalur</span>
                                    <span class="text-xl font-black text-primary uppercase">${b.gunung?.nama || b.jalur?.gunung?.nama || 'Nama Gunung'}</span>
                                    <p class="text-xs font-bold text-secondary uppercase tracking-widest mt-1">${b.jalur?.nama_jalur || 'Nama Jalur'}</p>
                                </div>
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase font-black block mb-1">Tanggal Naik</span>
                                    <span class="text-xl font-black text-primary uppercase">${b.tanggal_naik}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-neutral-dark/40 uppercase font-black block mb-1">Peran</span>
                                    <span class="px-3 py-1 bg-primary text-white text-[10px] font-black rounded-full uppercase tracking-widest">
                                        ${m.is_leader ? 'Ketua Rombongan' : 'Anggota'}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-neutral-light/50 flex flex-wrap gap-6 items-center text-[10px] font-black text-neutral-dark/40 uppercase tracking-widest">
                                <span class="flex items-center"><i data-lucide="shield-check" class="w-4 h-4 mr-2 text-success"></i> Verified Ticket</span>
                                <span class="flex items-center"><i data-lucide="info" class="w-4 h-4 mr-2"></i> Bawa Identitas Asli</span>
                                <span class="flex items-center"><i data-lucide="camera" class="w-4 h-4 mr-2"></i> Scan to Verify</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Kanan: QR Code -->
                    <div class="w-full md:w-72 bg-neutral-light/30 flex flex-col items-center justify-center p-8 md:p-12 space-y-6 print:bg-white">
                        <div class="bg-white p-4 rounded-3xl shadow-xl border border-neutral-light">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${b.kode_booking}-${m.nik}" alt="QR" class="w-40 h-40">
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] text-neutral-dark/40 font-black uppercase tracking-[0.2em]">Pindai Tiket Ini</span>
                            <p class="text-[9px] text-neutral-dark/30 mt-2 italic leading-tight">Gunakan QR ini untuk proses check-in <br> di gerbang pendakian.</p>
                        </div>
                    </div>
                </div>
            `).join('');

            lucide.createIcons();
        } catch (error) {
            console.error(error);
            window.showAlert('Gagal memuat e-ticket.', 'danger');
        } finally {
            document.getElementById('loading-overlay').classList.add('hidden');
        }
    }
</script>
@endpush

<style>
@media print {
    body { background: white !important; -webkit-print-color-adjust: exact; }
    nav, footer, .print\:hidden { display: none !important; }
    main { padding: 0 !important; margin: 0 !important; }
    section { max-width: 100% !important; margin-top: 0 !important; }
    .shadow-2xl { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>
@endsection
