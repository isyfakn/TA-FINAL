<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'organisasi_id' => 'nullable|exists:organisasi,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
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
                $path = $file->store('uploads/foto', 'public');
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
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $kegiatan->organisasi_id = $request->organisasi_id;
        $kegiatan->title = $request->title;
        $kegiatan->body = $request->body;
        $kegiatan->tgl_mulai = $request->tgl_mulai;
        $kegiatan->tgl_selesai = $request->tgl_selesai;

        // Upload multiple photos
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            $oldPhotos = json_decode($kegiatan->foto);
            if ($oldPhotos) {
                foreach ($oldPhotos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $photos = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('uploads/foto', 'public');
                $photos[] = $path;
            }
            $kegiatan->foto = json_encode($photos); // Simpan path foto sebagai JSON
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
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
}
