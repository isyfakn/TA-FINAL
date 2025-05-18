@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Kegiatan</h1>

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

    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="organisasi_id" class="form-label"></label>
            <input type="hidden" name="organisasi_id" class="form-control" id="organisasi_id" value="{{ $organisasi_id }}" required>
            @error('organisasi_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Judul Kegiatan</label>
            <input type="text" name="title" id="title" class="form-control"  required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Deskripsi Kegiatan</label>
            <textarea name="body" id="body" class="form-control" rows="4" required></textarea>
            @error('body')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Upload Foto</label>
            <input type="file" name="foto[]" id="foto" class="form-control" accept="image/jpeg,image/png,image/gif,image/jpg" multiple>
            <small class="text-muted">poster/dokumentasi. gambar bisa lebih dari satu</small>
            @error('foto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
            @error('tgl_mulai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
            <small class="text-muted">Kosongkan jika acara hanya 1 hari.</small>
            @error('tgl_selesai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection