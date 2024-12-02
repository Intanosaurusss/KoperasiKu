<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
