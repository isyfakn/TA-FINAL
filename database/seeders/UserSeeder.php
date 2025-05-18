<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'BEM',
                'email' => 'bem@gmail.com',
                'password' => bcrypt('12345678'), // Menggunakan bcrypt untuk meng-hash password
                'role' => 'bembpm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'BPM',
                'email' => 'bpm@gmail.com',
                'password' => bcrypt('12345678'), // Menggunakan bcrypt untuk meng-hash password
                'role' => 'bembpm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Kemahasiswaan',
                'email' => 'kemahasiswaan@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'kemahasiswaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Komputer',
                'email' => 'komputer@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Farmasi',
                'email' => 'farmasi@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Elektronika',
                'email' => 'elektro@gmail.com',
                'password' => bcrypt('12345678'), // Menggunakan bcrypt untuk meng-hash password
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Perhotelan',
                'email' => 'perhotelan@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Akuntansi',
                'email' => 'akuntansi@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP ASP',
                'email' => 'asp@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Informatika',
                'email' => 'informatika@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Kebidanan',
                'email' => 'kebidanan@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP DKV',
                'email' => 'dkv@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'HMP Mesin',
                'email' => 'mesin@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Komunitas Keperawatan',
                'email' => 'keperawatan@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}