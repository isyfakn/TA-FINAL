<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    protected $table = 'organisasi';

    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'deskripsi',
        'email',
        'no_telp',
        'tgl_berdiri',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } //1 user 1 organisasi

    // public function kegiatan()
    // {
    //     return $this->hasMany(Kegiatan::class, 'organisasi_id');
    // } //memiliki banyak pengajuan

//     public function rab()
//     {
//         return $this->hasOne(Rab::class, 'organisasi_id');
//     }
}
