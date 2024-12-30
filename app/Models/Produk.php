<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory;
    use SoftDeletes; // pakai softdeletes agar bisa menghapus produk namun tidak mempengaruhi relasi ke tabel riwayat, sebenernya data produknya masi ada di database (tapi kalo dihapus data nya maka ada data dihapusnya di kolom deleted_at)

    // Tentukan nama tabel jika berbeda dari penamaan default
    protected $table = 'produk';

    // Tentukan atribut yang bisa diisi 
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

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'produk_id');
    }

}
