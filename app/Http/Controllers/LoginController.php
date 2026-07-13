<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Hapus intended lama yang mungkin berisi URL POST (dari middleware auth sebelumnya)
        // supaya tidak redirect ke route yang hanya terima POST setelah login
        session()->forget('url.intended');

        // Simpan intended baru dari ?intended= kalau ada — harus URL internal
        if ($request->filled('intended')) {
            $intended = $request->query('intended');
            if (str_starts_with($intended, url('/'))) {
                session()->put('url.intended', $intended);
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Kunci pembatas berdasarkan kombinasi email + IP, biar 1 orang nyoba
        // banyak akun dari 1 IP atau nyoba 1 akun dari banyak tempat tetap kena limit.
        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        // Maksimal 5x salah dalam 1 menit, kalau lebih -> diblok sementara
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $credentials = $request->only('email', 'password');

        // Cek login
        if (Auth::attempt($credentials)) {
            // Login berhasil -> reset penghitung supaya tidak ikut menghukum user yang sah
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            // Setelah login, ke URL yang disimpan (halaman produk dll) atau dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Login gagal -> tambah hitungan, kunci 60 detik setelah mencapai batas
        RateLimiter::hit($throttleKey, 60);

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Hapus sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman login
        return redirect('/');
    }
}
