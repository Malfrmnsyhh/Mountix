@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - Mountix')

@section('content')
<section class="min-h-[calc(100vh-64px-300px)] flex items-center justify-center py-20 px-4 bg-neutral-light">
    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden text-center">
        <div class="bg-primary py-12 flex justify-center">
            <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center border-4 border-white/20 animate-bounce">
                <i data-lucide="check" class="text-secondary w-12 h-12 stroke-[3px]"></i>
            </div>
        </div>
        
        <div class="p-12">
            <h1 class="text-3xl font-bold text-primary mb-4">Konfirmasi Terkirim!</h1>
            <p class="text-neutral-dark/60 leading-relaxed mb-10">
                Terima kasih telah melakukan konfirmasi pembayaran. Admin kami akan segera melakukan verifikasi data Anda.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('booking.index') }}" class="flex items-center justify-center px-6 py-4 bg-neutral-light text-neutral-dark font-bold rounded-2xl hover:bg-neutral-light/70 transition-all">
                    <i data-lucide="list" class="w-5 h-5 mr-2"></i> Riwayat Booking
                </a>
                <a href="{{ route('home') }}" class="flex items-center justify-center px-6 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                    <i data-lucide="home" class="w-5 h-5 mr-2"></i> Kembali ke Beranda
                </a>
            </div>

            <p class="mt-8 text-xs text-neutral-dark/40 italic">
                Silahkan cek status booking Anda secara berkala untuk memantau proses verifikasi.
            </p>
        </div>
    </div>
</section>
@endsection
