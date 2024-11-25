@extends('layouts.sidebar')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Manajemen Pengguna</h1>

        <!-- Form pencarian pengguna -->
        <div class="d-flex mb-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex flex-grow-1">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari pengguna..." value="{{ request()->input('search') }}" style="border-radius: 25px; border: 1px solid #007bff;">
                <select name="jenis_kelamin" class="form-control mr-2" style="border-radius: 25px; border: 1px solid #007bff;">
                    <option value="">All Genders</option> <!-- Ubah label default -->
                    <option value="Male" {{ request()->input('jenis_kelamin') == 'Male' ? 'selected' : '' }}>Male</option> <!-- Opsi Male -->
                    <option value="Female" {{ request()->input('jenis_kelamin') == 'Female' ? 'selected' : '' }}>Female</option> <!-- Opsi Female -->
                </select>
                <button type="submit" class="btn btn-primary" style="border-radius: 25px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($users->isEmpty())
            <div class="alert alert-info">Tidak ada pengguna ditemukan.</div>
        @else
            <div class="table-responsive animate-table">
                <table class="table table-hover table-bordered custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name ?? 'kosong' }}</td>
                                <td>{{ $user->email ?? 'kosong' }}</td>
                                <td>{{ $user->phone ?? 'kosong' }}</td>
                                <td>{{ $user->jenis_kelamin ?? 'kosong' }}</td>
                                <td>{{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : 'kosong' }}</td>
                                <td>{{ $user->alamat ?? 'kosong' }}</td>
                                <td>
                                    <div class="password-field">
                                        <input type="password" id="password-{{ $user->id }}" value="{{ $user->plain_password ?? 'kosong' }}" readonly>
                                        <button type="button" class="btn btn-sm toggle-password" onclick="togglePassword({{ $user->id }})">
                                            <i class="fas fa-eye-slash" id="icon-{{ $user->id }}"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        function togglePassword(userId) {
            var passwordInput = document.getElementById('password-' + userId);
            var icon = document.getElementById('icon-' + userId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>

    <style>
        /* Gunakan font Roboto */
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Tabel dengan border radius dan shadow */
        .custom-table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; /* Latar belakang putih untuk tabel */
        }

        /* Efek hover pada row */
        .custom-table tbody tr:hover {
            background-color: #e8f0fe;
            transform: scale(1.02);
            transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        /* Styling untuk header tabel */
        .thead-dark th {
            background-color: #0056b3; /* Warna biru gelap */
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            padding: 12px 15px;
        }

        /* Styling border */
        .custom-table, .custom-table th, .custom-table td {
            border: 1px solid #dee2e6;
        }

        /* Styling untuk font dan padding */
        .custom-table th, .custom-table td {
            font-size: 14px;
            padding: 10px 15px;
            vertical-align: middle; /* Rata tengah untuk semua sel */
        }

        /* Alert yang lebih menarik */
        .alert {
            border-radius: 8px;
            background-color: #e9f7fd;
            color: #31708f;
            border: 1px solid #bce8f1;
        }

        /* Animasi muncul dari bawah */
        .animate-table {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s forwards ease-in-out;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling kolom password */
        .password-field {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-field input[type="password"] {
            padding-right: 40px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
        }

        .password-field .toggle-password {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
        }
    </style>
@endsection
