@extends('layouts.app')

@section('content')
<section class="reset-password-section text-center text-lg-start">
    <style>
        .reset-password-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('images/wp.jpeg') }}') no-repeat center center/cover;
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

        .reset-password-form {
            position: relative;
            z-index: 2;
            color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        .reset-password-form h2 {
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

        .alert {
            margin-top: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .reset-password-form {
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

    <div class="reset-password-form">
        <h2>Reset Your Password</h2>

        <!-- Display Status Message -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Hidden email input -->
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- Token input -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required />
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password confirmation input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password-confirm">Confirm Password</label>
                <input type="password" id="password-confirm" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required />
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">
                Reset Password
            </button>
        </form>
    </div>
</section>
@endsection
