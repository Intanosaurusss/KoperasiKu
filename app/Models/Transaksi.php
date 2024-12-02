<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $table = 'transaksi'; // Pastikan nama tabel sesuai dengan yang ada di database

    protected $fillable = [
        'user_id',
        'metode_pembayaran',
        'status_pembayaran',
        'subtotal',
    ];

    /**
     * Relasi ke tabel Riwayat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'transaksi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
