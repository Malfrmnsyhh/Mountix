@extends('layouts.app')

@section('title', 'Daftar Booking Saya - Mountix')

@section('content')
<!-- Header Section -->
<div class="bg-primary pt-10 pb-10">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Booking Saya</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Pantau status booking, lakukan pembayaran, dan lihat e-ticket Anda di sini.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($bookings->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-neutral-light">
            <div class="bg-neutral-light w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="calendar-x" class="w-10 h-10 text-neutral-dark/20"></i>
            </div>
            <h2 class="text-2xl font-bold text-neutral-dark mb-2">Belum Ada Booking</h2>
            <p class="text-neutral-dark/60 mb-8">Anda belum memiliki riwayat booking pendakian.</p>
            <a href="{{ route('gunung.index') }}" class="inline-flex items-center bg-secondary text-white px-8 py-3 rounded-2xl font-bold hover:bg-secondary/90 transition-all shadow-lg shadow-secondary/20">
                Cari Gunung <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-3xl shadow-sm border border-neutral-light overflow-hidden hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row">
                        <!-- Left: Mountain Info -->
                        <div class="p-8 md:w-2/3 border-b md:border-b-0 md:border-r border-neutral-light">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <span class="bg-neutral-light text-neutral-dark px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                        {{ $booking->kode_booking }}
                                    </span>
                                    <span class="text-xs text-neutral-dark/40 italic">
                                        Dipesan pada {{ $booking->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                                
                                <!-- Status Badge -->
                                @php
                                    // Fix: sesuaikan dengan status enum backend yang resmi
                                    $statusClasses = [
                                        'draft'                => 'bg-neutral-dark/10 text-neutral-dark border-neutral-dark/20',
                                        'pending_upload'       => 'bg-warning/10 text-warning border-warning/20',
                                        'waiting_verification' => 'bg-primary/10 text-primary border-primary/20',
                                        'verified'             => 'bg-success/10 text-success border-success/20',
                                        'ticket_issued'        => 'bg-success/10 text-success border-success/20',
                                        'rejected'             => 'bg-danger/10 text-danger border-danger/20',
                                        'cancelled'            => 'bg-neutral-dark/10 text-neutral-dark border-neutral-dark/20',
                                        'completed'            => 'bg-success text-white border-success',
                                    ];
                                    $statusLabels = [
                                        'draft'                => 'Draft',
                                        'pending_upload'       => 'Menunggu Bukti Bayar',
                                        'waiting_verification' => 'Menunggu Verifikasi',
                                        'verified'             => 'Diverifikasi',
                                        'ticket_issued'        => 'Tiket Terbit',
                                        'rejected'             => 'Ditolak',
                                        'cancelled'            => 'Dibatalkan',
                                        'completed'            => 'Selesai',
                                    ];
                                    $currentStatus = $booking->status;
                                    $class = $statusClasses[$currentStatus] ?? 'bg-neutral-light text-neutral-dark border-neutral-dark/10';
                                    $label = $statusLabels[$currentStatus] ?? ucfirst(str_replace('_', ' ', $currentStatus));
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $class }}">
                                    {{ $label }}
                                </span>
                            </div>

                            <div class="flex items-start gap-6">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0">
                                    @if($booking->jalur && $booking->jalur->gunung)
                                        <img src="{{ $booking->jalur->gunung->foto_cover ? (filter_var($booking->jalur->gunung->foto_cover, FILTER_VALIDATE_URL) ? $booking->jalur->gunung->foto_cover : asset('storage/' . $booking->jalur->gunung->foto_cover)) : 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400' }}" 
                                             class="w-full h-full object-cover" alt="{{ $booking->jalur->gunung->nama }}">
                                    @else
                                        <div class="w-full h-full bg-neutral-light flex items-center justify-center">
                                            <i data-lucide="image-off" class="text-neutral-dark/20"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-primary mb-1">{{ $booking->jalur->gunung->nama ?? 'Gunung Tidak Ditemukan' }}</h3>
                                    <p class="text-sm text-neutral-dark/60 mb-4 flex items-center">
                                        <i data-lucide="map-pin" class="w-4 h-4 mr-1 text-secondary"></i> {{ $booking->jalur->nama_jalur ?? 'Jalur Tidak Ditemukan' }}
                                    </p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <div>
                                            <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Tanggal</span>
                                            <span class="text-sm font-bold text-neutral-dark">{{ \Carbon\Carbon::parse($booking->tanggal_naik)->format('d M Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Peserta</span>
                                            <span class="text-sm font-bold text-neutral-dark">{{ $booking->jumlah_orang }} Orang</span>
                                        </div>
                                        <div class="hidden md:block">
                                            <span class="text-[10px] text-neutral-dark/40 block uppercase font-bold">Total Bayar</span>
                                            <span class="text-sm font-black text-primary italic">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="p-8 md:w-1/3 bg-neutral-light/20 flex flex-col justify-center items-center gap-4">
                            @if(in_array($booking->status, ['draft', 'pending_upload']))
                                <a href="{{ route('payment.create', $booking->id) }}" class="w-full bg-secondary text-white py-3 rounded-2xl text-center font-bold hover:bg-secondary/90 transition-all shadow-md">
                                    Bayar Sekarang
                                </a>
                            @elseif(in_array($booking->status, ['waiting_verification']))
                                <div class="w-full bg-primary/10 text-primary py-3 rounded-2xl text-center font-bold text-sm">
                                    ⏳ Menunggu Verifikasi
                                </div>
                            @elseif(in_array($booking->status, ['verified', 'ticket_issued', 'completed']))
                                <a href="{{ route('eticket.show', $booking->id) }}" class="w-full bg-primary text-white py-3 rounded-2xl text-center font-bold hover:bg-primary/90 transition-all shadow-md">
                                    Lihat E-Ticket
                                </a>
                            @endif

                            <a href="{{ route('booking.show', $booking->id) }}" class="w-full bg-white text-neutral-dark border border-neutral-light py-3 rounded-2xl text-center font-bold hover:bg-neutral-light transition-all">
                                Detail Booking
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
