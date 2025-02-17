<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|emial',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            switch ($user->role) {
                case User::ROLE_BPM:
                    return redirect()->route('bpm.dashboard');
                case User::ROLE_BEM:
                    return redirect()->route('bem.dashboard');
                case User::ROLE_ORGANISASI:
                    return redirect()->route('organisasi.dashboard');
                case User::ROLE_MAHASISWA:
                    return redirect()->route('mahasiswa.dashboard');
                default:
                    return redirect()->route('home');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}