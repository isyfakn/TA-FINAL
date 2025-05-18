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
            <div class="card">
                <h3 class="card-header text-center text-strong">{{ __('Lengkapi Profile Organisasi') }}</h3>

                <div class="card-body">
                    <form method="POST" action="{{ route('organisasi.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="user_id" class="form-control" id="user_id" value="{{ Auth::id() }}" required>
                        </div>
                        <!-- Input: Nama Organisasi -->
                        <div class="form-group mb-3">
                            <label for="nama_organisasi" class="form-label">{{ __('Nama Organisasi') }}</label>
                            <input type="text" name="nama_organisasi" id="nama_organisasi" class="form-control @error('nama_organisasi') is-invalid @enderror" value="{{ old('nama_organisasi') }}" required>
                            @error('nama_organisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input: Deskripsi -->
                        <div class="form-group mb-3">
                            <label for="deskipsi" class="form-label">{{ __('Deskripsi') }}</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input: Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input: Nomor Telepon -->
                        <div class="form-group mb-3">
                            <label for="no_telp" class="form-label">{{ __('Nomor Telepon') }}</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input: Tahun Berdiri -->
                        <div class="form-group mb-3">
                            <label for="thn_berdiri" class="form-label">{{ __('Tahun Berdiri') }}</label>
                            <input type="text" name="thn_berdiri" id="thn_berdiri" class="form-control @error('thn_berdiri') is-invalid @enderror" value="{{ old('thn_berdiri') }}">
                            @error('thn_berdiri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input: Logo -->
                        <div class="form-group mb-3">
                            <label for="logo" class="form-label">{{ __('Logo Organisasi') }}</label>
                            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/gif,image/jpg" class="form-control @error('logo') is-invalid @enderror" required>
                            <small class="text-muted">JPG, JPEG, PNG, GIF</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Simpan') }}
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
</div>
@endsection