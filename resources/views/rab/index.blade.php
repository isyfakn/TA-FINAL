@extends('layouts.app')

@section('content')
<div class="app-container">
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

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rencana Anggaran Biaya</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="py-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
            {{-- Search Box --}}
            <div class="search-box flex-grow-1" style="max-width: 300px;">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchBox" class="form-control form-control-sm border-start-0 ps-2" placeholder="Cari Data Pengajuan">
                </div>
            </div>
        
            @if (Auth::user()->role === 'organisasi')
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    {{-- Button Tambah --}}
                    <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#tambahRabModal">
                        <i class="fa fa-plus me-1"></i> Tambah RAB
                    </button>
        
                    {{-- Form Import --}}
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('rab.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                            @csrf
                            <div class="input-group input-group-sm" style="width: 300px;">
                                <input type="file" name="file" class="form-control form-control-md" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm px-3">
                                <i class="fa fa-upload me-1"></i> Import
                            </button>
                            <a href="{{ asset('storage/excel/template_rab_import.xlsx') }}" download="template_rab_import.xlsx" class="btn btn-primary btn-sm px-3">
                                <i class="fa fa-file me-1"></i>Template Excel
                            </a>
                        </form>
                    </div>
                </div>
            @endif
        </div>


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        @if (Auth::user()->role === 'bembpm' | Auth::user()->role === 'kemahasiswaan')
                        <th>Nama Ormawa</th>
                        @endif
                        <th>Nama Kegiatan</th>
                        <th>Rencana Anggaran</th>
                        @if (Auth::user()->role !== 'kemahasiswaan')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($rabs->isEmpty())
                        <tr>
                            <td colspan=" 5 : 4 " class="text-center">Tidak ada data</td>
                        </tr>
                    @else
                    @foreach($rabs as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if (Auth::user()->role === 'bembpm' | Auth::user()->role === 'kemahasiswaan')
                            <td>{{ $item->organisasi->nama_organisasi }}</td>
                            @endif
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>Rp {{ number_format($item->rencana_anggaran, 0, ',', '.') }}</td>
                            @if (Auth::user()->role !== 'kemahasiswaan')
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRabModal" onclick="openEditModal({{ $item->id }})"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('rab.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method ('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm('{{ route('rab.destroy', $item->id) }}')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Tambah-->
@if (Auth::user()->role === 'organisasi')
<div class="modal fade" id="tambahRabModal" tabindex="-1" aria-labelledby="tambahRabModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahRabModalLabel">Tambah RAB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    
            </div>
            <div class="modal-body">
                <form action="{{ route('rab.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="organisasi_id" class="form-label"></label>
                        <input type="hidden" name="organisasi_id" class="form-control" id="organisasi_id" value="{{ $organisasi_id }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" required>
                    </div>

                    <div class="mb-3">
                        <label for="rencana_anggaran" class="form-label">Rencana Anggaran</label>
                        <input type="text" name="rencana_anggaran" class="form-control" id="rencana_anggaran">
                        <small class="text-muted">Contoh penulisan 1000000</small>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editRabModal" tabindex="-1" aria-labelledby="editRabModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRabModalLabel">Edit RAB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($rabs->isEmpty())
                <tr>
                    <td class="text-center">Tidak ada data</td>
                </tr>
                 @else
                <form id="editRabForm" action="{{ route('rab.update', ['rab' => $item->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Gunakan method PUT untuk update -->
                    <input type="hidden" name="id" id="edit_id"> <!-- Input hidden untuk ID -->

                    <div class="mb-3">
                        <label for="edit_organisasi_id" class="form-label"></label>
                        <input type="hidden" name="organisasi_id" class="form-control" id="edit_organisasi_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" id="edit_nama_kegiatan" value="{{ $item->nama_kegiatan }}">
                    </div>

                    <div class="mb-3">
                        <label for="edit_rencana_anggaran" class="form-label">Rencana Anggaran</label>
                        <input type="text" name="rencana_anggaran" class="form-control" id="edit_rencana_anggaran" value="{{ $item->rencana_anggaran }}">
                        <small class="text-muted">Contoh penulisan 1000000</small>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id) {
    fetch(`/rab/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Isi form dengan data yang diterima
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_organisasi_id').value = data.organisasi_id;
            document.getElementById('edit_nama_kegiatan').value = data.nama_kegiatan;
            document.getElementById('edit_rencana_anggaran').value = data.rencana_anggaran;
            
            // Set action form for update
            document.getElementById('editRabForm').action = `/rab/${data.id}`;
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editRabModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endif


@endsection