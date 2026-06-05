<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalur extends Model
{
  protected $fillable = ['gunung_id', 'nama_jalur', 'harga_per_orang', 'kuota_default', 'estimasi_jam'];

  public function gunung() {
    return $this->belongsTo(Gunung::class);
  }

  public function kuotaHarians() {
    return $this->hasMany(KuotaHarian::class);
  }

  public function bookings() {
    return $this->hasMany(Booking::class);
  }
}