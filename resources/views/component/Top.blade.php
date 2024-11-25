@extends('layouts.app')

@section('content')

    <style>
        body {
            background: #ddd;
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
            font-size: 0.8rem;
            font-weight: bold;
            padding-top: 5px;
        }
        #media-carousel {
            margin-top: 30px; /* Menambahkan margin atas untuk menggeser carousel lebih ke bawah */
            border-radius: 10px; /* Menambahkan sudut melengkung pada carousel */
            overflow: hidden; /* Memastikan gambar/video tidak keluar dari carousel */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan */
        }
        #product-section {
            margin: 2rem 0; /* Menyesuaikan margin sesuai kebutuhan */
        }
        .product-title {
            color: #2C3E50; /* Warna judul */
            font-size: 2rem; /* Ukuran judul */
            font-weight: bold; /* Ketebalan judul */
            margin-bottom: 1rem; /* Margin bawah untuk jarak dengan deskripsi */
        }
        .product-description {
            color: #34495e; /* Warna deskripsi */
            font-size: 1rem; /* Ukuran deskripsi */
            margin-bottom: 2rem; /* Margin bawah untuk jarak dengan konten berikutnya */
        }
        .carousel-item img, .carousel-item video {
            width: 100%; /* Memastikan lebar media sesuai */
            height: auto; /* Memastikan tinggi media otomatis */
            border-radius: 10px; /* Menambahkan sudut melengkung pada gambar/video */
        }
        .carousel-item {
            text-align: center; /* Menyejajarkan konten carousel di tengah */
        }
    </style>

    <div id="media-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($mediaItems as $key => $media)
                <div class="carousel-item @if($key === 0) active @endif">
                    @if($media->type === 'image' || $media->type === 'gif')
                        <img src="{{ asset('storage/' . $media->file_path) }}" alt="Media Image" class="d-block">
                    @elseif($media->type === 'video')
                        <video controls class="d-block">
                            <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <span>Tipe media tidak dikenali.</span>
                    @endif
                </div>
            @endforeach
        </div>

@endsection
