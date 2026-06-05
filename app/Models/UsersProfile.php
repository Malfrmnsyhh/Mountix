<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
  protected $fillable = ['user_id', 'nama_lengkap', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp', 'foto_profile'];

    public function user() {
      return $this->belongsTo(User::class);
    }
}
