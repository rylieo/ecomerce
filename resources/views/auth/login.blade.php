@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <section class="login-section text-center text-lg-start">
        <style>
            .login-section {
                position: relative;
                min-height: 100vh;
                display: flex;
                align-items: center;
                /* Center vertically */
                justify-content: center;
                /* Center horizontally */
                background: url('{{ asset('images/wp.jpeg') }}') no-repeat center center;
                background-size: cover;
                width: 100%;
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

            .login-form {
                position: relative;
                z-index: 2;
                color: #fff;
                width: 100%;
                max-width: 400px;
                padding: 40px;
                background-color: transparent;
                /* Optional background for better contrast */
            }

            .login-form h2 {
                color: #fff;
                font-weight: bold;
                margin-bottom: 30px;
                text-align: center;
            }

            .alert-danger {
                color: red !important;
                border-color: red;
            }

            .form-outline {
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
                background-color: #333;
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
            }

            .btn-link {
                color: #fff;
                text-decoration: none;
                margin-top: 10px;
                display: inline-block;
            }

            .btn-link:hover {
                text-decoration: underline;
            }

            .text-danger {
                color: #ff0000;
                /* Atau pilih kode warna merah yang diinginkan */
            }


            @media (max-width: 768px) {
                .login-form {
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

        <div class="login-form">
            <h2>Sign in</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3 form-outline">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                        autofocus />
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-outline">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required />
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                <div class="text-center mb-4">
                    <a href="{{ route('password.request') }}" class="btn-link">Forgot Password?</a>
                </div>

                <div class="text-center mb-4">
                    <a href="{{ route('register') }}" class="btn-link">Belum punya akun? Daftar</a>
                </div>
            </form>
        </div>
    </section>
@endsection
