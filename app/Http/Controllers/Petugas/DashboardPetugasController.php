<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Riwayat;
use Carbon\Carbon;

class DashboardPetugasController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil jumlah produk
        $totaluser = User::where('role', 'user')->count();

        // Mengambil jumlah produk
        $totalproduk = Produk::count();

        // Menghitung total pemasukan berdasarkan bulan saat ini 
        $totalpemasukan = Transaksi::where('status_pembayaran', 'success')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('subtotal');

        // Menghitung total riwayat unik berdasarkan id_transaksi dari relasi
        $totalriwayat = Riwayat::join('transaksi', 'riwayat.transaksi_id', '=', 'transaksi.id')
        ->distinct('transaksi.id') // Menggunakan kolom unik dari tabel transaksi
        ->count('transaksi.id');

        // Set lokal ke Indonesia
        Carbon::setLocale('id');

        // Bulan untuk query (angka, seperti 01-12)
        $bulanQuery = Carbon::now()->format('m');

        // Nama bulan dalam bahasa Indonesia
        $bulanini = Carbon::now()->translatedFormat('F'); // Contoh: "Desember"

        // Query untuk mendapatkan produk terlaris
        $produkterlaris = Riwayat::selectRaw('produk_id, SUM(qty) as total_qty')
            ->whereMonth('created_at', $bulanQuery) // Gunakan angka bulan untuk query
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->with('produk') // sertakan relasi produk
            ->take(5)
            ->get();

        // Mengambil 5 user dengan total belanja terbesar berdasarkan bulan, beserta id_member dari tabel users
        $memberterroyal = Transaksi::selectRaw('transaksi.user_id, users.id_member, SUM(transaksi.subtotal) as total_belanja')
            ->join('users', 'transaksi.user_id', '=', 'users.id') // Join dengan tabel users
            ->where('transaksi.status_pembayaran', 'success') // Filter berdasarkan status_pembayaran "success"
            ->whereMonth('transaksi.created_at', $bulanQuery) // Filter berdasarkan bulan yang diinginkan
            ->groupBy('transaksi.user_id', 'users.id_member') // Group by user_id dan id_member
            ->orderByDesc('total_belanja')
            ->take(5)
            ->get();

        // Kirim data ke view
        return view('pages-petugas.dashboard-petugas', compact('totaluser', 'totalproduk', 'produkterlaris', 'bulanini', 'memberterroyal', 'totalpemasukan', 'totalriwayat'));
    }
}
