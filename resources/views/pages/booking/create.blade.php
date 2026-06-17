@extends('layouts.app')

@section('title', 'Buat Booking - Mountix')

@section('content')
<div id="loading-overlay" class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center">
    <i data-lucide="loader-2" class="w-12 h-12 animate-spin text-primary mb-4"></i>
    <p class="text-neutral-dark/60 font-medium">Menyiapkan formulir booking...</p>
</div>

<div class="bg-primary pt-20 pb-20">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Pesan Pendakian</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Lengkapi formulir di bawah untuk mendaftarkan pendakian Anda.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <form id="booking-form" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Form Sections -->
        <div class="lg:col-span-2 space-y-12">
            <!-- 1. Route Info -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-neutral-light">
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="map" class="w-6 h-6 mr-3"></i> Informasi Jalur
                </h2>
                <div id="jalur-summary" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Loaded via JS -->
                </div>
            </div>

            <!-- 2. Dates Selection -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-neutral-light">
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="calendar" class="w-6 h-6 mr-3"></i> Pilih Tanggal
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Tanggal Naik</label>
                        <input type="date" id="tanggal_naik" name="tanggal_naik" required 
                            class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Tanggal Turun</label>
                        <input type="date" id="tanggal_turun" name="tanggal_turun" required 
                            class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- 3. Participants -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-neutral-light">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-primary flex items-center">
                        <i data-lucide="users" class="w-6 h-6 mr-3"></i> Data Peserta
                    </h2>
                    <button type="button" onclick="addParticipant()" class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-secondary/90 transition-all flex items-center">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Peserta
                    </button>
                </div>

                <div id="participants-container" class="space-y-6">
                    <!-- Participant forms will be inserted here -->
                </div>
            </div>
        </div>

        <!-- Right: Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-neutral-light sticky top-24">
                <h3 class="text-xl font-bold text-primary mb-6">Ringkasan Pesanan</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-dark/60">Biaya per Orang</span>
                        <span id="price-per-person" class="font-bold text-neutral-dark">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-dark/60">Jumlah Peserta</span>
                        <span id="participant-count-display" class="font-bold text-neutral-dark">0 Orang</span>
                    </div>
                    <hr class="border-neutral-light">
                    <div class="flex justify-between items-center">
                        <span class="text-base font-bold text-primary">Total Bayar</span>
                        <span id="total-price" class="text-2xl font-black text-primary">Rp 0</span>
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-primary text-white py-4 rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex justify-center items-center">
                    <span>Lanjutkan Pembayaran</span>
                    <i data-lucide="loader-2" id="loader" class="ml-2 w-5 h-5 animate-spin hidden"></i>
                </button>
                
                <p class="mt-4 text-[10px] text-center text-neutral-dark/40 leading-relaxed">
                    Pastikan data yang dimasukkan benar. Perubahan data setelah booking mungkin dikenakan biaya tambahan.
                </p>
            </div>
        </div>
    </form>
</section>

@push('scripts')
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const jalurId = urlParams.get('jalur_id');
    const gunungId = urlParams.get('gunung_id'); // Fix N+1: ambil gunung_id dari URL
    let pricePerPerson = 0;
    let participantCount = 0;

    document.addEventListener('DOMContentLoaded', async function() {
        if (!localStorage.getItem('auth_token')) {
            window.showAlert('Anda harus login untuk melakukan booking.', 'danger');
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname + window.location.search);
            return;
        }

        if (!jalurId) {
            window.showAlert('Jalur tidak valid.', 'danger');
            window.location.href = '/gunung';
            return;
        }

        try {
            await fetchJalurInfo();
        } catch (e) {
            console.error(e);
        } finally {
            // Pastikan peserta pertama selalu ada dan overlay selalu hilang
            if (participantCount === 0) {
                addParticipant(true);
            }
            document.getElementById('loading-overlay').classList.add('hidden');
        }

        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_naik').min = today;
        document.getElementById('tanggal_turun').min = today;

        document.getElementById('tanggal_naik').addEventListener('change', function() {
            const tanggalTurun = document.getElementById('tanggal_turun');
            tanggalTurun.min = this.value;
            if (tanggalTurun.value && tanggalTurun.value < this.value) {
                tanggalTurun.value = '';
                window.showAlert('Tanggal turun direset karena lebih awal dari tanggal naik.', 'danger');
            }
        });

        document.getElementById('booking-form').addEventListener('submit', handleBookingSubmit);
    });

    /**
     * FIX #2: Gunakan gunung_id dari URL → 1 request saja.
     * Fallback ke loop hanya jika gunung_id benar-benar tidak ada.
     */
    async function fetchJalurInfo() {
        try {
            let foundJalur = null;
            let foundGunung = null;

            if (gunungId) {
                // Optimal path: 1 request
                const detailResp = await window.apiClient.get(`/gunung/${gunungId}`);
                const mountainData = detailResp.data.data || detailResp.data;
                const jalurs = mountainData.jalur || [];
                foundJalur = jalurs.find(j => String(j.id) === String(jalurId));
                if (foundJalur) foundGunung = mountainData;
            } else {
                // Fallback: loop semua gunung (N+1 — hanya jika gunung_id tidak ada)
                const response = await window.apiClient.get('/gunung');
                const mountains = response.data.data || response.data;
                const list = Array.isArray(mountains) ? mountains : (mountains.data || []);

                for (const mountain of list) {
                    const detailResp = await window.apiClient.get(`/gunung/${mountain.id}`);
                    const mountainData = detailResp.data.data || detailResp.data;
                    const jalurs = mountainData.jalur || [];
                    const target = jalurs.find(j => String(j.id) === String(jalurId));
                    if (target) {
                        foundJalur = target;
                        foundGunung = mountainData;
                        break;
                    }
                }
            }

            if (foundJalur && foundGunung) {
                pricePerPerson = foundJalur.harga_per_orang;
                updateSummary();

                document.getElementById('jalur-summary').innerHTML = `
                    <div class="flex items-start space-x-4">
                        <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-neutral-light">
                            <img src="${foundGunung.foto_cover ? foundGunung.foto_cover : 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=200'}" class="w-full h-full object-cover" alt="Foto gunung">
                        </div>
                        <div>
                            <span class="text-[10px] text-secondary font-black uppercase tracking-widest">${foundGunung.nama}</span>
                            <h4 class="text-lg font-bold text-primary">${foundJalur.nama_jalur}</h4>
                            <p class="text-xs text-neutral-dark/40 flex items-center mt-1 font-medium">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i> Estimasi ${foundJalur.estimasi_jam || 0} Jam
                            </p>
                        </div>
                    </div>
                    <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10">
                        <span class="text-[10px] text-primary/60 block mb-1 font-black uppercase tracking-widest">Ketersediaan</span>
                        <span class="text-sm font-bold text-primary flex items-center">
                            <i data-lucide="check-circle-2" class="w-4 h-4 mr-2"></i> Kuota Tersedia
                        </span>
                    </div>
                `;
                lucide.createIcons();
            } else {
                // FIX #6: Tampilkan error di UI, bukan hanya alert, dan jangan biarkan overlay terus tampil
                document.getElementById('jalur-summary').innerHTML = `
                    <div class="col-span-2 text-center py-6">
                        <p class="text-danger font-semibold">Jalur tidak ditemukan. Silakan kembali dan pilih jalur kembali.</p>
                        <a href="/gunung" class="mt-4 inline-block bg-primary text-white px-6 py-2 rounded-xl text-sm font-bold">Kembali ke Daftar Gunung</a>
                    </div>
                `;
                window.showAlert('Informasi jalur tidak ditemukan.', 'danger');
            }
        } catch (error) {
            console.error('Error in fetchJalurInfo:', error);
            throw error;
        }
    }

    /**
     * FIX #1 (CRITICAL): Perbaikan syntax error pada template literal.
     * Sebelumnya backtick di baris innerHTML ditutup prematur di tengah string
     * (setelah </span> pertama), menyebabkan seluruh JS crash.
     *
     * FIX #4: participantCount hanya digunakan sebagai counter monoton naik
     * untuk ID unik. Nomor tampilan dihitung ulang via recalculateParticipantNumbers().
     */
    function addParticipant(isLeader = false) {
        participantCount++;
        const cardId = participantCount;
        const container = document.getElementById('participants-container');
        const card = document.createElement('div');
        card.className = 'participant-card bg-neutral-light/20 p-6 rounded-3xl border border-neutral-light relative overflow-hidden group hover:border-primary/20 transition-all';
        card.id = `participant-container-${cardId}`;

        // FIX #1: Satu template literal yang konsisten tanpa penutupan backtick prematur
        const leaderBadge = isLeader
            ? '<span class="text-[10px] text-secondary font-black uppercase tracking-widest ml-2">Ketua Rombongan</span>'
            : '';
        const deleteBtn = !isLeader
            ? `<button type="button" onclick="removeParticipant(${cardId})" class="text-danger hover:scale-110 transition-transform p-1" title="Hapus peserta">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
               </button>`
            : '';

        card.innerHTML = `
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <span class="participant-badge bg-primary text-white px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest">
                        Peserta #${cardId}
                    </span>
                    ${leaderBadge}
                </div>
                ${deleteBtn}
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" name="nama_lengkap[]" required placeholder="Contoh: Muhammad Akmal"
                        class="w-full px-4 py-3 bg-white border border-neutral-light rounded-xl focus:border-primary focus:outline-none transition-all text-sm font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">Nomor NIK</label>
                    <input type="text" name="nik[]" required maxlength="16" minlength="16" placeholder="16 Digit NIK"
                        class="w-full px-4 py-3 bg-white border border-neutral-light rounded-xl focus:border-primary focus:outline-none transition-all text-sm font-medium"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir[]" required
                        class="w-full px-4 py-3 bg-white border border-neutral-light rounded-xl focus:border-primary focus:outline-none transition-all text-sm font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin[]" required
                        class="w-full px-4 py-3 bg-white border border-neutral-light rounded-xl focus:border-primary focus:outline-none transition-all text-sm font-medium appearance-none">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-neutral-dark/40 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat[]" required rows="2" placeholder="Alamat lengkap domisili saat ini..."
                        class="w-full px-4 py-3 bg-white border border-neutral-light rounded-xl focus:border-primary focus:outline-none transition-all text-sm font-medium resize-none"></textarea>
                </div>
            </div>
        `;

        container.appendChild(card);
        lucide.createIcons();
        updateSummary();
    }

    function removeParticipant(id) {
        const card = document.getElementById(`participant-container-${id}`);
        if (card) {
            card.remove();
            recalculateParticipantNumbers();
            updateSummary();
        }
    }

    function recalculateParticipantNumbers() {
        const cards = document.querySelectorAll('.participant-card');
        cards.forEach((card, index) => {
            const badge = card.querySelector('.participant-badge');
            if (badge) badge.textContent = `Peserta #${index + 1}`;
        });
    }

    function updateSummary() {
        const currentCount = document.querySelectorAll('.participant-card').length;
        document.getElementById('price-per-person').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(pricePerPerson)}`;
        document.getElementById('participant-count-display').textContent = `${currentCount} Orang`;
        document.getElementById('total-price').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(pricePerPerson * currentCount)}`;
    }

    async function handleBookingSubmit(e) {
        e.preventDefault();

        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');

        const names     = document.getElementsByName('nama_lengkap[]');
        const niks      = document.getElementsByName('nik[]');
        const dobs      = document.getElementsByName('tanggal_lahir[]');
        const genders   = document.getElementsByName('jenis_kelamin[]');
        const addresses = document.getElementsByName('alamat[]');

        // Validasi: harus ada minimal 1 peserta
        if (names.length === 0) {
            window.showAlert('Tambahkan minimal 1 peserta.', 'danger');
            return;
        }

        const members = [];
        for (let i = 0; i < names.length; i++) {
            // Validasi NIK harus 16 digit
            if (niks[i].value.length !== 16) {
                window.showAlert(`NIK peserta #${i + 1} harus 16 digit.`, 'danger');
                niks[i].focus();
                return;
            }
            members.push({
                nama_lengkap:      names[i].value.trim(),
                nik:               niks[i].value.trim(),
                tanggal_lahir:     dobs[i].value,
                jenis_kelamin:     genders[i].value,
                alamat:            addresses[i].value.trim(),
                ktp_path:          'placeholder',
                surat_sehat_path:  'placeholder'
            });
        }

        const tanggalNaik  = document.getElementById('tanggal_naik').value;
        const tanggalTurun = document.getElementById('tanggal_turun').value;

        if (!tanggalNaik || !tanggalTurun) {
            window.showAlert('Tanggal naik dan turun harus diisi.', 'danger');
            return;
        }

        const payload = {
            jalur_id:      parseInt(jalurId),
            tanggal_naik:  tanggalNaik,
            tanggal_turun: tanggalTurun,
            members:       members
        };

        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            const data = await window.bookingService.createBooking(payload);
            window.showAlert('Booking berhasil! Mengalihkan ke pembayaran...', 'success');

            // FIX #3: Ekstrak booking ID dari berbagai bentuk response
            const bookingId = data?.data?.id ?? data?.id ?? null;
            if (!bookingId) throw new Error('ID booking tidak ditemukan dari response server.');

            setTimeout(() => {
                window.location.href = `/payment/${bookingId}`;
            }, 1500);
        } catch (error) {
            console.error(error);
            // FIX #3: error dari bookingService bisa berupa object {message:...} atau string
            let message = 'Gagal membuat pesanan. Cek kembali data atau kuota jalur.';
            if (typeof error === 'string') {
                message = error;
            } else if (error?.message) {
                message = error.message;
            } else if (error?.errors) {
                // Laravel validation errors: ambil pesan pertama
                const firstKey = Object.keys(error.errors)[0];
                message = error.errors[firstKey][0];
            }
            window.showAlert(message, 'danger');
        } finally {
            btn.disabled = false;
            loader.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
