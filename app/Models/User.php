<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_BPM = 'bpm';
    const ROLE_BEM = 'bem';
    const ROLE_ORGANISASI = 'organisasi';
    const ROLE_MAHASISWA = 'mahasiswa';

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'users';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    // Tentukan kolom yang harus di-hash saat disimpan
    protected $hidden = [
        'password',
    ];

    // Tentukan kolom yang tidak boleh diubah secara massal
    protected $guarded = [];

    // Jika ada relasi yang ingin didefinisikan, tambahkan di sini
    // Contoh:
    // public function posts()
    // {
    //     return $this->hasMany(Post::class);
    // }
}
