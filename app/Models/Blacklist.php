<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'alasan',
        'tanggal_blacklist',
    ];
}
