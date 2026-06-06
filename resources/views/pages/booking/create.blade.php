@extends('layouts.app')

@section('title', 'Buat Booking - Mountix')

@section('content')
<div id="loading-overlay" class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center">
    <i data-lucide="loader-2" class="w-12 h-12 animate-spin text-primary mb-4"></i>
    <p class="text-neutral-dark/60 font-medium">Menyiapkan formulir booking...</p>
</div>

<div class="bg-primary pt-32 pb-20">
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
                        <input type="date" id="tanggal_naik" required 
                            class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Tanggal Turun</label>
                        <input type="date" id="tanggal_turun" required 
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
                    <!-- Participant forms inserted here -->
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
                        <span id="participant-count-display" class="font-bold text-neutral-dark">1 Orang</span>
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
                
                <p class="mt-4 text-[10px] text-center text-neutral-dark/40">
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
    let pricePerPerson = 0;
    let participantCount = 0;

    document.addEventListener('DOMContentLoaded', async function() {
        if (!localStorage.getItem('auth_token')) {
            window.showAlert('Anda harus login untuk melakukan booking.', 'danger');
            window.location.href = '/login';
            return;
        }

        if (!jalurId) {
            window.showAlert('Jalur tidak valid.', 'danger');
            window.location.href = '/gunung';
            return;
        }

        // Initialize with 1 participant (Leader)
        addParticipant(true);
        await fetchJalurInfo();
        
        // Min date today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_naik').min = today;
        document.getElementById('tanggal_turun').min = today;

        document.getElementById('tanggal_naik').addEventListener('change', function() {
            document.getElementById('tanggal_turun').min = this.value;
        });

        document.getElementById('booking-form').addEventListener('submit', handleBookingSubmit);
    });

    async function fetchJalurInfo() {
        try {
            // We need a way to get jalur info. Since we don't have a direct getJalur API yet, 
            // we'll find it from its mountain. For simplicity, we assume we need to fetch mountain detail or we'd have a specific API.
            // But wait, the API was: Route::apiResource('gunung.jalur', JalurController::class)
            // So we need gunung_id too. Let's adjust or assume we have it or fetch it.
            // For now, let's fetch all mountains and find the jalur if needed, or better, 
            // we should have added an API for single jalur. 
            // Looking at routes/api.php: Route::apiResource('gunung.jalur', JalurController::class)->only(['index', 'show']);
            // It expects /v1/gunung/{gunung}/jalur/{jalur}.
            // Let's assume the user clicked from detail page which has the info.
            
            // Temporary workaround: we need the gunung_id. Let's check if we can find it.
            // For now, I'll fetch ALL mountains and find the one with this jalur. 
            // In a real app, you'd pass both IDs in URL.
            const response = await window.gunungService.getGunungs();
            let foundJalur = null;
            let foundGunung = null;

            for (const g of response.data) {
                // Fetch full detail for each mountain to see jalurs
                const detail = await window.gunungService.getGunungDetail(g.id);
                const jalur = detail.data.jalur.find(j => j.id == jalurId);
                if (jalur) {
                    foundJalur = jalur;
                    foundGunung = detail.data;
                    break;
                }
            }

            if (foundJalur && foundGunung) {
                pricePerPerson = foundJalur.harga_per_orang;
                updateSummary();
                
                document.getElementById('jalur-summary').innerHTML = `
                    <div class="flex items-start space-x-4">
                        <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="${foundGunung.foto_cover || 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=200'}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <span class="text-xs text-secondary font-bold uppercase tracking-wider">${foundGunung.nama}</span>
                            <h4 class="text-lg font-bold text-neutral-dark">${foundJalur.nama_jalur}</h4>
                            <p class="text-xs text-neutral-dark/40 flex items-center mt-1">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i> Estimasi ${foundJalur.estimasi_jam} Jam
                            </p>
                        </div>
                    </div>
                    <div class="bg-neutral-light/50 p-4 rounded-xl border border-neutral-light">
                        <span class="text-xs text-neutral-dark/40 block mb-1">Status Jalur</span>
                        <span class="text-sm font-bold text-success flex items-center">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Terbuka untuk Booking
                        </span>
                    </div>
                `;
                lucide.createIcons();
            } else {
                window.showAlert('Jalur tidak ditemukan.', 'danger');
                window.location.href = '/gunung';
            }
        } catch (error) {
            console.error(error);
            window.showAlert('Gagal memuat data jalur.', 'danger');
        } finally {
            document.getElementById('loading-overlay').classList.add('hidden');
        }
    }

    function addParticipant(isLeader = false) {
        participantCount++;
        const container = document.getElementById('participants-container');
        const card = document.createElement('div');
        card.className = 'participant-card bg-neutral-light/30 p-6 rounded-2xl border border-neutral-light relative';
        card.id = `participant-${participantCount}`;
        
        card.innerHTML = `
            <div class="flex justify-between items-center mb-6">
                <span class="bg-primary text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">
                    Peserta #${participantCount} ${isLeader ? '(Ketua)' : ''}
                </span>
                ${!isLeader ? `
                    <button type="button" onclick="removeParticipant(${participantCount})" class="text-danger hover:text-danger/70 transition-colors">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                ` : ''}
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Nama Lengkap (sesuai KTP)</label>
                    <input type="text" name="nama_lengkap[]" required placeholder="Contoh: John Doe" 
                        class="w-full px-4 py-2 bg-white border border-neutral-light rounded-lg focus:border-primary focus:outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Nomor NIK</label>
                    <input type="text" name="nik[]" required maxlength="16" minlength="16" placeholder="16 digit NIK" 
                        class="w-full px-4 py-2 bg-white border border-neutral-light rounded-lg focus:border-primary focus:outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir[]" required 
                        class="w-full px-4 py-2 bg-white border border-neutral-light rounded-lg focus:border-primary focus:outline-none transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin[]" required 
                        class="w-full px-4 py-2 bg-white border border-neutral-light rounded-lg focus:border-primary focus:outline-none transition-all text-sm">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Alamat Lengkap</label>
                    <textarea name="alamat[]" required rows="2" placeholder="Alamat lengkap domisili saat ini" 
                        class="w-full px-4 py-2 bg-white border border-neutral-light rounded-lg focus:border-primary focus:outline-none transition-all text-sm resize-none"></textarea>
                </div>
            </div>
        `;
        
        container.appendChild(card);
        lucide.createIcons();
        updateSummary();
    }

    function removeParticipant(id) {
        document.getElementById(`participant-${id}`).remove();
        // Renumbering participants
        const cards = document.querySelectorAll('.participant-card');
        participantCount = 0;
        cards.forEach((card, index) => {
            participantCount++;
            card.id = `participant-${participantCount}`;
            const label = card.querySelector('.bg-primary');
            label.textContent = `Peserta #${participantCount} ${participantCount === 1 ? '(Ketua)' : ''}`;
            const deleteBtn = card.querySelector('button');
            if (deleteBtn) {
                deleteBtn.setAttribute('onclick', `removeParticipant(${participantCount})`);
            }
        });
        updateSummary();
    }

    function updateSummary() {
        const count = document.querySelectorAll('.participant-card').length;
        document.getElementById('price-per-person').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(pricePerPerson)}`;
        document.getElementById('participant-count-display').textContent = `${count} Orang`;
        document.getElementById('total-price').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(pricePerPerson * count)}`;
    }

    async function handleBookingSubmit(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');
        
        const participants = [];
        const names = document.getElementsByName('nama_lengkap[]');
        const niks = document.getElementsByName('nik[]');
        const dobs = document.getElementsByName('tanggal_lahir[]');
        const genders = document.getElementsByName('jenis_kelamin[]');
        const addresses = document.getElementsByName('alamat[]');

        for (let i = 0; i < names.length; i++) {
            participants.push({
                nama_lengkap: names[i].value,
                nik: niks[i].value,
                tanggal_lahir: dobs[i].value,
                jenis_kelamin: genders[i].value,
                alamat: addresses[i].value,
                ktp_path: "dummy/path", // Backend simplified this for now
                surat_sehat_path: "dummy/path"
            });
        }

        const payload = {
            jalur_id: jalurId,
            tanggal_naik: document.getElementById('tanggal_naik').value,
            tanggal_turun: document.getElementById('tanggal_turun').value,
            members: participants
        };

        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            const data = await window.bookingService.createBooking(payload);
            window.showAlert('Booking berhasil dibuat! Mengalihkan ke pembayaran...', 'success');
            
            setTimeout(() => {
                window.location.href = `/payment/${data.data.id}`;
            }, 1500);
        } catch (error) {
            console.error(error);
            const message = error.message || 'Gagal membuat booking. Cek kembali kuota atau data Anda.';
            window.showAlert(message, 'danger');
        } finally {
            btn.disabled = false;
            loader.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
