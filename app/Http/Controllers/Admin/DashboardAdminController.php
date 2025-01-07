<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pengeluaran; 
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Riwayat;
use Carbon\Carbon;

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

        // Menghitung total pemasukan hanya untuk transaksi dengan status_pembayaran 'success'
        $totalpemasukan = Transaksi::where('status_pembayaran', 'success')->sum('subtotal');

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

        return view('pages-admin.dashboard-admin', compact('totalproduk', 'totalpengeluaran', 'totaluser', 'totalpemasukan', 'totalriwayat', 'produkterlaris', 'bulanini', 'memberterroyal')); // Sesuaikan dengan nama view yang Anda gunakan
    }

    public function getgrafikdata(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Default ke tahun saat ini jika tidak dipilih

        // Data pemasukan (status_pembayaran = 'success' dan subtotal dijumlahkan)
        $pemasukan = Transaksi::where('status_pembayaran', 'success')
            ->whereYear('created_at', $tahun)
            ->selectRaw('MONTH(created_at) as bulan, SUM(subtotal) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Data pengeluaran (total_pengeluaran dijumlahkan per bulan)
        $pengeluaran = Pengeluaran::whereYear('tanggal_pengeluaran', $tahun)
            ->selectRaw('MONTH(tanggal_pengeluaran) as bulan, SUM(total_pengeluaran) as total')
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
