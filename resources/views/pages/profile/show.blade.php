@extends('layouts.app')

@section('title', 'Profil Saya - Mountix')

@section('content')
{{-- Header Section --}}
<div class="bg-primary pt-10 pb-10">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Profil Saya</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Kelola informasi akun dan preferensi pendakian Anda.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        {{-- Left: Sidebar Navigation --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-neutral-light overflow-hidden sticky top-24">
                <div class="p-8 text-center border-b border-neutral-light bg-neutral-light/10">
                    <div class="w-24 h-24 bg-secondary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-black uppercase shadow-lg border-4 border-white">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <h3 class="text-xl font-bold text-primary">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-neutral-dark/40 font-bold uppercase tracking-widest mt-1">{{ auth()->user()->role }}</p>
                </div>
                <nav class="p-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('profile.show') }}" class="w-full flex items-center p-3 rounded-2xl transition-all bg-primary text-white shadow-md shadow-primary/20">
                                <i data-lucide="user" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm font-bold">Detail Profil</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('booking.index') }}" class="w-full flex items-center p-3 rounded-2xl transition-all text-neutral-dark hover:bg-neutral-light">
                                <i data-lucide="calendar" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm font-bold">Booking Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('eticket.index') }}" class="w-full flex items-center p-3 rounded-2xl transition-all text-neutral-dark hover:bg-neutral-light">
                                <i data-lucide="ticket" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm font-bold">E-Ticket Aktif</span>
                            </a>
                        </li>
                        <hr class="my-4 border-neutral-light">
                        <li>
                            <button onclick="handleLogout()" class="w-full flex items-center p-3 rounded-2xl transition-all text-danger hover:bg-danger/10 font-bold">
                                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                                <span class="text-sm">Keluar Akun</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        {{-- Right: Profile Detail --}}
        <div class="lg:col-span-3 space-y-8">
            {{-- Informasi Akun --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light">
                <div class="flex justify-between items-center mb-10">
                    <h2 class="text-2xl font-bold text-primary flex items-center">
                        <i data-lucide="shield-check" class="w-6 h-6 mr-3 text-secondary"></i> Informasi Akun
                    </h2>
                    <a href="{{ route('profile.edit') }}" class="text-xs font-black uppercase tracking-widest text-secondary hover:underline flex items-center">
                        <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Profil
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Nama Lengkap</label>
                        <p class="text-lg font-bold text-primary">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Email</label>
                        <p class="text-lg font-bold text-primary">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Nomor Telepon</label>
                        <p class="text-lg font-bold text-primary">{{ auth()->user()->phone ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-neutral-dark/40">Terdaftar Sejak</label>
                        <p class="text-lg font-bold text-primary">{{ auth()->user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('booking.index') }}"
                   class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light hover:border-primary/30 hover:shadow-md transition-all group flex items-center gap-6">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all text-primary">
                        <i data-lucide="calendar" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-primary">Booking Saya</h3>
                        <p class="text-xs text-neutral-dark/50 mt-1">Pantau semua riwayat pendakian</p>
                    </div>
                    <i data-lucide="arrow-right" class="w-5 h-5 text-neutral-dark/20 ml-auto group-hover:text-primary transition-all"></i>
                </a>
                <a href="{{ route('eticket.index') }}"
                   class="bg-white p-8 rounded-3xl shadow-sm border border-neutral-light hover:border-primary/30 hover:shadow-md transition-all group flex items-center gap-6">
                    <div class="w-14 h-14 bg-success/10 rounded-2xl flex items-center justify-center group-hover:bg-success group-hover:text-white transition-all text-success">
                        <i data-lucide="ticket" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-primary">E-Ticket Aktif</h3>
                        <p class="text-xs text-neutral-dark/50 mt-1">Tiket siap digunakan saat pendakian</p>
                    </div>
                    <i data-lucide="arrow-right" class="w-5 h-5 text-neutral-dark/20 ml-auto group-hover:text-success transition-all"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
