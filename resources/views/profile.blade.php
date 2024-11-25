@extends('layouts.app')

@section('content')
    <main>
        <section class="profile-section">
            <div class="container">
                <div class="profile-container">
                    <!-- Sidebar Settings -->
                    <div class="settings-sidebar">
                        <h2>Pengaturan</h2>
                        <ul class="settings-menu">
                            <li>
                                <a href="{{ route('profile') }}">
                                    <i class="fas fa-user-circle"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i class="fas fa-box"></i> Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('password.change.form') }}">
                                    <i class="fas fa-lock"></i> Ubah Password
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="openLogoutModal()">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Profile Card -->
                    <div class="profile-card">
                        @if (session('success'))
                            <div class="alert alert-success" style="width: 100%; text-align: center; margin-bottom: 20px;">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger" style="width: 100%; text-align: center; margin-bottom: 20px;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="profile-picture">
                            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.jpg') }}"
                                alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h1>{{ Auth::user()->name }}</h1>
                            <p class="email">{{ Auth::user()->email }}</p>
                            <div class="additional-info">
                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <p><strong>Telepon:</strong> {{ Auth::user()->phone }}</p>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-genderless"></i>
                                    <p><strong>Jenis Kelamin:</strong> {{ Auth::user()->jenis_kelamin }}</p>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p><strong>Tanggal Lahir:</strong>
                                        {{ Auth::user()->tanggal_lahir ? Auth::user()->tanggal_lahir->format('d M Y') : 'Tidak Diketahui' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p><strong>Alamat:</strong> {{ Auth::user()->alamat }}</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary icon-only">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Logout Confirmation Modal -->
        <div id="logoutModal" class="modal" style="display: none;">
            <div class="modal-content">
                <p>Apakah Anda yakin ingin logout?</p>
                <button onclick="confirmLogout()" class="btn btn-danger">Ya</button>
                <button onclick="closeLogoutModal()" class="btn btn-secondary">Tidak</button>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </main>

    @push('styles')
        <style>
            /* Modal Styles */
            .modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
            }

            .modal-content {
                background: white;
                padding: 20px;
                border-radius: 8px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                max-width: 400px;
                width: 100%;
            }

            .modal-content p {
                font-size: 18px;
                margin-bottom: 20px;
            }

            .btn-danger {
                background-color: #dc3545;
                color: white;
                padding: 10px 20px;
                margin-right: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-secondary {
                background-color: #6c757d;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            body {
                background-color: #ddd;
                font-family: 'Poppins', sans-serif;
            }

            .profile-section {
                padding: 60px 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .container {
                max-width: 1000px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .profile-container {
                display: flex;
                gap: 30px;
                justify-content: center;
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .settings-sidebar {
                width: 100%;
                max-width: 250px;
                background: transparent;
                padding: 20px;
                border-radius: 15px;
                margin-bottom: 40px;
                transition: transform 0.3s;
                padding-right: 200px;
            }

            .settings-sidebar:hover {
                transform: translateY(-2px);
            }

            .settings-sidebar h2 {
                font-size: 24px;
                color: #333;
            }

            .settings-menu {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .settings-menu li {
                margin-bottom: 15px;
            }

            .settings-menu li a {
                color: #555;
                text-decoration: none;
                font-size: 16px;
                padding: 10px 15px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                gap: 10px;
                transition: background 0.3s ease, color 0.3s ease;
            }

            .settings-menu li a:hover {
                background: rgba(100, 100, 100, 0.1);
                color: #000;
            }

            .profile-card {
                flex: 1;
                max-width: 600px;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 15px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                padding: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .profile-card:hover {
                transform: scale(1.02);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            }

            .profile-picture img {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid rgba(100, 100, 100, 0.5);
                transition: transform 0.3s ease;
            }

            .profile-picture img:hover {
                transform: scale(1.1);
            }

            .alert {
                padding: 15px;
                border-radius: 5px;
                font-size: 16px;
                color: #fff;
            }

            .alert-success {
                background-color: #28a745;
            }

            .alert-danger {
                background-color: #dc3545;
            }

            .profile-info {
                text-align: center;
                margin-top: 20px;
            }

            .profile-info h1 {
                margin: 10px 0;
                font-size: 24px;
                color: #333;
            }

            .profile-info p {
                margin: 5px 0;
                font-size: 16px;
                color: #555;
            }

            .additional-info {
                display: flex;
                flex-direction: column;
                gap: 15px;
                margin-top: 20px;
                width: 100%;
            }

            .info-item {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 16px;
                color: #555;
            }

            .profile-info .btn-primary {
                margin-top: 15px;
                background: #3a3a3a;
                color: #ffffff;
                border: none;
                padding: 10px 15px;
                font-size: 16px;
                border-radius: 30px;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                transition: background 0.3s ease, transform 0.3s ease;
            }

            .profile-info .btn-primary:hover {
                background: #333;
                transform: scale(1.05);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .profile-container {
                    flex-direction: column;
                    align-items: center;
                }

                .settings-sidebar,
                .profile-card {
                    width: 100%;
                    max-width: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function openLogoutModal() {
                document.getElementById('logoutModal').style.display = 'flex';
            }

            function closeLogoutModal() {
                document.getElementById('logoutModal').style.display = 'none';
            }

            function confirmLogout() {
                document.getElementById('logout-form').submit();
            }
        </script>
    @endpush
@endsection
