@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Kelola Halaman About</h1>

    <!-- Tombol tambah konten, diposisikan ke kanan -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.about.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Konten
        </a>
    </div>

    <!-- Tabel konten About -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="about-table">
            <thead class="thead-dark">
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($abouts as $about)
                    <tr>
                        <td>{{ $about->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($about->description, 100) }}</td>
                        <td class="text-center">
                            @if($about->image)
                                <img src="{{ asset('storage/' . $about->image) }}" alt="foto {{ $about->title }}" width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.about.edit', $about->id) }}" class="btn btn-warning btn-sm mx-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.about.destroy', $about->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Yakin ingin menghapus?')">
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
</div>

<!-- Custom CSS untuk memperindah tabel dan efek hover -->
<style>
    .table {
        border: 1px solid #ddd;
        background-color: #fff;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .img-thumbnail {
        border-radius: 8px;
    }
    .btn {
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .btn-primary:hover {
        background-color: #3b6ec2;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .table thead th {
        background-color: #4e73df;
        color: white;
    }
    h1 {
        font-size: 28px;
        color: #4e73df;
    }
    /* Animasi untuk tabel */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- JavaScript untuk animasi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('#about-table tbody tr');

        // Menambahkan kelas "fade-in" untuk setiap baris tabel
        rows.forEach((row, index) => {
            setTimeout(() => {
                row.classList.add('fade-in');
                row.classList.add('visible');
            }, index * 100); // Menambahkan delay untuk efek muncul
        });
    });
</script>
@endsection
