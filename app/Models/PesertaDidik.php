<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaDidik extends Model
{
    protected $table = 'peserta_didik';
    protected $fillable = ['user_id', 'nis', 'jenis_kelamin', 'alamat'];
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function anggotaRombel()
{
    return $this->hasOne(AnggotaRombel::class, 'peserta_didik_id');
}
}
