<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->enum('type', ['bank', 'qris']);
            $blueprint->string('name'); // e.g. BCA, OVO, QRIS UTAMA
            $blueprint->string('account_number')->nullable();
            $blueprint->string('account_name')->nullable();
            $blueprint->string('qr_image')->nullable();
            $blueprint->boolean('is_active')->default(true);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
