<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // tampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/');
        }

        return view('auth.login');
    }

    // proses login
    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            // regenerate session
            $request->session()->regenerate();

            // redirect berdasarkan role + Tambahkan pesan 'success'
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard')->with('success', 'Login Berhasil! Selamat Datang Admin.');
            }

            return redirect('/')->with('success', 'Login Berhasil! Selamat Datang.');
        }

        // login gagal (Pop-up error akan otomatis muncul karena withErrors)
        return back()->withErrors([
            'email' => 'Email or password is incorrect!'
        ])->withInput($request->only('email'));
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}