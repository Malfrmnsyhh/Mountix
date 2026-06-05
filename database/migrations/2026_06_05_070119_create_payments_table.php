<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('booking_id')->unique()->constrained('bookings')->cascadeOnDelete();
      $table->date('tanggal_bayar');
      $table->integer('jumlah_bayar');
      $table->string('metode_pembayaran')->default('transfer');
      $table->string('bukti_bayar');
      $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('payments');
  }
};
