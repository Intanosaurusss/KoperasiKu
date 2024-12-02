<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pengeluaran; 
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Riwayat;

class DashboardAdminController extends Controller
{
    // function untuk menampilkan halaman dashboard admin
    public function index()
    {
        // Mengambil jumlah produk
        $totalproduk = Produk::count();

        // Mengambil jumlah produk
        $totalpengeluaran = Pengeluaran::count();

        // Mengambil jumlah produk
        $totaluser = User::count();

        // Mengambil total pemasukan dari subtotal di tabel transaksi
        $totalpemasukan = Transaksi::sum('subtotal'); // Menjumlahkan semua nilai di kolom 'subtotal'

        // Mengambil total riwayat 
        $totalriwayat = Riwayat::count();

        return view('pages-admin.dashboard-admin', compact('totalproduk', 'totalpengeluaran', 'totaluser', 'totalpemasukan', 'totalriwayat')); // Sesuaikan dengan nama view yang Anda gunakan
    }
}
