<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ETicket extends Model {
  protected $fillable = ['booking_id', 'nama_lengkap', 'qr_code', 'pdf_path'];

  public function booking() {
    return $this->belongsTo(Booking::class);
  }
}
