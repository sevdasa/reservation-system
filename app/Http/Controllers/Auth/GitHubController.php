<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        //ToDo bug fix in without stateless
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $githubUser->getEmail()],
            [
                'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                'password' => bcrypt(str()->random(24)),
                'email_verified_at' => now(),
                'avatar' => $githubUser->getAvatar(),
                'github_id' => $githubUser->getId(),
            ]
        );

        $user->assignRole('doctor');
        Auth::login($user);

        return redirect('/dashboard'); 
    }
}
