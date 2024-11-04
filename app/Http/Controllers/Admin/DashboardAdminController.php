<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    // function untuk menampilkan halaman dashboard admin
    public function index()
    {
        return view('pages-admin.dashboard-admin'); // Sesuaikan dengan nama view yang Anda gunakan
    }
}
