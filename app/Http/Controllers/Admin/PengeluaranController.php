<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengeluaran; // Pastikan namespace model ini benar
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    
    // Menampilkan halaman daftar pengeluaran
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        // Cek apakah ada input pencarian - ini untuk mencari data di searchbar 
        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where('tanggal_pengeluaran', 'LIKE', "%{$search}%")
                ->orWhere('total_pengeluaran', 'LIKE', "%{$search}%")
                ->orWhere('deskripsi_pengeluaran', 'LIKE', "%{$search}%");
        }

        $pengeluaran = $query->get();

        // Kirim data ke view
        return view('pages-admin.pengeluaran-admin', compact('pengeluaran')); // Sesuaikan nama view
    }

    // Menampilkan halaman detail pengeluaran berdasarkan ID
    public function show($id)
    {
        // Mengambil data detail pengeluaran berdasarkan ID dari database
        $pengeluaran = Pengeluaran::findOrFail($id); // Mengambil data berdasarkan ID, atau gagal jika tidak ditemukan

        // Mengambil data detail pengeluaran berdasarkan ID dari database
        return view('pages-admin.detail-pengeluaran-admin', compact('pengeluaran')); // Sesuaikan nama view dengan view detail pengeluaran
    }

    // Menampilkan form untuk menambahkan pengeluaran
    public function create()
    {
        return view('pages-admin.form-admin.tambah-pengeluaran-admin'); // Sesuaikan nama view dengan view form tambah pengeluaran
    }

    // Menyimpan data pengeluaran baru
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'tanggal_pengeluaran' => 'required|date',
            'total_pengeluaran' => 'required|string|min:0', // Pastikan jumlah pengeluaran tidak negatif
            'deskripsi_pengeluaran' => 'nullable|string', // Deskripsi opsional
        ]);

        // Simpan data pengeluaran baru ke dalam database
        Pengeluaran::create([
            'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
            'total_pengeluaran' => $request->total_pengeluaran,
            'deskripsi_pengeluaran' => $request->deskripsi_pengeluaran,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('pengeluaran-admin')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan formulir edit
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id); // Menemukan pengeluaran berdasarkan ID
        return view('pages-admin.form-admin.edit-pengeluaran-admin', compact('pengeluaran')); // Mengirim data pengeluaran ke view
    }

    // Fungsi untuk mengupdate pengeluaran
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_pengeluaran' => 'required|date',
            'total_pengeluaran' => 'required|string',
            'deskripsi_pengeluaran' => 'required|string',
        ]);

        // Mencari pengeluaran berdasarkan ID
        $pengeluaran = Pengeluaran::findOrFail($id);
        
        // Mengupdate data pengeluaran
        $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
        $pengeluaran->total_pengeluaran = $request->total_pengeluaran;
        $pengeluaran->deskripsi_pengeluaran = $request->deskripsi_pengeluaran;
        $pengeluaran->save(); // Menyimpan perubahan

        return redirect()->route('pages-admin.pengeluaran-admin')->with('success', 'Pengeluaran berhasil diupdate!');
    }

    // Fungsi untuk menghapus pengeluaran
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id); // Menemukan pengeluaran berdasarkan ID
        $pengeluaran->delete(); // Menghapus data pengeluaran

        return redirect()->route('pages-admin.pengeluaran-admin')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
