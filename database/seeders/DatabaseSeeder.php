<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Update atau buat akun Siswa
        User::updateOrCreate(
            ['email' => 'siswa@smk.belajar.id'],
            [
                'name' => 'Siswa Dummy',
                'password' => Hash::make('siswasmkn5'),
                'role' => 'siswa', // Sesuaikan dengan kolom role di aplikasi kamu (jika ada)
            ]
        );

        // Jika ada akun admin, pastikan tetap ada
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $this->call([
            CategorySeeder::class,
        ]);
    }
}