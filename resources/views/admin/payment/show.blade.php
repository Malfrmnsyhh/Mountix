@extends('admin.layouts.app')

@section('title', 'Verifikasi Pembayaran - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.payment.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitor
    </a>
    <h1 class="text-3xl font-black text-neutral-dark">Verifikasi Transaksi</h1>
    <p class="text-neutral-dark/60">Periksa bukti transfer dan konfirmasi validitas pembayaran.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- Proof of Payment -->
    <div class="space-y-6">
        <div class="bg-white p-4 rounded-[40px] border border-neutral-light shadow-xl shadow-neutral-dark/5">
            <div class="aspect-[3/4] bg-neutral-light rounded-[32px] overflow-hidden border border-neutral-light relative group">
                <img src="{{ asset('storage/' . $payment->bukti_bayar) }}" class="w-full h-full object-contain">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <a href="{{ asset('storage/' . $payment->bukti_bayar) }}" target="_blank" class="bg-white text-neutral-dark px-6 py-3 rounded-2xl font-bold flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-transform">
                        <i data-lucide="maximize" class="w-5 h-5"></i>
                        Lihat Gambar Penuh
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Details & Actions -->
    <div class="space-y-8">
        <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-8">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xs font-bold text-neutral-dark/40 uppercase tracking-widest mb-1">Total Pembayaran</h3>
                    <div class="text-4xl font-black text-primary">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</div>
                </div>
                <div class="text-right">
                    <h3 class="text-xs font-bold text-neutral-dark/40 uppercase tracking-widest mb-1">Status Saat Ini</h3>
                    @php
                        $statusColors = [
                            'pending' => 'bg-warning/10 text-warning',
                            'approved' => 'bg-success text-white shadow-lg shadow-success/20',
                            'rejected' => 'bg-danger text-white shadow-lg shadow-danger/20',
                        ];
                        $statusColor = $statusColors[$payment->status_verifikasi] ?? 'bg-neutral-light';
                    @endphp
                    <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase {{ $statusColor }}">
                        {{ $payment->status_verifikasi }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 py-6 border-y border-neutral-light/50">
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-2">Kode Booking</h4>
                    <a href="{{ route('admin.booking.show', $payment->booking_id) }}" class="text-sm font-black text-primary hover:underline">{{ $payment->booking->kode_booking }}</a>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-2">Metode</h4>
                    <div class="text-sm font-bold text-neutral-dark uppercase">{{ $payment->metode_pembayaran }}</div>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-2">Nama Pengirim</h4>
                    <div class="text-sm font-bold text-neutral-dark">{{ $payment->booking->user->name }}</div>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-2">Tgl Bayar</h4>
                    <div class="text-sm font-bold text-neutral-dark">{{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') }}</div>
                </div>
            </div>

            @if($payment->status_verifikasi === 'pending')
                <div class="pt-4 space-y-4">
                    <h3 class="font-bold text-neutral-dark">Lakukan Verifikasi:</h3>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="flex-grow">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="w-full py-4 bg-success text-white font-bold rounded-2xl hover:bg-success/90 transition-all shadow-lg shadow-success/20 flex items-center justify-center gap-2">
                                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                Setujui Pembayaran
                            </button>
                        </form>
                        <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="flex-grow">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="w-full py-4 bg-danger text-white font-bold rounded-2xl hover:bg-danger/90 transition-all shadow-lg shadow-danger/20 flex items-center justify-center gap-2">
                                <i data-lucide="x-circle" class="w-5 h-5"></i>
                                Tolak Bukti
                            </button>
                        </form>
                    </div>
                    <p class="text-[10px] text-neutral-dark/40 text-center italic mt-4">
                        * Menyetujui pembayaran akan otomatis mengubah status booking menjadi verified dan men-generate E-Ticket jika alur diaktifkan.
                    </p>
                </div>
            @else
                <div class="bg-neutral-light/50 p-6 rounded-2xl border border-neutral-light text-center">
                    <p class="text-xs font-bold text-neutral-dark/40">Transaksi ini sudah diverifikasi pada {{ $payment->updated_at->format('d M Y, H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
