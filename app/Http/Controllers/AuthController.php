<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    // Memproses login administrator menggunakan AJAX
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        // Memeriksa email dan password
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password tidak sesuai.',
            ], 422);
        }

        // Memeriksa hak akses administrator
        if (!Auth::user()->is_admin) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => false,
                'message' => 'Akun ini tidak memiliki akses administrator.',
            ], 403);
        }

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil. Selamat datang!',
            'redirect' => route('admin.dashboard'),
        ]);
    }

    // Logout administrator
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}
