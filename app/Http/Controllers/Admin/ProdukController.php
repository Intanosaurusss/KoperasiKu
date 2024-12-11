<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan namespace model ini benar

class ProdukController extends Controller
{
    // Menampilkan daftar produk
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
        $produk = $query->paginate(5); // Batas per halaman 5
        
        return view('pages-admin.produk-admin', compact('produk'));
    }

    // Menampilkan form untuk menambahkan produk baru
    public function create()
    {
        return view('pages-admin.form-admin.tambah-produk-admin');
    }

    // Menyimpan produk baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:produk,nama_produk',
            'kategori_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'stok_produk' => 'required|integer',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Custom message untuk validasi
            'nama_produk.unique' => 'Produk dengan nama ini sudah ada.',
        ]);

        // Menyimpan data produk ke database
        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_produk = $request->kategori_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->stok_produk = $request->stok_produk;

        // Menangani upload foto produk
        if ($request->hasFile('foto_produk')) {
            // Menyimpan foto produk baru ke folder publik
            $fileName = time() . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path('images/produk'), $fileName);
            
            // Menyimpan path foto produk ke database
            $produk->foto_produk = 'images/produk/' . $fileName;
        }

        $produk->save();

        return redirect()->route('produk-admin')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('pages-admin.form-admin.edit-produk-admin', compact('produk'));
    }

    // Mengupdate produk ke dalam database
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'stok_produk' => 'required|integer',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_produk = $request->kategori_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->stok_produk = $request->stok_produk;

        // Menangani foto produk jika ada yang diupload
        if ($request->hasFile('foto_produk')) {
            // Hapus foto produk lama jika ada
            if ($produk->foto_produk && file_exists(public_path($produk->foto_produk))) {
                unlink(public_path($produk->foto_produk));
            }

            // Upload foto produk baru
            $fileName = time() . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path('images/produk'), $fileName);
            
            // Update path foto produk di database
            $produk->foto_produk = 'images/produk/' . $fileName;
        }

        $produk->save();

        return redirect()->route('pages-admin.produk-admin')->with('success', 'Produk berhasil diupdate');
    }

    // Menghapus produk dari database
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus foto produk jika ada
        if ($produk->foto_produk && file_exists(public_path($produk->foto_produk))) {
            unlink(public_path($produk->foto_produk));
        }

        $produk->delete();

        return redirect()->route('pages-admin.produk-admin')->with('success', 'Produk berhasil dihapus');
    }
}
