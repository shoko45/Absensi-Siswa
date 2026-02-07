<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    // Tambahkan baris ini supaya Laravel tidak nyari "tahun_ajars"
    protected $table = 'tahun_ajar'; // Penting biar gak error 's' lagi

public function rombel()
{
    return $this->hasMany(RombonganBelajar::class, 'tahun_ajar_id');
}
    protected $fillable = [
        'tahun_akademik',
        'semester',
        'is_aktif',
    ];
}