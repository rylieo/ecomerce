@extends('layouts.app')  <!-- Menggunakan layout app -->

@section('content')
<div class="container text-center"> <!-- Menggunakan Bootstrap agar lebih responsif jika diperlukan -->

    @if($media->type === 'image')
        <!-- Jika media adalah gambar -->
        <img src="{{ asset('storage/' . $media->file_path) }}" alt="Media Image" style="max-width: 100%; height: auto;">

    @elseif($media->type === 'video')
        <!-- Jika media adalah video -->
        <video width="600" controls>
            <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    @endif

</div>
@endsection
