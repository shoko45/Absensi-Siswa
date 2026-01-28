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
    Schema::create('rombongan_belajar', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke Tahun Ajaran (Buku Periode)
        $table->foreignId('tahun_ajar_id')->constrained('tahun_ajar')->onDelete('cascade');
        
        // Relasi ke Guru (Wali Kelas) dari tabel Users
        $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
        
        // Detail Rombel
        $table->string('nama_rombel'); // Contoh: XII RPL 1
        $table->integer('tingkat');    // Contoh: 10, 11, atau 12
        
        $table->timestamps();
    });
}
};
