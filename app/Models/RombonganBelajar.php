<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model
{
    protected $table = 'rombongan_belajar';
    protected $fillable = ['tahun_ajar_id', 'teacher_id', 'nama_rombel', 'tingkat'];
}
