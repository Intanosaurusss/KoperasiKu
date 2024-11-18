<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari penamaan default
    protected $table = 'produk';

    // Tentukan atribut yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_produk',
        'kategori_produk',
        'harga_produk',
        'stok_produk',
        'foto_produk'
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
}
