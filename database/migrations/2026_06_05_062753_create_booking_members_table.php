<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('booking_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('ktp_path');
            $table->string('surat_sehat_path');
            $table->boolean('is_leader')->default(false);
            $table->timestamps();
        });
    }


    public function down(): void {
        Schema::dropIfExists('booking_members');
    }
};
