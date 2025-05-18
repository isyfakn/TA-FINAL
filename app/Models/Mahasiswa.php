<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'nama_mahasiswa',
        'email',
        'tgl_lahir',
        'prodi',
        'thn_masuk',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } // 1 user 1 mahasiswa

    // public function daftarKegiatan()
    // {
    //     return $this->hasMany(DaftarKegiatan::class, 'mahasiswa_id');
    // }
}
