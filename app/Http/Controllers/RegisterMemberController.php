<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use PhpOffice\PhpSpreadsheet\IOFactory;


class RegisterMemberController extends Controller
{
    public function index(Request $request)
    {
    // Ambil parameter search dari query string
    $search = $request->input('search');
    
    // Query untuk mengambil data user dengan role 'user'
    $query = User::where('role', 'user');

    // Jika ada kata kunci pencarian, tambahkan filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('kelas', 'like', "%{$search}%")
              ->orWhere('no_telepon', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('id_member', 'like', "%{$search}%");
        });
    }

    // Paginate hasil pencarian
    $members = $query->paginate(5);

    // Kirim data ke view
    return view('pages-admin.member', compact('members'));
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
            'id_member' => 'required|string|min:10|max:18|regex:/^\d+$/|unique:users', // regex agar hanya menerima angka
            'no_telepon' => 'required|string|max:15|regex:/^\d+$/|unique:users',
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
        return redirect()->route('pages-admin.member')->with('success', 'Member berhasil ditambahkan.');
    }

    // Menghapus member berdasarkan ID
    public function destroy($id)
    {
        $member = User::findOrFail($id); // Mencari member berdasarkan ID

        // Menghapus member
        $member->delete();

        // Redirect ke halaman member dengan pesan sukses
        return redirect()->route('pages-admin.member')->with('success', 'Member berhasil dihapus.');
    }

    // import data member melalui excel (pakai library spreadsheet)
    public function importexcel(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');
        
        // Baca file Excel menggunakan PHPSpreadsheet
        $spreadsheet = IOFactory::load($file);

        // Ambil data dari sheet pertama
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Proses data dan simpan ke database
        foreach ($data as $row) {
            // Menghindari header row
            if ($row[0] == 'Nama') continue; // Sesuaikan dengan header di file Excel Anda
            
            // Validasi dan simpan data member ke database
            $validator = Validator::make([
                'nama' => $row[0],
                'kelas' => $row[1],
                'email' => $row[2],
                'id_member' => $row[3],
                'no_telepon' => $row[4],
            ], [
                'nama' => 'required|string|max:255',
                'kelas' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'id_member' => 'required|string|min:10|max:18|regex:/^\d+$/|unique:users',
                'no_telepon' => 'required|string|max:15|regex:/^\d+$/|unique:users',
            ]);

            // Jika validasi gagal, lanjutkan ke baris berikutnya
            if ($validator->fails()) {
                continue;
            }

            // Simpan data member ke dalam database
            User::create([
                'nama' => $row[0],
                'kelas' => $row[1],
                'email' => $row[2],
                'no_telepon' => $row[4],
                'id_member' => $row[3],
                'role' => 'user',  // Default role untuk member adalah 'user'
            ]);
        }

        // Redirect ke halaman member setelah proses impor selesai
        return redirect()->route('pages-admin.member')->with('success', 'Data member berhasil diimpor!');
    }
}
