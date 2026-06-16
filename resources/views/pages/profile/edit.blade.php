@extends('layouts.app')

@section('title', 'Edit Profil - Mountix')

@section('content')
<!-- Header Section -->
<div class="bg-primary pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Edit Profil</h1>
        <p class="text-neutral-light/70 max-w-2xl mx-auto">Perbarui informasi akun pendaki Anda.</p>
    </div>
</div>

<section class="py-16 max-w-2xl mx-auto px-4 sm:px-6">
    <div class="bg-white rounded-3xl shadow-sm border border-neutral-light overflow-hidden">

        <!-- Profile Avatar Header -->
        <div class="p-8 text-center bg-neutral-light/20 border-b border-neutral-light">
            <div class="w-24 h-24 bg-secondary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-black uppercase shadow-lg border-4 border-white">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <h3 class="text-xl font-bold text-primary">{{ auth()->user()->name }}</h3>
            <p class="text-xs text-neutral-dark/40 font-bold uppercase tracking-widest mt-1">{{ auth()->user()->role }}</p>
        </div>

        <!-- Edit Form -->
        <div class="p-8">
            <div id="alert-container"></div>

            <form id="edit-profile-form" class="space-y-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-neutral-dark mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-3.5 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="text" id="name" name="name" required
                            value="{{ auth()->user()->name }}"
                            placeholder="Nama Lengkap"
                            class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>

                <!-- Email (read-only) -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-neutral-dark mb-2">
                        Alamat Email <span class="text-neutral-dark/40 font-normal text-xs">(Tidak dapat diubah)</span>
                    </label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-3.5 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="email" id="email" readonly
                            value="{{ auth()->user()->email }}"
                            class="w-full pl-10 pr-4 py-3 bg-neutral-dark/5 border border-transparent rounded-xl text-neutral-dark/50 cursor-not-allowed">
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-neutral-dark mb-2">
                        Nomor Telepon
                    </label>
                    <div class="relative">
                        <i data-lucide="phone" class="absolute left-3 top-3.5 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="tel" id="phone" name="phone"
                            value="{{ auth()->user()->phone ?? '' }}"
                            placeholder="08123456789"
                            class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>

                <hr class="border-neutral-light">

                <!-- Ganti Password (Opsional) -->
                <div>
                    <h3 class="text-base font-bold text-neutral-dark mb-4 flex items-center">
                        <i data-lucide="lock" class="w-4 h-4 mr-2 text-neutral-dark/40"></i>
                        Ganti Password <span class="text-neutral-dark/40 font-normal text-xs ml-2">(Opsional — kosongkan jika tidak ingin ganti)</span>
                    </h3>
                    <div class="space-y-4">
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-3.5 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="password" id="current_password" name="current_password"
                                placeholder="Password saat ini"
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                        <div class="relative">
                            <i data-lucide="key" class="absolute left-3 top-3.5 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="password" id="new_password" name="new_password"
                                placeholder="Password baru (min. 8 karakter)"
                                minlength="8"
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                        <div class="relative">
                            <i data-lucide="key" class="absolute left-3 top-3.5 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                placeholder="Konfirmasi password baru"
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-2">
                    <a href="{{ route('profile.show') }}" class="flex-1 bg-white text-neutral-dark border border-neutral-light py-3 rounded-2xl text-center font-bold hover:bg-neutral-light transition-all">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn"
                        class="flex-1 bg-primary text-white py-3 rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex justify-center items-center">
                        <span>Simpan Perubahan</span>
                        <i data-lucide="loader-2" id="loader" class="ml-2 w-5 h-5 animate-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('edit-profile-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');

        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const newPasswordConfirmation = document.getElementById('new_password_confirmation').value;

        // Validasi: password baru harus cocok
        if (newPassword && newPassword !== newPasswordConfirmation) {
            window.showAlert('Konfirmasi password baru tidak cocok.', 'danger');
            return;
        }

        // Validasi: jika ingin ganti password, wajib isi password lama
        if (newPassword && !currentPassword) {
            window.showAlert('Masukkan password saat ini terlebih dahulu.', 'danger');
            return;
        }

        const payload = { name, phone };
        if (newPassword) {
            payload.current_password = currentPassword;
            payload.password = newPassword;
            payload.password_confirmation = newPasswordConfirmation;
        }

        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            // Panggil API update profil via JWT
            await window.apiClient.put('/user/profile', payload);
            window.showAlert('Profil berhasil diperbarui!', 'success');

            setTimeout(() => {
                window.location.href = '{{ route("profile.show") }}';
            }, 1500);
        } catch (error) {
            console.error(error);
            let message = 'Gagal memperbarui profil. Silakan coba lagi.';

            if (error.errors) {
                const firstKey = Object.keys(error.errors)[0];
                message = error.errors[firstKey][0];
            } else if (error.message) {
                message = error.message;
            }

            window.showAlert(message, 'danger');
        } finally {
            btn.disabled = false;
            loader.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
