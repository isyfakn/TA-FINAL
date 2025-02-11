<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $table = 'porposal'; // Jika nama tabel tetap 'porposal'

    protected $fillable = [
        'kegiatan_id',
        'title',
        'tgl_pengajuan',
        'file',
        'status',
        'keterangan',
    ];

    // Relasi dengan model Kegiatan
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
