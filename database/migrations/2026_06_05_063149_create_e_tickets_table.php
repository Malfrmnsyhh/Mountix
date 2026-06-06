<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('e_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('qr_code')->unique();
            $table->string('pdf_path');
            $table->timestamps();
        });
    }


    public function down(): void {
        Schema::dropIfExists('e_tickets');
    }
};
