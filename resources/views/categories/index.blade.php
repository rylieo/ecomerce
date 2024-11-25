@extends('layouts.sidebar')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container mt-4">
    <h1 class="mb-4 text-dark">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-custom mb-3">
        <i class="fas fa-plus"></i> Add New Category
    </a>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="alert alert-warning shadow-sm">No categories found.</div>
    @else
        <div class="table-responsive animate-table">
            <table class="table table-hover table-bordered custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Color</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="color-box" style="background-color: {{ $category->color }};"></div>
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm btn-custom">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-custom" onclick="return confirm('Are you sure you want to delete this category?');">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

<style>
    /* Table Styling */
    .custom-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .custom-table th, .custom-table td {
        font-size: 16px;
        padding: 15px;
    }
    .thead-dark th {
        background-color: #007bff; /* Blue color for the table header */
        color: #fff; /* White text color for contrast */
        font-weight: bold;
        text-transform: uppercase;
        border: none;
    }
    .custom-table tbody tr:hover {
        background-color: #e0f7fa; /* Light blue hover effect */
        transform: scale(1.02);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    /* Button Styling */
    .btn-custom {
        border-radius: 30px;
        padding: 8px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    .btn-primary {
        background-color: #007bff; /* Bright primary color */
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }
    .btn-primary:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(0, 86, 179, 0.3);
    }
    .btn-warning {
        background-color: #f39c12; /* Vibrant orange */
        color: #212529;
        box-shadow: 0 4px 8px rgba(243, 156, 18, 0.3);
    }
    .btn-warning:hover {
        background-color: #e67e22; /* Darker orange on hover */
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(231, 111, 45, 0.3);
    }
    .btn-danger {
        background-color: #c0392b; /* Strong red */
        color: #fff;
        box-shadow: 0 4px 8px rgba(192, 57, 43, 0.3);
    }
    .btn-danger:hover {
        background-color: #a93226; /* Darker red on hover */
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(186, 47, 39, 0.3);
    }

    /* Alert Styling */
    .alert {
        border-radius: 10px;
        padding: 12px 20px;
        font-size: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    /* Animation and Color Box */
    .animate-table {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s forwards ease-in-out;
    }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .color-box {
        width: 50px;
        height: 20px;
        border-radius: 4px;
        border: 1px solid #bdc3c7; /* Light border for better visibility */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
