<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('daftar_kegiatan')->insert([
            [
                'kegiatan_id' => 1, // Pastikan ID ini sesuai dengan ID kegiatan yang ada di tabel kegiatan
                'mahasiswa_id' => 1, // Pastikan ID ini sesuai dengan ID mahasiswa yang ada di tabel mahasiswa
                'tgl_daftar' => '2023-10-01',
                'body' => 'Saya ingin mendaftar untuk kegiatan A.',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kegiatan_id' => 2, // Pastikan ID ini sesuai dengan ID kegiatan yang ada di tabel kegiatan
                'mahasiswa_id' => 2, // Pastikan ID ini sesuai dengan ID mahasiswa yang ada di tabel mahasiswa
                'tgl_daftar' => '2023-10-02',
                'body' => 'Saya ingin mendaftar untuk kegiatan B.',
                'status' => 'Approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kegiatan_id' => 3, // Pastikan ID ini sesuai dengan ID kegiatan yang ada di tabel kegiatan
                'mahasiswa_id' => 2, // Pastikan ID ini sesuai dengan ID mahasiswa yang ada di tabel mahasiswa
                'tgl_daftar' => '2023-10-03',
                'body' => 'Saya ingin mendaftar untuk kegiatan C.',
                'status' => 'Rejected',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}