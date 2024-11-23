<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterMemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'user')->get(); // Mengambil data member dari tabel 'users' tetapi hanya yang memiliki role sebagai "user" saja
        return view('pages-admin.member', compact('members'));  // Mengirim data member ke view
    }

    // Menampilkan detail member berdasarkan ID
    public function show($id)
    {
        $member = User::findOrFail($id);  // Mencari member berdasarkan ID
        return view('pages-admin.detail-member', compact('member'));  // Mengirim data member ke view
    }

    // Menampilkan form tambah member
    public function create()
    {
        return view('pages-admin.form-admin.tambah-member');
    }

    // Menyimpan data member ke database
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'id_member' => 'required|numeric|min:10|unique:users,id_member',
            'no_telepon' => 'required|string|max:15|unique:users',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat pengguna baru tanpa password (asumsi tidak menggunakan password pada registrasi member)
        User::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'id_member' => $request->id_member,
            'role' => 'user',  // Default role untuk member adalah 'user'
        ]);

        // Redirect ke halaman member setelah registrasi berhasil
        return redirect()->route('pages-admin.member')->with('message', 'Member berhasil ditambahkan.');
    }

    // Menghapus member berdasarkan ID
    public function destroy($id)
    {
        $member = User::findOrFail($id); // Mencari member berdasarkan ID

        // Menghapus member
        $member->delete();

        // Redirect ke halaman member dengan pesan sukses
        return redirect()->route('pages-admin.member')->with('message', 'Member berhasil dihapus.');
    }


    // public function registermember(Request $request)
    // {
    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'nama' => 'required|string|max:255',
    //         'kelas' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'id_member' => 'required|integer|min:10|unique:users,id_member',
    //         'no_telepon' => 'required|string|max:15|unique:users',
    //     ]);

    //     // Jika validasi gagal
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Membuat pengguna baru tanpa password (asumsi tidak menggunakan password pada registrasi member)
    //     User::create([
    //         'nama' => $request->nama,
    //         'kelas' => $request->kelas,
    //         'email' => $request->email,
    //         'no_telepon' => $request->no_telepon,
    //         'id_member' => $request->id_member,
    //         'role' => 'user',  // Default role untuk member adalah 'user'
    //     ]);

    //     // Redirect ke halaman login setelah registrasi berhasil
    //     return redirect()->route('login')->with('message', 'Registrasi berhasil. Silakan masuk.');
    // }
}
