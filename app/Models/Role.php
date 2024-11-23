<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Tentukan nama tabel jika nama tabel tidak mengikuti konvensi plural
    protected $table = 'roles'; // Tidak perlu jika nama tabel sudah plural 'roles'

    // Tentukan kolom yang bisa diisi melalui mass assignment
    protected $fillable = ['name', 'guard_name']; // Sesuaikan dengan kolom yang ada di tabel

    // Tentukan kolom yang tidak perlu disertakan saat serialisasi
    protected $hidden = ['created_at', 'updated_at']; // Opsional
}
