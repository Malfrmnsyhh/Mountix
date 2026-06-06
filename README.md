# 🏔️ Mountix - Sistem Booking Pendakian Gunung

Mountix adalah platform digital berbasis web yang dirancang untuk mempermudah proses reservasi pendakian gunung di Indonesia. Sistem ini mengintegrasikan manajemen kuota harian, validasi pendaki, sistem pembayaran, hingga penerbitan E-Ticket otomatis dengan QR Code.

## 🚀 Fitur Utama

- **Otentikasi Keamanan:** Menggunakan JWT (JSON Web Token) untuk keamanan API dan session user.
- **Eksplorasi Gunung:** Daftar gunung di Pulau Jawa dengan informasi ketinggian, syarat pendakian, dan jalur yang tersedia.
- **Sistem Booking Cerdas:** Form booking dinamis dengan validasi NIK (16 digit), integrasi kuota harian, dan perhitungan harga otomatis.
- **Manajemen Pembayaran:** Fitur upload bukti bayar untuk diverifikasi oleh admin.
- **E-Ticket & QR Code:** Penerbitan tiket digital yang unik untuk setiap pendaki setelah pembayaran disetujui.
- **Role-Based Access Control (RBAC):** Perbedaan hak akses antara User (Pendaki) dan Admin.
- **Responsive Design:** Tampilan modern dan mobile-friendly menggunakan Tailwind CSS 4.0.

## 🛠️ Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Blade Templating + JavaScript (Vanilla/Axios)
- **Styling:** Tailwind CSS 4.0
- **Database:** SQLite (Local/Dev) / MySQL (Production)
- **Security:** JWT (Tymon/jwt-auth)
- **Icons:** Lucide Icons & Tabler Icons

## 📦 Instalasi Lokal

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/username/mountix.git
   cd mountix
   ```

2. **Instal Dependensi:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret
   ```

4. **Setup Database:**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Link Storage:**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Aplikasi:**
   ```bash
   npm run build
   php artisan serve
   ```

## 🌐 Panduan Deployment (Railway)

Untuk deploy ke Railway, ikuti urutan berikut:

1. **Push Code:** Push repositori Anda ke GitHub.
2. **New Project:** Di Railway dashboard, pilih "Deploy from GitHub repo".
3. **Variables:** **PENTING!** Sebelum build selesai, masuk ke tab "Variables" dan tambahkan:
   - `APP_KEY` (Generate lokal lalu copy)
   - `JWT_SECRET` (Generate lokal lalu copy)
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `FILESYSTEM_DISK=public`
   - `NIXPACKS_PHP_ROOT_DIR=public`
4. **Database:** Jika menggunakan MySQL di Railway, tambahkan variabel `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai data dari plugin MySQL Railway.
5. **Post-Build Command:** Pastikan menjalankan `php artisan migrate --force` dan `php artisan storage:link` di server.

## 🔑 Akun Uji Coba (Seeder)

- **Admin:** `admin@mountix.test` / `password`
- **User:** (Silakan register di halaman `/register`)

## 📄 Dokumentasi API

- **Auth:** `POST /api/v1/auth/register`, `POST /api/v1/auth/login`
- **Gunung:** `GET /api/v1/gunung`, `GET /api/v1/gunung/{id}`
- **Booking:** `POST /api/v1/booking`, `GET /api/v1/booking/{id}`
- **Payment:** `POST /api/v1/booking/{id}/payment`, `POST /api/v1/admin/payment/{id}/verify`

