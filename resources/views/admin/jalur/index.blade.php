@extends('admin.layouts.app')

@section('title', 'Manajemen Jalur - Admin Mountix')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-neutral-dark">Manajemen Jalur</h1>
        <p class="text-neutral-dark/60">Kelola jalur pendakian untuk setiap gunung.</p>
    </div>
    <a href="{{ route('admin.jalur.create') }}" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 w-fit">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Tambah Jalur
    </a>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-6 border-b border-neutral-light bg-neutral-light/20">
        <form action="{{ route('admin.jalur.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-dark/40"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama jalur atau gunung..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>
            <div class="md:w-64">
                <select name="gunung_id" class="w-full px-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none">
                    <option value="">Semua Gunung</option>
                    @foreach($gunungs as $g)
                        <option value="{{ $g->id }}" {{ request('gunung_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-neutral-dark text-white px-8 py-3 rounded-2xl font-bold hover:bg-neutral-dark/90 transition-all">
                Filter
            </button>
            @if(request('search') || request('gunung_id'))
                <a href="{{ route('admin.jalur.index') }}" class="bg-neutral-light text-neutral-dark px-6 py-3 rounded-2xl font-bold hover:bg-neutral-dark/10 transition-all flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                <tr>
                    <th class="px-6 py-4">Jalur</th>
                    <th class="px-6 py-4">Gunung</th>
                    <th class="px-6 py-4 text-center">Kuota</th>
                    <th class="px-6 py-4 text-center">Estimasi</th>
                    <th class="px-6 py-4 text-right">Harga</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($jalurs as $jalur)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-dark">{{ $jalur->nama_jalur }}</div>
                            <div class="text-[10px] text-neutral-dark/40 line-clamp-1">{{ $jalur->deskripsi ?? 'Tidak ada deskripsi.' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-primary">{{ $jalur->gunung->nama }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-bold text-neutral-dark">{{ $jalur->kuota_default }} Pendaki</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-medium text-neutral-dark/60">{{ $jalur->estimasi_jam }} Jam</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-black text-secondary">Rp {{ number_format($jalur->harga_per_orang, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.jalur.edit', $jalur->id) }}" class="p-2 text-neutral-dark/40 hover:text-secondary hover:bg-secondary/5 rounded-lg transition-all">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.jalur.destroy', $jalur->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jalur ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-neutral-dark/40 hover:text-danger hover:bg-danger/5 rounded-lg transition-all">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Tidak ada data jalur ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($jalurs->hasPages())
        <div class="p-6 border-t border-neutral-light bg-neutral-light/10">
            {{ $jalurs->links() }}
        </div>
    @endif
</div>
@endsection
