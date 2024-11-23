<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('pages.login');
    }

     // Proses login
     public function login(Request $request)
     {
         // Validasi input
         $request->validate([
             'email' => 'required|email',
             'id_member' => 'required|integer',
         ]);
 
         // Coba autentikasi pengguna berdasarkan email dan id_member
         $user = User::where('email', $request->email)
                     ->where('id_member', $request->id_member)
                     ->first();
 
         if ($user) {
             // Login pengguna
             Auth::login($user);
 
             // Cek role pengguna dan redirect ke halaman sesuai
             if ($user->role === 'admin') {
                 return redirect()->route('pages-admin.dashboard-admin'); // Rute dashboard admin
             } elseif ($user->role === 'user') {
                 return redirect()->route('pages-user.dashboard-user'); // Rute dashboard user
             }
         }
 
         // Jika autentikasi gagal
         return back()->withErrors([
             'email' => 'Email atau ID Member salah.',
         ])->withInput();
     }

    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
