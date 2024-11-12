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
        // Cek apakah ada input pencarian - ini untuk mencari data di searchbar 
        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where('nama_produk', 'LIKE', "%{$search}%")
                ->orWhere('kategori_produk', 'LIKE', "%{$search}%")
                ->orWhere('harga_produk', 'LIKE', "%{$search}%")
                ->orWhere('stok_produk', 'LIKE', "%{$search}%");
        }
        $produk = $query->get(); // get data yang dicari di searchbar

        return view('pages-user.dashboard-user', compact('produk'));  //kirim data produk ke view nya
    }
}
