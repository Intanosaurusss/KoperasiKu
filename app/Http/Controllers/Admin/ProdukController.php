<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan namespace model ini benar
use Illuminate\Support\Facades\Storage;

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
            'nama_produk.required' => 'Silahkan isi nama produk terlebih dahulu.',
            'nama_produk.unique' => 'Produk dengan nama ini sudah ada.',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter',

            'kategori_produk.required' => 'Silahkan isi kategori produk terlebih dahulu.',
            'kategori_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter',

            'harga_produk.required' => 'Silahkan isi harga produk terlebih dahulu.',
            'harga_produk.numeric' => 'Harga produk harus berupa angka',

            'stok_produk.required' => 'Silahkan isi stok produk terlebih dahulu.',
            'stok_produk.integer' => 'Stok produk harus berupa angka',

            'foto_produk.required' => 'Silahkan isi stok produk terlebih dahulu.',
            'foto_produk.image' => 'Foto produk harus berupa gambar',
            'foto_produk.mimes' => 'Foto produk harus berupa jpeg,png,jpg',
            'foto_produk.max' => 'Ukuran foto produk tidak boleh lebih dari 2 MB',
        ]);

        // Menyimpan data produk ke database
        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_produk = $request->kategori_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->stok_produk = $request->stok_produk;

        // Menangani upload foto produk
        if ($request->hasFile('foto_produk')) {
            $path = $request->file('foto_produk')->store('images/produk', 'public');
            $produk->foto_produk = $path; // Simpan path gambar ke database
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
    
        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id);
    
        // Update data produk dari input
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_produk = $request->kategori_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->stok_produk = $request->stok_produk;

       // Periksa apakah ada gambar yang diunggah
       if ($request->hasFile('foto_produk')) {
            // Hapus gambar lama jika ada
            if ($produk->foto_produk) {
                Storage::disk('public')->delete($produk->foto_produk);
            }

            // Simpan gambar baru
            $produk->foto_produk = $request->file('foto_produk')->store('images/produk', 'public');
        }
    
        // Simpan perubahan ke database
        $produk->save();
    
        // Redirect kembali ke halaman produk admin dengan pesan sukses
        return redirect()->route('pages-admin.produk-admin')->with('success', 'Produk berhasil diedit');
    }
    
    // Menghapus produk dari database
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus foto produk jika ada
        if ($produk->foto_produk) {
            Storage::disk('public')->delete($produk->foto_produk); // Hapus file sesuai path di database
        }

        // Hapus data produk dari database
        $produk->delete();

        return redirect()->route('pages-admin.produk-admin')->with('success', 'Produk berhasil dihapus');
    }
}
