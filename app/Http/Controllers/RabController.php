<?php

namespace App\Http\Controllers;

use App\Models\Rab;
use App\Models\Organisasi;
use App\Imports\RabImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class RabController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'bembpm' | $user->role === 'kemahasiswaan') {
            // Untuk bembpm, tampilkan semua data RAB beserta organisasinya
            $rabs = Rab::with('organisasi')->get();
            $organisasi_id = null; // Tidak perlu organisasi_id untuk bembpm
        } else {
            // Untuk role lainnya (organisasi)
            $organisasis = Organisasi::where('user_id', $user->id)->first();

            if (!$organisasis) {
                return view('rab.index', ['rabs' => collect(), 'organisasi_id' => null]);
            }

            $rabs = Rab::where('organisasi_id', $organisasis->id)->get();
            $organisasi_id = $organisasis->id;
        }

        return view('rab.index', compact('rabs', 'organisasi_id'));
    }

    public function create()
    {
        $user = Auth::user();
        $organisasi_id = $user->organisasi->id; // Ambil ID organisasi dari pengguna yang sedang login

        return view('rab.create', compact('organisasi_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organisasi_id' => 'required|exists:organisasi,id',
            'nama_kegiatan' => 'required|string|max:255',
            'rencana_anggaran' => 'required|string|max:255',
        ]);

        Rab::create([
            'organisasi_id' => $request->organisasi_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'rencana_anggaran' => $request->rencana_anggaran,
        ]);

        return redirect()->route('rab.index')->with('success', 'Rencana Anggaran Biaya berhasil dibuat');
    }

    public function edit($id)
    {
        // Find the RAB by ID
        $rabs = Rab::findOrFail($id);
        

        // Return view with data
        return response()->json($rabs);
    }

    public function update(Request $request, $id)
    {
        // Find the RAB
        $rab = Rab::findOrFail($id);

        // Validate the request data
        $request->validate([
            'organisasi_id' => 'required|exists:organisasi,id',
            'nama_kegiatan' => 'required|string|max:255',
            'rencana_anggaran' => 'required|string|max:255',
        ]);

        // Update the RAB
        $rab->organisasi_id = $request->organisasi_id;
        $rab->nama_kegiatan = $request->nama_kegiatan;
        $rab->rencana_anggaran = $request->rencana_anggaran;

        $rab->save();

        // Return response
        return redirect()->route('rab.index')
            ->with('success', 'Rencana Anggaran Biaya berhasil diperbarui.');
    }

    public function destroy(Rab $rab)
    {
        $rab->delete();

        return redirect()->route('rab.index')->with('success', 'RAB berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $organisasi = Organisasi::where('user_id', Auth::id())->first();

        if (!$organisasi) {
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan.');
        }

        try {
            Excel::import(new RabImport($organisasi->id), $request->file('file'));
            return redirect()->back()->with('success', 'Data RAB berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
    }
}
