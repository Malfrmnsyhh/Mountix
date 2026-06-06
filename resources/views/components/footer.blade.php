<footer class="bg-primary text-white pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Brand & Description -->
            <div class="col-span-1 md:col-span-1">
                <a href="/" class="text-2xl font-bold tracking-tight">
                    MOUNT<span class="text-secondary">IX</span>
                </a>
                <p class="mt-4 text-neutral-light/80 text-sm leading-relaxed">
                    Platform booking pendakian gunung di Indonesia yang aman, mudah, dan terpercaya. Nikmati petualangan Anda tanpa ribet.
                </p>
                <div class="flex space-x-4 mt-6">
                    <a href="#" class="text-neutral-light hover:text-secondary transition-colors"><i data-lucide="instagram"></i></a>
                    <a href="#" class="text-neutral-light hover:text-secondary transition-colors"><i data-lucide="facebook"></i></a>
                    <a href="#" class="text-neutral-light hover:text-secondary transition-colors"><i data-lucide="twitter"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-6">Navigasi</h3>
                <ul class="space-y-4 text-sm text-neutral-light/80">
                    <li><a href="{{ route('home') }}" class="hover:text-secondary transition-colors">Beranda</a></li>
                    <li><a href="{{ route('gunung.index') }}" class="hover:text-secondary transition-colors">Daftar Gunung</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors">Bantuan</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold mb-6">Layanan</h3>
                <ul class="space-y-4 text-sm text-neutral-light/80">
                    <li><a href="#" class="hover:text-secondary transition-colors">Booking Online</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors">Cek Kuota</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors">Verifikasi Pembayaran</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors">E-Ticket</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-6">Kontak Kami</h3>
                <ul class="space-y-4 text-sm text-neutral-light/80">
                    <li class="flex items-start space-x-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-secondary"></i>
                        <span>Jl. Pendaki No. 123, Bandung, Jawa Barat</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i data-lucide="phone" class="w-5 h-5 text-secondary"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i data-lucide="mail" class="w-5 h-5 text-secondary"></i>
                        <span>support@mountix.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 text-center text-sm text-neutral-light/60">
            <p>&copy; {{ date('Y') }} MOUNTIX. All rights reserved.</p>
        </div>
    </div>
</footer>
