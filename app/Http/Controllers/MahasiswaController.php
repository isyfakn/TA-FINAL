<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $organisasis = Organisasi::with('user')->get(); //mengambil semua organisasi dengan relasi
        return view('dashboard', compact('organisasis'));
    }

    public function show($id)
    {
        // Fetch the organization by ID
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Pass both the organization and its activities to the view
        return view('mahasiswa.profile', compact('mahasiswa'));
    }


    public function create()
    {
        $users = Auth::user(); 
        $user_id = $users->id; 
        return view('mahasiswa.create', compact('users')); // Mengembalikan view untuk form pembuatan mahasiswa
    }

    public function store(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required|numeric',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'tgl_lahir' => 'required|date',
            'prodi' => 'required|string|max:255',
            'thn_masuk' => 'required|date_format:Y',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan foto ke storage
        $fotoPath = $request->file('foto')->store('fotos', 'public');

        Mahasiswa::create([
            'user_id' => $request->user_id,
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'email' => $request->email,
            'tgl_lahir' => $request->tgl_lahir,
            'prodi' => $request->prodi,
            'thn_masuk' => $request->thn_masuk,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswas = Mahasiswa::findOrFail($id); // Mengambil semua pengguna untuk dropdown
        return view('mahasiswa.edit', compact('mahasiswas')); // Mengembalikan view untuk form edit mahasiswa
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required|numeric',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'tgl_lahir' => 'required|date',
            'prodi' => 'required|string|max:255',
            'thn_masuk' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $mahasiswa->user_id = $request->user_id;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->email = $request->email;
        $mahasiswa->tgl_lahir = $request->tgl_lahir;
        $mahasiswa->prodi = $request->prodi;
        $mahasiswa->thn_masuk = $request->thn_masuk;


        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            // Simpan foto baru
            $mahasiswa->foto = $request->file('foto')->store('fotos', 'public');
        }

        $mahasiswa->save();
        
        return redirect()->route('mahasiswa.profile', ['id' => $mahasiswa->id])->with('success', 'Profile berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        Storage::disk('public')->delete($mahasiswa->foto); // Hapus foto dari storage
        $mahasiswa->delete(); // Hapus mahasiswa dari database

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
