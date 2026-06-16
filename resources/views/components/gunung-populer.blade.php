@props(['mountains'])

<section class="gunung-populer" id="gunungPopuler">
  <div class="section-container">
    <!-- Section Header -->
    <div class="section-header">
      <div>
        <h2 class="section-title">Gunung Populer</h2>
        <p class="section-subtitle">
          Destinasi favorit para pendaki bulan ini. Pilih rute terbaik untuk petualangan Anda.
        </p>
      </div>
      <a href="/gunung" class="btn btn-link">
        Lihat Semua
        <span>→</span>
      </a>
    </div>

    <!-- Mountains Grid -->
    <div class="mountains-grid">
      @forelse($mountains as $index => $gunung)
        <div class="reveal delay-{{ ($index % 3) + 1 }}">
          <x-mountain-card :gunung="$gunung" />
        </div>
      @empty
        <div class="empty-state reveal">
          <div class="empty-icon">📭</div>
          <h3>Tidak Ada Destinasi</h3>
          <p>Coba ubah filter pencarian Anda atau cek kembali nanti.</p>
          <a href="/gunung" class="btn btn-primary">
            Lihat Semua Destinasi
          </a>
        </div>
      @endforelse
    </div>

    <!-- CTA to see all -->
    <div class="section-footer">
      <a href="/gunung" class="btn btn-primary btn-lg">
        Lihat Semua Destinasi
        <span>→</span>
      </a>
    </div>
  </div>
</section>
