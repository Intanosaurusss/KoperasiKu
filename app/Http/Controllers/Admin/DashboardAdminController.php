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
        $totalpengeluaran = Pengeluaran::sum('total_pengeluaran');

        // Mengambil jumlah produk
        $totaluser = User::count();

        // Mengambil total pemasukan dari subtotal di tabel transaksi
        $totalpemasukan = Transaksi::sum('subtotal'); // Menjumlahkan semua nilai di kolom 'subtotal'

        // Mengambil total riwayat 
        $totalriwayat = Riwayat::count();

        return view('pages-admin.dashboard-admin', compact('totalproduk', 'totalpengeluaran', 'totaluser', 'totalpemasukan', 'totalriwayat')); // Sesuaikan dengan nama view yang Anda gunakan
    }

    public function getgrafikdata()
    {
        // Data pemasukan (status_pembayaran = 'success' dan subtotal dijumlahkan)
        $pemasukan = Transaksi::where('status_pembayaran', 'success')
            ->selectRaw('MONTH(created_at) as bulan, SUM(subtotal) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Data pengeluaran (total_pengeluaran dijumlahkan per bulan)
        $pengeluaran = Pengeluaran::selectRaw('MONTH(tanggal_pengeluaran) as bulan, SUM(total_pengeluaran) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Format data untuk frontend
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $data = [
            'labels' => [],
            'pemasukan' => [],
            'pengeluaran' => []
        ];

        // Gabungkan pemasukan dan pengeluaran berdasarkan bulan
        foreach ($bulanList as $bulan => $namaBulan) {
            $data['labels'][] = $namaBulan;
            $data['pemasukan'][] = $pemasukan[$bulan] ?? 0; // Default ke 0 jika tidak ada data
            $data['pengeluaran'][] = $pengeluaran[$bulan] ?? 0; // Default ke 0 jika tidak ada data
        }

        return response()->json($data);
    }
}
