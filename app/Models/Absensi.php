<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
   protected $fillable = ['user_id', 'rombongan_belajar_id', 'tanggal', 'jam_absen', 'lat_siswa', 'long_siswa', 'status', 'keterangan', 'metode'];

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function rombel()
{
    return $this->belongsTo(RombonganBelajar::class, 'rombongan_belajar_id');
}
}
