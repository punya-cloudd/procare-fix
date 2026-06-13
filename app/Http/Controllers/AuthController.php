<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/backend/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        // Simpan nama user untuk notifikasi (opsional)
        $userName = Auth::user() ? Auth::user()->name : 'User';
        
        // Proses logout
        Auth::logout();
        
        // Invalidasi session
        $request->session()->invalidate();
        
        // Regenerate token
        $request->session()->regenerateToken();
        
        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}
