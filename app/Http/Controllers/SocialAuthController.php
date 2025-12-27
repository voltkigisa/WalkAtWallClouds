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

        $user = User::updateOrCreate(
            [
                'provider' => 'google',
                'provider_id' => $googleUser->id,
            ],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(uniqid()),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function redirectGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callbackGithub()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate(
            [
                'provider' => 'github',
                'provider_id' => $githubUser->id,
            ],
            [
                'name' => $githubUser->name ?? $githubUser->nickname,
                'email' => $githubUser->email,
                'password' => bcrypt(uniqid()),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}

