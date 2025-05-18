@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Profil Ormawa</h3>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif

    <!-- Organization Profile Section -->
    <div class="card mb-4">
        <div class="card-header text-center">
            <img src="{{ asset('storage/' . $organisasis->logo) }}" alt="{{ $organisasis->nama_organisasi }} Logo" class="img-fluid rounded-circle" style="max-height: 150px;">
            <h3 class="mt-3">{{ $organisasis->nama_organisasi }}</h3>
        </div>
        <div class="card-body">
            <p>{{ $organisasis->deskripsi }}</p>
            <p><strong>Since:</strong> {{ $organisasis->thn_berdiri }}</p>
            <p><strong>Kontak:</strong> {{ $organisasis->no_telp }}</p>
            <p><strong>Email:</strong> {{ $organisasis->email }}</p>
        </div>
        <div class="card-footer ">
            @auth
                @if(Auth::id() == $organisasis->user_id)
                    <a href="{{ route('organisasi.edit', $organisasis->id) }}" class="btn btn-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#editOrganisasiModal"><i class="mdi mdi-pencil">Edit Profil</i></a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Activities Section -->
    <h2 class="text-center mb-4">Kegiatan Terlaksana</h2>
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
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    {{-- <div class="row">
        @if($kegiatans->isEmpty())
            <div class="col-12 text-center">
                <p>Tidak ada kegiatan yang terlaksana.</p>
            </div>
        @else
            @foreach($kegiatans as $kegiatan)
                <div class="col-md-4 mb-4">
                    <div class="card h-80">
                        <div class="card-body">
                            <h5 class="card-title">{{ $kegiatan->title }}</h5>
                            <p><strong>Tanggal:</strong> {{ $kegiatan->tgl_mulai }}</p>
                        </div>
                        <div class="card-footer">
                        <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div> --}}
</div>

<!-- Modal Edit Organisasi -->
<div class="modal fade" id="editOrganisasiModal" tabindex="-1" aria-labelledby="editOrganisasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrganisasiModalLabel">Edit Profil Organisasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrganisasiForm" action="{{ route('organisasi.update', ['organisasi' => $organisasis->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $organisasis->user_id }}">

                    <!-- Nama Organisasi -->
                    <div class="mb-3">
                        <label for="edit_nama_organisasi" class="form-label">Nama Organisasi</label>
                        <input type="text" name="nama_organisasi" class="form-control" id="edit_nama_organisasi" value="{{ $organisasis->nama_organisasi }}" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="edit_deskripsi" rows="3" required>{{ $organisasis->deskripsi }}</textarea>
                    </div>

                    <!-- Tahun Berdiri -->
                    <div class="mb-3">
                        <label for="edit_thn_berdiri" class="form-label">Tahun Berdiri</label>
                        <input type="text" name="thn_berdiri" class="form-control" id="edit_thn_berdiri" value="{{ $organisasis->thn_berdiri }}" required>
                    </div>

                    <!-- No Telepon -->
                    <div class="mb-3">
                        <label for="edit_no_telp" class="form-label">No Telepon</label>
                        <input type="text" name="no_telp" class="form-control" id="edit_no_telp" value="{{ $organisasis->no_telp }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="edit_email" value="{{ $organisasis->email }}" required>
                    </div>

                    <!-- Logo -->
                    <div class="mb-3">
                        <label for="edit_logo" class="form-label" accept="image/jpeg,image/png,image/gif,image/jpg">Logo</label>
                        <input type="file" name="logo" class="form-control" id="edit_logo">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo.</small>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id) {
    fetch(`/organisasi/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Isi form dengan data yang diterima
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama_organisasi').value = data.nama_organisasi;
            document.getElementById('edit_deskripsi').value = data.deskripsi;
            document.getElementById('edit_thn_berdiri').value = data.thn_berdiri;
            document.getElementById('edit_no_telp').value = data.no_telp;
            document.getElementById('edit_email').value = data.email;

            // Set action form for update
            document.getElementById('editOrganisasiForm').action = `/organisasi/${data.id}`;
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editOrganisasiModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection