@extends('layouts.app')

@section('title', 'Beranda - Mountix')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[80vh] flex items-center justify-center text-white overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80" alt="Mountain Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary/60 backdrop-blur-sm"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 text-center mt-16">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight drop-shadow-lg">
            Jelajahi Puncak Tertinggi <br class="hidden md:block"> Bersama <span class="text-secondary">Mountix</span>
        </h1>
        <p class="text-lg md:text-2xl text-neutral-light/90 mb-12 max-w-3xl mx-auto font-medium drop-shadow-md leading-relaxed">
            Platform booking pendakian gunung tercepat dan terpercaya. Temukan jalur impianmu sekarang.
        </p>

        <!-- Search Bar -->
        <div class="bg-white p-2 rounded-full shadow-2xl flex flex-col md:flex-row gap-2 max-w-3xl mx-auto transition-all duration-300 hover:shadow-primary/20">
            <div class="flex-grow flex items-center px-6 py-3 border-b md:border-b-0 md:border-r border-neutral-light/50">
                <i data-lucide="search" class="text-neutral-dark/40 mr-4 w-6 h-6"></i>
                <input type="text" id="hero-search" placeholder="Cari nama gunung..." class="w-full focus:outline-none text-neutral-dark text-lg bg-transparent">
            </div>
            <button onclick="window.location.href='/gunung?nama=' + document.getElementById('hero-search').value" class="bg-secondary text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-secondary/90 hover:scale-[1.02] transition-all duration-300 shadow-md">
                Cari Sekarang
            </button>
        </div>
    </div>
</section>

<!-- Popular Mountains Section -->
<section class="py-24 bg-neutral-light/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-extrabold text-primary mb-4 tracking-tight">Gunung Populer</h2>
                <p class="text-neutral-dark/60 text-lg leading-relaxed">Destinasi favorit para pendaki bulan ini. Pilih rute terbaik untuk petualangan Anda selanjutnya.</p>
            </div>
            <a href="{{ route('gunung.index') }}" class="mt-6 md:mt-0 text-secondary font-bold flex items-center hover:text-primary transition-colors duration-300 text-lg group">
                Lihat Semua <i data-lucide="arrow-right" class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($popularMountains as $gunung)
                <div class="transform hover:-translate-y-2 transition-transform duration-300">
                    <x-card 
                        :id="$gunung->id"
                        :name="$gunung->nama" 
                        :location="$gunung->lokasi" 
                        :price="$gunung->jalurs->min('harga_per_orang') ?? 0" 
                        :image="(filter_var($gunung->foto_cover, FILTER_VALIDATE_URL) ? $gunung->foto_cover : ($gunung->foto_cover ? asset('storage/' . $gunung->foto_cover) : 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'))" 
                    />
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-neutral-light shadow-sm">
                    <i data-lucide="mountain-snow" class="w-16 h-16 mx-auto text-neutral-dark/20 mb-4"></i>
                    <p class="text-neutral-dark/40 font-bold italic tracking-wide text-lg">Belum ada data gunung populer tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative group">
                <div class="overflow-hidden rounded-3xl shadow-2xl relative z-10">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=800" alt="Tentang Mountix" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                </div>
                <div class="absolute -bottom-8 -right-8 w-72 h-72 bg-secondary/10 rounded-full z-0 group-hover:bg-secondary/20 transition-colors duration-500"></div>
                <div class="absolute -top-8 -left-8 w-40 h-40 bg-primary/10 rounded-full z-0 group-hover:bg-primary/20 transition-colors duration-500"></div>
            </div>
            
            <div class="flex flex-col justify-center">
                <span class="inline-block px-4 py-1 bg-secondary/10 text-secondary text-xs font-black uppercase tracking-[0.2em] rounded-full w-max mb-6">Tentang Kami</span>
                <h3 class="text-4xl md:text-5xl font-extrabold text-primary mb-8 leading-tight tracking-tight">Dedikasi Kami untuk Para Petualang Indonesia</h3>
                <p class="text-neutral-dark/70 mb-10 leading-relaxed text-lg">
                    Mountix lahir dari semangat untuk mendigitalkan ekosistem pendakian gunung di Indonesia. Kami memahami tantangan pendaki dalam melakukan reservasi jalur yang seringkali masih dilakukan secara manual dan tidak efisien.
                </p>
                <div class="space-y-8 mb-12">
                    <div class="flex items-start group cursor-default">
                        <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mr-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-sm flex-shrink-0">
                            <i data-lucide="check-circle-2" class="text-primary group-hover:text-white w-7 h-7 transition-colors duration-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary text-xl mb-2">Akses Tanpa Batas</h4>
                            <p class="text-base text-neutral-dark/60 leading-relaxed">Booking kapan saja dan di mana saja hanya melalui ponsel Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start group cursor-default">
                        <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mr-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-sm flex-shrink-0">
                            <i data-lucide="users-2" class="text-primary group-hover:text-white w-7 h-7 transition-colors duration-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary text-xl mb-2">Komunitas Terpercaya</h4>
                            <p class="text-base text-neutral-dark/60 leading-relaxed">Menghubungkan ribuan pendaki dengan pengelola taman nasional.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-primary text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-secondary hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-primary/20 w-max">
                    Bergabung Sekarang <i data-lucide="arrow-right" class="ml-3 w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="bg-neutral-dark text-white py-32 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight">Mengapa Memilih <span class="text-secondary">Mountix</span>?</h2>
            <p class="text-neutral-light/60 max-w-2xl mx-auto text-lg leading-relaxed">Kami memberikan layanan terbaik untuk memastikan pengalaman pendakian Anda tak terlupakan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16 text-center">
            <div class="flex flex-col items-center group bg-white/5 p-10 rounded-3xl backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors duration-300">
                <div class="w-20 h-20 bg-primary/30 rounded-2xl flex items-center justify-center mb-8 border border-primary/50 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300 shadow-lg">
                    <i data-lucide="zap" class="text-secondary w-10 h-10"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 tracking-tight">Booking Cepat</h3>
                <p class="text-neutral-light/60 leading-relaxed">Proses reservasi hanya dalam hitungan menit tanpa antri panjang di basecamp.</p>
            </div>
            <div class="flex flex-col items-center group bg-white/5 p-10 rounded-3xl backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors duration-300">
                <div class="w-20 h-20 bg-primary/30 rounded-2xl flex items-center justify-center mb-8 border border-primary/50 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
                    <i data-lucide="shield-check" class="text-secondary w-10 h-10"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 tracking-tight">Keamanan Terjamin</h3>
                <p class="text-neutral-light/60 leading-relaxed">Data pribadi dan transaksi Anda terlindungi dengan sistem enkripsi terbaru dan terpercaya.</p>
            </div>
            <div class="flex flex-col items-center group bg-white/5 p-10 rounded-3xl backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors duration-300">
                <div class="w-20 h-20 bg-primary/30 rounded-2xl flex items-center justify-center mb-8 border border-primary/50 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300 shadow-lg">
                    <i data-lucide="ticket" class="text-secondary w-10 h-10"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 tracking-tight">E-Ticket Instan</h3>
                <p class="text-neutral-light/60 leading-relaxed">Dapatkan tiket digital resmi secara langsung seketika setelah pembayaran diverifikasi.</p>
            </div>
        </div>
    </div>
</section>
@endsection