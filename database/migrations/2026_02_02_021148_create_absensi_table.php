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
        Schema::create('absensi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users'); // Siapa yang absen
    $table->foreignId('rombongan_belajar_id')->constrained('rombongan_belajar');
    $table->date('tanggal');
    $table->time('jam_absen');
    $table->decimal('lat_siswa', 10, 8)->nullable(); // Catat posisi saat scan
    $table->decimal('long_siswa', 11, 8)->nullable();
    $table->enum('status', ['H', 'S', 'I', 'A']); // Hadir, Sakit, Izin, Alpha
    $table->string('keterangan')->nullable(); // Untuk alasan manual oleh walas
    $table->enum('metode', ['qr', 'manual']); // Membedakan absen mandiri vs dibantu walas
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
