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
             'id_member' => 'required',
         ]);
 
         // Coba autentikasi pengguna berdasarkan email dan id_member
         $user = User::where('email', $request->email)
                     ->where('id_member', $request->id_member)
                     ->first();
 
         if ($user) {
             // Login pengguna
             
             // Cek role pengguna dan redirect ke halaman sesuai
             if ($user->role === 'admin') {
                //ditambahin sama mas Roy, buat middleware nya sampai baris 40 
                 Auth::guard('admin')->login($user);
                 
                 $request->session()->regenerate();
                 
                 return redirect()->route('pages-admin.dashboard-admin'); // Rute dashboard admin
             } elseif ($user->role === 'user') {
                //ditambahin sama mas Roy, buat middleware sampai baris 48
                Auth::login($user);
                 
                 $request->session()->regenerate();
                 
                 return redirect()->route('pages-user.dashboard-user'); // Rute dashboard user
             }
         }
 
         // Jika autentikasi gagal
         return back()->withErrors([
             'email' => 'Email atau ID Member salah.',
         ])->withInput();
     }

    // controller logout dipisah antara admin dan user untuk middleware, ditambahin sama mas Roy
    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Proses logout
    public function logoutadmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        
 
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
