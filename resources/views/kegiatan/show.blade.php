@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-md">
                <div class="card-body">
                    <h1 class="card-header fw-bold text-uppercase">{{ $kegiatan->title }}</h1>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <p class="fw-bold mb-1">Tanggal Pelaksanaan</p>
                            <p>
                                {{ \Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('d F Y') }}
                                {{ $kegiatan->tgl_selesai ? '- ' . \Carbon\Carbon::parse($kegiatan->tgl_selesai)->format('d F Y') : '' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fw-bold mb-1">Deskripsi Kegiatan</p>
                            <p>{!! nl2br(e($kegiatan->body)) !!}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        @auth
                            @if (Auth::user()->role === 'organisasi' && Auth::user()->organisasi->id == $kegiatan->organisasi_id)
                                <a href="{{ route('daftar-kegiatan.index', $kegiatan) }}" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-account-group">Daftar Peserta</i> 
                                </a>
                                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning btn-sm">
                                    <i class="mdi mdi-pencil">Edit Kegiatan</i>
                                </a>
                                <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm('{{ route('kegiatan.destroy', $kegiatan->id) }}')">
                                        <i class="mdi mdi-delete">Hapus Kegiatan</i> 
                                    </button>
                                </form>
                            @endif
                        @endauth
                        @if (Auth::user()->role === 'mahasiswa')
                            @php
                                $today = \Carbon\Carbon::now();
                                $startDate = \Carbon\Carbon::parse($kegiatan->tgl_mulai);
                            @endphp

                            @if ($today->lte($startDate))
                                <form id="registrationForm" action="{{ route('daftar-kegiatan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                    <input type="hidden" name="mahasiswa_id" value="{{ Auth::user()->mahasiswa->id }}">
                                    
                                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                        Daftar Kegiatan
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-warning mt-2">
                                    Pendaftaran telah ditutup karena kegiatan telah dimulai atau selesai.
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($kegiatan->foto && count(json_decode($kegiatan->foto)) > 0)
    <div class="row">
        <div class="col-12">
            <h5 class="mb-3 text-uppercase">DOKUMENTASI</h5>
            
            <div class="row">
                @foreach(json_decode($kegiatan->foto) as $index => $foto)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $foto) }}" class="card-img-top" alt="Foto Kegiatan" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#fotoModal{{ $index }}">
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk foto -->
                <div class="modal fade" id="fotoModal{{ $index }}" tabindex="-1" aria-labelledby="fotoModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="fotoModalLabel{{ $index }}">{{ $kegiatan->title }} - Foto {{ $index + 1 }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $foto) }}" class="img-fluid" alt="Foto Kegiatan">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>



<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mendaftar pada kegiatan <strong>{{ $kegiatan->title }}</strong>?</p>
                <p>Tanggal kegiatan: {{ date('d F Y', strtotime($kegiatan->tgl_mulai)) }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmRegistration">Ya, Saya Yakin</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('confirmRegistration').addEventListener('click', function() {
            document.getElementById('registrationForm').submit();
        });
    });
</script>
@endsection
@push('styles')
<style>
    h2, h5 {
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card {
        border-radius: 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>
@endpush