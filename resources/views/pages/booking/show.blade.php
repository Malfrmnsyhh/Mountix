@extends('layouts.app')

@section('title', 'Detail Booking - Mountix')

@section('content')
<div class="bg-primary pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Detail Booking</h1>
        <p class="text-neutral-light/70 uppercase tracking-widest text-sm font-black">{{ $booking->kode_booking }}</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Status Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold mb-1">Status Saat Ini</span>
                    @php
                        $statusClasses = [
                            'draft' => 'text-neutral-dark',
                            'pending_upload' => 'text-warning',
                            'waiting_verification' => 'text-primary',
                            'verified' => 'text-success',
                            'ticket_issued' => 'text-success',
                            'rejected' => 'text-danger',
                            'cancelled' => 'text-neutral-dark',
                            'completed' => 'text-success',
                        ];
                        $statusText = [
                            'draft' => 'Draft',
                            'pending_upload' => 'Menunggu Bukti Bayar',
                            'waiting_verification' => 'Menunggu Verifikasi Admin',
                            'verified' => 'Pembayaran Disetujui',
                            'ticket_issued' => 'Tiket Telah Terbit',
                            'rejected' => 'Ditolak',
                            'cancelled' => 'Dibatalkan',
                            'completed' => 'Selesai Pendakian',
                        ];
                        $class = $statusClasses[$booking->status] ?? 'text-neutral-dark';
                        $text = $statusText[$booking->status] ?? $booking->status;
                    @endphp
                    <h2 class="text-2xl font-black {{ $class }} uppercase italic">{{ $text }}</h2>
                </div>
                <div class="hidden md:block">
                    @if(in_array($booking->status, ['pending_upload', 'waiting_verification']))
                        <i data-lucide="clock" class="w-12 h-12 text-warning animate-pulse"></i>
                    @elseif(in_array($booking->status, ['verified', 'ticket_issued', 'completed']))
                        <i data-lucide="check-circle" class="w-12 h-12 text-success"></i>
                    @endif
                </div>
            </div>

            <!-- Trip Info -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light">
                <h3 class="text-lg font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="mountain" class="w-5 h-5 mr-3"></i> Informasi Pendakian
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-neutral-light rounded-xl flex items-center justify-center text-primary">
                                <i data-lucide="map-pin"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Gunung & Jalur</span>
                                <span class="font-bold text-neutral-dark block">{{ $booking->jalur->gunung->nama ?? 'N/A' }}</span>
                                <span class="text-xs text-neutral-dark/60 italic">{{ $booking->jalur->nama_jalur ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-neutral-light rounded-xl flex items-center justify-center text-primary">
                                <i data-lucide="calendar"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Tanggal Pendakian</span>
                                <span class="font-bold text-neutral-dark">{{ $booking->tanggal_naik ? \Carbon\Carbon::parse($booking->tanggal_naik)->format('d F Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-neutral-light rounded-xl flex items-center justify-center text-primary">
                                <i data-lucide="users"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Jumlah Peserta</span>
                                <span class="font-bold text-neutral-dark">{{ $booking->jumlah_orang ?? 0 }} Orang</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-neutral-light rounded-xl flex items-center justify-center text-primary">
                                <i data-lucide="clock"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Durasi</span>
                                <span class="font-bold text-neutral-dark">Estimasi {{ $booking->jalur->estimasi_jam ?? '-' }} Jam</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participants List (FIXED) -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light">
                <h3 class="text-lg font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="list" class="w-5 h-5 mr-3"></i> Daftar Peserta
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] text-neutral-dark/40 uppercase font-bold border-b border-neutral-light">
                                <th class="pb-4">No</th>
                                <th class="pb-4">Nama Lengkap</th>
                                <th class="pb-4">No. NIK</th>
                                <th class="pb-4">L/P</th>
                                <th class="pb-4">Peran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-light">
                            @foreach($booking->members as $index => $member)
                                <tr>
                                    <td class="py-4 text-sm text-neutral-dark/60">{{ $index + 1 }}</td>
                                    <td class="py-4 text-sm font-bold text-neutral-dark">{{ $member->nama_lengkap }}</td>
                                    <td class="py-4 text-sm text-neutral-dark/60 font-mono">{{ $member->nik }}</td>
                                    <td class="py-4 text-sm text-neutral-dark/60 uppercase">{{ $member->jenis_kelamin }}</td>
                                    <td class="py-4">
                                        @if($member->is_leader)
                                            <span class="bg-primary/10 text-primary text-[9px] font-black px-2 py-0.5 rounded-full uppercase">Ketua</span>
                                        @else
                                            <span class="bg-neutral-light text-neutral-dark/40 text-[9px] font-black px-2 py-0.5 rounded-full uppercase">Anggota</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Actions -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-neutral-light sticky top-24">
                <h3 class="text-xl font-bold text-primary mb-6">Ringkasan Biaya</h3>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-dark/60">Tiket Pendakian (x{{ $booking->jumlah_orang }})</span>
                        <span class="font-bold text-neutral-dark">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-dark/60">Biaya Layanan</span>
                        <span class="font-bold text-success font-mono">GRATIS</span>
                    </div>
                    <div class="border-t border-neutral-light pt-4 flex justify-between items-center">
                        <span class="font-bold text-neutral-dark">Total</span>
                        <span class="text-2xl font-black text-primary italic">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @if($booking->status === 'unpaid' || $booking->status === 'pending_upload')
                        <a href="{{ route('payment.create', $booking->id) }}" class="w-full bg-secondary text-white py-4 rounded-2xl text-center font-bold hover:bg-secondary/90 transition-all shadow-lg shadow-secondary/20 block uppercase tracking-widest text-sm">
                            Bayar Sekarang
                        </a>
                    @elseif(in_array($booking->status, ['verified', 'ticket_issued', 'completed']))
                        <a href="{{ route('eticket.show', $booking->id) }}" class="w-full bg-primary text-white py-4 rounded-2xl text-center font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 block uppercase tracking-widest text-sm">
                            Lihat E-Ticket
                        </a>
                    @endif
                    
                    <button onclick="window.print()" class="w-full bg-white text-neutral-dark border border-neutral-light py-4 rounded-2xl font-bold hover:bg-neutral-light transition-all flex items-center justify-center text-sm uppercase tracking-widest">
                        <i data-lucide="printer" class="w-5 h-5 mr-2"></i> Cetak Detail
                    </button>
                </div>

                @if($booking->catatan_admin)
                    <div class="mt-8 p-4 bg-warning/5 border border-warning/20 rounded-2xl">
                        <span class="text-[10px] text-warning font-bold uppercase block mb-1">Catatan Admin:</span>
                        <p class="text-xs text-neutral-dark/70 italic leading-relaxed">{{ $booking->catatan_admin }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
