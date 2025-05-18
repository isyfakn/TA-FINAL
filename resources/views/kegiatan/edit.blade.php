@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Kegiatan</h1>

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

    <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <input type="hidden" name="organisasi_id" class="form-control" id="organisasi_id" value="{{ $kegiatan->organisasi_id }}" required>
            @error('organisasi_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Judul Kegiatan</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $kegiatan->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Deskripsi Kegiatan</label>
            <textarea name="body" id="body" class="form-control" rows="4" required>{{ old('body', $kegiatan->body) }}</textarea>
            @error('body')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Upload Foto</label>
            <input type="file" name="foto[]" id="foto" class="form-control" accept="image/jpeg,image/png,image/gif,image/jpg" multiple>
            <small class="text-muted">Poster/dokumentasi. Gambar bisa lebih dari satu.</small>
            @error('foto.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        @if($kegiatan->foto)
            <div class="mb-3">
                <label class="form-label">Foto Saat Ini</label>
                <div class="row">
                    @foreach(json_decode($kegiatan->foto) as $index => $image)
                        <div class="col-md-3 mb-2">
                            <div class="card">
                                <img src="{{ asset('storage/' . $image) }}" class="card-img-top" alt="Foto Kegiatan">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hapus_foto[]" value="{{ $index }}" id="hapus_foto_{{ $index }}">
                                        <label class="form-check-label" for="hapus_foto_{{ $index }}">
                                            Hapus foto ini
                                        </label>
                                    </div>
                                    <small class="text-muted">Centang jika foto ingin dihapus.</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ old('tgl_mulai', $kegiatan->tgl_mulai) }}" required>
            @error('tgl_mulai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" value="{{ old('tgl_selesai', $kegiatan->tgl_selesai) }}">
            <small class="text-muted">Kosongkan jika acara hanya satu hari</small>
            @error('tgl_selesai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection