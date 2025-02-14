<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proposals = Proposal::with('kegiatan')->get();
        return view('proposal.index', compact('proposals'));
    }

    public function create()
    {
        $kegiatans = Kegiatan::all();
        return view('proposal.create', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'title' => 'required|string|max:255',
            'tgl_pengajuan' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file
            'keterangan' => 'nullable|string',
        ]);

        // Upload file
        $filePath = $request->file('file')->store('uploads/proposals', 'public');

        Proposal::create([
            'kegiatan_id' => $request->kegiatan_id,
            'title' => $request->title,
            'tgl_pengajuan' => $request->tgl_pengajuan,
            'file' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('proposal.index')->with('success', 'Proposal berhasil diajukan');
    }

    public function show(Proposal $proposal)
    {
        return view('proposal.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $kegiatans = Kegiatan::all();
        return view('proposal.edit', compact('proposal', 'kegiatans'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'title' => 'required|string|max:255',
            'tgl_pengajuan' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file
            'keterangan' => 'nullable|string',
        ]);

        // Update proposal
        $proposal->kegiatan_id = $request->kegiatan_id;
        $proposal->title = $request->title;
        $proposal->tgl_pengajuan = $request->tgl_pengajuan;
        $proposal->keterangan = $request->keterangan;

        // Upload file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            Storage::disk('public')->delete($proposal->file);
            $filePath = $request->file('file')->store('uploads/proposals', 'public');
            $proposal->file = $filePath;
        }

        $proposal->save();

        return redirect()->route('proposal.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    public function destroy(Proposal $proposal)
    {
        // Hapus file yang ada
        Storage::disk('public')->delete($proposal->file);
        $proposal->delete();

        return redirect()->route('proposal.index')->with('success', 'Proposal berhasil dihapus.');
    }

    public function updateStatus(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $proposal->status = $request->status;
        $proposal->save();

        return redirect()->route('proposal.index')->with('success', 'Status proposal berhasil diperbarui.');
    }
}
