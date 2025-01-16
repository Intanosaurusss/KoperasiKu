<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi'; // Nama tabel
    protected $fillable = [
        'transaksi_id',
        'user_id',
        'message',
        'is_read',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model transaksi
     */

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
