<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPetugasController extends Controller
{
    public function index(Request $request)
    {
        // Kirim data ke view
        return view('pages-petugas.dashboard-petugas');
    }
}
