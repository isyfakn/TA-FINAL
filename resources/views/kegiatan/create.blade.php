{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Kegiatan</h1>
    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="organisasi_id">Organisasi</label>
            <select name="organisasi_id" id="organisasi_id" class="form-control">
                <option value="">Pilih Organisasi</option>
                <!-- Tambahkan opsi organisasi di sini -->
            </select>
        </div>
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="body">Deskripsi</label>
            <textarea name="body" id="body" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" name="foto[]" id="foto" class="form-control" multiple>
        </div>
        <div class="form-group">
            <label for="tgl_mulai">Tanggal Mulai</label>
            <input type="datetime-local" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tgl_selesai">Tanggal Selesai</label>
            <input type="datetime-local" name="tgl_selesai" id="tgl_selesai" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection --}}