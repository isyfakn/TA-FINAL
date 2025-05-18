<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengajuan;
use App\Models\Organisasi;
use App\Models\Rab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Handle case when user doesn't have organization (hanya untuk role organisasi)
        if ($user->role === 'organisasi' && !$user->organisasi) {
            return view('pengajuan.index', [
                'pengajuans' => collect(),
                'rabs' => collect(),
                'organisasi_id' => null
            ]);
        }

        if (in_array($user->role, ['bembpm', 'kemahasiswaan'])) {
            // Untuk bembpm dan kemahasiswaan, ambil semua pengajuan yang memiliki RAB
            $pengajuans = Pengajuan::whereHas('rab')
                            ->with(['rab', 'rab.organisasi']) // Tambahkan eager loading organisasi
                            ->get();
            $rabs = Rab::with('organisasi')->get(); // Tambahkan eager loading organisasi
            $organisasi_id = null;
        } else {
            // Untuk role organisasi
            $organisasi_id = $user->organisasi->id;
            $pengajuans = Pengajuan::whereHas('rab', function($query) use ($organisasi_id) {
                $query->where('organisasi_id', $organisasi_id);
            })->with('rab')->get();

            $rabs = Rab::where('organisasi_id', $organisasi_id)->get();
        }
        
        return view('pengajuan.index', compact('pengajuans', 'rabs', 'organisasi_id'));
    }

    public function create()
    {
        $user = Auth::user();
        $organisasi = $user->organisasi;
        
        if (!$organisasi) {
            return redirect()->route('pengajuan.index')
                ->with('error', 'Anda tidak memiliki organisasi terkait');
        }
        
        $rabs = Rab::where('organisasi_id', $organisasi->id)->get();
        
        return view('pengajuan.create', compact('rabs', 'organisasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rab_id' => 'required|exists:rab,id',
            'tgl_kegiatan' => 'nullable|date',
            'proposal_file' => 'nullable|file|mimes:pdf|max:2048',
            'anggaran' => 'nullable|string|max:255', 
            'lpj_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $proposalPath = null;
        if ($request->hasFile('proposal_file')) {
            $proposalPath = $request->file('proposal_file')->store('proposals', 'public');
        }
            
        $lpjPath = null;
        if ($request->hasFile('lpj_file')) {
            $lpjPath = $request->file('lpj_file')->store('lpj', 'public');
        }

        Pengajuan::create([
            'rab_id' => $request->rab_id,
            'tgl_kegiatan' => $request->tgl_kegiatan,
            'proposal_file' => $proposalPath,
            'status_proposal' => 'Pending',
            'anggaran' => $request->anggaran,
            'lpj_file' => $lpjPath,
            'status_lpj' => 'Pending',
            'keterangan' => 'Berhasil Diajukan',
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Find the Pengajuan by ID
        $pengajuan = Pengajuan::findOrFail($id);
        
        // Return view with data
        return response()->json($pengajuan);
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $rules = [
            'rab_id' => 'required|exists:rab,id',
            'tgl_kegiatan' => 'nullable|date',
            'status_proposal' => 'nullable|string|in:Pending,Approved,Rejected',
            'anggaran' => 'nullable|string|max:255', 
            'status_lpj' => 'nullable|string|in:Pending,Approved,Rejected',
            'keterangan' => 'nullable|string|max:255',
            'keterangan_tambahan' => 'nullable|string|max:255',
        ];
        
        // Add file validation rules only if files are uploaded
        if ($request->hasFile('proposal_file')) {
            $rules['proposal_file'] = 'file|mimes:pdf|max:2048';
        }
        
        if ($request->hasFile('lpj_file')) {
            $rules['lpj_file'] = 'file|mimes:pdf|max:2048';
        }
        
        $request->validate($rules);

        // Update fields that we allow the current role to update
        if ($request->has('rab_id')) {
            $pengajuan->rab_id = $request->rab_id;
        } elseif ($request->has('current_rab_id')) {
            $pengajuan->rab_id = $request->current_rab_id;
        }

        if ($request->has('tgl_kegiatan')) {
            $pengajuan->tgl_kegiatan = $request->tgl_kegiatan;
        } elseif ($request->has('current_tgl_kegiatan')) {
            $pengajuan->tgl_kegiatan = $request->current_tgl_kegiatan;
        }
        
        if ($request->has('status_proposal')) {
            $pengajuan->status_proposal = $request->status_proposal;
        } elseif ($request->has('current_status_proposal')) {
            $pengajuan->status_proposal = $request->current_status_proposal;
        }
        
        if ($request->has('anggaran')) {
            $pengajuan->anggaran = $request->anggaran;
        } elseif ($request->has('current_anggaran')) {
            $pengajuan->anggaran = $request->current_anggaran;
        }
        
        if ($request->has('status_lpj')) {
            $pengajuan->status_lpj = $request->status_lpj;
        } elseif ($request->has('current_status_lpj')) {
            $pengajuan->status_lpj = $request->current_status_lpj;
        }
        
        if ($request->has('keterangan')) {
            $keterangan = $request->keterangan;
            
            // If "Revisi BEM" or "Revisi BPM" is selected and there's additional text
            if (($keterangan === 'Revisi BEM' || $keterangan === 'Revisi BPM') && $request->filled('keterangan_tambahan')) {
                $keterangan .= ': ' . $request->keterangan_tambahan;
            }
            
            $pengajuan->keterangan = $keterangan;
        } elseif ($request->has('current_keterangan')) {
            $pengajuan->keterangan = $request->current_keterangan;
        }

        // Handle proposal file upload
        if ($request->hasFile('proposal_file')) {
            // Delete the old file if it exists
            if ($pengajuan->proposal_file) {
                Storage::disk('public')->delete($pengajuan->proposal_file);
            }

            $pengajuan->proposal_file = $request->file('proposal_file')->store('proposals', 'public');
        }
        // Use hidden field value if passed
        elseif ($request->has('current_proposal_file')) {
            $pengajuan->proposal_file = $request->current_proposal_file;
        }
        
        // Handle LPJ file upload
        if ($request->hasFile('lpj_file')) {
            // Delete the old file if it exists
            if ($pengajuan->lpj_file) {
                Storage::disk('public')->delete($pengajuan->lpj_file);
            }

            $pengajuan->lpj_file = $request->file('lpj_file')->store('lpj', 'public');
        }
        // Use hidden field value if passed
        elseif ($request->has('current_lpj_file')) {
            $pengajuan->lpj_file = $request->current_lpj_file;
        }

        $pengajuan->save();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
    }
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'rab_id' => 'required|exists:rabs,id', // Diubah dari organisasi ke rabs
    //         'nama_kegiatan' => 'required|string|max:255',
    //         'tgl_kegiatan' => 'nullable|date',
    //         'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    //         'anggaran' => 'nullable|string|max:255', // Diubah ke numeric untuk nilai uang
    //         'lpj_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    //         'keterangan' => 'nullable|string|max:500',
    //     ]);

    //     try {
    //         // Handle file uploads
    //         $filePaths = [
    //             'proposal' => $request->file('proposal_file')?->store('proposals', 'public'),
    //             'lpj' => $request->file('lpj_file')?->store('lpj', 'public')
    //         ];

    //         // Create pengajuan
    //         Pengajuan::create([
    //             'rab_id' => $validated['rab_id'],
    //             'nama_kegiatan' => $validated['nama_kegiatan'],
    //             'tgl_kegiatan' => $validated['tgl_kegiatan'],
    //             'proposal_file' => $filePaths['proposal'],
    //             'status_proposal' => 'Pending',
    //             'anggaran' => $validated['anggaran'],
    //             'lpj_file' => $filePaths['lpj'],
    //             'status_lpj' => 'Pending',
    //             'keterangan' => $validated['keterangan'],
    //         ]);


    //         return redirect()->route('pengajuan.index')
    //             ->with('success', 'Pengajuan berhasil diajukan');

    //     } catch (\Exception $e) {
    //         // Hapus file yang sudah diupload jika terjadi error
    //         if (isset($filePaths['proposal']) && Storage::disk('public')->exists($filePaths['proposal'])) {
    //             Storage::disk('public')->delete($filePaths['proposal']);
    //         }
    //         if (isset($filePaths['lpj']) && Storage::disk('public')->exists($filePaths['lpj'])) {
    //             Storage::disk('public')->delete($filePaths['lpj']);
    //         }

    //         return back()->withInput()
    //             ->with('error', 'Gagal menyimpan pengajuan: '.$e->getMessage());
    //     }
    // }

    // public function show(Pengajuan $pengajuan)
    // {
    //     return view('pengajuan.show', compact('pengajuan'));
    //     // Note: I changed 'proposal.show' to 'pengajuan.show' to match your naming conventions
    // }

    // public function edit($id)
    // {
    //     // Find the RAB by ID
    //     $pengajuan = Pengajuan::findOrFail($id);
        

    //     // Return view with data
    //     return response()->json($pengajuan);
    // }
    

    // public function update(Request $request, Pengajuan $pengajuan)
    // {
    //     $request->validate([
    //         'rab_id' => 'required|exists:rab,id',
    //         'tgl_kegiatan' => 'nullable|date',
    //         'proposal_file' => 'nullable|string',
    //         'status_proposal' => 'nullale|string|in:Pending,Approved,Rejected',
    //         'anggaran' => 'nullable|string|max:255', 
    //         'lpj_file' => 'nullable|string',
    //         'status_lpj' => 'nullable|string|in:Pending,Approved,Rejected',
    //         'keterangan' => 'nullable|string|max:255',
    //     ]);

    //     $pengajuan->rab_id = $request->rab_id;
    //     $pengajuan->tgl_kegiatan = $request->tgl_kegiatan;
    //     $pengajuan->status_proposal = $request->status_proposal;
    //     $pengajuan->anggaran = $request->anggaran;
    //     $pengajuan->status_lpj = $request->status_lpj;
    //     $pengajuan->keterangan = $request->keterangan;

    //     if ($request->hasFile('proposal_file')) {
    //         if ($pengajuan->proposal_file) {
    //             Storage::disk('public')->delete($pengajuan->proposal_file);
    //         }

    //         $pengajuan->proposal_file = $request->file('proposal_file')->store('proposals', 'public');
    //     }
    //     if ($request->hasFile('lpj_file')) {
    //         if ($pengajuan->lpj_file) {
    //             Storage::disk('public')->delete($pengajuan->lpj_file);
    //         }

    //         $pengajuan->lpj_file = $request->file('lpj_file')->store('lpj', 'public');
    //     }

    //     $pengajuan->save();

    //     return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
    // }
    // public function update(Request $request, Pengajuan $pengajuan)
    // {
    //     $user = Auth::user();
        
    //     // Load the rab relationship to check organization ownership
    //     $pengajuan->load('rab');
        
    //     // Check if user has permission to update this pengajuan
    //     if (!($user->role === 'bembpm')) {
    //         $organisasi = Organisasi::where('user_id', $user->id)->first();
    //         if (!$organisasi || $pengajuan->rab->organisasi_id !== $organisasi->id) {
    //             return response()->json(['error' => 'Unauthorized'], 403);
    //         }

    //         $validatedData = $request->validate([
    //             'rab_id' => 'required|exists:rab,id',
    //             'nama_kegiatan' => 'required|string|max:255',
    //             'tgl_kegiatan' => 'nullable|date',
    //             'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file
    //             'lpj_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi untuk file LPJ
    //         ]);

    //         // Update pengajuan
    //         $validatedData['rab_id'] = $request->rab_id;
    //         $validatedData['nama_kegiatan'] = $request->nama_kegiatan;
    //         $validatedData['tgl_kegiatan'] = $request->tgl_kegiatan;
            
    //         // Update file proposal jika ada
    //         if ($request->hasFile('proposal_file')) {
    //             // Hapus file lama jika ada
    //             if ($pengajuan->proposal_file && Storage::disk('public')->exists($pengajuan->proposal_file)) {
    //                 Storage::disk('public')->delete($pengajuan->proposal_file);
    //             }
    //             // Simpan file baru
    //             $validatedData['proposal_file'] = $request->file('proposal_file')->store('uploads/proposals', 'public');
    //         }

    //         // Update file LPJ jika ada
    //         if ($request->hasFile('lpj_file')) {
    //             // Hapus file lama jika ada
    //             if ($pengajuan->lpj_file && Storage::disk('public')->exists($pengajuan->lpj_file)) {
    //                 Storage::disk('public')->delete($pengajuan->lpj_file);
    //             }
    //             // Simpan file baru
    //             $validatedData['lpj_file'] = $request->file('lpj_file')->store('uploads/lpj', 'public');
    //         }
    //     } else {
    //         // Admin validation and updates
    //         $validatedData = $request->validate([
    //             'status_proposal' => 'string|in:Pending,Approved,Rejected',
    //             'status_lpj' => 'string|in:Pending,Approved,Rejected',
    //             'anggaran' => 'nullable|numeric',
    //             'keterangan' => 'nullable|string',
    //         ]);

    //         $validatedData['status_proposal'] = $request->status_proposal;
    //         $validatedData['status_lpj'] = $request->status_lpj;
    //         $validatedData['anggaran'] = $request->anggaran;
    //         $validatedData['keterangan'] = $request->keterangan;
    //     }

    //     $pengajuan->update($validatedData);

    //     return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
    // }
    
    
    public function destroy(Pengajuan $pengajuan)
    {
        // Hapus file yang ada
        // Storage::disk('public.proposal')->delete($pengajuan->proposal_file);
        // Storage::disk('public.lpj')->delete($pengajuan->lpj_file);
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Proposal berhasil dihapus.');
    }


    public function updateStatusProposal(Request $request, $id)
    {
        $request->validate([
            'status_proposal' => 'string',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status_proposal = $request->status_proposal;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status proposal berhasil diperbarui.');
    }

    public function updateStatusLPJ(Request $request, $id)
    {
        $request->validate([
            'status_lpj' => 'string',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status_lpj = $request->status_lpj;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status LPJ berhasil diperbarui.');
    }

    public function showProposal($id)
    {
        $pengajuans = Pengajuan::findOrFail($id);
        $filePath = storage_path('app/public/' . $pengajuans->proposal_file);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File proposal tidak ditemukan'], 404);
        }

        return response()->file($filePath);
    }

    public function showLpj($id)
    {
        $pengajuans = Pengajuan::findOrFail($id);
        $filePath = storage_path('app/public/' . $pengajuans->lpj_file);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File LPJ tidak ditemukan'], 404);
        }

        return response()->file($filePath);
    }



    
}
