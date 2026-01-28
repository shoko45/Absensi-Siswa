<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('tahun_ajar', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik'); // Contoh: 2025/2026
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->boolean('is_aktif')->default(false); // Untuk menentukan tahun ajaran yang sedang berjalan
            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajar');
    }
};
