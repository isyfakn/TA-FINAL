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

    const ROLE_KEMAHASISWAAN = 'kemahasiswaan';
    const ROLE_BEMBPM = 'bembpm';
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

    public function organisasi()
    {
        return $this->hasOne(Organisasi::class, 'user_id'); // Assuming 'user_id' is the foreign key in the 'organisasi' table
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id'); // Assuming 'user_id' is the foreign key in the 'organisasi' table
    }

    public function getProfileImage()
    {
        if ($this->role === 'mahasiswa' && $this->mahasiswa && $this->mahasiswa->foto) {
            return asset('storage/' . $this->mahasiswa->foto);
        } elseif ($this->role === 'organisasi' && $this->organisasi && $this->organisasi->logo) {
            return asset('storage/' . $this->organisasi->logo);
        } else {
            // Default image if no profile picture/logo is set
            return asset('storage/default.jpg');
        }
    }
}
