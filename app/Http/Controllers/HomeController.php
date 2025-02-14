<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function bpmDashboard()
    {
        return view('bpm.dashboard');
    }

    public function bemDashboard()
    {
        return view('bem.dashboard');
    }

    public function organisasiDashboard()
    {
        return view('organisasi.dashboard');
    }

    public function mahasiswaDashboard()
    {
        return view('mahasiswa.dashboard');
    }
}
