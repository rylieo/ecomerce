@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary font-weight-bold">Daftar Admin</h1>

    <!-- Tombol tambah admin, diposisikan ke kanan -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.users.showAddAdminForm') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Admin
        </a>
    </div>

    <!-- Tabel Admin -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="admin-table">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('admin.users.removeAdmin', $admin->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Yakin ingin menghapus admin ini?')">
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
        background-color: #ffffff;
        border-radius: 10px; /* Rounded corners for the table */
        overflow: hidden; /* Rounded corners effect */
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .btn-primary {
        background-color: #007bff; /* Primary color */
    }
    .btn-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
    .btn-danger {
        background-color: #dc3545; /* Danger color */
    }
    .btn-danger:hover {
        background-color: #c82333; /* Darker shade on hover */
    }
    .table thead th {
        background-color: #4e73df; /* Header color */
        color: white;
    }
    h1 {
        font-size: 28px;
        color: #4e73df;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Text shadow for title */
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
    /* Efek hover pada baris tabel */
    tbody tr:hover {
        background-color: #f1f1f1; /* Highlight background on hover */
        transition: background-color 0.3s ease; /* Smooth transition */
    }
</style>

<!-- JavaScript untuk animasi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('#admin-table tbody tr');

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
