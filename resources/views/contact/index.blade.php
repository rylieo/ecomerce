@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary font-weight-bold">Contact Info</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Contact Info Button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Contact Info
        </a>
    </div>

    <!-- Contact Table -->
    @if($contacts)
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="contact-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="fade-in">
                        <td>{{ $contacts->email }}</td>
                        <td>{{ $contacts->phone }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('contacts.edit', $contacts->id) }}" class="btn btn-warning btn-sm mx-1">Edit</a>
                                <form action="{{ route('contacts.destroy', $contacts->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <p>No contact info available.</p>
    @endif
</div>

<!-- Custom CSS for Table Styling and Hover Effects -->
<style>
    .table {
        border: 1px solid #ddd;
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .btn {
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .btn-primary {
        background-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .btn-warning {
        background-color: #ffc107;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .table thead th {
        background-color: #4e73df;
        color: white;
    }
    h2 {
        font-size: 24px;
        color: #4e73df;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
    /* Row Fade-In Animation */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
    /* Row Hover Effect */
    tbody tr:hover {
        background-color: #f1f1f1;
        transition: background-color 0.3s ease;
    }
</style>

<!-- JavaScript for Animation Effect -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const row = document.querySelector('#contact-table tbody tr');
        row.classList.add('fade-in', 'visible');
    });
</script>
@endsection
