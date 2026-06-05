<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('jalurs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('gunung_id')->constrained('gunungs')->cascadeOnDelete();
      $table->string('nama_jalur');
      $table->text('deskripsi')->nullable();
      $table->integer('harga_per_orang');
      $table->integer('kuota_default');
      $table->integer('estimasi_jam')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('jalurs');
  }
};
