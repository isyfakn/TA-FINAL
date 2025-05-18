<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use App\Models\User;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
//use Illuminate\View\View;

class OrganisasiController extends Controller
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

    public function create()
    {
        $users = Auth::user(); //mengambil semua pengguna untuk dropdown
        $user_id = $users->id;
        return view('organisasi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_organisasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'nullable|string|max:15',
            'thn_berdiri' => 'nullable|numeric',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Menyimpan logo ke storage
        $logoPath = $request->file('logo')->store('uploads/logos', 'public');

        Organisasi::create([
            'user_id' => $request->user_id,
            'nama_organisasi' => $request->nama_organisasi,
            'deskripsi' => $request->deskripsi,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'thn_berdiri' => $request->thn_berdiri,
            'logo' => $logoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $organisasis = Organisasi::findOrFail($id);
        
        // Since you're using fetch in your JavaScript to get JSON data
        // we need to return JSON instead of a view
        if(request()->ajax()) {
            return response()->json($organisasis);
        }
        
        // Keep this for non-AJAX requests
        return view('organisasi.edit', compact('organisasis'));
    }

    public function update(Request $request, Organisasi $organisasi)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_organisasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'nullable|string|max:15',
            'thn_berdiri' => 'nullable|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $organisasi->user_id = $request->user_id;
        $organisasi->nama_organisasi = $request->nama_organisasi;
        $organisasi->deskripsi = $request->deskripsi;
        $organisasi->email = $request->email;
        $organisasi->no_telp = $request->no_telp;
        $organisasi->thn_berdiri = $request->thn_berdiri;

        // Jika ada logo baru, hapus logo lama dan simpan logo baru
        if ($request->hasFile('logo')) {
            // Hapus foto lama jika ada
            if ($organisasi->logo) {
                Storage::disk('public')->delete($organisasi->logo);
            }
            // Simpan foto baru
            $organisasi->logo = $request->file('logo')->store('uploads/logos', 'public');
        }

        $organisasi->save();

        return redirect()->route('organisasi.profile', ['id' => $organisasi->id])->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroy(Organisasi $organisasi)
    {
        // Hapus logo dari storage
        Storage::disk('public')->delete($organisasi->logo);
        $organisasi->delete(); // Menghapus organisasi
        return redirect()->route('organisasi.index')->with('success', 'Organisasi berhasil dihapus.');
    }

    public function show($id)
    {
        // Fetch the organization by ID
        $organisasis = Organisasi::findOrFail($id);

        // Fetch the activities associated with the organization
        $kegiatans = Kegiatan::where('organisasi_id', $id)->get(); // Adjust based on your relationship

        // Pass both the organization and its activities to the view
        return view('organisasi.profile', compact('organisasis', 'kegiatans'));
    }


}
