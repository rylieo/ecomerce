@extends('layouts.app')

@section('content')
    <main>
        <section class="profile-edit-section">
            <div class="container">
                <div class="profile-card">
                    <div class="profile-picture">
                        <!-- Menampilkan foto profil saat ini atau foto default -->
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.jpg') }}"
                            alt="Profile Picture">
                    </div>
                    <div class="profile-info">
                        <!-- Menampilkan pesan sukses jika ada -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Menampilkan pesan error jika ada -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Gender</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="" disabled>Select Gender</option>
                                    <option value="Male"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="Female"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Female' ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Date of Birth</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                    value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Address</label>
                                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="profile_picture">Profile Picture</label>
                                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endsection

    @push('styles')
        <style>
            .profile-edit-section {
                padding: 30px 0;
                background-color: #f1f1f1;
                margin-top: 80px;
                /* Adjust this value if needed to account for header height */
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .profile-card {
                display: flex;
                gap: 20px;
                flex-wrap: wrap;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }

            .profile-picture {
                flex: 0 0 120px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .profile-picture img {
                width: 120px;
                /* Menetapkan ukuran tetap untuk gambar profil */
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid #ddd;
            }

            .profile-info {
                flex: 1;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                width: 100%;
                padding: 10px;
                border-radius: 4px;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }

            .form-group textarea {
                resize: vertical;
                min-height: 100px;
            }

            .btn-primary {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #0056b3;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .profile-card {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .profile-picture {
                    margin-bottom: 20px;
                    /* Space between picture and info on mobile */
                }
            }
        </style>
    @endpush
