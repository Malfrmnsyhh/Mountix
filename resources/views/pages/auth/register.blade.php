@extends('layouts.app')

@section('title', 'Daftar - Mountix')

@section('content')
<section class="min-h-[calc(100vh-64px-300px)] flex items-center justify-center py-20 px-4 bg-neutral-light">
    <div class="max-w-xl w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-primary">Buat Akun Baru</h1>
                <p class="text-neutral-dark/60 mt-2">Daftar untuk mulai merencanakan petualangan Anda</p>
            </div>

            <form id="register-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <i data-lucide="user" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="text" id="name" required placeholder="John Doe" 
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Nomor Telepon</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="tel" id="phone" required placeholder="08123456789" 
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Alamat Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="email" id="email" required placeholder="name@example.com" 
                            class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="password" id="password" required placeholder="••••••••" 
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-neutral-dark mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <i data-lucide="shield-check" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                            <input type="password" id="password_confirmation" required placeholder="••••••••" 
                                class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" id="terms" required class="mt-1 w-4 h-4 rounded text-primary focus:ring-primary border-neutral-light">
                    <label for="terms" class="ml-2 text-sm text-neutral-dark/60">
                        Saya setuju dengan <a href="#" class="text-primary font-bold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-primary font-bold hover:underline">Kebijakan Privasi</a> Mountix.
                    </label>
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all flex justify-center items-center">
                    <span>Daftar Akun</span>
                    <i data-lucide="loader-2" id="loader" class="ml-2 w-5 h-5 animate-spin hidden"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-sm">
                <p class="text-neutral-dark/60">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-secondary hover:underline">Masuk Di Sini</a>
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('register-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;
        
        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');

        if (password !== password_confirmation) {
            window.showAlert('Password konfirmasi tidak cocok.', 'danger');
            return;
        }

        // Loading state
        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            const data = await window.auth.register({ 
                name, 
                phone, 
                email, 
                password, 
                password_confirmation 
            });
            window.showAlert('Registrasi berhasil! Silakan cek email Anda untuk verifikasi.', 'success');
            
            setTimeout(() => {
                window.location.href = '{{ route("home") }}';
            }, 2000);
        } catch (error) {
            console.error(error);
            let message = 'Registrasi gagal. Silakan coba lagi.';
            
            if (error.errors) {
                // Get first validation error
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
