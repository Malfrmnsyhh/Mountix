<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gunung extends Model
{
  protected $fillable = ['nama', 'lokasi', 'ketinggian', 'syarat_pendakian', 'deskripsi', 'status_buka', 'foto_cover'];

  public function jalurs() {
    return $this->hasMany(Jalur::class);
  }
}
