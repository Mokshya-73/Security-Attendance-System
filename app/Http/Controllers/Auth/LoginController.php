<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // Accept email or employee_id
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Try to detect if input is email or employee_id
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_id';

        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->back()->withErrors(['login' => 'Account is inactive']);
        }

        // ✅ Link the session to user_core_data.id
        DB::table('sessions')->where('id', Session::getId())->update([
            'user_id' => $user->id,
        ]);

        return match ((int) $user->role_id) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('company.dashboard'),
            3 => redirect()->route('approverdgm.dashboard'),
            4 => redirect()->route('manager.dashboard'),
            5 => redirect()->route('patrol.dashboard'),
            6 => redirect()->route('security.dashboard'),
            default => redirect('/'),
        };
    }

        return redirect()->back()->withErrors(['login' => 'Invalid login credentials']);
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        Session::invalidate();
        Session::regenerateToken();

        // This header won’t affect the dashboard that was already cached
        return redirect()->route('login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 1990 00:00:00 GMT'
        ]);
    }

}
