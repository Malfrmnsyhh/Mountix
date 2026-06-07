<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gunung;
use App\Models\Jalur;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MountixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. CREATE ADMIN USER
        $admin = User::firstOrCreate(
            ['email' => 'admin@mountix.test'],
            [
                'name' => 'Admin Mountix',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. CREATE SAMPLE GUNUNG
        $gunungList = [
            [
                'nama' => 'Gunung Rinjani',
                'deskripsi' => 'Gunung tertinggi di Nusa Tenggara Barat dengan pemandangan spektakuler.',
                'ketinggian' => 3726,
                'lokasi' => 'Lombok, Nusa Tenggara Barat',
                'foto_cover' => 'https://images.unsplash.com/photo-1596395819057-e37f55a8528c?auto=format&fit=crop&w=800&q=80',
                'syarat_pendakian' => 'Surat Sehat, KTP',
                'status_buka' => 1,
            ],
            [
                'nama' => 'Gunung Semeru',
                'deskripsi' => 'Gunung tertinggi di Jawa, legendaris.',
                'ketinggian' => 3676,
                'lokasi' => 'Lumajang, Jawa Timur',
                'foto_cover' => 'https://images.unsplash.com/photo-1544198365-f5d60b6d8190?auto=format&fit=crop&w=800&q=80',
                'syarat_pendakian' => 'Surat Sehat, Vaksin',
                'status_buka' => 1,
            ],
        ];

        foreach ($gunungList as $data) {
            $gunung = Gunung::updateOrCreate(
                ['nama' => $data['nama']],
                $data
            );
            
            // Create Jalur
            $gunung->jalurs()->updateOrCreate(
                ['nama_jalur' => 'Jalur Utama ' . $gunung->nama],
                [
                    'deskripsi' => 'Jalur pendakian resmi.',
                    'harga_per_orang' => 25000,
                    'kuota_default' => 100,
                    'estimasi_jam' => 8
                ]
            );
        }
    }
}
