@extends('admin.layouts.app')

@section('title', 'Detail Gunung - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.gunung.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-neutral-dark">{{ $gunung->nama }}</h1>
            <p class="text-neutral-dark/60 flex items-center gap-1">
                <i data-lucide="map-pin" class="w-4 h-4 text-secondary"></i> {{ $gunung->lokasi }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.gunung.edit', $gunung->id) }}" class="bg-secondary/10 text-secondary px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-secondary/20 transition-all">
                <i data-lucide="edit-3" class="w-5 h-5"></i>
                Edit Data
            </a>
            <a href="{{ route('admin.jalur.create', ['gunung_id' => $gunung->id]) }}" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Tambah Jalur
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Mountain Info -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-8">
            <div>
                <h3 class="text-xs font-bold text-neutral-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-primary"></i> Deskripsi
                </h3>
                <p class="text-neutral-dark/70 leading-relaxed">{{ $gunung->deskripsi }}</p>
            </div>

            <div>
                <h3 class="text-xs font-bold text-neutral-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="scroll-text" class="w-4 h-4 text-primary"></i> Syarat Pendakian
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $gunung->syarat_pendakian) as $syarat)
                        <span class="bg-neutral-light text-neutral-dark/70 px-4 py-2 rounded-xl text-xs font-medium border border-neutral-light/50">
                            {{ trim($syarat) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Jalur List -->
        <div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
            <div class="p-6 border-b border-neutral-light">
                <h3 class="font-bold text-neutral-dark flex items-center gap-2">
                    <i data-lucide="map" class="w-5 h-5 text-primary"></i>
                    Daftar Jalur Pendakian
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                        <tr>
                            <th class="px-6 py-4">Nama Jalur</th>
                            <th class="px-6 py-4 text-center">Kuota</th>
                            <th class="px-6 py-4 text-center">Estimasi</th>
                            <th class="px-6 py-4 text-right">Harga</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-light">
                        @forelse($gunung->jalurs as $jalur)
                            <tr class="hover:bg-neutral-light/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-neutral-dark">{{ $jalur->nama_jalur }}</div>
                                    <div class="text-[10px] text-neutral-dark/40 line-clamp-1">{{ $jalur->deskripsi ?? 'Tidak ada deskripsi.' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs font-bold text-neutral-dark">{{ $jalur->kuota_default }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs font-medium text-neutral-dark/60">{{ $jalur->estimasi_jam }} Jam</span>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-primary">
                                    Rp {{ number_format($jalur->harga_per_orang, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.jalur.edit', $jalur->id) }}" class="p-2 text-neutral-dark/40 hover:text-secondary hover:bg-secondary/5 rounded-lg transition-all">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.jalur.destroy', $jalur->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jalur ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-neutral-dark/40 hover:text-danger hover:bg-danger/5 rounded-lg transition-all">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Belum ada jalur pendakian untuk gunung ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stats & Meta -->
    <div class="space-y-8">
        <div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
            <div class="aspect-video bg-neutral-light">
                <img src="{{ filter_var($gunung->foto_cover, FILTER_VALIDATE_URL) ? $gunung->foto_cover : asset('storage/' . $gunung->foto_cover) }}" alt="{{ $gunung->nama }}" class="w-full h-full object-cover">
            </div>
            <div class="p-8 space-y-6">
                <div class="flex justify-between items-center pb-6 border-b border-neutral-light">
                    <span class="text-xs font-bold text-neutral-dark/40 uppercase tracking-widest">Ketinggian</span>
                    <span class="text-xl font-black text-secondary">{{ $gunung->ketinggian }} mdpl</span>
                </div>
                <div class="flex justify-between items-center pb-6 border-b border-neutral-light">
                    <span class="text-xs font-bold text-neutral-dark/40 uppercase tracking-widest">Status</span>
                    @if($gunung->status_buka)
                        <span class="bg-success text-white text-[10px] font-black uppercase px-4 py-1 rounded-full shadow-lg shadow-success/20">Buka</span>
                    @else
                        <span class="bg-danger text-white text-[10px] font-black uppercase px-4 py-1 rounded-full shadow-lg shadow-danger/20">Tutup</span>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-neutral-dark/40 uppercase tracking-widest">Dibuat Pada</span>
                    <span class="text-xs font-bold text-neutral-dark/70">{{ $gunung->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-primary p-8 rounded-3xl text-white shadow-xl shadow-primary/20">
            <h3 class="font-bold mb-6 flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-5 h-5 text-secondary"></i>
                Statistik Gunung
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-white/60">Total Booking</span>
                    <span class="text-lg font-black">{{ $gunung->jalurs->sum(function($j) { return $j->bookings_count ?? 0; }) }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-white/40 italic">* Data real-time dari sistem</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
