<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan namespace model ini benar

class ProdukPetugasController extends Controller
{
    // Menampilkan daftar produk
    public function indexprodukpetugas(Request $request)
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
        $produk = $query->paginate(5); // Batas per halaman 5
        
        return view('pages-petugas.produk-petugas', compact('produk'));
    }
}
