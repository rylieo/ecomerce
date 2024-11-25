@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <div class="card shadow" id="about-card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Tambah Konten About</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Gambar (opsional)</label>
                    <input type="file" name="image" class="form-control-file">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom CSS untuk memperindah form -->
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    h2 {
        font-size: 28px;
        color: #ffffff; /* Ubah warna teks judul */
    }
    .card {
        transition: transform 0.3s, box-shadow 0.3s; /* Efek transisi untuk animasi */
    }
    .card:hover {
        transform: scale(1.05); /* Membesar sedikit saat hover */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Bayangan saat hover */
    }
</style>

<!-- JavaScript untuk animasi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const card = document.getElementById('about-card');

        // Menambahkan efek animasi saat card muncul
        card.style.opacity = 0;
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = 1;
            card.style.transform = 'translateY(0)';
        }, 100);
    });
</script>
@endsection
