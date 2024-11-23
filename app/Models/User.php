<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'kelas',
        'no_telepon',
        'email',
        'id_member', // Mengganti 'password' dengan 'id_member'
        'foto_profile',
        'role',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
}
