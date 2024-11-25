@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Add Category</h1>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="card p-4">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save
            </button>
        </form>
    </div>
@endsection

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Add some animation to the form */
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('form');
        form.classList.add('fade-in');

        // Add 'visible' class after a delay
        setTimeout(() => {
            form.classList.add('visible');
        }, 100); // Delay 100ms for the effect
    });
</script>
