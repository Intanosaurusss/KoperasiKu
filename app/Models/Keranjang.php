<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang'; //tentukan nama tabel nya disini

    protected $fillable = [
        'user_id',
        'produk_id',
        'qty',
    ];

    /**
     * Relasi ke tabel User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
