<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan ID user yang sedang login
        $userId = Auth::id();

        // Ambil transaksi beserta riwayat dan produk terkait sesuai dengan ID user
        $transaksi = Transaksi::with(['riwayat.produk'])
            ->where('user_id', $userId)
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
                $hargaProduk = $item->produk->harga_produk ?? 0; // Default harga 0 jika produk tidak ditemukan
                $subtotal = $hargaProduk * $item->qty; // Hitung subtotal
                return [
                    'produk' => $item->produk->nama_produk ?? 'Produk tidak ditemukan', // Mendapatkan nama produk
                    'qty' => $item->qty,
                    'harga' => $item->produk->harga_produk ?? 'gatau harganya', // kirim harga produknya ges
                    'subtotal' => $subtotal, // Kirim subtotal
                ];
            }),
            'created_at' => $transaksi->created_at->toISOString(), // Pastikan tanggal dikirim dalam format ISO 8601
        ]);
    }

    public function cetakriwayat($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::with(['user', 'riwayat.produk'])->findOrFail($id);

        // Format data riwayat untuk PDF
        $riwayatData = $transaksi->riwayat->map(function ($riwayat) {
            $subtotal = $riwayat->qty * $riwayat->produk->harga_produk; // Perhitungan subtotal
            return [
                'produk' => $riwayat->produk->nama_produk, // Pastikan atribut 'nama' sesuai dengan model Produk Anda
                'qty' => $riwayat->qty,
                'harga' => $riwayat->produk->harga_produk, // Pastikan atribut harga tersedia
                'subtotal' => $subtotal,
            ];
        });

        // Data yang akan dikirim ke PDF
        $data = [
            'email' => $transaksi->user->email,
            'tanggal' => $transaksi->created_at->translatedFormat('d F Y'),
            'riwayat' => $riwayatData,
            'total' => $riwayatData->sum('subtotal'),
        ];

        // Generate PDF
        $pdf = PDF::loadView('pages.cetak-laporan-riwayat.cetak-laporan-riwayat-by-id', $data);

        // Unduh file PDF
        return $pdf->download("Riwayat_Transaksi_{$id}.pdf");
    }

}
