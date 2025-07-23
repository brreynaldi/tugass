<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('users')->insert([
    ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => bcrypt('password'), 'role' => 'admin'],
    ['name' => 'Guru 1', 'email' => 'guru@mail.com', 'password' => bcrypt('password'), 'role' => 'guru'],
    ['name' => 'Siswa 1', 'email' => 'siswa@mail.com', 'password' => bcrypt('password'), 'role' => 'siswa'],
]);

    }
}
