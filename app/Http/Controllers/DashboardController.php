<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use App\Models\Rab;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $organisasis = Organisasi::all();
        $user = auth()->user();
        $organisasi = Organisasi::where('user_id', $user->id)->first();
        
        // Initialize variables
        $remainingRab = 0;
        $totalOriginal = 0;
        $remainingAllRab = 0;
        $totalAllOriginal = 0;
        
        if ($organisasi) {
            $rabs = Rab::where('organisasi_id', $organisasi->id)->get();
            
            $totalUsed = 0;
            $totalOriginal = 0;
            
            foreach ($rabs as $rab) {
                $totalOriginal += $rab->rencana_anggaran;
                $usedBudget = Pengajuan::where('rab_id', $rab->id)->sum('anggaran');
                $totalUsed += $usedBudget;
            }
            
            $remainingRab = $totalOriginal - $totalUsed;
        }
        
        if ($user->role === 'bembpm') {
            $totalAllOriginal = Rab::sum('rencana_anggaran');
            $totalAllUsed = Pengajuan::sum('anggaran');
            $remainingAllRab = $totalAllOriginal - $totalAllUsed;
        }
        
        return view('dashboard', compact(
            'organisasis',
            'remainingRab',
            'remainingAllRab',
            'totalOriginal',
            'totalAllOriginal'
        ));
    }
    // public function index()
    // {
    //     // Fetch all organizations
    //     $organisasis = Organisasi::all(); // You can modify this to filter based on user roles if needed

    //     return view('dashboard', compact('organisasis'));
    // }
}
