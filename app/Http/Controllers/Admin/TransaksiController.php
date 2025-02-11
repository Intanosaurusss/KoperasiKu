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
use Illuminate\Support\Facades\Auth;

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

    public function addtransaksitokeranjang(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_member' => 'required|string',
            'nama_produk' => 'required|array',   // Array untuk menerima data produk dalam bentuk array
            'nama_produk.*' => 'required|string', // Setiap elemen dalam array harus berupa string
            'qty' => 'required|array',           // Array untuk menerima data qty dalam bentuk array
            'qty.*' => 'required|integer|min:1', // Setiap elemen dalam array qty harus integer dan lebih besar dari 0
        ]);

        // Cari user berdasarkan id_member
        $member = User::where('id_member', $request->id_member)->first();
        if (!$member) {
            return redirect()->back()->with('error', 'Member tidak ditemukan');
        }

        // Pesan untuk menampung informasi produk yang sudah ada di keranjang
        $produkSudahAda = [];
        $produkTidakDitemukan = []; // Menampung nama produk yang tidak ditemukan
        $produkStokKosong = []; // Menampung produk dengan stok kosong

        // Loop untuk menambah data ke keranjang berdasarkan produk dan qty yang dikirim
        foreach ($request->nama_produk as $index => $namaProduk) {
            // Cari produk berdasarkan nama_produk
            $produk = Produk::where('nama_produk', $namaProduk)->first();

            if (!$produk) {
                // Jika produk tidak ditemukan, tambahkan ke daftar produk tidak ditemukan
                $produkTidakDitemukan[] = $namaProduk;
                continue; // Lanjutkan ke iterasi berikutnya
            }

            // Cek apakah stok produk cukup
            if ($produk->stok_produk < $request->qty[$index]) {
                // Jika stok tidak cukup, tambahkan ke daftar produk dengan stok kosong
                $produkStokKosong[] = $namaProduk;
                continue; // Lanjutkan ke iterasi berikutnya
            }

            // Cek apakah produk sudah ada di keranjang
            $keranjang = Keranjang::where('user_id', $member->id)
                ->where('produk_id', $produk->id)
                ->first();

            if ($keranjang) {
                // Jika produk sudah ada di keranjang, tambahkan qty
                $keranjang->qty += $request->qty[$index];
                $keranjang->save();

                // Tambahkan nama produk ke pesan informasi
                $produkSudahAda[] = $namaProduk;
            } else {
                // Jika produk belum ada di keranjang, tambahkan produk baru
                Keranjang::create([
                    'user_id' => $member->id,
                    'produk_id' => $produk->id,
                    'qty' => $request->qty[$index],
                ]);
            }
        }

        // Jika ada produk yang tidak ditemukan
        if (!empty($produkTidakDitemukan)) {
            $produkList = implode(', ', $produkTidakDitemukan);
            return redirect()->back()->with('error', 'Produk (' . $produkList . ') tidak ditemukan, gagal ditambahkan ke keranjang.');
        }

        // Jika ada produk dengan stok kosong
        if (!empty($produkStokKosong)) {
            $produkList = implode(', ', $produkStokKosong);
            return redirect()->back()->with('error', 'Stok produk (' . $produkList . ') tidak cukup untuk memenuhi permintaan.');
        }

        // Jika ada produk yang sudah ada di keranjang
        if (!empty($produkSudahAda)) {
            $produkList = implode(', ', $produkSudahAda);
            return redirect()->back()->with('success', 'Produk (' . $produkList . ') sudah ada di keranjang, kuantitasnya ditambahkan!');
        }

        // Pesan sukses jika semua produk ditambahkan tanpa masalah
        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang!');
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
        $subtotal = $keranjang->sum(function ($item) { // variabel subtotal ini menghitung data yg dikeranjang unuk kemudian menjadi subtotal yang akan disimpan di tabel transaksi (kolom subtotal)
            return $item->produk->harga_produk * $item->qty;
        });

        $metodePembayaran = $request->input('metode_pembayaran');
        $petugas = Auth::id(); // Petugas yang sedang login

        if ($metodePembayaran === 'cash') {
            try {
                // Simpan transaksi ke database
                $transaksi = Transaksi::create([
                    'user_id' => $user->id,
                    'petugas_id' => $petugas,
                    'metode_pembayaran' => 'cash',
                    'status_pembayaran' => 'success',
                    'subtotal' => $subtotal,  // subtotal ini didapat dari variabel yang sudah didefinisikan/dijelaskan di line no 212
                ]);

                // Tambahkan riwayat dan kurangi stok
                foreach ($keranjang as $item) {
                    $produk = $item->produk;
                    $subtotal = $produk->harga_produk * $item->qty;  // subtotal ini untuk subtotal_perproduk di tabel transaksi
        
                    Riwayat::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $item->produk_id,
                        'qty' => $item->qty,
                        'subtotal_perproduk' => $subtotal,
                    ]);
        
                    // Kurangi stok produk
                    $produk->stok_produk -= $item->qty;
                    $produk->save();
                }
        
                // Kosongkan keranjang
                $keranjang->each->delete();
        
                return response()->json([
                    'message' => 'Pembayaran berhasil dengan metode cash!',
                    'transaksi' => $transaksi,
                ]);
            } catch (\Exception $e) {
                // Jika terjadi error, ubah status pembayaran menjadi 'failed'
                if (isset($transaksi)) {
                    $transaksi->status_pembayaran = 'failed';
                    $transaksi->save();
                }
        
                return response()->json([
                    'message' => 'Terjadi kesalahan saat memproses pembayaran.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } elseif ($metodePembayaran === 'digital') {
            // Buat transaksi sementara di database
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'petugas_id' => $petugas,
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
            $produk = $item->produk;
            $subtotal = $produk->harga_produk * $item->qty;

            Riwayat::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'qty' => $item->qty,
                'subtotal_perproduk' => $subtotal,
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
