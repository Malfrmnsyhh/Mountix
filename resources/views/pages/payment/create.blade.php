@extends('layouts.app')

@section('title', 'Pembayaran - Mountix')

@section('content')
<div id="loading-overlay" class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center">
    <i data-lucide="loader-2" class="w-12 h-12 animate-spin text-primary mb-4"></i>
    <p class="text-neutral-dark/60 font-medium">Memuat data pembayaran...</p>
</div>

<div class="bg-primary pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Pembayaran</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Selesaikan pembayaran Anda untuk mendapatkan e-ticket pendakian.</p>
    </div>
</div>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Payment Methods & Info -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Booking Summary -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-neutral-light">
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="shopping-bag" class="w-6 h-6 mr-3"></i> Ringkasan Booking
                </h2>
                <div id="booking-info" class="space-y-4">
                    <!-- Loaded via JS -->
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-neutral-light">
                <h2 class="text-2xl font-bold text-primary mb-6 flex items-center">
                    <i data-lucide="credit-card" class="w-6 h-6 mr-3"></i> Metode Pembayaran
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 border-2 border-primary rounded-2xl relative">
                        <div class="absolute top-4 right-4 text-primary">
                            <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-neutral-dark mb-2">Transfer Bank (Manual)</h4>
                        <p class="text-sm text-neutral-dark/60 mb-4">Silakan transfer ke rekening berikut:</p>
                        <div class="bg-neutral-light p-4 rounded-xl space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-neutral-dark/40 uppercase">Bank</span>
                                <span class="text-sm font-bold text-neutral-dark">Bank Mandiri</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-neutral-dark/40 uppercase">No. Rekening</span>
                                <span class="text-sm font-bold text-neutral-dark">123-00-123456-7</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-neutral-dark/40 uppercase">Atas Nama</span>
                                <span class="text-sm font-bold text-neutral-dark">PT MOUNTIX INDONESIA</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 border-2 border-neutral-light rounded-2xl opacity-50 cursor-not-allowed">
                        <h4 class="font-bold text-neutral-dark mb-2">Credit Card / E-Wallet</h4>
                        <p class="text-sm text-neutral-dark/60 mb-4">Otomatis Terverifikasi</p>
                        <div class="bg-neutral-light p-4 rounded-xl text-center text-xs font-bold text-neutral-dark/40 uppercase">
                            Segera Hadir
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Upload Proof -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-neutral-light sticky top-24">
                <h3 class="text-xl font-bold text-primary mb-6">Konfirmasi Pembayaran</h3>
                
                <form id="payment-form" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Total yang Harus Dibayar</label>
                        <div class="text-3xl font-black text-primary" id="total-amount-display">Rp 0</div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Unggah Bukti Transfer</label>
                        <div id="drop-area" class="border-2 border-dashed border-neutral-light rounded-2xl p-8 text-center cursor-pointer hover:border-primary transition-colors group">
                            <input type="file" id="bukti_bayar" class="hidden" accept="image/*" required>
                            <i data-lucide="upload-cloud" class="w-10 h-10 mx-auto text-neutral-dark/20 group-hover:text-primary transition-colors mb-4"></i>
                            <p class="text-xs text-neutral-dark/60" id="file-name">Klik atau seret gambar ke sini (Max 2MB)</p>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="w-full bg-primary text-white py-4 rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex justify-center items-center">
                        <span>Kirim Konfirmasi</span>
                        <i data-lucide="loader-2" id="loader" class="ml-2 w-5 h-5 animate-spin hidden"></i>
                    </button>
                </form>
                
                <p class="mt-4 text-[10px] text-center text-neutral-dark/40 leading-relaxed">
                    Admin akan memverifikasi pembayaran Anda dalam waktu maksimal 1x24 jam. E-ticket akan dikirimkan otomatis setelah disetujui.
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const bookingId = "{{ $booking_id }}";
    let bookingData = null;

    document.addEventListener('DOMContentLoaded', async function() {
        await loadBookingDetail();

        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('bukti_bayar');
        const fileNameDisplay = document.getElementById('file-name');

        dropArea.onclick = () => fileInput.click();

        fileInput.onchange = (e) => {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    window.showAlert('Ukuran file maksimal 2MB.', 'danger');
                    fileInput.value = '';
                    fileNameDisplay.textContent = 'Klik atau seret gambar ke sini (Max 2MB)';
                } else {
                    fileNameDisplay.textContent = file.name;
                    fileNameDisplay.classList.add('text-primary', 'font-bold');
                }
            }
        };

        document.getElementById('payment-form').onsubmit = handlePaymentSubmit;
    });

    async function loadBookingDetail() {
        try {
            const response = await window.bookingService.getBookingDetail(bookingId);
            bookingData = response.data;
            
            document.getElementById('total-amount-display').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(bookingData.total_bayar)}`;
            
            const infoContainer = document.getElementById('booking-info');
            infoContainer.innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-neutral-dark/40 block">Kode Booking</span>
                        <span class="font-bold text-neutral-dark">${bookingData.kode_booking}</span>
                    </div>
                    <div>
                        <span class="text-neutral-dark/40 block">Gunung & Jalur</span>
                        <span class="font-bold text-neutral-dark">${bookingData.jalur.gunung.nama} - ${bookingData.jalur.nama_jalur}</span>
                    </div>
                    <div>
                        <span class="text-neutral-dark/40 block">Tanggal Naik</span>
                        <span class="font-bold text-neutral-dark">${bookingData.tanggal_naik}</span>
                    </div>
                    <div>
                        <span class="text-neutral-dark/40 block">Jumlah Peserta</span>
                        <span class="font-bold text-neutral-dark">${bookingData.jumlah_orang} Orang</span>
                    </div>
                </div>
            `;
            
            lucide.createIcons();
            document.getElementById('loading-overlay').classList.add('hidden');
        } catch (error) {
            console.error(error);
            window.showAlert('Gagal memuat detail booking.', 'danger');
        }
    }

    async function handlePaymentSubmit(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');
        const fileInput = document.getElementById('bukti_bayar');
        
        if (!fileInput.files[0]) {
            window.showAlert('Pilih bukti transfer terlebih dahulu.', 'danger');
            return;
        }

        const formData = new FormData();
        formData.append('metode_pembayaran', 'transfer');
        formData.append('bukti_bayar', fileInput.files[0]);

        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            await window.paymentService.submitPayment(bookingId, formData);
            window.showAlert('Konfirmasi berhasil! Mengalihkan...', 'success');
            
            setTimeout(() => {
                window.location.href = `/payment/${bookingId}/success`;
            }, 1500);
        } catch (error) {
            console.error(error);
            window.showAlert(error.message || 'Gagal mengirim konfirmasi.', 'danger');
        } finally {
            btn.disabled = false;
            loader.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
