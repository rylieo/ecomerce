@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <div class="card animate-card shadow-lg p-4 rounded bg-light" style="margin-top: -50px;">
        <h1 class="mb-4 text-center">Edit Media</h1>

        <form action="{{ route('media.update', $media->id) }}" method="POST" enctype="multipart/form-data" class="animate-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $media->title }}" required>
            </div>

            <div class="mb-4">
                <label for="file" class="form-label">Upload New File (optional)</label>
                <input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png,.mp4,.gif"> <!-- Menambahkan accept untuk GIF -->
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Update</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Gaya untuk card */
    .animate-card {
        opacity: 0;
        transform: translateY(-30px);
        animation: slideIn 0.6s forwards ease-in-out;
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Gaya untuk input dan button */
    .form-control {
        border-radius: 20px;
        transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        padding: 12px 20px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        background-color: #e9f5ff;
        outline: none;
    }

    .btn-primary {
        border-radius: 20px;
        background-color: #007bff;
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        padding: 12px 0; /* Memastikan padding vertikal yang baik */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 86, 179, 0.3);
    }

    /* Styling header */
    h1 {
        font-size: 2.5rem;
        color: #343a40;
        font-weight: 700;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Gaya untuk label */
    .form-label {
        font-weight: 600;
        color: #343a40;
        transition: color 0.3s;
    }

    .form-label:hover {
        color: #007bff;
    }
</style>
@endsection
