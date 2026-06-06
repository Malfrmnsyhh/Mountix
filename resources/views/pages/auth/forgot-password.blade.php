@extends('layouts.app')

@section('title', 'Lupa Password - Mountix')

@section('content')
<section class="min-h-[calc(100vh-64px-300px)] flex items-center justify-center py-20 px-4 bg-neutral-light">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-primary">Lupa Password?</h1>
                <p class="text-neutral-dark/60 mt-2">Masukkan email Anda untuk menerima link reset password</p>
            </div>

            <form id="forgot-password-form" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-neutral-dark mb-2">Alamat Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-3 w-5 h-5 text-neutral-dark/40"></i>
                        <input type="email" id="email" required placeholder="name@example.com" 
                            class="w-full pl-10 pr-4 py-3 bg-neutral-light border border-transparent rounded-xl focus:border-primary focus:bg-white focus:outline-none transition-all">
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary/90 transition-all flex justify-center items-center">
                    <span>Kirim Link Reset</span>
                    <i data-lucide="loader-2" id="loader" class="ml-2 w-5 h-5 animate-spin hidden"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-sm">
                <p class="text-neutral-dark/60">Ingat password Anda? 
                    <a href="{{ route('login') }}" class="font-bold text-secondary hover:underline">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('forgot-password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const btn = document.getElementById('submit-btn');
        const loader = document.getElementById('loader');

        // Loading state
        btn.disabled = true;
        loader.classList.remove('hidden');

        try {
            const data = await window.auth.forgotPassword(email);
            window.showAlert('Link reset password telah dikirim ke email Anda.', 'success');
            
            // Clear input
            document.getElementById('email').value = '';
        } catch (error) {
            console.error(error);
            const message = error.message || 'Gagal mengirim email reset password. Pastikan email Anda terdaftar.';
            window.showAlert(message, 'danger');
        } finally {
            btn.disabled = false;
            loader.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
