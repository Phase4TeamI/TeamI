<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback(Request $request)
    {
        $user = Socialite::driver('github')->stateless()->user();

        $existingUser = User::where('provider_id', $user->getId())->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = User::create([
                'provider_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]);

            Auth::login($newUser, true);
        }

        return redirect()->intended('/dashboard');
    }
}