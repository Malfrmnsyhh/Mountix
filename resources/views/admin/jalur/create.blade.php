@extends('admin.layouts.app')

@section('title', 'Tambah Jalur - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.jalur.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <h1 class="text-3xl font-black text-neutral-dark">Tambah Jalur Baru</h1>
    <p class="text-neutral-dark/60">Tambahkan rute pendakian baru untuk gunung pilihan.</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.jalur.store') }}" method="POST">
        @csrf
        <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-6">
            <div>
                <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Gunung <span class="text-danger">*</span></label>
                <select name="gunung_id" required class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all appearance-none">
                    <option value="" disabled {{ !$selected_gunung_id ? 'selected' : '' }}>Pilih Gunung</option>
                    @foreach($gunungs as $g)
                        <option value="{{ $g->id }}" {{ $selected_gunung_id == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                    @endforeach
                </select>
                @error('gunung_id') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Nama Jalur <span class="text-danger">*</span></label>
                <input type="text" name="nama_jalur" value="{{ old('nama_jalur') }}" required placeholder="Contoh: Jalur Selo, Jalur Bambangan" class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                @error('nama_jalur') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Deskripsi Jalur</label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Harga Per Orang <span class="text-danger">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-dark/40">Rp</span>
                        <input type="number" name="harga_per_orang" value="{{ old('harga_per_orang') }}" required class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                    </div>
                    @error('harga_per_orang') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Kuota Default <span class="text-danger">*</span></label>
                    <input type="number" name="kuota_default" value="{{ old('kuota_default') }}" required class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                    @error('kuota_default') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Estimasi Jam <span class="text-danger">*</span></label>
                    <div class="relative">
                        <input type="number" name="estimasi_jam" value="{{ old('estimasi_jam') }}" required class="w-full pr-12 px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-dark/40">Jam</span>
                    </div>
                    @error('estimasi_jam') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-neutral-light flex flex-col md:flex-row gap-4">
                <button type="submit" class="flex-grow py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                    Simpan Jalur
                </button>
                <a href="{{ route('admin.jalur.index') }}" class="md:w-48 py-4 bg-neutral-light text-neutral-dark font-bold rounded-2xl hover:bg-neutral-dark/10 transition-all flex items-center justify-center">
                    Batalkan
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
