<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // tampilkan form login
    public function showLoginForm()
    {
        // kalau sudah login, langsung redirect sesuai role
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

            // redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/');
        }

        // login gagal
        return back()->withErrors([
            'email' => 'Email or password is incorrect!'
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
