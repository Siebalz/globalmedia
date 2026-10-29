<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        // Role selalu 'user' — admin TIDAK bisa didapat lewat registrasi publik.
        // Untuk membuat admin pertama, jalankan: php artisan tinker
        // >>> User::first()->update(['role' => 'admin'])
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        // Setelah registrasi berhasil, arahkan ke login
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
