<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class KegiatanController extends Controller
{
    public function index()
    {
        $organisasis = Organisasi::all();
        $kegiatans = Kegiatan::all();
        //$kegiatans = Kegiatan::with('organisasi')->get();
        return view('kegiatan.index', compact('kegiatans', 'organisasis'));
    }

    public function create()
    {
        $user = Auth::user();
        $organisasi_id = $user->organisasi->id; // Ambil ID organisasi dari pengguna yang sedang login

        return view('kegiatan.create', compact('organisasi_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organisasi_id' => 'nullable|exists:organisasi,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'foto' => 'required|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        $kegiatan = new Kegiatan();
        $kegiatan->organisasi_id = $request->organisasi_id;
        $kegiatan->title = $request->title;
        $kegiatan->body = $request->body;
        $kegiatan->tgl_mulai = $request->tgl_mulai;
        $kegiatan->tgl_selesai = $request->tgl_selesai;

        // Upload multiple photos
        if ($request->hasFile('foto')) {
            $photos = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('uploads/kegiatan', 'public');
                $photos[] = $path;
            }
            $kegiatan->foto = json_encode($photos); // Simpan path foto sebagai JSON
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Kegiatan $kegiatan)
    {
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'organisasi_id' => 'nullable|exists:organisasi,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Make this nullable
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        $kegiatan->organisasi_id = $request->organisasi_id;
        $kegiatan->title = $request->title;
        $kegiatan->body = $request->body;
        $kegiatan->tgl_mulai = $request->tgl_mulai;
        $kegiatan->tgl_selesai = $request->tgl_selesai;

        // Handle existing photos
        if ($request->has('hapus_foto')) {
            $oldPhotos = json_decode($kegiatan->foto);
            foreach ($request->hapus_foto as $index) {
                if (isset($oldPhotos[$index])) {
                    Storage::disk('public')->delete($oldPhotos[$index]);
                    unset($oldPhotos[$index]);
                }
            }
            $kegiatan->foto = json_encode(array_values($oldPhotos)); // Re-index the array
        }

        // Upload new photos
        if ($request->hasFile('foto')) {
            $photos = json_decode($kegiatan->foto) ?? [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('uploads/foto', 'public');
                $photos[] = $path;
            }
            $kegiatan->foto = json_encode($photos); // Save paths as JSON
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.show', $kegiatan->id)->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        // Hapus foto yang ada
        $oldPhotos = json_decode($kegiatan->foto);
        if ($oldPhotos) {
            foreach ($oldPhotos as $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    
    public function getLatest()
    {
        $latestKegiatan = Kegiatan::latest()->take(2)->get();
        return response()->json($latestKegiatan);
    }
    }
