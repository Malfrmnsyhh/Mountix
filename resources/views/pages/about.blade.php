@extends('layouts.app')

@section('title', 'Tentang Kami - Mountix')
@section('meta_description', 'Mountix adalah platform digital booking pendakian gunung di Pulau Jawa. Kami hadir untuk mempermudah proses reservasi jalur, manajemen kuota, dan penerbitan e-ticket pendakian.')

@section('content')

<!-- about -->
<section class="relative overflow-hidden bg-primary flex items-end pb-10 pt-10">
    {{-- Background pattern --}}
    <div class="absolute inset-0 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=60'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-primary/80 via-primary/70 to-primary"></div>

    <div class="relative max-w-3xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-5">
            Mendaki Lebih Mudah,<br><span class="text-secondary">Lebih Aman, Lebih Teratur</span>
        </h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto text-base md:text-lg leading-relaxed">
            Mountix lahir dari semangat para pendaki yang percaya bahwa alam harus dijaga,
            dan administrasi pendakian tidak boleh mempersulit siapapun.
        </p>
    </div>
</section>

<!-- misi dan visi -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <img
                    src="https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=800&q=80"
                    alt="Pendaki gunung"
                    class="rounded-3xl shadow-xl w-full object-cover h-80 md:h-96"
                >
            </div>

            <div>
                <span class="text-secondary text-xs font-black uppercase tracking-widest">Mengapa Mountix?</span>
                <h2 class="text-3xl font-bold text-primary mt-3 mb-5 leading-tight">
                    Platform Ticketing Pendakian yang Dirancang untuk Pendaki Indonesia
                </h2>
                <p class="text-neutral-dark/60 leading-relaxed mb-6">
                    Sebelum Mountix, proses booking jalur pendakian masih manual — antre panjang, formulir kertas,
                    dan kuota yang tidak transparan. Kami hadir untuk mengubah itu semua menjadi pengalaman
                    digital yang cepat, aman, dan bisa dilakukan dari mana saja.
                </p>
                <ul class="space-y-3">
                    @foreach([
                        ['icon' => '🗺️', 'text' => 'Manajemen jalur & kuota pendakian secara real-time'],
                        ['icon' => '🎫', 'text' => 'E-Ticket digital dengan QR Code yang terverifikasi'],
                        ['icon' => '🔒', 'text' => 'Sistem pembayaran aman & proses verifikasi transparan'],
                        ['icon' => '📱', 'text' => 'Akses penuh dari ponsel, tanpa unduh aplikasi tambahan'],
                    ] as $item)
                    <li class="flex items-start gap-3">
                        <span class="text-xl mt-0.5">{{ $item['icon'] }}</span>
                        <span class="text-neutral-dark/70 text-sm leading-relaxed">{{ $item['text'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- statistik -->
<section class="py-16 bg-primary/5 border-y border-primary/10">
    <div class="max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach([
                ['value' => '15+',   'label' => 'Gunung Terdaftar',    'icon' => '⛰️'],
                ['value' => '50+',   'label' => 'Jalur Pendakian',     'icon' => '🥾'],
                ['value' => '2.500+','label' => 'Pendaki Terbantu',    'icon' => '🧗'],
                ['value' => '99%',   'label' => 'Kepuasan Pengguna',   'icon' => '⭐'],
            ] as $stat)
            <div class="flex flex-col items-center gap-2">
                <span class="text-4xl">{{ $stat['icon'] }}</span>
                <div class="text-3xl font-black text-primary">{{ $stat['value'] }}</div>
                <div class="text-xs text-neutral-dark/50 font-semibold uppercase tracking-wider">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- cara kerja -->
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-primary mt-3">Booking Pendakian dalam 4 Langkah</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['step' => '01', 'icon' => '🔍', 'title' => 'Pilih Gunung & Jalur',   'desc' => 'Cari gunung impianmu, bandingkan jalur, cek kuota & harga secara real-time.'],
                ['step' => '02', 'icon' => '📝', 'title' => 'Isi Data Peserta',        'desc' => 'Lengkapi data diri semua anggota rombongan beserta kontak darurat.'],
                ['step' => '03', 'icon' => '💳', 'title' => 'Lakukan Pembayaran',      'desc' => 'Bayar melalui transfer bank. Upload bukti pembayaran langsung dari aplikasi.'],
                ['step' => '04', 'icon' => '🎫', 'title' => 'Terima E-Ticket',         'desc' => 'E-Ticket + QR Code diterbitkan otomatis setelah pembayaran diverifikasi.'],
            ] as $step)
            <div class="relative bg-neutral-light/40 rounded-2xl p-6 border border-neutral-light hover:border-primary/30 hover:shadow-md transition-all">
                <div class="absolute -top-3 -left-3 bg-primary text-white text-xs font-black w-7 h-7 rounded-full flex items-center justify-center">
                    {{ $step['step'] }}
                </div>
                <div class="text-4xl mb-4">{{ $step['icon'] }}</div>
                <h3 class="font-bold text-primary text-sm mb-2">{{ $step['title'] }}</h3>
                <p class="text-xs text-neutral-dark/55 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- nilai-nilai kami -->
<section class="py-20 bg-primary text-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold mt-3">Prinsip yang Mendasari Mountix</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['icon' => '🌿', 'title' => 'Kelestarian Alam',   'desc' => 'Kami mendukung sistem kuota ketat agar jalur pendakian tidak melebihi kapasitas daya dukung alam.'],
                ['icon' => '🛡️', 'title' => 'Keselamatan Utama',  'desc' => 'Setiap pendaki wajib melengkapi data darurat. E-Ticket kami memuat informasi keselamatan yang dapat dipindai petugas.'],
                ['icon' => '🤝', 'title' => 'Ekosistem Lokal',    'desc' => 'Mountix bermitra dengan pengelola gunung, basecamp, dan pemandu lokal untuk mendistribusikan manfaat secara adil.'],
            ] as $value)
            <div class="bg-white/10 rounded-2xl p-7 border border-white/10 hover:bg-white/15 transition-all">
                <div class="text-4xl mb-4">{{ $value['icon'] }}</div>
                <h3 class="font-bold text-lg mb-3">{{ $value['title'] }}</h3>
                <p class="text-neutral-light/60 text-sm leading-relaxed">{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- tim -->
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-primary mt-3 mb-4">Dibangun oleh Pendaki, untuk Pendaki</h2>
        <p class="text-neutral-dark/55 max-w-2xl mx-auto text-sm leading-relaxed mb-12">
            Mountix dikembangkan oleh tim yang mencintai alam dan teknologi.
            Kami percaya bahwa pendakian yang terorganisir dengan baik adalah pendakian yang paling berkesan.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['initial' => 'MA', 'name' => 'Muhammad Akmal',    'role' => 'Founder & Fullstack Developer', 'color' => 'bg-primary'],
                ['initial' => 'SF', 'name' => 'Siti Fatimah',   'role' => 'Lead & System Analyst',  'color' => 'bg-secondary'],
                ['initial' => 'EA', 'name' => 'Eka Ahmad',   'role' => 'Lead & Frontend Developer',  'color' => 'bg-primary/70'],
            ] as $member)
            <div class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 {{ $member['color'] }} rounded-full flex items-center justify-center text-white text-2xl font-black shadow-lg">
                    {{ $member['initial'] }}
                </div>
                <div>
                    <div class="font-bold text-primary">{{ $member['name'] }}</div>
                    <div class="text-xs text-neutral-dark/40 font-semibold">{{ $member['role'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-neutral-light/40 border-t border-neutral-light">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-primary mb-4">Siap Memulai Petualangan?</h2>
        <p class="text-neutral-dark/55 mb-8 text-sm leading-relaxed">
            Jelajahi gunung-gunung indah di Pulau Jawa dan buat booking pendakian pertamamu hari ini.
        </p>
        <a href="{{ route('gunung.index') }}" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-8 py-3.5 rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Temukan Gunung Pilihan
        </a>
    </div>
</section>

@endsection
