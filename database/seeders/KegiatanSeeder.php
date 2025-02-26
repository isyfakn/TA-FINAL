<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kegiatan')->insert([
            [
                'pengajuan_id' => 1, // Pastikan ID ini sesuai dengan ID pengajuan yang ada di tabel pengajuan
                'title' => 'Kegiatan A',
                'body' => 'Deskripsi kegiatan A.',
                'foto' => 'foto_kegiatan_a.png',
                'tgl_mulai' => '2023-10-01 10:00:00',
                'tgl_selesai' => '2023-10-01 12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengajuan_id' => 2, // Pastikan ID ini sesuai dengan ID pengajuan yang ada di tabel pengajuan
                'title' => 'Kegiatan B',
                'body' => 'Deskripsi kegiatan B.',
                'foto' => 'foto_kegiatan_b.png',
                'tgl_mulai' => '2023-10-05 14:00:00',
                'tgl_selesai' => '2023-10-05 16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengajuan_id' => 3, // Pastikan ID ini sesuai dengan ID pengajuan yang ada di tabel pengajuan
                'title' => 'Kegiatan C',
                'body' => 'Deskripsi kegiatan C.',
                'foto' => 'foto_kegiatan_c.png',
                'tgl_mulai' => '2023-10-10 09:00:00',
                'tgl_selesai' => '2023-10-10 11:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}