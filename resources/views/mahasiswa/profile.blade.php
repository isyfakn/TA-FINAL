@extends('layouts.app') <!-- Ganti 'layouts.app' dengan layout yang sesuai -->

@section('content')
<div class="container">
    <h3>Profil Mahasiswa</h3>
    
    <div class="card">
        <div class="card-header text-center text-uppercase">
            <h2>{{ $mahasiswa->nama_mahasiswa }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    @if ($mahasiswa->foto && Storage::exists('public/' . $mahasiswa->foto))
                        <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Mahasiswa" class="img-fluid" style="max-height: 300px;">
                    @else
                        <img src="{{ asset('storage/default.jpg') }}" alt="Foto Default" class="img-fluid" style="max-height: 300px;">
                    @endif
                </div>
                <div class="col-md-8">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>NIM:</strong> {{ $mahasiswa->nim }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $mahasiswa->email }}</li>
                        <li class="list-group-item"><strong>No HP:</strong> {{ $mahasiswa->no_hp ?? 'Tidak ada' }}</li>
                        <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($mahasiswa->tgl_lahir)->format('d-m-Y') }}</li>
                        <li class="list-group-item"><strong>Program Studi:</strong> {{ $mahasiswa->prodi }}</li>
                        <li class="list-group-item"><strong>Tahun Masuk:</strong> {{ $mahasiswa->thn_masuk }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer">
            @auth
                @if(Auth::id() == $mahasiswa->user_id)
            <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editMahasiswaModal"><i class="mdi mdi-pencil">Edit Profil</i></a>
                @endif
            @endauth
        </div>
    </div>
</div>

<!-- Modal Edit Mahasiswa -->
<div class="modal fade" id="editMahasiswaModal" tabindex="-1" aria-labelledby="editMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="editMahasiswaModalLabel">Edit Profil Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMahasiswaForm" action="{{ route('mahasiswa.update', ['mahasiswa' => $mahasiswa->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id" value="{{ $mahasiswa->id }}">

                    <div class="mb-3">
                        <label for="edit_user_id" class="form-label"></label>
                        <input type="hidden" name="user_id" class="form-control" id="edit_user_id" value="{{ $mahasiswa->user_id }}" required>
                    </div>

                    <!-- Nama Mahasiswa -->
                    <div class="mb-3">
                        <label for="edit_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="nama_mahasiswa" class="form-control" id="edit_nama_mahasiswa" value="{{ $mahasiswa->nama_mahasiswa }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="edit_email" value="{{ $mahasiswa->email }}" required>
                    </div>

                    
                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="edit_tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" id="edit_tgl_lahir" value="{{ $mahasiswa->tgl_lahir }}" required>
                    </div>

                    <!-- Program Studi -->
                    <div class="mb-3">
                        <label for="edit_prodi" class="form-label">Program Studi</label>
                        <select name="prodi" id="edit_prodi" class="form-control" value="{{ $mahasiswa->prodi }}" required>
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
                </div>

                    <!-- Tahun Masuk -->
                    <div class="mb-3">
                        <label for="edit_thn_masuk" class="form-label">Tahun Masuk</label>
                        <input type="text" name="thn_masuk" class="form-control" id="edit_thn_masuk" value="{{ $mahasiswa->thn_masuk }}" required>
                    </div>

                    <!-- Foto -->
                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-control" id="edit_foto">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
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
    fetch(`/mahasiswa/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Isi form dengan data yang diterima
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_user_id').value = data.user_id;
            document.getElementById('edit_nama_mahasiswa').value = data.nama_mahasiswa;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_no_hp').value = data.no_hp;
            document.getElementById('edit_tgl_lahir').value = data.tgl_lahir;
            document.getElementById('edit_prodi').value = data.prodi;
            document.getElementById('edit_thn_masuk').value = data.thn_masuk;


            // Set action form untuk update
            document.getElementById('editMahasiswaForm').action = `/mahasiswa/${data.id}`;
        })
        .catch(error => console.error('Error:', error));
}
</script>
@endsection