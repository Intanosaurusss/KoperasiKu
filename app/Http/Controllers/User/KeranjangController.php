<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Menampilkan data produk yang ada di keranjang.
     */
    public function index()
    {
        $keranjang = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $keranjang->sum(function ($item) {
            // Menghapus titik (jika ada) dan mengonversi harga ke float
            $harga = (float) str_replace('.', '', $item->produk->harga_produk);
                
            // Menghitung subtotal (harga * quantity)
            return $harga * $item->qty;
        });
            
        // Format subtotal untuk menampilkan dengan pemisah ribuan
        $Subtotal = number_format($subtotal, 0, ',', '.');

        return view('pages-user.keranjang-user', compact('keranjang', 'Subtotal'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'qty' => 'required|integer|min:1',
        ]);

        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($keranjang) {
            // Jika produk sudah ada di keranjang, tambahkan qty
            return redirect()->back()->with('warning', 'Produk sudah dimasukkan ke keranjang!');
        } else {
            // Jika belum ada, buat entri baru
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'qty' => $request->qty,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function removeFromCart($id)
    {
        $keranjang = Keranjang::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang Anda!');
        }

        $keranjang->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Menambah qty produk di keranjang.
     */
    public function incrementQty($id)
    {
        $keranjang = Keranjang::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang Anda!');
        }

        $keranjang->qty += 1;
        $keranjang->save();

        return redirect()->back()->with('success', 'Kuantitas produk berhasil ditambah!');
    }

    /**
     * Mengurangi qty produk di keranjang.
     */
    public function decrementQty($id)
    {
        $keranjang = Keranjang::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang Anda!');
        }

        if ($keranjang->qty > 1) {
            $keranjang->qty -= 1;
            $keranjang->save();
        }

        return redirect()->back()->with('success', 'Kuantitas produk berhasil dikurangi!');
    }
}
