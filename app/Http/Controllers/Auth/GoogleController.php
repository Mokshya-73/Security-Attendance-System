<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\UserCoreData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = \App\Models\UserCoreData::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        return redirect()->route('login')->withErrors(['email' => 'Your Google email is not registered in the system.']);
    }

    Auth::login($user);

    return $this->redirectByRole($user->role_id);
}

private function redirectByRole($roleId)
{
    switch ($roleId) {
        case 1:
            return redirect()->route('admin.dashboard');
        case 2:
            return redirect()->route('company.dashboard');
        case 3:
            return redirect()->route('approverdgm.dashboard');
        case 4:
            return redirect()->route('manager.dashboard');
        case 5:
            return redirect()->route('patrol.dashboard');
        case 6:
            return redirect()->route('security.dashboard');
        default:
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Unauthorized role.']);
    }
}

}
