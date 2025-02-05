<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    //CONTROLLER RIWAYAT UNTUK ADMIN//
    //function untuk mengirim data riwayat transaksi di halaman admin
    public function indexadmin(Request $request)
    {
        // Mendapatkan parameter pencarian
        $search = $request->input('search');

        // Ambil transaksi beserta riwayat dan produk terkait
        $transaksi = Transaksi::with(['riwayat.produk', 'user'])
            ->where('status_pembayaran', 'success') // Filter hanya transaksi dengan status_pembayaran = 'success'
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereDate('created_at', 'like', '%' . $search . '%') // Pencarian berdasarkan tanggal
                        ->orWhere('subtotal', 'like', '%' . $search . '%') // Pencarian berdasarkan subtotal
                        ->orWhereHas('riwayat.produk', function ($q) use ($search) {
                            $q->where('nama_produk', 'like', '%' . $search . '%'); // Pencarian berdasarkan nama produk
                        })
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('email', 'like', '%' . $search . '%'); // Pencarian berdasarkan email pengguna
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Batas per halaman 5

        // Return view dengan data transaksi
        return view('pages-admin.riwayat-admin', compact('transaksi'));
    }

    // function untuk menampilkan detail riwayat pembelian dalam bentuk popup di halaman riwayat admin
    public function showadmin($id) 
    {
        $transaksi = Transaksi::with(['riwayat.produk']) // Memuat relasi produk
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'transaksi' => $transaksi,
            'user' => $transaksi->user,
            'riwayat' => $transaksi->riwayat->map(function ($item) {
                $subtotalPerProduk = $item->subtotal_perproduk ?? 0; // Ambil nilai dari kolom subtotal_perproduk
                $qty = $item->qty ?? 1; // Default qty 1 jika null
                $harga = $qty > 0 ? $subtotalPerProduk / $qty : 0; // Hitung harga dengan membagi subtotal_perproduk dengan qty

                return [
                    'produk' => $item->produk->nama_produk ?? 'Produk tidak ditemukan', // Mendapatkan nama produk
                    'qty' => $item->qty,
                    'harga' => $harga, // kirim harga produknya ges
                    'subtotal' => $subtotalPerProduk, // Kirim subtotal
                ];
            }),
            'created_at' => $transaksi->created_at->toISOString(), // Pastikan tanggal dikirim dalam format ISO 8601
            'total' => $transaksi->subtotal, // Ambil total dari tabel transaksi
        ]);
    }

    // function untuk mencetak data riwayat pembelian/transaksi user di halaman riwayat admin
    public function cetakriwayatadmin($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::with(['user', 'riwayat.produk'])->findOrFail($id);

        // Format data riwayat untuk PDF
        $riwayatData = $transaksi->riwayat->map(function ($riwayat) {
            $subtotalPerProduk = $riwayat->subtotal_perproduk; // Ambil nilai dari kolom subtotal_perproduk
            $qty = $riwayat->qty;
            $harga = $qty > 0 ? $subtotalPerProduk / $qty : 0; // Hitung harga (subtotal_perproduk dibagi qty)

            return [
                'produk' => $riwayat->produk->nama_produk, // Pastikan atribut 'nama' sesuai dengan model Produk Anda
                'qty' => $riwayat->qty,
                'harga' => $harga, // Pastikan atribut harga tersedia
                'subtotal' => $subtotalPerProduk,
            ];
        });

        // Data yang akan dikirim ke PDF
        $data = [
            'email' => $transaksi->user->email,
            'tanggal' => $transaksi->created_at,
            'riwayat' => $riwayatData,
            'total' => $transaksi->subtotal, // Total belanja dari kolom subtotal di tabel transaksi
        ];

        // Generate PDF
        $pdf = PDF::loadView('pages.cetak-laporan-riwayat.cetak-laporan-riwayat-by-id', $data);

        // Unduh file PDF
        return $pdf->download("Riwayat_Transaksi_{$id}.pdf");
    }

    public function cetakriwayatadminbydate(Request $request)
    {
        // validasi kalender untuk mencetak riwayat berdasarkan tanggal
        $request->validate([
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ], [ // pesan jika validasi gagal/error
            'date_start.required' => 'Tanggal awal wajib diisi.',
            'date_start.date' => 'Format tanggal awal tidak valid.',
            'date_end.required' => 'Tanggal akhir wajib diisi.',
            'date_end.date' => 'Format tanggal akhir tidak valid.',
            'date_end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal.',
        ]);        

        // Ambil data transaksi berdasarkan rentang tanggal
        $transaksi = Transaksi::with(['user', 'riwayat.produk'])
            ->where('status_pembayaran', 'success') // Filter hanya transaksi dengan status_pembayaran = 'success'
            ->whereDate('created_at', '>=', $request->date_start)
            ->whereDate('created_at', '<=', $request->date_end)
            ->get();

        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada transaksi pada rentang tanggal yang dipilih.');
        }

         // Format data untuk PDF dan hitung grand total
         $grandTotal = 0;

        // Format data untuk PDF
        $data = $transaksi->map(function ($transaksi) use (&$grandTotal) {
            $riwayatData = $transaksi->riwayat->map(function ($riwayat) {
                $subtotalPerProduk = $riwayat->subtotal_perproduk; // Ambil nilai dari kolom subtotal_perproduk
                $qty = $riwayat->qty;
                $harga = $qty > 0 ? $subtotalPerProduk / $qty : 0; // Hitung harga produknya (subtotal_perproduk dibagi qty)

                return [
                    'produk' => $riwayat->produk->nama_produk,
                    'qty' => $riwayat->qty,
                    'harga' => $harga,
                    'subtotal' => $subtotalPerProduk,
                ];
            });

            // Hitung total transaksi dan tambahkan ke grand total
            $totalTransaksi = $riwayatData->sum('subtotal');
            $grandTotal += $totalTransaksi;

            return [
                'email' => $transaksi->user->email,
                'tanggal' => $transaksi->created_at,
                'riwayat' => $riwayatData,
                'total' => $transaksi->subtotal,
            ];
        });

        // Generate PDF
        $pdf = PDF::loadView('pages.cetak-laporan-riwayat.cetak-laporan-riwayat-admin-by-date', ['data' => $data, 'grandTotal' => $grandTotal]);

        // Unduh file PDF
        return $pdf->download('Laporan_Transaksi_by_Date.pdf');
    }








    //CONTROLLER RIWAYAT UNTUK USER//
    public function index(Request $request)
    {
    // Mendapatkan ID user yang sedang login
    $userId = Auth::id();

    // Mendapatkan parameter pencarian
    $search = $request->input('search');

    // Ambil transaksi beserta riwayat dan produk terkait sesuai dengan ID user
    $transaksi = Transaksi::with(['riwayat.produk'])
        ->where('user_id', $userId)
        ->where('status_pembayaran', 'success') // Filter berdasarkan status_pembayaran success
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('created_at', 'like', '%' . $search . '%') // Pencarian berdasarkan tanggal
                    ->orWhere('subtotal', 'like', '%' . $search . '%') // Pencarian berdasarkan subtotal
                    ->orWhereHas('riwayat.produk', function ($q) use ($search) {
                        $q->where('nama_produk', 'like', '%' . $search . '%'); // Pencarian berdasarkan nama produk
                    });
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5); // Batas per halaman 5

    // Return view dengan data transaksi
    return view('pages-user.riwayat-user', compact('transaksi'));
    }

    // function untuk menampilkan detail riwayat pembelian dalam bentuk popup di halaman riwayat user
    public function show($id) 
    {
        $transaksi = Transaksi::with(['riwayat.produk']) // Memuat relasi produk
            ->where('id', $id)
            ->firstOrFail();

            return response()->json([
                'transaksi' => $transaksi,
                'user' => $transaksi->user,
                'riwayat' => $transaksi->riwayat->map(function ($item) {
                    $subtotalPerProduk = $item->subtotal_perproduk ?? 0; // Ambil nilai dari kolom subtotal_perproduk
                    $qty = $item->qty ?? 1; // Default qty 1 jika null
                    $harga = $qty > 0 ? $subtotalPerProduk / $qty : 0; // Hitung harga dengan membagi subtotal_perproduk dengan qty
        
                    return [
                        'produk' => $item->produk->nama_produk ?? 'Produk tidak ditemukan', // Mendapatkan nama produk
                        'qty' => $qty,
                        'harga' => $harga, // Kirim harga yang dihitung
                        'subtotal' => $subtotalPerProduk, // Kirim nilai subtotal_perproduk
                    ];
                }),
                'created_at' => $transaksi->created_at->toISOString(), // Pastikan tanggal dikirim dalam format ISO 8601
                'total' => $transaksi->subtotal, // Ambil total dari tabel transaksi
            ]);
    }

    public function cetakriwayat($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::with(['user', 'riwayat.produk'])->findOrFail($id);
    
        // Format data riwayat untuk PDF
        $riwayatData = $transaksi->riwayat->map(function ($riwayat) {
            $subtotalPerProduk = $riwayat->subtotal_perproduk; // Ambil nilai dari kolom subtotal_perproduk
            $qty = $riwayat->qty;
            $harga = $qty > 0 ? $subtotalPerProduk / $qty : 0; // Hitung harga (subtotal_perproduk dibagi qty)
    
            return [
                'produk' => $riwayat->produk->nama_produk ?? 'Produk tidak ditemukan', // Nama produk atau default
                'qty' => $qty,
                'harga' => $harga, // Harga per produk
                'subtotal' => $subtotalPerProduk, // Subtotal dari kolom subtotal_perproduk
            ];
        });
    
        // Data yang akan dikirim ke PDF
        $data = [
            'email' => $transaksi->user->email,
            'tanggal' => $transaksi->created_at,
            'riwayat' => $riwayatData,
            'total' => $transaksi->subtotal, // Total belanja dari kolom subtotal di tabel transaksi
        ];
    
        // Generate PDF
        $pdf = PDF::loadView('pages.cetak-laporan-riwayat.cetak-laporan-riwayat-by-id', $data);
    
        // Unduh file PDF
        return $pdf->download("Riwayat_Transaksi_{$id}.pdf");
    }
    
    public function cetakriwayatdate(Request $request)
    {
        // validasi kalender untuk mencetak riwayat berdasarkan tanggal
        $request->validate([
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ], [ // pesan jika validasi gagal/error
            'date_start.required' => 'Tanggal awal wajib diisi.',
            'date_start.date' => 'Format tanggal awal tidak valid.',
            'date_end.required' => 'Tanggal akhir wajib diisi.',
            'date_end.date' => 'Format tanggal akhir tidak valid.',
            'date_end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal.',
        ]); 

        // Ambil data transaksi berdasarkan rentang tanggal
        $transaksi = Transaksi::with(['user', 'riwayat.produk'])
            ->where('user_id', Auth::id())  // Filter berdasarkan user yang sedang login
            ->where('status_pembayaran', 'success') // Filter hanya transaksi dengan status_pembayaran = 'success'
            ->whereDate('created_at', '>=', $request->date_start)
            ->whereDate('created_at', '<=', $request->date_end)
            ->get();

        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada transaksi pada rentang tanggal yang dipilih.');
        }

         // Format data untuk PDF dan hitung grand total
        $grandTotal = 0;

        // Format data untuk PDF
        $data = $transaksi->map(function ($transaksi) use (&$grandTotal) {
            $riwayatData = $transaksi->riwayat->map(function ($riwayat) {
                $subtotalPerProduk = $riwayat->subtotal_perproduk; // Ambil nilai dari kolom subtotal_perproduk
                $qty = $riwayat->qty;
                $harga = $qty > 0 ? $subtotalPerProduk / $qty : 0; // Hitung harga produknya (subtotal_perproduk dibagi qty)

                return [
                    'produk' => $riwayat->produk->nama_produk,
                    'qty' => $riwayat->qty,
                    'harga' => $harga, // Harga per produk
                    'subtotal' => $subtotalPerProduk,
                ];
            });

             // Hitung total transaksi dan tambahkan ke grand total
            $totalTransaksi = $riwayatData->sum('subtotal');
            $grandTotal += $totalTransaksi;

            return [
                'email' => $transaksi->user->email,
                'tanggal' => $transaksi->created_at,
                'riwayat' => $riwayatData,
                'total' => $transaksi->subtotal,
            ];
        });

        // Generate PDF
        $pdf = PDF::loadView('pages.cetak-laporan-riwayat.cetak-laporan-riwayat-by-date', ['data' => $data, 'grandTotal' => $grandTotal, ]);

        // Unduh file PDF
        return $pdf->download('Laporan_Transaksi_by_Date.pdf');
    }
}
