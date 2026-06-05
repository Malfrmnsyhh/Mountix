<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuotaHarian extends Model
{
  protected $table = 'kuota_harian';
  protected $fillable = ['jalur_id', 'tanggal', 'kuota_harian', 'kuota_terpakai', 'status'];

  public function jalur() {
    return $this->belongsTo(Jalur::class);
  }
}
