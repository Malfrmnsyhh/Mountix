<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::create('kuota_harians', function (Blueprint $table) {
      $table->id();
      $table->foreignId('jalur_id')->constrained('jalurs')->cascadeOnDelete();
      $table->date('tanggal');
      $table->integer('kuota_total');
      $table->integer('kuota_terpakai')->default(0);
      $table->enum('status', ['buka', 'tutup'])->default('buka');
      $table->timestamps();
      $table->unique(['jalur_id', 'tanggal']);
    });
  }


  public function down(): void {
    Schema::dropIfExists('kuota_harians');
  }
};
