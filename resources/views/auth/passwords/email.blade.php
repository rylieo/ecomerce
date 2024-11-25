@extends('layouts.app')

@section('content')
<section class="forgot-password-section text-center text-lg-start">
    <style>
        .forgot-password-section {
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

        .forgot-password-form {
            position: relative;
            z-index: 2;
            color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        .forgot-password-form h2 {
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

        .alert-success {
            color: #16d141;
            background-color: transparent;
            border-color: #16d141;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .alert-danger {
            color: #de1a2d;
            background-color: transparent;
            border-color: #de1a2d;
            margin-top: 10px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .forgot-password-form {
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

    <div class="forgot-password-form">
        <h2>Silahkan Masukan Email Anda</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus />
                @error('email')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Display Status Message -->
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">
                Send Link
            </button>
        </form>
    </div>
</section>
@endsection
