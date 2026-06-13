<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // 🔍 Lihat profil user
    public function show()
    {
        $user = Auth::user();
        return view('backend.profile.show', compact('user'));
    }

    // 📝 Halaman edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('backend.profile.index', compact('user'));
    }

    // ✅ Simpan perubahan profil
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru ke storage
            $path = $request->file('foto')->store('profile', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // 🛠️ Halaman pengaturan akun
    public function settings()
    {
        $user = Auth::user();
        return view('backend.profile.settings', compact('user'));
    }

    // 🔐 Simpan perubahan password
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
