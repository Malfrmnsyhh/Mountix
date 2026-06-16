@props(['gunung'])

@php
    $price = $gunung->jalurs->min('harga_per_orang') ?? 0;
    $statusBuka = $gunung->status_buka;
    $isOpen = $statusBuka === 1
           || $statusBuka === true
           || strtolower((string) $statusBuka) === 'buka';

    $statusClass = $isOpen ? 'tersedia' : 'soldout';
    $statusText  = $isOpen ? 'Buka' : 'Tutup';
    
    // Terbatas jika harga tinggi tapi masih buka
    if ($isOpen && $price > 100000) {
        $statusClass = 'limited';
        $statusText  = 'Terbatas';
    }

    $image = (filter_var($gunung->foto_cover, FILTER_VALIDATE_URL) 
        ? $gunung->foto_cover 
        : ($gunung->foto_cover ? asset('storage/' . $gunung->foto_cover) : 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'));
    
    $rating = 4.5; 
    $totalReviews = 125;
@endphp

<div class="mountain-card">
  <!-- Status Badge -->
  <div class="card-badge {{ $statusClass }}">
    {{ $statusText }}
  </div>

  <!-- Image Container -->
  <div class="card-image">
    <img 
      src="{{ $image }}"
      alt="{{ $gunung->nama }}"
      class="image"
      loading="lazy"
    >
    <div class="card-overlay"></div>
  </div>

  <!-- Content -->
  <div class="card-content">
    <!-- Title & Rating -->
    <div class="card-header">
      <h3 class="card-title">{{ $gunung->nama }}</h3>
      <div class="card-rating">
        <span class="rating-value">{{ number_format($rating, 1) }}</span>
      </div>
    </div>

    <!-- Location -->
    <p class="card-location">📍 {{ $gunung->lokasi }}</p>

    <!-- Rating & Reviews -->
    <p class="card-reviews">({{ $totalReviews }} ulasan)</p>

    <!-- Price Range -->
    <div class="card-price">
      <span>Dari</span>
      <span class="price">Rp {{ number_format($price, 0, ',', '.') }}</span>
    </div>

    <!-- CTA Buttons -->
    <div class="card-actions">
      <a href="/gunung/{{ $gunung->id }}" class="btn btn-secondary btn-sm">
        Lihat Ketersediaan
      </a>
    </div>
  </div>
</div>
