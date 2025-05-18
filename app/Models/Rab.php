<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    use HasFactory;
    protected $table = 'rab';

    protected $fillable = [
        'organisasi_id',
        'nama_kegiatan',
        'rencana_anggaran',
    ];


    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    // public function pengajuan()
    // {
    //     return $this->hasOne(Pengajuan::class, 'rab_id');
    // }
}
