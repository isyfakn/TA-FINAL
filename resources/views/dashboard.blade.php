@extends('layouts.app')

@section('content')
<!-- Profile Completion Notification -->
@if(Auth::check())
    @if(Auth::user()->role === 'mahasiswa' && !Auth::user()->mahasiswa)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-alert-circle-outline me-2 fs-4"></i>
                <div>
                    <strong>Profil belum lengkap!</strong> Silakan lengkapi profil mahasiswa Anda untuk mengakses semua fitur.
                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-sm btn-warning ms-3">Lengkapi Profil</a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(Auth::user()->role === 'organisasi' && !Auth::user()->organisasi)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-alert-circle-outline me-2 fs-4"></i>
                <div>
                    <strong>Profil organisasi belum lengkap!</strong> Silakan lengkapi profil organisasi Anda untuk mengakses semua fitur.
                    <a href="{{ route('organisasi.create') }}" class="btn btn-sm btn-warning ms-3">Lengkapi Profil</a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endif

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            @if (Auth::user()->role === 'organisasi')
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('template/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Sisa Rencana Anggaran Biaya <i class="mdi mdi-cash-multiple mdi-24px float-end"></i></h4>
                        @if($remainingRab !== 0)
                            <h2 class="mb-5">Rp {{ number_format($remainingRab, 0, ',', '.') }}</h2>
                            <h6 class="card-text">Total Anggaran: Rp {{ number_format($totalOriginal, 0, ',', '.') }}</h6>
                        @else
                            <h2 class="mb-5">Belum ada RAB</h2>
                            <h6 class="card-text">Silakan tambahkan RAB terlebih dahulu</h6>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            @if (Auth::user()->role === 'bembpm')
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('template/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Sisa RAB Semua Organisasi <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i></h4>
                        @if($remainingAllRab !== 0)
                            <h2 class="mb-5">Rp {{ number_format($remainingAllRab, 0, ',', '.') }}</h2>
                            <h6 class="card-text">Total Anggaran: Rp {{ number_format($totalAllOriginal, 0, ',', '.') }}</h6>
                        @else
                            <h2 class="mb-5">Belum ada RAB</h2>
                            <h6 class="card-text">Belum ada data RAB yang tersedia</h6>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="row mt-4">
            @foreach($organisasis as $organisasi)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm" style="transition: transform 0.2s; background-color: {{ $organisasi->warna ?? '#f8f9fa' }};">
                    <img src="{{ asset('storage/' . $organisasi->logo) }}" class="card-img-top" alt="{{ $organisasi->nama_organisasi }} Logo" style="height: 150px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <a href="{{ route('organisasi.profile', $organisasi->id) }}" class="text-decoration-none text-dark">{{ $organisasi->nama_organisasi }}</a>
                        </h5>
                        <p class="card-text text-muted">{{ Str::limit($organisasi->deskripsi, 50) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="latest-posts mb-4">
    <h2>Latest Posts</h2>
    <!-- Data akan dimuat di sini secara dinamis -->
    <div id="latest-kegiatan-container" class="row">
        <!-- Konten akan diisi oleh JavaScript -->
    </div>
</div>
<script>
   function loadLatestKegiatan() {
    fetch('{{ route("kegiatan.latest") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const container = document.getElementById('latest-kegiatan-container');
            container.innerHTML = '';
            
            if (data.length === 0) {
                container.innerHTML = '<div class="col-12 text-center"><p>No activities found</p></div>';
                return;
            }
            
            data.forEach(kegiatan => {
                // Parse the JSON string for foto if it exists
                const fotoArray = kegiatan.foto ? JSON.parse(kegiatan.foto) : null;
                const fotoPath = fotoArray && fotoArray.length > 0 ? fotoArray[0] : null;
                
                const postElement = `
                    <div class="col-md-6 mb-4">
                        <div class="post card border-0 shadow-sm">
                            <div class="post-header p-3">
                                <span class="post-title h5">${kegiatan.title}</span>
                                <span class="post-meta text-muted">${formatDate(kegiatan.tgl_mulai)} • ${kegiatan.tgl_selesai ? formatDate(kegiatan.tgl_selesai) : ''}</span>
                            </div>
                            <div class="post-image">
                                <img src="${fotoPath ? '{{ asset("storage") }}/' + fotoPath : '{{ asset("images/default-image.jpg") }}'}" 
                                     alt="${kegiatan.title}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="post-content p-3">
                                <p>${kegiatan.body ? (kegiatan.body.substring(0, 100) + (kegiatan.body.length > 100 ? '...' : '')) : 'No description available'}</p>
                                <div class="text-end">
                                    <a href="{{ url('kegiatan') }}/${kegiatan.id}" class="btn btn-sm btn-info">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += postElement;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('latest-kegiatan-container').innerHTML = 
                '<div class="col-12 text-center"><p>Failed to load latest activities</p></div>';
        });
    }

    // Format date function
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    // Call the function when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadLatestKegiatan();
    });
</script>
@endsection