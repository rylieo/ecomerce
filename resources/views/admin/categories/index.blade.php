@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-custom mb-3">
            <i class="fas fa-plus"></i> Tambah Category
        </a>

        @if($categories->isEmpty())
            <div class="alert alert-info">No categories found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-custom btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-custom btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
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
    .custom-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .thead-dark th {
        background-color: #007bff; /* Dark background for the header */
        color: #ffffff; /* White text for the header */
        font-weight: bold;
        text-transform: uppercase;
    }

    .table-hover tbody tr:hover {
        background-color: #e0e0e0; /* Light grey on hover for table rows */
    }

    /* Styles for buttons */
    .btn-custom {
        border-radius: 8px;
        padding: 8px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff; /* Blue for the add button */
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    .btn-warning {
        background-color: #ffc107; /* Yellow for edit button */
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800; /* Darker yellow on hover */
    }

    .btn-danger {
        background-color: #dc3545; /* Red for delete button */
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333; /* Darker red on hover */
    }
</style>
