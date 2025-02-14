<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Illuminate\View\View;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:bpm, bem, organisasi, mahasiswa',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')-with('succes', 'Pengguna berhasil ditambahkan');
    }

    public function destroy(User $user)
    {
        $user->delete(); // Menghapus pengguna
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
