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

    // Relasi ke keranjang (seorang user bisa memiliki banyak produk di keranjang)
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

     // Relasi ke transaksi (seorang user bisa memiliki banyak transaksi)
     public function transaksi()
     {
         return $this->hasMany(Transaksi::class, 'user_id', 'id');
     }

     /**
     * Menghapus transaksi dan riwayat yang terkait dengan user. alur logikanya : 1. Semua riwayat yang terkait dengan transaksi user tersebut akan dihapus terlebih dahulu. 2. Setelah itu, transaksi yang terkait dengan user tersebut juga akan dihapus.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Hapus riwayat yang terkait dengan transaksi
            $user->transaksi->each(function ($transaksi) {
                $transaksi->riwayat()->delete();
            });
            
            // Hapus transaksi terkait dengan user
            $user->transaksi()->delete();
        });
    }
}
