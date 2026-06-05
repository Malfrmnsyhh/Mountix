<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nik',16)->unique();
            $table->date('tanngal_lahir');
            $table->enum('jenis_kelamis', ['L', 'P']);
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('foto_profile')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void {
        Schema::dropIfExists('users_profiles');
    }
};
