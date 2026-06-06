@props(['image', 'name', 'location', 'price', 'id'])

<div class="bg-white rounded-xl shadow-md overflow-hidden hover:scale-105 transition-transform duration-300">
    <div class="relative h-48">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
        <div class="absolute top-4 right-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">
            Tersedia
        </div>
    </div>
    <div class="p-6">
        <div class="flex items-center text-secondary text-sm font-medium mb-2">
            <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
            {{ $location }}
        </div>
        <h3 class="text-xl font-bold text-neutral-dark mb-2">{{ $name }}</h3>
        <div class="flex items-center text-warning mb-4">
            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
            <i data-lucide="star" class="w-4 h-4 fill-current ml-0.5"></i>
            <i data-lucide="star" class="w-4 h-4 fill-current ml-0.5"></i>
            <i data-lucide="star" class="w-4 h-4 fill-current ml-0.5"></i>
            <i data-lucide="star" class="w-4 h-4 text-neutral-dark/20 ml-0.5"></i>
            <span class="text-neutral-dark text-sm ml-2">(4.0)</span>
        </div>
        <div class="flex items-center justify-between border-t border-neutral-light pt-4">
            <div>
                <span class="text-xs text-neutral-dark/60 block">Mulai dari</span>
                <span class="text-lg font-bold text-primary">Rp {{ number_format($price, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('gunung.show', $id) }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors">
                Detail
            </a>
        </div>
    </div>
</div>
