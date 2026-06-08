@extends('layouts.app')

@section('title', 'Beranda - Mountix')

@section('content')
<!-- Hero Section -->
<section class="relative h-[600px] flex items-center justify-center text-white overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80" alt="Mountain Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary/40 backdrop-blur-[2px]"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 tracking-tight leading-tight">
            Jelajahi Puncak Tertinggi <br> Bersama <span class="text-secondary">Mountix</span>
        </h1>
        <p class="text-lg md:text-xl text-neutral-light/90 mb-10 max-w-2xl mx-auto">
            Platform booking pendakian gunung tercepat dan terpercaya. Temukan jalur impianmu sekarang.
        </p>

        <!-- Search Bar -->
        <div class="bg-white p-2 rounded-2xl shadow-2xl flex flex-col md:flex-row gap-2 max-w-3xl mx-auto">
            <div class="flex-grow flex items-center px-4 py-2 border-b md:border-b-0 md:border-r border-neutral-light">
                <i data-lucide="search" class="text-neutral-dark/40 mr-3"></i>
                <input type="text" id="hero-search" placeholder="Cari nama gunung..." class="w-full focus:outline-none text-neutral-dark">
            </div>
            <button onclick="window.location.href='/gunung?nama=' + document.getElementById('hero-search').value" class="bg-secondary text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary/90 transition-all duration-300">
                Cari Sekarang
            </button>
        </div>
    </div>
</section>

<!-- Popular Mountains Section -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
        <div>
            <h2 class="text-3xl font-bold text-primary mb-4">Gunung Populer</h2>
            <p class="text-neutral-dark/60">Destinasi favorit para pendaki bulan ini.</p>
        </div>
        <a href="{{ route('gunung.index') }}" class="mt-4 md:mt-0 text-secondary font-bold flex items-center hover:underline">
            Lihat Semua <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
        </a>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($popularMountains as $gunung)
            <x-card 
                :id="$gunung->id"
                :name="$gunung->nama" 
                :location="$gunung->lokasi" 
                :price="$gunung->jalurs->min('harga_per_orang') ?? 0" 
                :image="(filter_var($gunung->foto_cover, FILTER_VALIDATE_URL) ? $gunung->foto_cover : ($gunung->foto_cover ? asset('storage/' . $gunung->foto_cover) : 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'))" 
            />
        @empty
            <div class="col-span-full text-center py-12 bg-neutral-light rounded-3xl">
                <p class="text-neutral-dark/40 font-bold italic tracking-wide">Belum ada data gunung populer tersedia.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=800" alt="Tentang Mountix" class="rounded-3xl shadow-2xl relative z-10">
                <div class="absolute -bottom-6 -right-6 w-64 h-64 bg-secondary/10 rounded-full z-0"></div>
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-primary/10 rounded-full z-0"></div>
            </div>
            
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-secondary mb-4">Tentang Kami</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-primary mb-6 leading-tight">Dedikasi Kami untuk Para Petualang Indonesia</h3>
                <p class="text-neutral-dark/70 mb-6 leading-relaxed">
                    Mountix lahir dari semangat untuk mendigitalkan ekosistem pendakian gunung di Indonesia. Kami memahami tantangan pendaki dalam melakukan reservasi jalur yang seringkali masih dilakukan secara manual dan tidak efisien.
                </p>
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center mr-4 mt-1">
                            <i data-lucide="check-circle-2" class="text-primary w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary">Akses Tanpa Batas</h4>
                            <p class="text-sm text-neutral-dark/60 italic">Booking kapan saja dan di mana saja hanya melalui ponsel Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center mr-4 mt-1">
                            <i data-lucide="users-2" class="text-primary w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary">Komunitas Terpercaya</h4>
                            <p class="text-sm text-neutral-dark/60 italic">Menghubungkan ribuan pendaki dengan pengelola taman nasional.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="inline-block bg-primary text-white px-8 py-4 rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                    Bergabung Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="bg-neutral-dark text-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Mengapa Memilih <span class="text-secondary">Mountix</span>?</h2>
            <p class="text-neutral-light/60 max-w-2xl mx-auto">Kami memberikan layanan terbaik untuk memastikan pengalaman pendakian Anda tak terlupakan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div class="flex flex-col items-center group">
                <div class="w-16 h-16 bg-primary/30 rounded-full flex items-center justify-center mb-6 border border-primary/50 group-hover:scale-110 transition-transform">
                    <i data-lucide="zap" class="text-secondary w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Booking Cepat</h3>
                <p class="text-neutral-light/60 italic">Proses reservasi hanya dalam hitungan menit tanpa antri panjang.</p>
            </div>
            <div class="flex flex-col items-center group">
                <div class="w-16 h-16 bg-primary/30 rounded-full flex items-center justify-center mb-6 border border-primary/50 group-hover:scale-110 transition-transform">
                    <i data-lucide="shield-check" class="text-secondary w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Keamanan Terjamin</h3>
                <p class="text-neutral-light/60 italic">Data pribadi dan transaksi Anda terlindungi dengan sistem enkripsi terbaru.</p>
            </div>
            <div class="flex flex-col items-center group">
                <div class="w-16 h-16 bg-primary/30 rounded-full flex items-center justify-center mb-6 border border-primary/50 group-hover:scale-110 transition-transform">
                    <i data-lucide="ticket" class="text-secondary w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">E-Ticket Instan</h3>
                <p class="text-neutral-light/60 italic">Dapatkan tiket digital langsung setelah pembayaran diverifikasi.</p>
            </div>
        </div>
    </div>
</section>
@endsection
