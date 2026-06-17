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
      'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
      // Relasi jalur dengan gunung di dalamnya
      'jalur' => $this->whenLoaded('jalur', function () {
        $jalur = $this->jalur;
        return [
          'id' => $jalur->id,
          'nama_jalur' => $jalur->nama_jalur,
          'deskripsi' => $jalur->deskripsi,
          'harga_per_orang' => $jalur->harga_per_orang,
          'kuota_default' => $jalur->kuota_default,
          'estimasi_jam' => $jalur->estimasi_jam,
          // Sertakan gunung di dalam jalur agar konsisten dengan b.jalur.gunung di JS
          'gunung' => $jalur->relationLoaded('gunung') ? [
            'id' => $jalur->gunung->id,
            'nama' => $jalur->gunung->nama,
            'lokasi' => $jalur->gunung->lokasi,
            'foto_cover' => $jalur->gunung->foto_cover
              ? (filter_var($jalur->gunung->foto_cover, FILTER_VALIDATE_URL)
                  ? $jalur->gunung->foto_cover
                  : url('storage/' . $jalur->gunung->foto_cover))
              : null,
          ] : null,
        ];
      }),
      'members' => $this->whenLoaded('members'),
      'e_tickets' => $this->whenLoaded('eTickets'),
    ];
  }
}