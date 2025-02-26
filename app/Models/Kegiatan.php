<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';

    protected $fillable = [
        'pengajuan_id',
        'title',
        'body',
        'foto',
        'tgl_mulai',
        'tgl_selesai',
    ];

    // Relasi dengan model Organisasi
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }

    // Relasi dengan model DaftarKegiatan
    public function daftarKegiatan()
    {
        return $this->hasMany(DaftarKegiatan::class, 'kegiatan_id');
    }
    
}
