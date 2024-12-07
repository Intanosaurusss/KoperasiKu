<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\Riwayat;
use Midtrans\Config;
use Midtrans\Snap;
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
        $subtotal = 0; // Inisialisasi nilai default subtotal
        if ($idMember) {
            // Cari user berdasarkan id_member
            $user = User::where('id_member', $idMember)->first();

            if ($user) {
                // Jika user ditemukan, cari keranjang berdasarkan user_id
                $keranjang = Keranjang::where('user_id', $user->id)
                    ->with('produk') // Pastikan relasi produk benar
                    ->get();

            // Hitung subtotal
            $subtotal = $keranjang->sum(function ($item) {
                // Pastikan harga_produk memiliki nilai, jika null atau kosong, set ke 0
                $harga = (float) str_replace('.', '', $item->produk->harga_produk ?? '0');
                return $harga * $item->qty;
            });
            } else {
                // Jika id_member tidak ditemukan
                Log::warning('User dengan id_member tidak ditemukan.', ['id_member' => $idMember]);
            }
        }

        // Log query yang dijalankan
        Log::info('Query yang dijalankan:', DB::getQueryLog());

        // Log hasil data keranjang
        Log::info('Data Keranjang:', ['keranjang' => $keranjang]);

         // Format subtotal untuk tampilan
        $formattedSubtotal = number_format($subtotal, 0, ',', '.');

        return view('pages-admin.transaksi-admin', compact('keranjang', 'idMember', 'formattedSubtotal'));
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

    //controller untuk menghandle pembayaran/transaksi yang dilakukan oleh admin
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Set server key dari .env
        Config::$isProduction = false; // Ubah ke true jika di production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkoutbyadmin(Request $request)
    {
        // Ambil id_member dari session
        $idMember = session('id_member');
        
        // Cari user berdasarkan id_member
        $user = User::where('id_member', $idMember)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $keranjang = $user->keranjang; // Sesuaikan dengan relasi user ke keranjang
        $subtotal = $keranjang->sum(function ($item) {
            return $item->produk->harga_produk * $item->qty;
        });

        $metodePembayaran = $request->input('metode_pembayaran');

        if ($metodePembayaran === 'cash') {
            // Simpan transaksi ke database
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'metode_pembayaran' => 'cash',
                'status_pembayaran' => 'success',
                'subtotal' => $subtotal,
            ]);

            // Tambahkan riwayat dan kurangi stok
            foreach ($keranjang as $item) {
                Riwayat::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item->produk_id,
                    'qty' => $item->qty,
                ]);

                // Kurangi stok produk
                $produk = $item->produk;
                $produk->stok_produk -= $item->qty;
                $produk->save();
            }

            // Kosongkan keranjang
            $keranjang->each->delete();

            return response()->json([
                'message' => 'Pembayaran berhasil dengan metode cash!',
                'transaksi' => $transaksi,
            ]);
        } elseif ($metodePembayaran === 'digital') {
            // Buat transaksi sementara di database
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'metode_pembayaran' => 'digital',
                'status_pembayaran' => 'pending',
                'subtotal' => $subtotal,
            ]);

            // Siapkan data untuk Snap Midtrans
            $payload = [
                'transaction_details' => [
                    'order_id' => $transaksi->id, // Gunakan id sebagai order_id
                    'gross_amount' => $subtotal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->telepon ?? '',
                ],
                'item_details' => $keranjang->map(function ($item) {
                    return [
                        'id' => $item->produk->id,
                        'price' => $item->produk->harga_produk,
                        'quantity' => $item->qty,
                        'name' => $item->produk->nama_produk,
                    ];
                })->toArray(),
            ];

            $snapToken = Snap::getSnapToken($payload);

            return response()->json([
                'snapToken' => $snapToken,
            ]);
        }
    }

    public function paymentsuccessbyadmin(Request $request)
    {
        $orderId = $request->input('order_id');

        // Cari transaksi berdasarkan order_id
        $transaksi = Transaksi::find($orderId);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Perbarui status pembayaran
        $transaksi->status_pembayaran = 'success';
        $transaksi->save();

        // Ambil keranjang milik pengguna berdasarkan id_member
        $idMember = session('id_member');
        $user = User::where('id_member', $idMember)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $keranjang = $user->keranjang;

        if ($keranjang->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong, tidak ada data yang dipindahkan ke riwayat.'], 400);
        }

        // Proses setiap item di keranjang dan tambahkan ke riwayat serta kurangi stok produk
        foreach ($keranjang as $item) {
            Riwayat::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'qty' => $item->qty,
            ]);

            // Kurangi stok produk
            $produk = $item->produk;
            $produk->stok_produk -= $item->qty;
            $produk->save();
        }

        // Hapus produk dari keranjang setelah ditambahkan ke riwayat
        $keranjang->each(function ($item) {
            $item->delete();
        });

        return response()->json([
            'message' => 'Pembayaran berhasil!',
            'transaksi' => $transaksi,
        ]);
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
