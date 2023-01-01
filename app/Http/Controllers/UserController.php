<?php

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function login(): RedirectResponse
    {
        return Socialite::driver('github')
            ->scopes(['read:user', 'user:email'])
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        $github_user = Socialite::driver('github')->user();

        $user = User::updateOrCreate(
            [
                'email' => $github_user->email,
            ],
            [
                'name' => $github_user->name,
                'github_id' => $github_user->id,
                'github_email' => $github_user->email,
                'github_token' => $github_user->token,
                'github_oauth_status' => true,
                'github_oauth_timestamp' => now(),
            ]
        );
        Auth::guard('web')->login($user);
        $user->createToken('github_token');
        return redirect(route('user.dashboard'));
    }

    public function dashboard(): View
    {
        return view('user.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->flash('flash-notification', 'You are now logged out!');

        return redirect(route('home'));
    }
}
