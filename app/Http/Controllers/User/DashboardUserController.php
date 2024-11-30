<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class DashboardUserController extends Controller
{
    // function untuk menampilkan halaman dashboard user
    public function index(Request $request)
    {
    $query = Produk::query();

    // Filter berdasarkan kategori jika dipilih
    if ($request->filled('kategori_produk')) {
        $kategori = $request->input('kategori_produk');
        $query->where('kategori_produk', $kategori);
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

    // Ambil data produk berdasarkan filter
    $produk = $query->get();

    // Kirim data ke view
    return view('pages-user.dashboard-user', compact('produk'));
    }
}
