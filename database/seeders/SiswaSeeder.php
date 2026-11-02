<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // [nama, NIS, kelas, bagian email sebelum @smk.belajar.id]
        $siswas = [
            ['Evan Arganta',    '2425001', 'XII RPL A', 'evan.arganta'],
            ['Ramadhan Putra',     '2425002', 'XII RPL A', 'ramadhan.putra'],
            ['Dimas Pratama',   '2425003', 'XII RPL B', 'dimas.pratama'],
            ['Zidan Kewer',     '2425004', 'XII RPL B', 'zidan.kewer'],
            ['Rizky Ramadhan',  '2425005', 'XI RPL A',  'rizky.ramadhan'],
            ['Nabila Putri',    '2425006', 'XI RPL A',  'nabila.putri'],
        ];

        foreach ($siswas as [$nama, $nis, $kelas, $username]) {
            $email = $username . '@smk.belajar.id';

            if (User::where('email', $email)->orWhere('nis', $nis)->exists()) {
                continue;
            }

            (new User)->forceFill([
                'name'              => $nama,
                'nis'               => $nis,
                'kelas'             => $kelas,
                'email'             => $email,
                'password'          => Hash::make('siswa123'),
                'role'              => 'siswa',
                'email_verified_at' => now(),
            ])->save();
        }
    }
}