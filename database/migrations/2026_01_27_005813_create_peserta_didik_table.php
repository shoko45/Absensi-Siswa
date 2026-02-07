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
    Schema::create('peserta_didik', function (Blueprint $table) {
        $table->id(); // ID unik buku ini
        
        // Relasi ke tabel users (akun login)
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        
        // Identitas Siswa
        $table->string('nis', 20)->unique(); // Nomor Induk Siswa
        $table->enum('jenis_kelamin', ['L', 'P']); // L = Laki-laki, P = Perempuan
        $table->text('alamat')->nullable();
        
        $table->timestamps(); // Mencatat kapan data dibuat
    });
}
};
