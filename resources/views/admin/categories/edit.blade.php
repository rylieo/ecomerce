@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card" style="background-color: #f8f9fc; border-color: #4e73df;">
            <div class="card-header" style="background-color: #4e73df; color: white;">
                <h2 class="mb-0">Edit Category</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- Custom CSS untuk memperindah form -->
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    h2 {
        font-size: 28px;
        color: white;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
    });
</script>
