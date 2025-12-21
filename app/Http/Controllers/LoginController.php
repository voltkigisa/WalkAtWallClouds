<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //login user
        if (Auth::attempt($request->only('email', 'password'))) {
            //login berhasil
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        //login gagal
        return back()->withErrors([
            'email' => 'Email or password is incorrect!'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}