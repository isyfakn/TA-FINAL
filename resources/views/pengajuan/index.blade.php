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
                    <h1 class="m-0">List Pengajuan</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="py-4">
        <div class="d-flex align-items-center justify-content-between position-relative mb-3">
            <div class="search-box">
                <label class="position-absolute" for="searchBox">
                    <i class="fa fa-search"></i>
                </label>
                <input type="text" id="searchBox" class="form-control form-control-solid small-search" placeholder="Cari Data Pengajuan" />
            </div>
            @if (Auth::user()->role === 'organisasi')
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPengajuanModal"><i class="fa fa-plus fa-sm text-white-50"></i>
                Tambah Pengajuan
            </button>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        @if (Auth::user()->role === ['bembpm', 'kemahasiswaan'])
                        <th>Nama Ormawa</th>
                        @endif
                        <th>Nama Kegiatan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Proposal</th>
                        <th>Status Proposal</th>
                        <th>Anggaran</th>
                        <th>LPJ</th>
                        <th>Status LPJ</th>
                        <th>Keterangan</th>
                        @if (Auth::user()->role !== 'kemahasiswaan')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($pengajuans->isEmpty())
                        <tr>
                            <td colspan=" 10 : 9 " class="text-center">Tidak ada data</td>
                        </tr>
                    @else
                    @foreach($pengajuans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if (Auth::user()->role === ['bembpm', 'kemahasiswaan'])
                            <td>{{ $item->rab->organisasi->nama_organisasi }}</td>
                            @endif
                            <td>{{ $item->rab->nama_kegiatan }}</td>
                            <td>{{ $item->tgl_kegiatan }}</td>
                            <td>
                                <a href="{{ route('pengajuan.show.proposal', $item->id) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                @if($item->status_proposal == 'Approved')
                                    <button type="button" class="btn btn-outline-success btn-outline btn-sm">Disetujui</button>
                                @elseif($item->status_proposal == 'Rejected')
                                    <button type="button" class="btn btn-outline-danger btn-outline btn-sm">Ditolak</button>
                                @elseif($item->status_proposal == 'Pending')
                                    <button type="button" class="btn btn-outline-secondary btn-outline btn-sm">Pending</button>
                                @else
                                    <button style="background-color: gray; color: white;">{{ $item->status_proposal }}</button>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pengajuan.show.lpj', $item->id) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                @if($item->status_lpj == 'Approved')
                                    <button type="button" class="btn btn-outline-success btn-outline btn-sm">Disetujui</button>
                                @elseif($item->status_lpj == 'Rejected')
                                    <button type="button" class="btn btn-outline-danger btn-outline btn-sm">Ditolak</button>
                                @elseif($item->status_lpj == 'Pending')
                                    <button type="button" class="btn btn-outline-secondary btn-outline btn-sm">Pending</button>
                                @else
                                    <button style="background-color: gray; color: white;">{{ $item->status_lpj }}</button>
                                @endif
                            </td>
                            <td>{{ $item->keterangan }}</td>
                            @if (Auth::user()->role !== 'kemahasiswaan')
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPengajuanModal" onclick="openEditModal({{ $item->id }})"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method ('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm('{{ route('pengajuan.destroy', $item->id) }}')">
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

{{-- Berhasil diajuakan
    Validasi BEM
    Revisi BEM " "
    Validasi BPM
    Revisi BPM " "
--}}

<!-- Modal Tambah-->
<div class="modal fade" id="tambahPengajuanModal" tabindex="-1" aria-labelledby="tambahPengajuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPengajuanModalLabel">Tambah Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengajuan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="rab_id" class="form-label">Pilih RAB</label>
                        <select class="form-control" id="rab_select" name="rab_id" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($rabs as $rab)
                                <option value="{{ $rab->id }}" 
                                    @if(isset($pengajuan) && $pengajuan->rab_id == $rab->id) selected @endif>
                                    {{ $rab->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan">
                    </div>

                    <div class="mb-3">
                        <label for="proposal_file" class="form-label">File Proposal</label>
                        <input class="form-control" type="file" name="proposal_file" id="proposal_file" accept=".pdf,application/pdf">
                        <small class="text-muted">Format PDF</small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editPengajuanModal" tabindex="-1" aria-labelledby="editPengajuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPengajuanModalLabel">Edit Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPengajuanForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_rab_id" class="form-label"></label>
                        <input type="hidden" name="rab_id" class="form-control" id="edit_rab_id" required readonly>
                    </div>

                    @if (Auth::user()->role === 'organisasi')
                    <div class="mb-3">
                        <label for="edit_tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" name="tgl_kegiatan" class="form-control" id="edit_tgl_kegiatan">
                    </div>

                    <div class="mb-3">
                        <label for="edit_anggaran" class="form-label">Anggaran</label>
                        <input type="text" name="anggaran" class="form-control" id="edit_anggaran">
                        <small class="text-muted">Contoh penulisan 1000000</small>
                    </div>

                    <div class="mb-3">
                        <label for="edit_proposal_file" class="form-label">File Proposal</label>
                        <input class="form-control" type="file" name="proposal_file" id="edit_proposal_file" accept=".pdf,application/pdf">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file. Format PDF</small>
                        <div id="current_proposal_file" class="mt-1"></div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_lpj_file" class="form-label">File LPJ</label>
                        <input class="form-control" type="file" name="lpj_file" id="edit_lpj_file" accept=".pdf,application/pdf">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file. Format PDF</small>
                        <div id="current_lpj_file" class="mt-1"></div>
                    </div>
                    @endif

                    @if (Auth::user()->role === 'bembpm')
                    <div class="mb-3">
                        <label for="edit_status_proposal" class="form-label">Status Proposal</label>
                        <select name="status_proposal" class="form-select" id="edit_status_proposal">
                            <option value="Pending">Pending</option>
                            <option value="Approved">Disetujui</option>
                            <option value="Rejected">Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status_lpj" class="form-label">Status LPJ</label>
                        <select name="status_lpj" class="form-select" id="edit_status_lpj">
                            <option value="Pending">Pending</option>
                            <option value="Approved">Disetujui</option>
                            <option value="Rejected">Ditolak</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <select name="keterangan" id="edit_keterangan" class="form-control" onchange="toggleKeteranganInput()">
                            <option value="Validasi BEM">Validasi BEM</option>
                            <option value="Revisi BEM">Revisi BEM</option>
                            <option value="Validasi BPM">Validasi BPM</option>
                            <option value="Revisi BPM">Revisi BPM</option>
                        </select>
                        
                        <div id="keteranganTambahan" class="form-control" style="display: none;">
                            <input type="text" name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" placeholder="Masukkan keterangan di sini" />
                        </div>
                    </div>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id) {
    // First, reset the form to clear previous data
    document.getElementById('editPengajuanForm').reset();
    
    // Set up the form action URL
    document.getElementById('editPengajuanForm').action = `/pengajuan/${id}`;
    
    // Fetch the pengajuan data
    fetch(`/pengajuan/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched data:", data); // For debugging
            
            // Set form values
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_rab_id').value = data.rab_id;
            
            // Handle tanggal kegiatan
            const tglKegiatanElement = document.getElementById('edit_tgl_kegiatan');
            if (tglKegiatanElement && data.tgl_kegiatan) {
                tglKegiatanElement.value = data.tgl_kegiatan;
            } else if (data.tgl_kegiatan) {
                // If the element doesn't exist but we have a date, add a hidden input to preserve it
                const hiddenDate = document.createElement('input');
                hiddenDate.type = 'hidden';
                hiddenDate.name = 'tgl_kegiatan';
                hiddenDate.value = data.tgl_kegiatan;
                document.getElementById('editPengajuanForm').appendChild(hiddenDate);
            }
            
            // Show current file information & add hidden inputs for files
            if (data.proposal_file) {
                const currentProposalElement = document.getElementById('current_proposal_file');
                if (currentProposalElement) {
                    const filename = data.proposal_file.split('/').pop();
                    currentProposalElement.innerHTML = 
                        `<span class="text-info">File saat ini: ${filename}</span>`;
                }
                
                // Add hidden input if element doesn't exist
                if (!document.getElementById('edit_proposal_file')) {
                    const hiddenProposal = document.createElement('input');
                    hiddenProposal.type = 'hidden';
                    hiddenProposal.name = 'current_proposal_file';
                    hiddenProposal.value = data.proposal_file;
                    document.getElementById('editPengajuanForm').appendChild(hiddenProposal);
                }
            }
            
            if (data.lpj_file) {
                const currentLpjElement = document.getElementById('current_lpj_file');
                if (currentLpjElement) {
                    const filename = data.lpj_file.split('/').pop();
                    currentLpjElement.innerHTML = 
                        `<span class="text-info">File saat ini: ${filename}</span>`;
                }
                
                // Add hidden input if element doesn't exist
                if (!document.getElementById('edit_lpj_file')) {
                    const hiddenLpj = document.createElement('input');
                    hiddenLpj.type = 'hidden';
                    hiddenLpj.name = 'current_lpj_file';
                    hiddenLpj.value = data.lpj_file;
                    document.getElementById('editPengajuanForm').appendChild(hiddenLpj);
                }
            }
            
            // BEMBPM specific fields
            // Set select inputs values if they exist
            const statusProposalElement = document.getElementById('edit_status_proposal');
            if (statusProposalElement) {
                statusProposalElement.value = data.status_proposal || 'Pending';
            }
            
            const statusLpjElement = document.getElementById('edit_status_lpj');
            if (statusLpjElement) {
                statusLpjElement.value = data.status_lpj || 'Pending';
            }
            
            // Set other field values
            const anggaranElement = document.getElementById('edit_anggaran');
            if (anggaranElement) {
                anggaranElement.value = data.anggaran || '';
            }

            // Handle keterangan field
            const keteranganElement = document.getElementById('edit_keterangan');
            const keteranganTambahanElement = document.getElementById('keterangan_tambahan');
            
            if (keteranganElement && data.keterangan) {
                // Check if keterangan contains revision info
                if (data.keterangan.startsWith('Revisi BEM:')) {
                    keteranganElement.value = 'Revisi BEM';
                    if (keteranganTambahanElement) {
                        keteranganTambahanElement.value = data.keterangan.substring('Revisi BEM:'.length).trim();
                    }
                } else if (data.keterangan.startsWith('Revisi BPM:')) {
                    keteranganElement.value = 'Revisi BPM';
                    if (keteranganTambahanElement) {
                        keteranganTambahanElement.value = data.keterangan.substring('Revisi BPM:'.length).trim();
                    }
                } else {
                    // If no special format, just set the value
                    keteranganElement.value = data.keterangan;
                }
                toggleKeteranganInput();
            }

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editPengajuanModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Terjadi kesalahan saat memuat data.');
        });
    }

    function toggleKeteranganInput() {
        const selectValue = document.getElementById('edit_keterangan').value;
        const keteranganDiv = document.getElementById('keteranganTambahan');
        
        if (selectValue === 'Revisi BEM' || selectValue === 'Revisi BPM') {
            keteranganDiv.style.display = 'block';
        } else {
            keteranganDiv.style.display = 'none';
            // Reset input when hidden
            document.getElementById('keterangan_tambahan').value = '';
        }
    }
    // Run on page load to handle initial state
    document.addEventListener('DOMContentLoaded', function() {
        const keteranganElement = document.getElementById('edit_keterangan');
        if (keteranganElement) {
            toggleKeteranganInput();
        }
    });
</script>
@endsection