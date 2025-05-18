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
        <h3 class="card-header text-center text-strong">{{ __('Lengkapi Profile Mahasiswa') }}</h3>

        <div class="card-body">
            <form method="POST" action="{{ route('mahasiswa.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="user_id" class="form-control" id="user_id" value="{{ Auth::id() }}" required>
                </div>
                
                <!-- Input: NIM -->
                <div class="form-group mb-3">
                    <label for="nim" class="form-label">{{ __('NIM') }}</label>
                    <input type="number" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input: Nama Mahasiswa -->
                <div class="form-group mb-3">
                    <label for="nama_mahasiswa" class="form-label">{{ __('Nama Mahasiswa') }}</label>
                    <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control @error('nama_mahasiswa') is-invalid @enderror" value="{{ old('nama_mahasiswa') }}" required>
                    @error('nama_mahasiswa')
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

                <!-- Input: Tanggal Lahir -->
                <div class="form-group mb-3">
                    <label for="tgl_lahir" class="form-label">{{ __('Tanggal Lahir') }}</label>
                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir') }}" required>
                    @error('tgl_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input: Program Studi -->
                <div class="form-group mb-3">
                    <label for="prodi" class="form-label">{{ __('Program Studi') }}</label>
                    <select name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
                        <option value="" disabled selected>{{ __('Pilih Program Studi') }}</option>
                        <option value="D3 Teknik Komputer" {{ old('prodi') == 'D3 Teknik Komputer' ? 'selected' : '' }}>D3 Teknik Komputer</option>
                        <option value="D3 Teknik Mesin" {{ old('prodi') == 'D3 Teknik Mesin' ? 'selected' : '' }}>D3 Teknik Mesin</option>
                        <option value="D3 Teknik Elektronika" {{ old('prodi') == 'D3 Teknik Elektronika' ? 'selected' : '' }}>D3 Teknik Elektronika</option>
                        <option value="D3 Desain Komunikasi Visual" {{ old('prodi') == 'D3 Desain Komunikasi Visual' ? 'selected' : '' }}>D3 Desain Komunikasi Visual</option>
                        <option value="D3 Akuntansi" {{ old('prodi') == 'D3 Akuntansi' ? 'selected' : '' }}>D3 Akuntansi</option>
                        <option value="D3 Perhotelan" {{ old('prodi') == 'D3 Perhotelan' ? 'selected' : '' }}>D3 Perhotelan</option>
                        <option value="D3 Farmasi" {{ old('prodi') == 'D3 Farmasi' ? 'selected' : '' }}>D3 Farmasi</option>
                        <option value="D3 Kebidanan" {{ old('prodi') == 'D3 Kebidanan' ? 'selected' : '' }}>D3 Kebidanan</option>
                        <option value="D3 Keperawatan" {{ old('prodi') == 'D3 Keperawatan' ? 'selected' : '' }}>D3 Keperawatan</option>
                        <option value="D4 Akuntansi Sektor Publik" {{ old('prodi') == 'D4 Akuntansi Sektor Publik' ? 'selected' : '' }}>D4 Akuntansi Sektor Publik</option>
                        <option value="D4 Teknik Informatika" {{ old('prodi') == 'D4 Teknik Informatika' ? 'selected' : '' }}>D4 Teknik Informatika</option>
                    </select>
                    @error('prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input: Tahun Masuk -->
                <div class="form-group mb-3">
                    <label for="thn_masuk" class="form-label">{{ __('Tahun Masuk') }}</label>
                    <input type="text" name="thn_masuk" id="thn_masuk" class="form-control @error('thn_masuk') is-invalid @enderror" value="{{ old('thn_masuk') }}" required>
                    @error('thn_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input: Foto -->
                <div class="form-group mb-3">
                    <label for="foto" class="form-label">{{ __('Foto Mahasiswa') }}</label>
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/gif,image/jpg" class="form-control @error('foto') is-invalid @enderror" required>
                    <small class="text-muted">JPG, JPEG, PNG, GIF</small>
                    @error('foto')
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