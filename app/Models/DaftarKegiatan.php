<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKegiatan extends Model
{
    use HasFactory;
    protected $table = 'daftar_kegiatan';

    protected $fillable = [
        'kegiatan_id',
        'mahasiswa_id',
        'tgl_daftar',
        'body',
        'status',
    ];

    // Relasi dengan model Kegiatan
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    // Relasi dengan model Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
