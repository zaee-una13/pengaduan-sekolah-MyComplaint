<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // role & last_login_at sengaja tidak di sini: diisi lewat forceFill di controller
    protected $fillable = [
        'name',
        'email',
        'password',
        'nis',
        'kelas',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_profil ? asset('storage/' . $this->foto_profil) : null;
    }
}