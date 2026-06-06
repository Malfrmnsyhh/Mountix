<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'kode_booking' => $this->kode_booking,
      'tanggal_naik' => $this->tanggal_naik,
      'tanggal_turun' => $this->tanggal_turun,
      'jumlah_orang' => $this->jumlah_orang,
      'total_bayar' => $this->total_bayar,
      'status' => $this->status,
      'catatan_admin' => $this->catatan_admin,
      'dibuat_pada' => $this->created_at->format('Y-m-d H:i:s'),
      // Tampilkan relasi jika sedang di-load oleh query builder
      'gunung' => new GunungResource($this->whenLoaded('jalur.gunung')),
      'jalur' => new JalurResource($this->whenLoaded('jalur')),
    ];
  }
}