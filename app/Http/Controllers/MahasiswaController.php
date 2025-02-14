<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('user')->get(); // Mengambil semua mahasiswa dengan relasi pengguna
        return view('mahasiswa.index', compact('mahasiswa')); // Mengembalikan view dengan data mahasiswa
    }

    public function create()
    {
        $users = User::all(); // Mengambil semua pengguna untuk dropdown
        return view('mahasiswa.create', compact('users')); // Mengembalikan view untuk form pembuatan mahasiswa
    }

    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'no_hp' => 'nullable|string|max:15',
            'tgl_lahir' => 'required|date',
            'prodi' => 'required|string|max:255',
            'thn_masuk' => 'required|date_format:Y',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan foto ke storage
        $fotoPath = $request->file('foto')->store('fotos', 'public');

        Mahasiswa::create([
            'users_id' => $request->users_id,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tgl_lahir' => $request->tgl_lahir,
            'prodi' => $request->prodi,
            'thn_masuk' => $request->thn_masuk,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $users = User::all(); // Mengambil semua pengguna untuk dropdown
        return view('mahasiswa.edit', compact('mahasiswa', 'users')); // Mengembalikan view untuk form edit mahasiswa
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'no_hp' => 'nullable|string|max:15',
            'tgl_lahir' => 'required|date',
            'prodi' => 'required|string|max:255',
            'thn_masuk' => 'required|date_format:Y',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada foto baru, hapus foto lama dan simpan foto baru
        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($mahasiswa->foto); // Hapus foto lama
            $fotoPath = $request->file('foto')->store('fotos', 'public'); // Simpan foto baru
        } else {
            $fotoPath = $mahasiswa->foto; // Tetap menggunakan foto lama
        }

        $mahasiswa->update([
            'users_id' => $request->users_id,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tgl_lahir' => $request->tgl_lahir,
            'prodi' => $request->prodi,
            'thn_masuk' => $request->thn_masuk,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        Storage::disk('public')->delete($mahasiswa->foto); // Hapus foto dari storage
        $mahasiswa->delete(); // Hapus mahasiswa dari database

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
