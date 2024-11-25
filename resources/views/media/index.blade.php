@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <h1 class="my-4">Media List</h1>
    <div class="mb-4">
        <a href="{{ route('media.create') }}" class="btn btn-success">Create New Media</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($mediaItems->isEmpty())
        <div class="alert alert-warning">Tidak ada media tersedia.</div>
    @else
    <div class="row">
        @foreach ($mediaItems as $media)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-light animate-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $media->title }}</h5>
                        <div class="media-container">
                            @if ($media->type === 'image' || $media->type === 'gif')
                                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}" class="img-fluid media-image">
                            @elseif ($media->type === 'video')
                                <video class="img-fluid media-video" controls>
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <span>Tipe media tidak dikenali.</span>
                            @endif
                        </div>
                        <a class="btn btn-primary mt-3" href="{{ route('media.edit', $media->id) }}">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>

@section('scripts')
    <style>
        /* Animasi saat hover pada gambar/video */
        .media-container {
            overflow: hidden; /* Menjaga konten agar tidak meluap */
            position: relative; /* Mengatur posisi relatif untuk animasi */
        }

        .media-image, .media-video {
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Menambahkan efek transisi */
            border-radius: 8px; /* Membuat sudut gambar/video melengkung */
        }

        .media-image:hover, .media-video:hover {
            transform: scale(1.05); /* Efek zoom */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Menambahkan bayangan saat hover */
        }

        .animate-card {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s forwards ease-in-out; /* Animasi muncul */
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling untuk tabel */
        .custom-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Efek hover pada row */
        .custom-table tbody tr:hover {
            background-color: #f5f5f5;
            transform: scale(1.01);
            transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        /* Styling untuk header tabel */
        .thead-dark th {
            background-color: #343a40;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Styling border */
        .custom-table, .custom-table th, .custom-table td {
            border: 1px solid #dee2e6;
        }

        /* Styling untuk font */
        .custom-table th, .custom-table td {
            font-size: 16px;
            padding: 15px;
        }

        /* Gaya select dropdown */
        .form-control {
            border-radius: 8px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-control:hover {
            border-color: #007bff;
        }

        /* Alert yang lebih menarik */
        .alert {
            border-radius: 8px;
            background-color: #e9f7fd;
            color: #31708f;
            border: 1px solid #bce8f1;
        }
    </style>
@endsection
@endsection
