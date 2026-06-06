<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('users_profiles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->unique()->cascadeOnDelete();
      $table->string('nama_lengkap');
      $table->string('nik', 16)->unique();
      $table->date('tanggal_lahir');
      $table->enum('jenis_kelamin', ['L', 'P']);
      $table->text('alamat');
      $table->string('no_hp');
      $table->string('foto_profile')->nullable();
      $table->string('kontak_darurat_nama')->nullable();
      $table->string('kontak_darurat_no_hp')->nullable();
      $table->string('kontak_darurat_hubungan')->nullable();
      $table->timestamps();
    });
  }


  public function down(): void
  {
    Schema::dropIfExists('users_profiles');
  }
};
