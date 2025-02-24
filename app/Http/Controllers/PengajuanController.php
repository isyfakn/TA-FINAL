<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pengajuans = Pengajuan::with('organisasi')->get();
        return view('pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $organisasis = Organisasi::all();
        return view('pengajuan.create', compact('organisasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organisasi_id' => 'required|exists:organisasi,id',
            'nama_kegiatan' => 'required|string|max:255',
            'tgl_kegiatan' => 'nullable|date',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'anggaran' => 'nullable|string|max:255',
            'lpj_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $proposalFilePath = null;
        if ($request->hasFile('proposal_file')) {
            $proposalFilePath = $request->file('proposal_file')->store('uploads/proposal', 'public');
        }
        // Upload file LPJ jika ada
        $lpjFilePath = null;
        if ($request->hasFile('lpj_file')) {
            $lpjFilePath = $request->file('lpj_file')->store('uploads/lpj', 'public');
        }
        Pengajuan::create([
            'organisasi_id' => $request->organisasi_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tgl_kegiatan' => $request->tgl_kegiatan,
            'proposal_file' => $proposalFilePath,
            'status_proposal' => 'Pending', // Status default
            'anggaran' => $request->anggaran,
            'lpj_file' => $lpjFilePath,
            'status_lpj' => 'Pending', // Status default
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diajukan');
    }

    public function show(Pengajuan $pengajuan)
    {
        return view('proposal.show', compact('pengajuan'));
    }

    public function edit(Pengajuan $pengajuan)
    {
        $organisasis = Organisasi::all(); // Ambil data organisasi
        return view('proposal.edit', compact('pengajuan', 'organisasis'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'organisasi_id' => 'required|exists:organisasi,id',
            'nama_kegiatan' => 'required|string|max:255',
            'tgl_kegiatan' => 'nullable|date',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file
            'anggaran' => 'nullable|string|max:255',
            'lpj_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file LPJ
            'keterangan' => 'nullable|string',
        ]);

        // Update pengajuan
        $pengajuan->organisasi_id = $request->organisasi_id;
        $pengajuan->nama_kegiatan = $request->nama_kegiatan;
        $pengajuan->tgl_kegiatan = $request->tgl_kegiatan;
        $pengajuan->anggaran = $request->anggaran;
        $pengajuan->keterangan = $request->keterangan;

        // Upload file proposal jika ada
        if ($request->hasFile('proposal_file')) {
            // Hapus file lama jika ada
            Storage::disk('public')->delete($pengajuan->proposal_file);
            $proposalFilePath = $request->file('proposal_file')->store('uploads/proposals', 'public');
            $pengajuan->proposal_file = $proposalFilePath;
        }
        // Upload file LPJ jika ada
        if ($request->hasFile('lpj_file')) {
            // Hapus file lama jika ada
            Storage ::disk('public')->delete($pengajuan->lpj_file);
            $lpjFilePath = $request->file('lpj_file')->store('uploads/lpj', 'public');
            $pengajuan->lpj_file = $lpjFilePath;
        }

        $pengajuan->save();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        // Hapus file yang ada
        Storage::disk('public')->delete($pengajuan->proposal_file);
        Storage::disk('public')->delete($pengajuan->lpj_file);
        $pengajuan->delete();

        return redirect()->route('proposal.index')->with('success', 'Proposal berhasil dihapus.');
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status_proposal' => 'required|in:Pending,Approved,Rejected',
        ]);

        $pengajuan->status_proposal = $request->status_proposal;
        $pengajuan->save();

        return redirect()->route('proposal.index')->with('success', 'Status proposal berhasil diperbarui.');
    }
}
