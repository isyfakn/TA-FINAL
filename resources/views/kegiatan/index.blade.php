@extends('layouts.app')

@section('content')
<div class="container">
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
    <h3 class="text-center mb-4">Event</h3>

    <div class="row">
        @if($kegiatans->isEmpty())
            <div class="col-12 text-center">
                <p>Tidak ada kegiatan yang terlaksana.</p>
            </div>
        @else
            @foreach($kegiatans as $kegiatan)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . json_decode($kegiatan->foto)[0]) }}" class="card-img-top" alt="{{ $kegiatan->title }}" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h2 class="card-title text-uppercase text-center"><strong>{{ $kegiatan->title }}</strong></h2>
                            <p class="card-text">{{ \Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('d M Y') }}</p>
                            {{-- <p class="card-text">Penyelenggara: {{ $kegiatan->organisasi->nama_organisasi ?? 'Tidak Ada' }}</p> --}}
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end gap-1"> <!-- gap lebih kecil -->
                                <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="btn btn-info btn-sm px-2"> <!-- padding horizontal lebih kecil -->
                                    <i class="mdi mdi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


@endsection