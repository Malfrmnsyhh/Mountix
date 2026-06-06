<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('bookings', function (Blueprint $table) {
      $table->id();
      $table->string('kode_booking')->unique();
      $table->foreignId('user_id')->constrained('users'); // leader
      $table->foreignId('jalur_id')->constrained('jalurs');
      $table->date('tanggal_naik');
      $table->date('tanggal_turun');
      $table->integer('jumlah_orang');
      $table->integer('total_bayar');
      $table->enum('status', ['draft', 'pending_upload', 'waiting_verification', 'verified', 'ticket_issued', 'completed', 'cancelled', 'rejected'])->default('draft');
      $table->text('catatan_admin')->nullable();
      $table->timestamp('check_in_at')->nullable();
      $table->timestamp('check_out_at')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('bookings');
  }
};
