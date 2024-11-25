@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <div class="card bg-light shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Pengaturan QR Code Pembayaran</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.qr.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="qr_code" class="font-weight-bold">Unggah QR Code Baru</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="qr_code" id="qr_code" required>
                        <label class="custom-file-label" for="qr_code">Pilih file...</label>
                    </div>
                    <small class="form-text text-muted">Hanya file gambar yang diperbolehkan (PNG, JPG, JPEG).</small>
                </div>

                <button type="submit" class="btn btn-success btn-block mt-4">
                    <i class="fas fa-save"></i> Simpan QR Code
                </button>
            </form>

            @if(Storage::exists('public/qr_code.png'))
                <h2 class="mt-4 text-center">QR Code Saat Ini</h2>
                <div class="text-center">
                    <img src="{{ asset('storage/qr_code.png') }}" alt="QR Code Saat Ini" class="img-fluid rounded" style="max-height: 150px;">
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom CSS untuk memperindah tampilan -->
<style>
    .card {
        transition: all 0.3s ease;
        border-radius: 15px; /* Rounded corners */
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
    }
    .btn {
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-success {
        background-color: #5b6bff;
        border: none;
    }
    .btn-success:hover {
        background-color: #0016a5; /* Warna hover untuk tombol success */
        transform: translateY(-2px);
    }
    /* Animasi fade-in untuk konten */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
    /* Gaya input file yang lebih modern */
    .custom-file-input:lang(en) ~ .custom-file-label::after {
        content: "Browse";
    }
    .custom-file-input:focus ~ .custom-file-label {
        border-color: #80bdff;
        box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
    }
    .form-text {
        margin-top: 5px;
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>

<!-- JavaScript untuk animasi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const card = document.querySelector('.card');
        card.classList.add('fade-in');

        // Menambahkan kelas "visible" setelah delay
        setTimeout(() => {
            card.classList.add('visible');
        }, 100); // Delay 100ms untuk efek

        // Update label file input saat file dipilih
        const fileInput = document.getElementById('qr_code');
        const fileLabel = document.querySelector('label[for="qr_code"]');

        fileInput.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Pilih file...';
            fileLabel.textContent = fileName;
        });
    });
</script>
@endsection
