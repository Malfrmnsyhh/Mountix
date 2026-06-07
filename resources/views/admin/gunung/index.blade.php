@extends('admin.layouts.app')

@section('title', 'Manajemen Gunung - Admin Mountix')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-neutral-dark">Manajemen Gunung</h1>
        <p class="text-neutral-dark/60">Kelola daftar gunung, informasi, dan status operasional.</p>
    </div>
    <a href="{{ route('admin.gunung.create') }}" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 w-fit">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Tambah Gunung
    </a>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-6 border-b border-neutral-light bg-neutral-light/20">
        <form action="{{ route('admin.gunung.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-dark/40"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama gunung atau lokasi..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>
            <button type="submit" class="bg-neutral-dark text-white px-8 py-3 rounded-2xl font-bold hover:bg-neutral-dark/90 transition-all">
                Filter
            </button>
            @if(request('search'))
                <a href="{{ route('admin.gunung.index') }}" class="bg-neutral-light text-neutral-dark px-6 py-3 rounded-2xl font-bold hover:bg-neutral-dark/10 transition-all flex items-center justify-center">
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
                    <th class="px-6 py-4">Gunung</th>
                    <th class="px-6 py-4 text-center">Ketinggian</th>
                    <th class="px-6 py-4 text-center">Jalur</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($gunungs as $gunung)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-neutral-light">
                                    <img src="{{ filter_var($gunung->foto_cover, FILTER_VALIDATE_URL) ? $gunung->foto_cover : asset('storage/' . $gunung->foto_cover) }}" alt="{{ $gunung->nama }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-neutral-dark">{{ $gunung->nama }}</div>
                                    <div class="text-[10px] text-neutral-dark/40 flex items-center gap-1">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                                        {{ $gunung->lokasi }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-bold text-neutral-dark bg-secondary/10 text-secondary px-3 py-1 rounded-full border border-secondary/20">
                                {{ $gunung->ketinggian }} mdpl
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-primary">{{ $gunung->jalurs_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($gunung->status_buka)
                                <span class="bg-success/10 text-success text-[10px] font-black uppercase px-3 py-1 rounded-full border border-success/20">Buka</span>
                            @else
                                <span class="bg-danger/10 text-danger text-[10px] font-black uppercase px-3 py-1 rounded-full border border-danger/20">Tutup</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.gunung.show', $gunung->id) }}" class="p-2 text-neutral-dark/40 hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Detail">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                                <a href="{{ route('admin.gunung.edit', $gunung->id) }}" class="p-2 text-neutral-dark/40 hover:text-secondary hover:bg-secondary/5 rounded-lg transition-all" title="Edit">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.gunung.destroy', $gunung->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gunung ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-neutral-dark/40 hover:text-danger hover:bg-danger/5 rounded-lg transition-all" title="Hapus">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Tidak ada data gunung ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($gunungs->hasPages())
        <div class="p-6 border-t border-neutral-light bg-neutral-light/10">
            {{ $gunungs->links() }}
        </div>
    @endif
</div>
@endsection
