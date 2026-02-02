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
    $table->string('nama_rombel');
    $table->foreignId('teacher_id')->constrained('users'); // Wali Kelas
    $table->foreignId('sekertaris_id')->nullable()->constrained('users'); // Sekretaris terpilih
    // Titik pusat sekolah (Radius 50m)
    $table->decimal('latitude_sekolah', 10, 8); 
    $table->decimal('longitude_sekolah', 11, 8);
    $table->integer('radius_meter')->default(50); 
    $table->timestamps();
});
}
};
