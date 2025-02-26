<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengajuan')->insert([
            [
                'organisasi_id' => 1, // Pastikan ID ini sesuai dengan ID organisasi yang ada di tabel organisasi
                'nama_kegiatan' => 'Pengajuan Kegiatan A',
                'tgl_kegiatan' => '2023-11-01',
                'proposal_file' => 'proposal_kegiatan_a.pdf',
                'status_proposal' => 'Pending',
                'anggaran' => '5000000',
                'lpj_file' => null,
                'status_lpj' => 'Pending',
                'keterangan' => 'Kegiatan A akan dilaksanakan pada bulan November.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organisasi_id' => 2, // Pastikan ID ini sesuai dengan ID organisasi yang ada di tabel organisasi
                'nama_kegiatan' => 'Pengajuan Kegiatan B',
                'tgl_kegiatan' => '2023-11-15',
                'proposal_file' => 'proposal_kegiatan_b.pdf',
                'status_proposal' => 'Approved',
                'anggaran' => '3000000',
                'lpj_file' => null,
                'status_lpj' => 'Pending',
                'keterangan' => 'Kegiatan B akan dilaksanakan pada pertengahan November.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'organisasi_id' => 3, // Pastikan ID ini sesuai dengan ID organisasi yang ada di tabel organisasi
                'nama_kegiatan' => 'Pengajuan Kegiatan C',
                'tgl_kegiatan' => '2023-12-01',
                'proposal_file' => 'proposal_kegiatan_c.pdf',
                'status_proposal' => 'Rejected',
                'anggaran' => '2000000',
                'lpj_file' => null,
                'status_lpj' => 'Pending',
                'keterangan' => 'Kegiatan C ditolak karena alasan tertentu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}