<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Jalur;
use App\Models\KuotaHarian;
use App\Models\Blacklist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class BookingService
{
  /**
   * Memproses reservasi tiket, cek kuota, dan cek blacklist.
   */
  public function createBooking($user, array $data)
  {
    return DB::transaction(function () use ($user, $data) {
      $jalur = Jalur::findOrFail($data['jalur_id']);
      $tanggalNaik = $data['tanggal_naik'];
      $jumlahOrang = count($data['members']);

      // 1. Cek User Blacklist (berdasarkan NIK masing-masing member)
      foreach ($data['members'] as $member) {
        $isBlacklisted = Blacklist::where('nik', $member['nik'])->exists();
        if ($isBlacklisted) {
          throw new Exception("Pendaki dengan NIK {$member['nik']} ({$member['nama_lengkap']}) sedang dalam masa blacklist.");
        }
      }

      // 2. Cek & Lock Kuota Harian untuk mencegah race condition (Concurrency)
      $kuotaHarian = KuotaHarian::firstOrCreate(
        ['jalur_id' => $jalur->id, 'tanggal' => $tanggalNaik],
        ['kuota_total' => $jalur->kuota_default, 'kuota_terpakai' => 0, 'status' => 'buka']
      );

      // Re-fetch dengan lockForUpdate untuk mencegah double booking di slot terakhir
      $kuotaLock = KuotaHarian::where('id', $kuotaHarian->id)->lockForUpdate()->first();

      if ($kuotaLock->status !== 'buka') {
        throw new Exception("Jalur pendakian ditutup pada tanggal tersebut.");
      }

      if (($kuotaLock->kuota_terpakai + $jumlahOrang) > $kuotaLock->kuota_total) {
        throw new Exception("Kuota tidak mencukupi. Sisa kuota: " . ($kuotaLock->kuota_total - $kuotaLock->kuota_terpakai));
      }

      // 3. Tambah kuota terpakai
      $kuotaLock->kuota_terpakai += $jumlahOrang;
      $kuotaLock->save();

      // 4. Hitung Harga Total
      $totalBayar = $jalur->harga_per_orang * $jumlahOrang;

      // 5. Buat Record Booking
      $booking = Booking::create([
        'kode_booking' => 'MTX-' . strtoupper(Str::random(8)),
        'user_id' => $user->id,
        'jalur_id' => $jalur->id,
        'tanggal_naik' => $tanggalNaik,
        'tanggal_turun' => $data['tanggal_turun'],
        'jumlah_orang' => $jumlahOrang,
        'total_bayar' => $totalBayar,
        'status' => 'pending_upload' // Status pending menunggu pembayaran
      ]);

      // 6. Simpan Detail Member
      foreach ($data['members'] as $index => $member) {
        $booking->members()->create([
          'nama_lengkap' => $member['nama_lengkap'],
          'nik' => $member['nik'],
          'tanggal_lahir' => $member['tanggal_lahir'],
          'jenis_kelamin' => $member['jenis_kelamin'],
          'alamat' => $member['alamat'],
          'ktp_path' => $member['ktp_path'] ?? '',
          'surat_sehat_path' => $member['surat_sehat_path'] ?? '',
          'is_leader' => $index === 0 ? true : false,
        ]);
      }

      return $booking;
    });
  }
}