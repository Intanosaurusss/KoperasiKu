<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pengeluaran; 
use App\Models\User;// Pastikan sudah mengimport model Product

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

        return view('pages-admin.dashboard-admin', compact('totalproduk', 'totalpengeluaran', 'totaluser')); // Sesuaikan dengan nama view yang Anda gunakan
    }
}
