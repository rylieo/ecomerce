@extends('layouts.app')

@section('content')
<section class="password-section text-center text-lg-start">
    <style>
        .password-section {
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

        .password-form {
            position: relative;
            z-index: 2;
            color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        .password-form h2 {
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
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        /* Custom Alert Styles */
        .alert-success {
            background-color: transparent;
            color: #28a745;
            border-radius: 5px;
        }

        .alert-danger, .invalid-feedback {
            background-color: transparent;
            color: #dc3545;
            border-radius: 5px;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .password-form {
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

    <div class="password-form">
        <h2>Change Your Password</h2>

        <!-- Display status message -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.change') }}" class="text-start">
            @csrf

            <!-- Current Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                    class="form-control @error('current_password') is-invalid @enderror" required />
                @error('current_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- New Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password"
                    class="form-control @error('new_password') is-invalid @enderror" required />
                @error('new_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirm New Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                    class="form-control" required />
            </div>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Change Password</button>

            <div class="text-center mb-4">
                <a href="{{ route('password.request') }}" class="btn-link">Lupa Kata sandi?</a>
            </div>
        </form>
    </div>
</section>
@endsection
