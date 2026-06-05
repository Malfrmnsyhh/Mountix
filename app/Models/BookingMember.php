<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingMember extends Model{
  protected $fillable = ['booking_id', 'nama_lengkap', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'ktp_path', 'surat_sehat_path'];

  public function booking() {
    return $this->belongsTo(Booking::class);
  }
}
