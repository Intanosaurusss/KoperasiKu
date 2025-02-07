<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller; // Pastikan meng-extend Controller
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendIdMembertoMail;


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
                'role' => 'user',  // Default role untuk member adalah 'user'
            ]);

            DB::commit();

            // Kirim email dengan ID Member
            Mail::to($user->email)->send(new SendIdMembertoMail($user));

            // Redirect ke halaman member setelah registrasi berhasil
            return redirect()->route('pages-admin.member')->with('success', 'Member berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        // Generate ID Member secara otomatis (5 digit angka acak)
      
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
        ], [
            'file.required' => 'Silahkan unggah file Excel terlebih dahulu.',
            'file.mimes' => 'Format file harus .xlsx atau .xls.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');
        
        // Baca file Excel menggunakan PHPSpreadsheet
        $spreadsheet = IOFactory::load($file);

        // Ambil data dari sheet pertama
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Array untuk menyimpan pesan error
        $errors = [];

        // Proses data dan simpan ke database
        foreach ($data as $index => $row) {
            // Menghindari header row (baris pertama adalah header)
            if ($index == 0) continue; // Skip header
            
             // Generate ID Member otomatis (10 digit angka unik)
            $id_member = mt_rand(10000, 99999);

            // Validasi dan simpan data member ke database
            $validator = Validator::make([
                'nama' => $row[0],
                'kelas' => $row[1],
                'email' => $row[2],
                'no_telepon' => $row[3],
            ], [
                'nama' => 'required|string|max:255',
                'kelas' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'no_telepon' => 'required|string|max:15|regex:/^\d+$/|unique:users',
            ], [
                // Custom pesan validasi
                'nama.required' => "Baris ke-" . ($index) . ": Nama wajib diisi.",
                'nama.string' => "Baris ke-" . ($index) . ": Nama harus berupa teks.",
                'nama.max' => "Baris ke-" . ($index) . ": Nama tidak boleh lebih dari 255 karakter.",

                'kelas.required' => "Baris ke-" . ($index) . ": Kelas wajib diisi.",
                'kelas.string' => "Baris ke-" . ($index) . ": Kelas harus berupa teks.",
                'kelas.max' => "Baris ke-" . ($index) . ": Kelas tidak boleh lebih dari 255 karakter.",

                'email.required' => "Baris ke-" . ($index) . ": Email wajib diisi.",
                'email.string' => "Baris ke-" . ($index) . ": Email harus berupa teks.",
                'email.email' => "Baris ke-" . ($index) . ": Format email tidak valid.",
                'email.max' => "Baris ke-" . ($index) . ": Email tidak boleh lebih dari 255 karakter.",
                'email.unique' => "Baris ke-" . ($index) . ": Email sudah terdaftar.",

                'no_telepon.required' => "Baris ke-" . ($index) . ": Nomor telepon wajib diisi.",
                'no_telepon.string' => "Baris ke-" . ($index) . ": Nomor telepon harus berupa teks.",
                'no_telepon.max' => "Baris ke-" . ($index) . ": Nomor telepon tidak boleh lebih dari 15 karakter.",
                'no_telepon.regex' => "Baris ke-" . ($index) . ": Nomor telepon hanya boleh berisi angka.",
                'no_telepon.unique' => "Baris ke-" . ($index) . ": Nomor telepon sudah terdaftar.",
            ]);

            // Jika validasi gagal, kumpulkan error dalam satu pesan per baris
            if ($validator->fails()) {
                $errorMessages = implode(", ", $validator->errors()->all());
                $errors[] = "Baris ke-" . ($index + 1) . ": " . $errorMessages;
                continue;
            }

            // Simpan data member ke dalam database
            $user = User::create([
                'nama' => $row[0],
                'kelas' => $row[1],
                'email' => $row[2],
                'no_telepon' => $row[3],
                'id_member' => $id_member,
                'role' => 'user',  // Default role untuk member adalah 'user'
            ]);

            // Kirim email dengan ID Member
            Mail::to($user->email)->send(new SendIdMembertoMail($user));
        }

        // Jika ada error, tampilkan pesan error
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Redirect ke halaman member setelah proses impor selesai
        return redirect()->route('pages-admin.member')->with('success', 'Data member berhasil diimpor!');
    }
}
