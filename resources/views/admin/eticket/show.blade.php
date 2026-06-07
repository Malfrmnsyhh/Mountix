@extends('admin.layouts.app')

@section('title', 'Detail E-Ticket - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.eticket.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <h1 class="text-3xl font-black text-neutral-dark">Validasi Tiket</h1>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-[40px] border border-neutral-light shadow-xl shadow-neutral-dark/5 overflow-hidden">
        <div class="bg-primary p-8 text-white text-center">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-md">
                <i data-lucide="ticket" class="w-10 h-10"></i>
            </div>
            <h2 class="text-2xl font-black uppercase tracking-widest">E-Ticket Pendakian</h2>
            <p class="text-white/60 text-xs font-bold tracking-widest uppercase mt-2">Mountix Official Ticket</p>
        </div>

        <div class="p-10 space-y-8">
            <div class="flex justify-center">
                <div class="p-4 bg-white border-2 border-neutral-light rounded-3xl">
                    <!-- Placeholder for QR Code Image -->
                    <div class="w-48 h-48 bg-neutral-light rounded-2xl flex items-center justify-center">
                        <i data-lucide="qr-code" class="w-20 h-20 text-neutral-dark/20"></i>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <div class="text-[10px] font-black text-neutral-dark/40 uppercase tracking-[0.3em] mb-1">Ticket ID</div>
                <div class="text-xl font-mono font-black text-primary">{{ $eticket->qr_code }}</div>
            </div>

            <div class="grid grid-cols-2 gap-8 pt-8 border-t border-dashed border-neutral-light">
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-1">Nama Pendaki</h4>
                    <p class="text-sm font-black text-neutral-dark uppercase">{{ $eticket->nama_lengkap }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-1">Gunung</h4>
                    <p class="text-sm font-black text-neutral-dark uppercase">{{ $eticket->booking->jalur->gunung->nama }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-1">Jalur</h4>
                    <p class="text-sm font-bold text-neutral-dark/70">{{ $eticket->booking->jalur->nama_jalur }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-1">Tanggal Naik</h4>
                    <p class="text-sm font-black text-primary">{{ \Carbon\Carbon::parse($eticket->booking->tanggal_naik)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-neutral-light/50 p-6 text-center border-t border-neutral-light">
            <p class="text-[10px] font-bold text-neutral-dark/40">Diterbitkan pada {{ $eticket->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-8 flex gap-4">
        <button onclick="window.print()" class="flex-grow bg-neutral-dark text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-2">
            <i data-lucide="printer" class="w-5 h-5"></i> Cetak Tiket
        </button>
        <a href="{{ route('admin.booking.show', $eticket->booking_id) }}" class="flex-grow bg-white border border-neutral-light text-neutral-dark py-4 rounded-2xl font-bold flex items-center justify-center gap-2">
            <i data-lucide="external-link" class="w-5 h-5"></i> Lihat Booking
        </a>
    </div>
</div>
@endsection
