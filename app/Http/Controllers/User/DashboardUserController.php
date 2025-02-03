<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Riwayat;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Filter berdasarkan kategori jika dipilih
        if ($request->filled('kategori_produk')) {
            $kategori = $request->input('kategori_produk');
            
            if ($kategori === 'produk terlaris') {
                // Query untuk mendapatkan produk terlaris
                $bulanQuery = now()->month; // Ambil bulan saat ini
                $produkterlaris = Riwayat::selectRaw('produk_id, SUM(qty) as total_qty')
                    ->whereMonth('created_at', $bulanQuery) // Filter berdasarkan bulan
                    ->groupBy('produk_id')
                    ->orderByDesc('total_qty')
                    ->with('produk') // Relasi produk
                    ->take(5) // Ambil 5 produk terlaris
                    ->get();

                // Ambil ID produk terlaris
                $produkIds = $produkterlaris->pluck('produk_id');
                
                // Filter produk berdasarkan ID produk terlaris
                $query->whereIn('id', $produkIds);
            } else {
                // Filter berdasarkan kategori selain produk terlaris
                $query->where('kategori_produk', $kategori);
            }
        }

        // Filter berdasarkan pencarian teks
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'LIKE', "%{$search}%")
                    ->orWhere('harga_produk', 'LIKE', "%{$search}%")
                    ->orWhere('stok_produk', 'LIKE', "%{$search}%");
            });
        }

        // filter produk agar produk dengan stok kosong/0 akan berada di bawah
        $query->orderByRaw('stok_produk > 0 DESC');
        
        // Ambil data produk berdasarkan filter
        $produk = $query->get();

        // Kirim data ke view
        return view('pages-user.dashboard-user', compact('produk'));
    }
}
