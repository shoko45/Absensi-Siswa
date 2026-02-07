<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaRombel extends Model
{
    protected $table = 'anggota_rombel';
    
    public function pesertaDidik()
{
    return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id');
}

public function rombel()
{
    return $this->belongsTo(RombonganBelajar::class, 'rombongan_belajar_id');
}
}
