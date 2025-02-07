<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Pastikan mengimpor model Role

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan role 'admin'
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Menambahkan role 'petugas'
        Role::create(['name' => 'petugas', 'guard_name' => 'web']);

        // Menambahkan role 'user'
        Role::create(['name' => 'user', 'guard_name' => 'web']);
    }
}
