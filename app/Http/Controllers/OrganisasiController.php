<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use Illuminate\View\View;

class OrganisasiController extends Controller
{
    public function index()
    {
        $organisasis = Organisasi::with('user')->get(); //mengambil semua organisasi dengan relasi
        return view('organisasi.index', compact('organisasis'));
    }

    public function create()
    {
        $users = User::all(); //mengambil semua pengguna untuk dropdown
        return view('organisasi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'nama_organisasi' => 'required|string|max:255',
            'deskipsi' => 'required|string',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'nullable|string|max:15',
            'thn_berdiri' => 'nullable|date_format:Y',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Menyimpan logo ke storage
        $logoPath = $request->file('logo')->store('logos', 'public');

        Organisasi::create([
            'users_id' => $request->users_id,
            'nama_organisasi' => $request->nama_organisasi,
            'deskipsi' => $request->deskipsi,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'thn_berdiri' => $request->thn_berdiri,
            'logo' => $logoPath,
        ]);

        return redirect()->route('organisasi.index')->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function edit(Organisasi $organisasi)
    {
        $users = User::all(); // Mengambil semua pengguna untuk dropdown
        return view('organisasi.edit', compact('organisasi', 'users')); // Mengembalikan view untuk form edit organisasi
    }

    public function update(Request $request, Organisasi $organisasi)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'nama_organisasi' => 'required|string|max:255',
            'deskipsi' => 'required|string',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'nullable|string|max:15',
            'thn_berdiri' => 'nullable|date_format:Y',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada logo baru, hapus logo lama dan simpan logo baru
        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($organisasi->logo); // Hapus logo lama
            $logoPath = $request->file('logo')->store('logos', 'public'); // Simpan logo baru
        } else {
            $logoPath = $organisasi->logo; // Tetap menggunakan logo lama
        }

        $organisasi->update([
            'users_id' => $request->users_id,
            'nama_organisasi' => $request->nama_organisasi,
            'deskipsi' => $request->deskipsi,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'thn_berdiri' => $request->thn_berdiri,
            'logo' => $logoPath,
        ]);

        return redirect()->route('organisasi.index')->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroy(Organisasi $organisasi)
    {
        // Hapus logo dari storage
        Storage::disk('public')->delete($organisasi->logo);
        $organisasi->delete(); // Menghapus organisasi
        return redirect()->route('organisasi.index')->with('success', 'Organisasi berhasil dihapus.');
    }
}
