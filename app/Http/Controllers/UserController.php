<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Illuminate\View\View;

class UserController extends Controller
{
    
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required',
            'terms' => 'required|accepted',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'role' => $request->role,
        ]);

        
        return redirect()->route('login')->with('succes', 'Registrasi berhasil! Silahkan Login.');
    }

    public function destroy(User $user)
    {
        $user->delete(); // Menghapus pengguna
        return redirect()->route('dashboard')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function profile() 
    {
        $user = auth()->user();
       
        
        if ($user->role === 'mahasiswa') {
            if ($user->mahasiswa) {
                return redirect()->route('mahasiswa.profile', $user->mahasiswa->id);
            } else {
                return redirect()->route('mahasiswa.create');
            }
        } elseif ($user->role === 'organisasi') {
            if ($user->organisasi) {
                return redirect()->route('organisasi.profile', $user->organisasi->id);
            } else {
                return redirect()->route('organisasi.create');
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'Gagal menuju halaman profil');
        }
    }
}
