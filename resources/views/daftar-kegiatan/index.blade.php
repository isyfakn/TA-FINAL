@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Daftar Peserta Kegiatan {{ $kegiatan->title }}</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <h6>Informasi Kegiatan:</h6>
                        <p>Tanggal: {{ date('d F Y', strtotime($kegiatan->tgl_mulai)) }}</p>
                        <p>Jumlah Pendaftar: {{ $jumlahPendaftar }} orang</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal Pendaftaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarKegiatan as $index => $daftar)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $daftar->mahasiswa->nim }}</td>
                                        <td>{{ $daftar->mahasiswa->nama_mahasiswa }}</td>
                                        <td>{{ $daftar->mahasiswa->prodi }}</td>
                                        <td>{{ date('d F Y', strtotime($daftar->tgl_daftar)) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada peserta yang terdaftar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection