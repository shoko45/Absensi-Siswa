<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // app/Models/User.php

    protected $fillable = ['name', 'username', 'password', 'role'];

public function pesertaDidik()
{
    return $this->hasOne(PesertaDidik::class, 'user_id');
}

// Untuk cek kelas yang dia pimpin (khusus Wali Kelas)
public function kelasDipimpin()
{
    return $this->hasOne(RombonganBelajar::class, 'teacher_id');
}

// Untuk cek absen-absen yang pernah dia lakukan
public function absensi()
{
    return $this->hasMany(Absensi::class, 'user_id');
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
