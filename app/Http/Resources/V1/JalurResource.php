<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JalurResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'nama_jalur' => $this->nama_jalur,
      'deskripsi' => $this->deskripsi,
      'harga_per_orang' => $this->harga_per_orang,
      'kuota_default' => $this->kuota_default,
      'estimasi_jam' => $this->estimasi_jam,
    ];
  }
}