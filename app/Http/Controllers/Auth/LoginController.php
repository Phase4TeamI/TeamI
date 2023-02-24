<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    // 初回ログイン時にユーザー情報をデータベースに保存し、以降のログインではログイン処理を行う
    public function handleGithubCallback(Request $request)
    {
        $user = Socialite::driver('github')->stateless()->user();
        $existingUser = User::where('provider_id', $user->getId())->orWhere('email', $user->getEmail())->first();

        Log::info($user->getId());

        if (!$existingUser) {
            $newUser = User::create([
                'provider_id' => $user->getId(),
                'name' => $user->getNickname(),
                'email' => $user->getEmail(),
            ]);
            $existingUser = $newUser;
        }

        Auth::login($existingUser, true);

        return redirect()->intended('/dashboard');
    }
}