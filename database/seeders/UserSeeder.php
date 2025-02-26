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
                'username' => 'mahasiswa',
                'email' => 'mhs1@gmail.com',
                'password' => bcrypt('12345678'), // Menggunakan bcrypt untuk meng-hash password
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'bpm',
                'email' => 'bpm@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'bpm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'bem',
                'email' => 'bem@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'bem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'ormawa',
                'email' => 'orm@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'mahasiswa2',
                'email' => 'mhs2@gmail.com',
                'password' => bcrypt('12345678'), // Menggunakan bcrypt untuk meng-hash password
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}