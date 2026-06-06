<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  protected $fillable = ['kode_booking', 'user_id', 'jalur_id', 'tanggal_naik', 'tanggal_turun', 'jumlah_orang', 'total_bayar', 'status', 'catatan_admin', 'check_in_at', 'check_out_at'];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function jalur() {
    return $this->belongsTo(Jalur::class);
  }

  public function members() {
    return $this->hasMany(BookingMember::class);
  }

  public function payment() {
    return $this->hasOne(Payment::class);
  }

  public function eTickets() {
    return $this->hasMany(ETicket::class, 'booking_id'); 
  }
}
