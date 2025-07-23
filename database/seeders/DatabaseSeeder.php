<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Guru
        $guru = User::create([
            'name' => 'Guru Matematika',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru'
        ]);

        // Siswa
        $siswa1 = User::create([
            'name' => 'Siswa Satu',
            'email' => 'siswa1@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);

        $siswa2 = User::create([
            'name' => 'Siswa Dua',
            'email' => 'siswa2@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);

        // Kelas
        $kelas = Kelas::create([
            'nama' => 'Kelas 7A'
        ]);
      

        // Hubungkan guru dan siswa ke kelas
        $kelas->users()->attach([$guru->id, $siswa1->id, $siswa2->id]);
          $wali = User::create([
            'name' => 'Orang Tua Siswa Satu',
            'email' => 'wali1@example.com',
            'password' => Hash::make('password'),
            'role' => 'wali'
        ]);

        $siswa1->wali_id = $wali->id;
        $siswa1->save();
    }
}
