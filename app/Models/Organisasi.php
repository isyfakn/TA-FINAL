<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    protected $table = 'organisasi';

    protected $fillable = [
        'users_id',
        'nama_organisasi',
        'deskripsi',
        'email',
        'no_telp',
        'tgl_berdiri',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    } //1 user 1 organisasi

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'organisasi_id');
    } //memiliki banyak pengajuan
}
