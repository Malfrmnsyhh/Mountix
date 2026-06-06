<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable;

  protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'role',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];


  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function profile()
  {
    return $this->hasOne(UsersProfile::class);
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class);
  }

  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
    return ['role' => $this->role];
  }
}
