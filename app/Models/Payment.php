<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
  protected $fillable = ['booking_id', 'tanggal_bayar', 'jumlah_bayar', 'metode_pembayaran', 'bukti_bayar', 'status_verifikasi'];

  public function booking() {
    return $this->belongsTo(Booking::class);
  }
}
