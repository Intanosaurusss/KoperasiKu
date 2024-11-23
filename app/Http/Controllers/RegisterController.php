<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        // Validasi input hanya untuk field yang ada di form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Membuat pengguna baru dengan hanya field yang ada di form
        User::create([
            'name' => $request->name,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon, // Pastikan ini ada
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login setelah registrasi berhasil
        return redirect()->route('login')->with('message', 'Registrasi berhasil. Silakan masuk.');
    }
}
