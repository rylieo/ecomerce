@extends('layouts.sidebar')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Kelola Produk</h1>

        <!-- Search Form -->
        <div class="d-flex mb-3">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex flex-grow-1">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari produk..." value="{{ request()->input('search') }}" style="border-radius: 25px; border: 1px solid #007bff;">
                <button type="submit" class="btn btn-primary" style="border-radius: 25px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Tombol tambah produk, diposisikan ke kiri -->
        <div class="d-flex mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-custom btn-sm">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($products->isEmpty())
            <div class="alert alert-info">Tidak ada produk ditemukan.</div>
        @else
            <div class="table-responsive animate-table">
                <table class="table table-hover table-bordered custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('images/default.png') }}"
                                         alt="{{ $product->name }}" class="img-fluid" style="height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ Str::limit($product->description, 50) }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-custom btn-sm mx-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-custom btn-sm mx-1" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

<!-- Styling CSS tambahan -->
<style>
    /* Tabel dengan border radius dan shadow */
    .custom-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background-color: #ffffff; /* Latar belakang putih untuk tabel */
    }

    /* Efek hover pada row */
    .custom-table tbody tr:hover {
        background-color: #f1f1f1;
        transform: scale(1.01);
        transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
    }

    /* Styling untuk header tabel */
    .thead-dark th {
        background-color: #007bff; /* Warna biru gelap */
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

    /* Alert yang lebih menarik */
    .alert {
        border-radius: 8px;
        background-color: #e9f7fd;
        color: #31708f;
        border: 1px solid #bce8f1;
    }

    /* Animasi muncul dari bawah */
    .animate-table {
        opacity: 0;
        transform: translateY(30px);
        animation: slideUp 0.6s forwards ease-in-out;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tombol yang lebih modern dan senada */
    .btn-custom {
        border-radius: 8px;
        padding: 8px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    /* Efek hover untuk tombol primary */
    .btn-primary.btn-custom:hover {
        background-color: #0056b3; /* Warna saat hover */
        transform: translateY(-2px); /* Mengangkat tombol sedikit */
    }

    /* Efek hover untuk tombol warning */
    .btn-warning.btn-custom {
        background-color: #ffc107; /* Warna senada */
        color: black; /* Warna teks */
    }

    .btn-warning.btn-custom:hover {
        background-color: #e0a800; /* Warna saat hover */
        transform: translateY(-2px);
    }

    /* Efek hover untuk tombol danger */
    .btn-danger.btn-custom {
        background-color: #dc3545; /* Warna senada */
        color: white; /* Warna teks */
    }

    .btn-danger.btn-custom:hover {
        background-color: #c82333; /* Warna saat hover */
        transform: translateY(-2px);
    }

    /* Gambar default untuk produk */
    img {
        border-radius: 5px; /* Sudut melengkung untuk gambar */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Search Input Styling */
    input[type="text"] {
        height: 40px; /* Adjust height */
        font-size: 16px; /* Font size */
        padding-left: 15px; /* Padding for the input */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        border: 1px solid #007bff; /* Warna border */
    }

    input[type="text"]:focus {
        border-color: #0056b3; /* Change border color on focus */
        box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Highlight shadow */
        outline: none; /* Remove default outline */
    }

    /* Button Styling */
    .btn {
        height: 40px; /* Match button height to input */
        padding: 0 20px; /* Adjust padding for the button */
    }
</style>
