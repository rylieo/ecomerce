@extends('layouts.app')

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
                color: #000;
                font-size: 16px;
                width: 100%;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #9e9e9e;
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
            }

            .btn-black {
                background-color: transparent;
                border: none;
                padding: 12px 20px;
                border-radius: 30px;
                color: #fff;
                font-size: 16px;
                transition: all 0.3s ease;
            }

            .btn-black:hover {
                background-color: #333;
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
            }

            .alert-danger {
                color: red !important;
                border-color: red;
            }

            .alert-success {
                color: green !important;
                border-color: green;
            }

            .resend-button {
                margin-top: 5px;
            }
        </style>

        <div class="bg-overlay"></div>

        <div class="otp-form">
            <h2>Enter OTP</h2>
            <p class="mb-4">A verification code has been sent to: <strong>{{ session('email', $email) }}</strong></p>

            <form method="POST" action="{{ route('otp.verify') }}" class="text-start">
                @csrf
                <input type="hidden" name="email" value="{{ session('email', $email) }}">

                <div class="form-outline mb-4">
                    <label class="form-label" for="otp_code">Enter OTP</label>
                    <input type="text" id="otp_code" name="otp_code"
                        class="form-control @error('otp_code') is-invalid @enderror" required autofocus />
                    @error('otp_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @if (session('otp_expired'))
                    <div class="alert alert-danger mt-3">
                        {{ session('otp_expired') }}
                    </div>
                @endif

                @if (session('otp_failed'))
                    <div class="alert alert-danger mt-3">
                        {{ session('otp_failed') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-block mb-4">Verify OTP</button>
            </form>

            <div class="text-center mt-3">
                <form action="{{ route('otp.resend') }}" method="POST" id="resend-form">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email', $email) }}">
                    <button type="submit" id="resend-otp-button" class="btn btn-black text-white resend-button">Resend OTP</button>
                    <p id="resend-timer" class="text-primary mt-2"></p>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendOtpButton = document.getElementById('resend-otp-button');
            const resendTimer = document.getElementById('resend-timer');
            const lastResendTime = localStorage.getItem('lastResendTime');
            const cooldownDuration = 5 * 60 * 1000;

            if (lastResendTime) {
                const now = Date.now();
                const elapsed = now - lastResendTime;

                if (elapsed < cooldownDuration) {
                    resendOtpButton.disabled = true;
                    updateTimer(cooldownDuration - elapsed);
                }
            }

            function updateTimer(ms) {
                const interval = setInterval(function() {
                    const minutes = Math.floor(ms / 60000);
                    const seconds = Math.floor((ms % 60000) / 1000);
                    resendTimer.textContent = `You can resend OTP in ${minutes}:${seconds.toString().padStart(2, '0')}`;
                    ms -= 1000;

                    if (ms <= 0) {
                        clearInterval(interval);
                        resendOtpButton.disabled = false;
                        resendTimer.textContent = '';
                    }
                }, 1000);
            }

            document.getElementById('resend-form').addEventListener('submit', function() {
                localStorage.setItem('lastResendTime', Date.now());
            });
        });
    </script>
@endsection
