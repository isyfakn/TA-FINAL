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

    public function organisasi()
    {
        return $this->hasMany(Organisasi::class, 'organisasi_id', 'id');
    }

    // Di dalam class Kegiatan
    public function rab()
    {
        return $this->belongsTo(Rab::class);
        // Atau jika nama kolom foreign key berbeda:
        // return $this->belongsTo(Rab::class, 'rab_id');
    }

    // Relasi dengan model DaftarKegiatan
    // public function daftarKegiatan()
    // {
    //     return $this->hasMany(DaftarKegiatan::class, 'kegiatan_id');
    // }
    
}
