@extends('layouts.app')

@section('title', 'Masuk - Mountix')

@section('content')
<section class="min-h-[calc(100vh-64px-300px)] flex items-center justify-center py-20 px-4 bg-neutral-light">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-primary">Selamat Datang</h1>
                <p class="text-neutral-dark/60 mt-2">Masuk untuk mengelola pendakian Anda</p>
            </div>

            <form id="login-form" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Alamat Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="email" id="email" required placeholder="name@example.com" 
                            class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-semibold text-neutral-dark">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-secondary hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="password" id="password" required placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="w-4 h-4 rounded text-primary focus:ring-primary border-neutral-light">
                    <label for="remember" class="ml-2 text-sm text-neutral-dark/60">Ingat saya</label>
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all flex justify-center items-center">
                    <span>Masuk</span>
                    <i data-lucide="loader-2" id="loader" class="ml-2 w-5 h-5 animate-spin hidden"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-sm">
                <p class="text-neutral-dark/60">Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-secondary hover:underline">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');

        // Loading state
        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            const data = await window.auth.login(email, password);
            window.showAlert('Login berhasil! Mengalihkan...', 'success');
            
            setTimeout(() => {
                // If user is admin, redirect to bridge to sync session
                if (data.user && data.user.role === 'admin') {
                    window.location.href = `/auth/session-bridge?token=${data.access_token}`;
                } else {
                    window.location.href = '{{ route("home") }}';
                }
            }, 1000);
        } catch (error) {
            console.error(error);
            const message = error.error || error.message || 'Login gagal. Periksa kembali email dan password Anda.';
            window.showAlert(message, 'danger');
        } finally {
            btn.disabled = false;
            loader.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
