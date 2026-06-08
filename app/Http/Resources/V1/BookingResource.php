<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    $data = [
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
      'jalur' => new JalurResource($this->whenLoaded('jalur')),
      'members' => $this->whenLoaded('members'),
    ];

    if ($this->relationLoaded('jalur') && $this->jalur->relationLoaded('gunung')) {
      $data['gunung'] = new GunungResource($this->jalur->gunung);
    }

    return $data;
  }
}