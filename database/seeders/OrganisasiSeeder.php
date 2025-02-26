<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organisasi')->insert([
            [
                'users_id' => 2, // Pastikan ID ini sesuai dengan ID pengguna yang ada di tabel users
                'nama_organisasi' => 'BPM',
                'deskipsi' => 'Deskripsi untuk BPM',
                'email' => 'bpm@gmail.com',
                'no_telp' => '081234567890',
                'thn_berdiri' => 2020,
                'logo' => 'logo_organisasi_a.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'users_id' => 3, // Pastikan ID ini sesuai dengan ID pengguna yang ada di tabel users
                'nama_organisasi' => 'BEM',
                'deskipsi' => 'Deskripsi untuk BEM',
                'email' => 'bem@gmail.com',
                'no_telp' => '081234567891',
                'thn_berdiri' => 2021,
                'logo' => 'logo_organisasi_b.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'users_id' => 4, // Pastikan ID ini sesuai dengan ID pengguna yang ada di tabel users
                'nama_organisasi' => 'Ormawa',
                'deskipsi' => 'Deskripsi untuk Ormawa',
                'email' => 'ormawa@gmail.com',
                'no_telp' => '081234567892',
                'thn_berdiri' => 2022,
                'logo' => 'logo_organisasi_c.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}