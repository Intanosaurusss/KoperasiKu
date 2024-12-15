<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Saran;
use Carbon\Carbon;

class SaranController extends Controller
{
    public function indexadmin()
    {
        // Ambil semua data dari tabel saran
        $saran = Saran::all();

        // Set locale ke Bahasa Indonesia, untuk penanggalan
        Carbon::setLocale('id');

         // Format tanggal sebelum mengirim ke view
        $saran->each(function($item) {
            $item->formatted_created_at = $item->created_at->translatedFormat('d F Y');
        });
        
        // Kirim data ke view
        return view('pages-admin.saran-admin', compact('saran'));
    }
    
    // Method untuk menghapus saran berdasarkan ID
    public function destroy($id)
    {
        // Cari data saran berdasarkan ID
        $saran = Saran::findOrFail($id);
        
        // Hapus data saran
        $saran->delete();
        
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('saran.indexadmin')->with('success', 'Saran berhasil dihapus.');
    }



    //INI FUNCTIION UNTUK MENU SARAN DI HALAMAN USER//      
    public function index()
    {
        return view('pages-user.saran-user');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'saran' => 'required|string|max:1000',
        ]);

        try {
            // Simpan data saran ke database
            Saran::create([
                'user_id' => Auth::id(), // Mendapatkan ID user yang sedang login
                'rating' => $validated['rating'],
                'saran' => $validated['saran'],
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Saran berhasil disimpan!');
        } catch (\Exception $e) {
            // Jika terjadi error, kirimkan pesan error
            return redirect()->back()->withErrors(['error' => 'Saran gagal dikirim. Silakan coba lagi.']);
        }
    }
}
