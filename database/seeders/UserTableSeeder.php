<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        // Buat akun admin
        User::create([
            'nama' => 'Admin',
            'kelas' => '-',
            'no_telepon' => '0895365544316',
            'email' => 'admin@gmail.com',
            'id_member' => 27077, // ID Member 10 angka untuk admin
            'foto_profile' => null, // Jika belum ada foto
            'role' => 'admin',
        ]);

        // Buat akun user petugas
        User::create([
            'nama' => 'Petugas',
            'kelas' => '12 pplg 3',
            'no_telepon' => '089898263210',
            'email' => 'petugas@gmail.com',
            'id_member' => 26077, // ID Member 10 angka untuk user
            'foto_profile' => null,
            'role' => 'petugas',
        ]);

        // Buat akun user 
        User::create([
            'nama' => 'User',
            'kelas' => '12 pplg 3',
            'no_telepon' => '089876543210',
            'email' => 'user@gmail.com',
            'id_member' => 25077, // ID Member 10 angka untuk user
            'foto_profile' => null,
            'role' => 'user',
        ]);
    }
}
