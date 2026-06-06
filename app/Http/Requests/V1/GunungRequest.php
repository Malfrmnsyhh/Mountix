<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class GunungRequest extends FormRequest
{
  public function authorize(): bool
  {
    // Autorisasi admin dihandle di middleware routes, kita return true di sini
    return true;
  }

  public function rules(): array
  {
    return [
      'nama' => 'required|string|max:255',
      'lokasi' => 'required|string|max:255',
      'ketinggian' => 'required|integer|min:1',
      'syarat_pendakian' => 'required|string',
      'deskripsi' => 'required|string',
      'status_buka' => 'boolean',
      'foto_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];
  }
}