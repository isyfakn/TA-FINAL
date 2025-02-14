{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $kegiatan->title }}</h1>
    <p>{{ $kegiatan->body }}</p>
    <p>Mulai: {{ $kegiatan->tgl_mulai }}</p>
    <p>Selesai: {{ $kegiatan->tgl_selesai }}</p>
    <h3>Foto:</h3>
    @if($kegiatan->foto)
        @foreach(json_decode($kegiatan->foto) as $foto)
            <img src="{{ asset('storage/' . $foto) }}" alt="Foto Kegiatan" style="width: 200px; height: auto;">
        @endforeach
    @endif
</div>
@endsection --}}