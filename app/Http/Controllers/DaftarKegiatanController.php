<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Rab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DaftarKegiatanController extends Controller
{
    public function index(Kegiatan $kegiatan) 
    {
        $kegiatan->load('rab');
        $daftarKegiatan = DaftarKegiatan::where('kegiatan_id', $kegiatan->id)
            ->with('mahasiswa')
            ->orderBy('tgl_daftar', 'desc')
            ->get();

        $jumlahPendaftar = $daftarKegiatan->count();

        return view('daftar-kegiatan.index', [
            'kegiatan' => $kegiatan,
            'daftarKegiatan' => $daftarKegiatan,
            'jumlahPendaftar' => $jumlahPendaftar
        ]);
    }

    public function create($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);
        
        // Get list of mahasiswa who haven't registered for this kegiatan yet
        $registeredMahasiswaIds = DaftarKegiatan::where('kegiatan_id', $kegiatan_id)
            ->pluck('mahasiswa_id')
            ->toArray();
            
        $mahasiswa = Mahasiswa::whereNotIn('id', $registeredMahasiswaIds)
            ->orderBy('nama', 'asc')
            ->get();
            
        return view('daftar-kegiatan.create', compact('kegiatan', 'mahasiswa'));
    
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);
        
        // Check if the registration already exists
        $exists = DaftarKegiatan::where('kegiatan_id', $request->kegiatan_id)
            ->where('mahasiswa_id', $request->mahasiswa_id)
            ->exists();
            
        if ($exists) {
            return redirect()->back()->with('error', 'Mahasiswa sudah terdaftar pada kegiatan ini!');
        }
        
        // Create new registration
        $daftarKegiatan = new DaftarKegiatan();
        $daftarKegiatan->kegiatan_id = $request->kegiatan_id;
        $daftarKegiatan->mahasiswa_id = $request->mahasiswa_id;
        $daftarKegiatan->tgl_daftar = now();
        $daftarKegiatan->save();
        
        return redirect()->route('kegiatan.index', $request->kegiatan_id)
            ->with('success', 'Pendaftaran kegiatan berhasil!');
    }
}
