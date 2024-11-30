<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $table = 'riwayat'; // Pastikan nama tabel sesuai dengan yang ada di database

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
    ];

    
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
