<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $idMember = $request->input('id_member');

        // Simpan ID Member ke dalam session untuk logika penghapusan data keranjangnya (controller hapus keranjangbyadmin)
        if ($idMember) {
            session(['id_member' => $idMember]);
        }

        // Log ID Member untuk debugging
        Log::info('ID Member:', ['id_member' => $idMember]);

        // Aktifkan log query
        DB::enableQueryLog();

        $keranjang = [];
        if ($idMember) {
            // Cari user berdasarkan id_member
            $user = User::where('id_member', $idMember)->first();

            if ($user) {
                // Jika user ditemukan, cari keranjang berdasarkan user_id
                $keranjang = Keranjang::where('user_id', $user->id)
                    ->with('produk') // Pastikan relasi produk benar
                    ->get();
            } else {
                // Jika id_member tidak ditemukan
                Log::warning('User dengan id_member tidak ditemukan.', ['id_member' => $idMember]);
            }
        }

        // Log query yang dijalankan
        Log::info('Query yang dijalankan:', DB::getQueryLog());

        // Log hasil data keranjang
        Log::info('Data Keranjang:', ['keranjang' => $keranjang]);

        return view('pages-admin.transaksi-admin', compact('keranjang', 'idMember'));
    }

    // Fungsi untuk menambah data ke keranjang
    public function addtransaksitokeranjang(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_member' => 'required|string',
            'nama_produk' => 'required|string',
            'qty' => 'required|integer|min:1',
        ]);

        // Cari user berdasarkan id_member
        $member = User::where('id_member', $request->id_member)->orWhere('nama', $request->nama)->first();
        if (!$member) {
            // Menggunakan session untuk menyimpan pesan
            return redirect()->back()->with('error', 'Member tidak ditemukan');
        }

        // Cari produk berdasarkan nama_produk
        $produk = Produk::where('nama_produk', $request->nama_produk)->first();
        if (!$produk) {
            // Menggunakan session untuk menyimpan pesan
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        // Menambah data ke keranjang
        Keranjang::create([
            'user_id' => $member->id,
            'produk_id' => $produk->id,
            'qty' => $request->qty,
        ]);

        // Menyimpan pesan sukses di session
        return redirect()->back()->with('success', 'berhasil ditambahkan!');
    }

    public function hapuskeranjangbyadmin(Request $request)
    {
        // Ambil ID Member dari session
        $idMember = session('id_member');

        if (!$idMember) {
            return redirect()->back()->with('error', 'ID Member tidak tersedia.');
        }

        // Cari user berdasarkan id_member
        $user = User::where('id_member', $idMember)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User dengan ID Member tidak ditemukan.');
        }

        // Ambil ID keranjang dari permintaan
    $idKeranjang = $request->input('id_keranjang');

    if (!$idKeranjang) {
        return redirect()->back()->with('error', 'ID Keranjang tidak tersedia.');
    }
    
        // Hapus item keranjang tertentu berdasarkan user_id dan id keranjang
        $deleted = Keranjang::where('user_id', $user->id)
        ->where('id', $idKeranjang)
        ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Semua item keranjang berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada item keranjang untuk dihapus.');
        }
    }


    



    // function untuk pencarian data di halaman transaksi
    public function searchidmember(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|min:1',
        ]);

        // Ambil query dari input yang dimasukkan
        $query = $request->input('nama');

        // Cari ID Member yang mirip dengan input
        $members = User::where('id_member', 'like', "%$query%")
                    ->orWhere('nama', 'like', "%$query%")
                    ->get();

        // Kembalikan hasil pencarian
        return response()->json($members);
    }

    public function searchproduk(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|min:1',
        ]);

        // Ambil query dari input yang dimasukkan
        $query = $request->input('nama_produk');

        // Cari produk yang mirip dengan input
        $produk = Produk::where('nama_produk', 'like', "%$query%")->get();

        // Kembalikan hasil pencarian
        return response()->json($produk);
    }
}
