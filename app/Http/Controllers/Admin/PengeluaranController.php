<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengeluaran; // Pastikan namespace model ini benar
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $pengeluaran = $query->paginate(5); // Batas per halaman 5

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
            'deskripsi_pengeluaran' => 'required|string', // Deskripsi opsional
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

    // Metode di controller
    public function cetakpengeluaranbyid($id)
    {
        $pengeluaran = Pengeluaran::find($id); // Ambil data berdasarkan ID
        $pdf = PDF::loadView('pages-admin.cetak-laporan.cetak-laporan-pengeluaran-by-id', compact('pengeluaran')); // Ganti dengan path yang sesuai
        return $pdf->download('laporan_pengeluaran_by_id.pdf');
    }

    // fungsi untuk mencetak laporan pengeluaran by date start-end
    public function cetakpengeluaranbydate(Request $request)
    {
        // Validasi input
        $request->validate([
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ]);

        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');

        // Ambil data pengeluaran berdasarkan tanggal
        $pengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$dateStart, $dateEnd])->get();

        // Cek apakah data pengeluaran ada
        if ($pengeluaran->isEmpty()) {
            // Jika tidak ada data, tampilkan notifikasi
            return back()->with('error', 'Tidak ada laporan pengeluaran pada tanggal yang dipilih.');
        }

        // Pastikan total pengeluaran diproses sebagai angka
        $pengeluaran->map(function ($item) {
            // Menghapus titik dari total_pengeluaran jika ada dan mengonversi ke angka
            $item->total_pengeluaran = (float) str_replace('.', '', $item->total_pengeluaran);
            return $item;
        });

        // Hitung total pengeluaran tanpa memformat
        $totalPengeluaran = $pengeluaran->sum('total_pengeluaran');

        // Render HTML untuk laporan
        $html = view('pages-admin.cetak-laporan.cetak-laporan-pengeluaran-by-date', compact('pengeluaran', 'totalPengeluaran', 'dateStart', 'dateEnd'))->render();

        try {
            // Generate PDF
            $pdf = Pdf::loadHTML($html);
            $pdf->setPaper('A4', 'portrait');  // Set kertas A4, orientasi portrait

            // Stream PDF ke browser
            return $pdf->download('Laporan_Pengeluaran.pdf');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error
            return back()->with('error', 'Terjadi kesalahan saat membuat laporan PDF: ' . $e->getMessage());
        }
    }
}
