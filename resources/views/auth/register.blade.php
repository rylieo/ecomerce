@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section class="register-section text-center text-lg-start">
  <style>
    .register-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
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

    .register-form {
        position: relative;
        z-index: 2;
        color: #fff;
        width: 100%;
        max-width: 400px;
        padding: 40px;
        background-color: transparent; /* Similar background for contrast */
        margin-top: 70px;
    }

    .register-form h2 {
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
      background-color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 30px;
      color: #000;
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

    .alert-danger {
      color: red;
      padding: 8px;
      font-size: 14px;
      border-radius: 5px;
      margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
      .register-form {
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

  <div class="register-form">
    <h2>Register</h2>

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="mb-3 form-outline">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
      </div>
      <div class="mb-3 form-outline">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
      </div>
      @if ($errors->has('email'))
        <div class="alert alert-danger text-danger">
          <strong>{{ $errors->first('email') }}</strong>
        </div>
      @endif
      <div class="mb-3 form-outline">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      @if ($errors->has('password'))
        <div class="alert alert-danger text-danger">
          <strong>{{ $errors->first('password') }}</strong>
        </div>
      @endif
      <div class="mb-3 form-outline">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <div class="text-center mt-3">
      <a href="{{ route('login') }}" class="btn-link">Sudah punya akun? Login</a>
    </div>
  </div>
</section>
@endsection
