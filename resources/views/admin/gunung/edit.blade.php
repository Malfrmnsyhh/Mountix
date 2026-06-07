@extends('admin.layouts.app')

@section('title', 'Edit Gunung - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.gunung.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <h1 class="text-3xl font-black text-neutral-dark">Edit Gunung: {{ $gunung->nama }}</h1>
    <p class="text-neutral-dark/60">Perbarui informasi gunung melalui formulir di bawah.</p>
</div>

<form action="{{ route('admin.gunung.update', $gunung->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Nama Gunung <span class="text-danger">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $gunung->nama) }}" required class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                        @error('nama') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $gunung->lokasi) }}" required placeholder="Contoh: Magelang, Jawa Tengah" class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                        @error('lokasi') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Ketinggian (mdpl) <span class="text-danger">*</span></label>
                        <input type="number" name="ketinggian" value="{{ old('ketinggian', $gunung->ketinggian) }}" required class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">
                        @error('ketinggian') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Status Operasional <span class="text-danger">*</span></label>
                        <select name="status_buka" required class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all appearance-none">
                            <option value="1" {{ old('status_buka', $gunung->status_buka) == '1' ? 'selected' : '' }}>Buka</option>
                            <option value="0" {{ old('status_buka', $gunung->status_buka) == '0' ? 'selected' : '' }}>Tutup</option>
                        </select>
                        @error('status_buka') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" rows="5" required class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">{{ old('deskripsi', $gunung->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-2">Syarat Pendakian <span class="text-danger">*</span></label>
                    <textarea name="syarat_pendakian" rows="3" required placeholder="Gunakan tanda koma (,) untuk memisahkan syarat" class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">{{ old('syarat_pendakian', $gunung->syarat_pendakian) }}</textarea>
                    @error('syarat_pendakian') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-6">
                <div>
                    <label class="block text-xs font-bold text-neutral-dark uppercase tracking-wider mb-4">Foto Cover</label>
                    <div id="image-preview-container" class="w-full aspect-video bg-neutral-light rounded-2xl overflow-hidden mb-4 border-2 border-dashed border-neutral-dark/10 flex items-center justify-center">
                        <img src="{{ filter_var($gunung->foto_cover, FILTER_VALIDATE_URL) ? $gunung->foto_cover : asset('storage/' . $gunung->foto_cover) }}" class="w-full h-full object-cover">
                    </div>
                    <input type="file" name="foto_cover" id="foto_cover" class="hidden" accept="image/*">
                    <button type="button" onclick="document.getElementById('foto_cover').click()" class="w-full py-3 bg-neutral-light hover:bg-neutral-dark/10 text-neutral-dark text-sm font-bold rounded-2xl transition-all flex items-center justify-center gap-2">
                        <i data-lucide="upload" class="w-4 h-4"></i> Ganti Foto
                    </button>
                    <p class="text-[10px] text-neutral-dark/40 mt-2">Biarkan kosong jika tidak ingin mengubah foto.</p>
                    @error('foto_cover') <p class="text-danger text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-neutral-light space-y-3">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                        Perbarui Data
                    </button>
                    <a href="{{ route('admin.gunung.index') }}" class="w-full py-4 bg-neutral-light text-neutral-dark font-bold rounded-2xl hover:bg-neutral-dark/10 transition-all flex items-center justify-center">
                        Batalkan
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Image Preview
    document.getElementById('foto_cover').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('image-preview-container');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                previewContainer.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
