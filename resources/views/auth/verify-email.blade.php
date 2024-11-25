@extends('layouts.app')

@section('title', 'Email Verification')

@section('content')
    <section class="otp-section text-center text-lg-start">
        <style>
            .otp-section {
                position: relative;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: url('{{ asset('images/wp.jpeg') }}') no-repeat center center/cover;
                margin-top: 35px;
            }

            .bg-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                z-index: 1;
            }

            .otp-form {
                position: relative;
                z-index: 2;
                color: #fff;
                width: 100%;
                max-width: 400px;
                padding: 40px;
            }

            .otp-form h2 {
                color: #fff;
                font-weight: bold;
                margin-bottom: 30px;
                text-align: center;
            }

            .form-outline {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 1.5rem;
            }

            .form-label {
                font-weight: 600;
                color: #fff;
                margin-bottom: 5px;
            }

            .form-control {
                padding: 15px;
                border-radius: 30px;
                border: 1px solid #ddd;
                background-color: rgba(255, 255, 255, 0.1);
                color: #fff;
                font-size: 16px;
                width: 100%;
                box-sizing: border-box;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: #fff;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
            }

            .btn-primary {
                background-color: #ffffff;
                border: none;
                padding: 12px 20px;
                border-radius: 30px;
                color: #000000;
                font-size: 16px;
                width: 100%;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #9e9e9e;
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
            }

            .btn-link {
                color: #fff;
                background-color: transparent;
                text-decoration: none;
                margin-top: 10px;
                display: inline-block;
            }

            .btn-link:hover {
                text-decoration: underline;
            }

            .resend-btn {
                margin-bottom: 4px;
                /* Adds space below the resend button */
            }

            .mt-logout-btn {
                margin-top: 3px;
                /* Adds space above the logout button */
            }

            @media (max-width: 768px) {
                .otp-form {
                    padding: 20px;
                    width: 90%;
                }

                .form-control {
                    font-size: 14px;
                }

                .btn-primary {
                    font-size: 14px;
                }
            }
        </style>

        <div class="bg-overlay"></div>

        <div class="otp-form">
            <h2>Verifikasi Email Anda</h2>
            <p class="mb-4">Silakan periksa email Anda untuk tautan verifikasi. Jika Anda tidak menerima tautan, Anda dapat
                meminta ulang di bawah ini.</p>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success text-center">
                    Tautan verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <!-- Resend Verification Link Form -->
            <form action="{{ route('verification.send') }}" method="POST" class="text-start">
                @csrf
                <button type="submit" class="btn btn-primary btn-block resend-btn">Kirim Ulang Tautan Verifikasi</button>
            </form>

            <!-- Logout Button -->
            <div class="text-center">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="button" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="btn btn-primary mt-logout-btn">
                        Sudah verifikasi? Login
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
