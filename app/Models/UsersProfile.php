<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
  protected $table = 'users_profiles';
  protected $fillable = ['user_id', 'nama_lengkap', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp', 'foto_profile', 'kontak_darurat_nama', 'kontak_darurat_no_hp', 'kontak_darurat_hubungan'];

    public function user() {
      return $this->belongsTo(User::class);
    }
}
