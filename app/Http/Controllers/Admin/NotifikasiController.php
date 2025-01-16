<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function fetchNotifikasi()
    {
        // Ambil notifikasi yang belum dibaca
        $notifikasi = Notifikasi::where('is_read', false)->get();

        return response()->json($notifikasi);
    }

    // Tandai notifikasi sebagai dibaca
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::find($id);

        if ($notifikasi) {
            $notifikasi->is_read = true;
            $notifikasi->save();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Notifikasi tidak ditemukan'], 404);
    }

    // function untuk menghitung jumlah notifikasi yang belum dibaca 
    public function checkUnreadNotifikasi()
    {
        // Cek apakah ada notifikasi yang belum dibaca
        $unreadNotifikasiCount = Notifikasi::where('is_read', false)->count();

        return response()->json(['unread_count' => $unreadNotifikasiCount]);
    }
}
