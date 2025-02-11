<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';

    protected $fillable = [
        'organisasi_id',
        'title',
        'body',
        'foto',
        'tgl_mulai',
        'tgl_selesai',
    ];

    // Relasi dengan model Organisasi
    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    // Relasi dengan model DaftarKegiatan
    public function daftarKegiatan()
    {
        return $this->hasMany(DaftarKegiatan::class, 'kegiatan_id');
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'kegiatan_id');
    }
}
