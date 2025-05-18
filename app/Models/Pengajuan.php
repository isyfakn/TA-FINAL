<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan'; // Jika nama tabel tetap ''

    protected $fillable = [
        'rab_id',
        'tgl_kegiatan',
        'proposal_file',
        'status_proposal',
        'anggaran',
        'lpj_file',
        'status_lpj',
        'keterangan',
    ];

    // Relasi dengan model Kegiatan
    public function rab()
    {
        return $this->belongsTo(Rab::class, 'rab_id');
    }
}
