<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuotaHarian extends Model
{
  protected $table = 'kuota_harians';
  protected $fillable = ['jalur_id', 'tanggal', 'kuota_total', 'kuota_terpakai', 'status'];

  public function jalur() {
    return $this->belongsTo(Jalur::class);
  }
}
