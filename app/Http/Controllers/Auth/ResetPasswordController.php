<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserCoreData;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.reset', compact('token')); // resources/views/auth/reset.blade.php
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user_core_data,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        UserCoreData::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
    }
}
