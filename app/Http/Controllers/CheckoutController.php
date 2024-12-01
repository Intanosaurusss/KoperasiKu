<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;


class CheckoutController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Ganti ke `true` jika dalam mode produksi
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
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

    public function paymentSuccess(Request $request)
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

        // Ambil keranjang milik pengguna
        $keranjang = $transaksi->user->keranjang;

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

    // public function callback(Request $request)
    // {
    // $notification = new \Midtrans\Notification($request->all()); // Terima request dengan benar

    // $transactionStatus = $notification->transaction_status;
    // $orderId = $notification->order_id; // Ini adalah id transaksi dari database

    // // Cari transaksi berdasarkan id
    // $transaksi = Transaksi::find($orderId);

    // if (!$transaksi) {
    //     return response()->json([
    //         'message' => 'Transaksi tidak ditemukan.',
    //     ], 404);
    // }

    // if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
    //     // Pembayaran berhasil
    //     $transaksi->update([
    //         'status_pembayaran' => 'success',
    //     ]);

    //     // Tambahkan riwayat dari keranjang
    //     $user = $transaksi->user;
    //     $keranjang = $user->keranjang;

    //     foreach ($keranjang as $item) {
    //         Riwayat::create([
    //             'transaksi_id' => $transaksi->id,
    //             'produk_id' => $item->produk_id,
    //             'qty' => $item->qty,
    //         ]);
    //     }

    //     // Kosongkan keranjang
    //     $keranjang->each->delete();
    // } elseif ($transactionStatus == 'pending') {
    //     // Pembayaran pending
    //     $transaksi->update([
    //         'status_pembayaran' => 'pending',
    //     ]);
    // } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
    //     // Pembayaran gagal
    //     $transaksi->update([
    //         'status_pembayaran' => 'failed',
    //     ]);
    // }

    // return response()->json([
    //     'message' => 'Callback berhasil diproses.',
    // ]);
    // }
}
