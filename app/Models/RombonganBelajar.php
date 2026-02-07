<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model
{
    protected $table = 'rombongan_belajar';
    protected $fillable = ['nama_rombel', 'teacher_id', 'sekertaris_id', 'latitude_sekolah', 'longitude_sekolah', 'radius_meter'];

public function tahunAjar()
{
    return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
}

public function waliKelas()
{
    return $this->belongsTo(User::class, 'teacher_id');
}

public function sekertaris()
{
    return $this->belongsTo(User::class, 'sekertaris_id');
}

public function anggotaRombel()
{
    return $this->hasMany(AnggotaRombel::class, 'rombongan_belajar_id');
}
}
