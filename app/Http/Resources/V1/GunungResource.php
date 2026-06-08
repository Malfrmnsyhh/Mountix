<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GunungResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'nama' => $this->nama,
      'lokasi' => $this->lokasi,
      'ketinggian' => $this->ketinggian . ' mdpl',
      'syarat_pendakian' => $this->syarat_pendakian,
      'deskripsi' => $this->deskripsi,
      'status_buka' => (bool) $this->status_buka,
      'foto_cover' => $this->foto_cover ? (filter_var($this->foto_cover, FILTER_VALIDATE_URL) ? $this->foto_cover : url('storage/' . $this->foto_cover)) : null,
      'jalurs_count' => $this->whenCounted('jalurs'),
      'jalur' => JalurResource::collection($this->whenLoaded('jalurs')),
    ];
  }
}