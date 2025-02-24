<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan'; // Jika nama tabel tetap 'porposal'

    protected $fillable = [
        'organisasi_id',
        'nama_kegiatan',
        'tgl_kegiatan',
        'proposal_file',
        'status_proposal',
        'anggaran',
        'lpj_file',
        'status_lpj',
        'keterangan',
    ];

    // Relasi dengan model Kegiatan
    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }
}
