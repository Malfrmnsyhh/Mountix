<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gunung extends Model
{
  protected $fillable = ['nama', 'lokasi', 'ketinggian', 'syarat_pendakian', 'deskripsi', 'status_buka', 'foto_cover', 'is_popular'];

  public function jalurs() {
    return $this->hasMany(Jalur::class);
  }

  public function bookings() {
    return $this->hasManyThrough(Booking::class, Jalur::class);
  }
}
