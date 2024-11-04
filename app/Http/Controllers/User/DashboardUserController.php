<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    // function untuk menampilkan halaman dashboard user
    public function index()
    {
        return view('pages-user.dashboard-user'); // Sesuaikan dengan nama view yang Anda gunakan
    }
}
