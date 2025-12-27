<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        $googleUser = Socialite::driver('google')->user();

        // Cek apakah user dengan email ini sudah ada
        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            // Update provider info jika user sudah ada
            $user->update([
                'provider' => 'google',
                'provider_id' => $googleUser->id,
            ]);
        } else {
            // Buat user baru jika belum ada
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(uniqid()),
                'provider' => 'google',
                'provider_id' => $googleUser->id,
                'role' => 'user',
            ]);
        }

        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Login Berhasil! Selamat Datang Admin.');
        }

        return redirect('/')->with('success', 'Login Berhasil! Selamat Datang.');
    }
}

