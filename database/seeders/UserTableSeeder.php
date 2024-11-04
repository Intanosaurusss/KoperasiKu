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
            'name' => 'Admin',
            'kelas' => '-',
            'no_telepon' => '0895365544316',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Gunakan bcrypt untuk password
            'foto_profile' => null, // Jika belum ada foto
            'role' => 'admin',
        ]);

        // Buat akun user biasa
        User::create([
            'name' => 'User',
            'kelas' => '12 pplg 3',
            'no_telepon' => '089876543210',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'foto_profile' => null,
            'role' => 'user',
        ]);
    }
}
