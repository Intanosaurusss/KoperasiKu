<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterPetugasController extends Controller
{
    // Menampilkan form untuk menambahkan produk baru
    public function index()
    {
        return view('pages-admin.petugas');
    }
}
