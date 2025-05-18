<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mahasiswa')->insert([
            [
                'user_id' => 7, // Pastikan ID ini sesuai dengan ID pengguna yang ada di tabel users
                'nama_mahasiswa' => 'Mahasiswa A',
                'email' => 'mahasiswaA@example.com',
                'no_hp' => '081234567890',
                'tgl_lahir' => '2000-01-01',
                'prodi' => 'Teknik Informatika',
                'thn_masuk' => 2018,
                'foto' => 'foto_mahasiswa_a.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8, // Pastikan ID ini sesuai dengan ID pengguna yang ada di tabel users
                'nama_mahasiswa' => 'Mahasiswa B',
                'email' => 'mahasiswaB@example.com',
                'no_hp' => '081234567891',
                'tgl_lahir' => '2001-02-02',
                'prodi' => 'Sistem Informasi',
                'thn_masuk' => 2019,
                'foto' => 'foto_mahasiswa_b.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}