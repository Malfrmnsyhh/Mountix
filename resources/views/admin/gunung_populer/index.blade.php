@extends('admin.layouts.app')

@section('title', 'Pengaturan Gunung Populer')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-neutral-dark">Pengaturan Gunung Populer</h2>
        <p class="text-neutral-dark/60 mt-1">Atur gunung mana saja yang akan ditampilkan di halaman beranda.</p>
    </div>
</div>

<div class="mb-6">
    <div class="bg-primary/10 border border-primary/20 rounded-xl p-4 flex items-center">
        <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary mr-4 shrink-0">
            <i data-lucide="info" class="w-5 h-5"></i>
        </div>
        <div>
            <h4 class="font-semibold text-primary-dark">Informasi Penampilan Beranda</h4>
            <p class="text-sm text-primary-dark/80 mt-1">
                Sistem akan menampilkan maksimal <strong>6 gunung populer</strong> terbaru di halaman beranda pengguna. 
                Saat ini Anda telah memilih <strong>{{ $popularCount }} gunung</strong>.
            </p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-success/10 text-success border border-success/20 flex items-center">
    <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 rounded-xl bg-danger/10 text-danger border border-danger/20 flex items-center">
    <i data-lucide="alert-circle" class="w-5 h-5 mr-3"></i>
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-2xl border border-neutral-light overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-neutral-dark">
            <thead class="bg-neutral-light/50 text-xs uppercase text-neutral-dark/60 border-b border-neutral-light">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Nama Gunung</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Lokasi</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Status Operasional</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Tampilkan di Beranda?</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($gunungs as $gunung)
                <tr class="hover:bg-neutral-light/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($gunung->foto_cover)
                                <img src="{{ asset('storage/' . $gunung->foto_cover) }}" alt="{{ $gunung->nama }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-neutral-light flex items-center justify-center text-neutral-dark/40">
                                    <i data-lucide="image" class="w-5 h-5"></i>
                                </div>
                            @endif
                            <div class="font-medium text-neutral-dark">{{ $gunung->nama }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-neutral-dark/80">
                        {{ $gunung->lokasi }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($gunung->status_buka)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-success/10 text-success">
                                Buka
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-danger/10 text-danger">
                                Tutup
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.gunung-populer.toggle', $gunung->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                style="width: 44px; height: 24px; border-radius: 9999px; position: relative; display: inline-flex; align-items: center; cursor: pointer; border: none; background-color: {{ $gunung->is_popular ? '#2D5016' : '#d1d5db' }}; transition: background-color 0.2s; outline: none;">
                                <span class="sr-only">Toggle Popular</span>
                                <span style="display: inline-block; width: 18px; height: 18px; background-color: white; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.2); transition: transform 0.2s; transform: {{ $gunung->is_popular ? 'translateX(22px)' : 'translateX(4px)' }};"></span>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-neutral-dark/60">
                        Belum ada data gunung.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
