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
   git clone https://github.com/Malfrmnsyhh/mountix.git
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

## 🔑 Akun Uji Coba (Seeder)

- **Admin:** `admin@mountix.test` / `password`
- **User:** (Silakan register di halaman `/register`)

## 📄 Dokumentasi API

- **Auth:** `POST /api/v1/auth/register`, `POST /api/v1/auth/login`
- **Gunung:** `GET /api/v1/gunung`, `GET /api/v1/gunung/{id}`
- **Booking:** `POST /api/v1/booking`, `GET /api/v1/booking/{id}`
- **Payment:** `POST /api/v1/booking/{id}/payment`, `POST /api/v1/admin/payment/{id}/verify`

