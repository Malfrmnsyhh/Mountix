<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder {
    public function run(): void {
      \App\Models\User::create([
        'name' => 'Admin Mountix',
        'email' => 'admin@mountix.test',
        'password' => 'password',
        'phone' => '085706765799',
        'role' => 'admin',
      ]);
    }
}
