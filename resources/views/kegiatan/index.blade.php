@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Kegiatan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul Kegiatan</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kegiatans as $keg)
                                <tr>
                                    <td>{{ $keg->id }}</td>
                                    <td>{{ $keg->title }}</td>
                                    <td>{{ $keg->body }}</td>
                                    <td><img src="{{ asset('path/to/images/' . $keg->foto) }}" alt="Foto Kegiatan" style="width: 100px;"></td>
                                    <td>{{ $keg->tgl_mulai }}</td>
                                    <td>{{ $keg->tgl_selesai }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection