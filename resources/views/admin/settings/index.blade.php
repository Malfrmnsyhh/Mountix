@extends('admin.layouts.app')

@section('title', 'Pengaturan Beranda - Admin Mountix')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-neutral-dark">Pengaturan Beranda</h1>
    <p class="text-neutral-dark/60">Kelola tampilan halaman utama yang dilihat oleh pengguna.</p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-success/10 border border-success/20 rounded-2xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5 text-success flex-shrink-0"></i>
        <p class="text-success font-bold text-sm">{{ session('success') }}</p>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    {{-- Hero Image --}}
    <div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
        <div class="p-6 border-b border-neutral-light">
            <h2 class="font-bold text-neutral-dark flex items-center gap-2">
                <i data-lucide="image" class="w-5 h-5 text-primary"></i>
                Hero Background Image
            </h2>
            <p class="text-xs text-neutral-dark/50 mt-1">Gambar latar belakang di halaman beranda (JPG, PNG, WebP — maks. 5MB)</p>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                {{-- Preview --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-3">Preview Saat Ini</label>
                    @php
                        $heroPath = $settings['hero_image']->value ?? null;
                        $heroUrl = $heroPath
                            ? asset('storage/' . $heroPath)
                            : null;
                    @endphp
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden border-2 border-dashed border-neutral-light bg-neutral-light/30" id="preview-container">
                        @if($heroUrl)
                            <img src="{{ $heroUrl }}" alt="Hero Preview"
                                 class="w-full h-full object-cover" id="preview-img">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-4">
                                <span class="text-white text-xs font-bold bg-success/80 px-3 py-1 rounded-full">
                                    ✓ Gambar Aktif
                                </span>
                            </div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-neutral-dark/30" id="preview-empty">
                                <i data-lucide="image-off" class="w-16 h-16 mb-3"></i>
                                <p class="text-sm font-bold">Belum ada gambar</p>
                                <p class="text-xs">Upload gambar untuk menampilkannya</p>
                            </div>
                            <img src="" alt="" class="hidden w-full h-full object-cover" id="preview-img">
                        @endif
                    </div>
                </div>

                {{-- Upload --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-3">Upload Gambar Baru</label>

                    {{-- Dropzone --}}
                    <label for="hero_image"
                           class="relative flex flex-col items-center justify-center w-full aspect-video rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 hover:bg-primary/10 hover:border-primary/50 transition-all cursor-pointer group">
                        <i data-lucide="upload-cloud" class="w-12 h-12 text-primary/40 group-hover:text-primary/70 mb-3 transition-all"></i>
                        <p class="text-sm font-bold text-primary/60 group-hover:text-primary transition-all">Klik atau seret gambar ke sini</p>
                        <p class="text-xs text-neutral-dark/40 mt-1">JPG, PNG, WebP — Maks. 5MB</p>
                        <input type="file" id="hero_image" name="hero_image"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="absolute inset-0 opacity-0 cursor-pointer"
                               onchange="previewImage(this)">
                    </label>

                    @error('hero_image')
                        <p class="text-danger text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-neutral-dark/40 mt-3 italic">
                        💡 Tips: Gunakan gambar landscape beresolusi tinggi (min. 1920×1080) untuk hasil terbaik.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Hero Text --}}
    <div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
        <div class="p-6 border-b border-neutral-light">
            <h2 class="font-bold text-neutral-dark flex items-center gap-2">
                <i data-lucide="type" class="w-5 h-5 text-secondary"></i>
                Teks Hero Section
            </h2>
            <p class="text-xs text-neutral-dark/50 mt-1">Judul dan deskripsi yang tampil di atas hero image</p>
        </div>
        <div class="p-8 space-y-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">
                    {{ $settings['hero_title']->label ?? 'Judul Hero' }}
                </label>
                <input type="text" name="hero_title"
                       value="{{ old('hero_title', $settings['hero_title']->value ?? '') }}"
                       placeholder="Booking Pendakian Gunung Impian Anda"
                       class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all text-sm font-medium">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">
                    {{ $settings['hero_subtitle']->label ?? 'Subtitle Hero' }}
                </label>
                <textarea name="hero_subtitle" rows="3"
                          placeholder="Deskripsi singkat platform..."
                          class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all text-sm font-medium resize-none">{{ old('hero_subtitle', $settings['hero_subtitle']->value ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-neutral-dark/50 hover:text-neutral-dark transition-all flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
        </a>
        <button type="submit"
                class="px-10 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            Simpan Pengaturan
        </button>
    </div>
</form>

@push('scripts')
<script>
    function previewImage(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.getElementById('preview-img');
            const empty = document.getElementById('preview-empty');
            const container = document.getElementById('preview-container');

            img.src = e.target.result;
            img.classList.remove('hidden');
            if (empty) empty.classList.add('hidden');

            // Add "new" badge
            container.querySelectorAll('.new-badge').forEach(el => el.remove());
            const badge = document.createElement('div');
            badge.className = 'new-badge absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-4';
            badge.innerHTML = '<span class="text-white text-xs font-bold bg-warning/80 px-3 py-1 rounded-full">⚠ Belum disimpan — klik Simpan</span>';
            container.appendChild(badge);
        };

        reader.readAsDataURL(file);
    }
</script>
@endpush
@endsection
