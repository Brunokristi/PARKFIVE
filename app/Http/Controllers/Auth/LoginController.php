<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if the email exists
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user) {
            // If email exists but password doesn't match
            if (!\Hash::check($credentials['password'], $user->password)) {
                return redirect()->back()->withErrors([
                    'password' => 'Heslo je nesprávne.',
                ])->withInput();
            }
        } else {
            // If email doesn't exist
            return redirect()->back()->withErrors([
                'email' => 'Tento email neexistuje.',
            ])->withInput();
        }

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // General fallback error
        return redirect()->back()->withErrors([
            'general' => 'Vyskytla sa chyba, skúste to znovu.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
