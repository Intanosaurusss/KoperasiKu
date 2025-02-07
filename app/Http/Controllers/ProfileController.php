<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil berdasarkan id user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showProfile($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Pastikan hanya pengguna yang sedang login yang bisa mengakses profil mereka
        // if (dd(Auth::id()) !== $user->id) {
        //     return abort(403, 'Unauthorized');
        // }

        // Tentukan layout berdasarkan role pengguna
        if ($user->role === 'admin') {
            $layout = 'components.layout-admin';
        } elseif ($user->role === 'petugas') {
            $layout = 'components.layout-petugas';
        } else {
            $layout = 'components.layout-user';
        }
        
        // Tampilkan halaman profil dengan layout yang sesuai
        return view('pages.profile', compact('user', 'layout'));
    }

    // Display the edit profile form with current user data
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Tentukan layout berdasarkan role pengguna
        if ($user->role === 'admin') {
            $layout = 'components.layout-admin';
        } elseif ($user->role === 'petugas') {
            $layout = 'components.layout-petugas';
        } else {
            $layout = 'components.layout-user';
        }

        return view('pages.edit-profile', compact('user', 'layout'));
    }

    // Update user profile
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'id_member' => 'nullable|digits:5', 
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::findOrFail($id);
        
        // Update the user fields
        $user->nama = $request->nama;
        $user->kelas = $request->kelas;
        $user->no_telepon = $request->no_telepon;
        $user->email = $request->email;
        $user->id_member = $request->id_member;

       // Periksa apakah ada gambar yang diunggah
       if ($request->hasFile('foto_profile')) {
            // Hapus gambar lama jika ada
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }

            // Simpan gambar baru
            $user->foto_profile = $request->file('foto_profile')->store('images/profile', 'public');
        }

         // Bandingkan data yang diperbarui dengan data asli
        if ($user->isDirty() || $request->hasFile('foto_profile')) {
            // Simpan jika ada perubahan
            $user->save();
            return redirect()->route('profile', $id)->with('success', 'Profile berhasil diedit!');
        }

        // Tidak ada perubahan, kembalikan tanpa pesan
        return redirect()->route('profile', $id);
    }
}
