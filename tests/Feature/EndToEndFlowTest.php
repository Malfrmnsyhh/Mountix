<?php

namespace Tests\Feature;

use App\Models\Gunung;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EndToEndFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_flow()
    {
        Storage::fake('public');

        // 1. Register
        $registerResponse = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '08123456789'
        ]);

        $registerResponse->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);

        // 2. Login
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $loginResponse->assertStatus(200);
        $token = $loginResponse->json('access_token');
        $this->assertNotEmpty($token);

        // 3. Setup Gunung Semeru (since we use RefreshDatabase, we need to seed or create)
        $gunung = Gunung::create([
            'nama' => 'Semeru',
            'lokasi' => 'Lumajang',
            'ketinggian' => 3676,
            'syarat_pendakian' => 'Surat Sehat',
            'deskripsi' => 'Gunung Semeru',
            'status_buka' => 1
        ]);
        $jalur = $gunung->jalurs()->create([
            'nama_jalur' => 'Jalur Utama',
            'harga_per_orang' => 25000,
            'kuota_default' => 100,
            'estimasi_jam' => 8
        ]);

        // 4. Booking 2 people
        $bookingResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/booking', [
                'jalur_id' => $jalur->id,
                'tanggal_naik' => now()->addDays(7)->format('Y-m-d'),
                'tanggal_turun' => now()->addDays(8)->format('Y-m-d'),
                'members' => [
                    [
                        'nama_lengkap' => 'Member 1',
                        'nik' => '1234567890123456',
                        'tanggal_lahir' => '1990-01-01',
                        'jenis_kelamin' => 'L',
                        'alamat' => 'Alamat 1'
                    ],
                    [
                        'nama_lengkap' => 'Member 2',
                        'nik' => '6543210987654321',
                        'tanggal_lahir' => '1995-05-05',
                        'jenis_kelamin' => 'P',
                        'alamat' => 'Alamat 2'
                    ]
                ]
            ]);

        $bookingResponse->assertStatus(201);
        $bookingId = $bookingResponse->json('data.id');

        // 5. Upload Proof of Payment
        $dummyImage = UploadedFile::fake()->image('proof.jpg');
        $paymentResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/booking/{$bookingId}/payment", [
                'metode_pembayaran' => 'Transfer Bank',
                'bukti_bayar' => $dummyImage
            ]);

        $paymentResponse->assertStatus(201);
        $paymentId = $paymentResponse->json('data.id');
        $this->assertNotEmpty($paymentResponse->json('data.bukti_bayar'));
        Storage::disk('public')->assertExists($paymentResponse->json('data.bukti_bayar'));

        // 6. Admin Verification
        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $adminLoginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@test.com',
            'password' => 'password'
        ]);
        $adminToken = $adminLoginResponse->json('access_token');

        $verifyResponse = $this->withHeader('Authorization', 'Bearer ' . $adminToken)
            ->postJson("/api/v1/admin/payment/{$paymentId}/verify", [
                'status' => 'approved'
            ]);

        $verifyResponse->assertStatus(200);
        $this->assertEquals('approved', $verifyResponse->json('data.status_verifikasi'));

        // 7. Generate E-Ticket QR
        $ticketResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/v1/booking/{$bookingId}/ticket");

        $ticketResponse->assertStatus(200);
        $this->assertNotEmpty($ticketResponse->json('data'));
        // Check if QR code path or data is present (assuming it's in the E-Ticket model)
        foreach ($ticketResponse->json('data') as $ticket) {
            $this->assertNotEmpty($ticket['qr_code']);
        }
    }
}
