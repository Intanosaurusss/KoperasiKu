<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        if (Auth::id() !== $user->id) {
            return abort(403, 'Unauthorized');
        }

        // Tentukan layout berdasarkan role pengguna
        $layout = $user->role === 'admin' ? 'components.layout-admin' : 'components.layout-user';

        // Tampilkan halaman profil dengan layout yang sesuai
        return view('pages.profile', compact('user', 'layout'));
    }

    // Display the edit profile form with current user data
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Menentukan layout berdasarkan role pengguna
        $layout = 'components.layout-user'; // Default layout

        if ($user->role === 'admin') {
            $layout = 'components.layout-admin'; // Layout untuk admin
        } elseif ($user->role === 'user') {
            $layout = 'components.layout-user'; // Layout untuk user biasa
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
            'id_member' => 'nullable|digits:10', // Validasi ID Member dengan 10 angka
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::findOrFail($id);
        
        // Update the user fields
        $user->nama = $request->nama;
        $user->kelas = $request->kelas;
        $user->no_telepon = $request->no_telepon;
        $user->email = $request->email;
        $user->id_member = $request->id_member;

        // Handle image upload
        if ($request->hasFile('foto_profile')) {
            // Cek apakah pengguna sudah memiliki foto profil lama
            if ($user->foto_profile && file_exists(public_path($user->foto_profile))) {
                // Hapus foto profil lama
                unlink(public_path($user->foto_profile));
            }

            // Upload foto baru
            $fileName = time() . '.' . $request->foto_profile->extension();
            $request->foto_profile->move(public_path('images/profile'), $fileName);
            
            // Update path foto profil baru di database
            $user->foto_profile = 'images/profile/' . $fileName;
        } 

        $user->save();

        return redirect()->route('profile', $id)->with('success', 'Profile updated successfully.');
    }
}
