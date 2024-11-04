<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'kelas',
        'no_telepon',
        'email',
        'password',
        'foto_profile',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
