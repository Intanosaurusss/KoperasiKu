<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Pastikan meng-extend Controller
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendIdMembertoMail;

class RegisterPetugasController extends Controller
{
    // Menampilkan halaman petugas di role admin
    public function index()
    {
        // Query untuk mengambil data user dengan role 'user'
        $query = User::where('role', 'petugas');

        // Paginate data
        $petugas = $query->paginate(5);

        // Hitung jumlah user dengan role 'petugas'
        $jumlahPetugas = $query->count();

        return view('pages-admin.petugas', compact('petugas', 'jumlahPetugas'));
    }

    // Menampilkan form tambah member
    public function create()
    {
        return view('pages-admin.form-admin.tambah-petugas');
    }

    // Menyimpan data member ke database
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'kelas' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'id_member' => 'string|regex:/^\d+$/|unique:users', // hanya menerima angka
                'no_telepon' => 'required|string|max:13|regex:/^\d+$/|unique:users',
            ], [ // pesan jika validasi gagal
                'nama.required' => 'Silahkan isi nama terlebih dahulu.', 
                'nama.string' => 'Nama harus berupa teks.',
                'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            
                'kelas.required' => 'Silahkan isi kelas terlebih dahulu.',
                'kelas.string' => 'Kelas harus berupa teks.',
                'kelas.max' => 'Kelas tidak boleh lebih dari 255 karakter.',
            
                'email.required' => 'Silahkan isi email terlebih dahulu.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
                'email.unique' => 'Email sudah digunakan, silahkan gunakan email lain.',
        
                'id_member.string' => 'ID Member harus berupa teks.',
                'id_member.regex' => 'ID Member hanya boleh berisi angka.',
                'id_member.unique' => 'ID Member sudah terdaftar, gunakan ID lain.',
            
                'no_telepon.required' => 'Silahkan isi nomor telepon terlebih dahulu.',
                'no_telepon.string' => 'Nomor telepon harus berupa teks.',
                'no_telepon.max' => 'Nomor telepon tidak boleh lebih dari 13 digit.',
                'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
                'no_telepon.unique' => 'Nomor telepon sudah digunakan, silahkan gunakan nomor lain.',
            ]);
    
            // Jika validasi gagal
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            // Membuat pengguna baru tanpa password (asumsi tidak menggunakan password pada registrasi member)
            $user = User::create([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'email' => $request->email,
                'no_telepon' => $request->no_telepon,
                'id_member' => mt_rand(10000, 99999), // 5 digit angka
                'role' => 'petugas',  // // rolenya petugas
            ]);

            DB::commit();

            // Kirim email dengan ID Member
            Mail::to($user->email)->send(new SendIdMembertoMail($user));

            // Redirect ke halaman member setelah registrasi berhasil
            return redirect()->route('pages-admin.petugas')->with('success', 'Petugas berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan detail petugas berdasarkan ID
    public function show($id)
    {
        $petugas = User::findOrFail($id);  // Mencari member berdasarkan ID
        return view('pages-admin.detail-petugas', compact('petugas'));  // Mengirim data member ke view
    }

    // Menghapus petugas berdasarkan ID
    public function destroy($id)
    {
        $petugas = User::findOrFail($id); // Mencari member berdasarkan ID

        // Menghapus member
        $petugas->delete();

        // Redirect ke halaman member dengan pesan sukses
        return redirect()->route('pages-admin.petugas')->with('success', 'Petugas berhasil dihapus!');
    }
}
