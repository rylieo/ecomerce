@extends('layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background: #f0f0f0;
            /* Warna abu-abu terang */
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
            color: #333;
            /* Warna teks yang sedikit lebih gelap */
            margin-top: 100px;
        }

        .title {
            margin-bottom: 5vh;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInUp 0.5s forwards;
            text-align: center;
        }

        .title h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
            /* Warna hitam lembut */
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .title p {
            font-size: 1.2rem;
            color: #666;
            /* Warna abu-abu */
        }

        .card {
            margin: auto;
            max-width: 950px;
            width: 90%;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            margin-top: 60px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.7s forwards;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .card-text {
            color: #555;
            /* Teks yang lebih lembut */
        }

        .btn {
            background-color: #333;
            border-color: #333;
            color: white;
            width: 100%;
            font-size: 0.9rem;
            margin-top: 4vh;
            padding: 1vh;
            border-radius: 0;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #555;
            transform: scale(1.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .team-member img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
            transition: transform 0.3s;
        }

        .team-member img:hover {
            transform: scale(1.05);
        }

        .list-unstyled li {
            position: relative;
            padding-left: 25px;
        }

        .list-unstyled li i {
            position: absolute;
            left: 0;
            top: 0;
            color: #333;
        }

        #map {
            height: 400px;
            margin-top: 30px;
            border-radius: 0.5rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="container my-5">
        <div class="row">
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center title">
                <h1>About Our E-Commerce</h1>
                <p class="lead mt-4">
                    Welcome to <strong>{{ config('app.name') }}</strong>, your number one source for all things
                    [product niche]. We're dedicated to giving you the very best of [product type], with a focus on
                    [three characteristics, e.g., dependability, customer service, and uniqueness].
                </p>
            </div>

            @foreach($abouts as $about)
                <div class="col-md-6 mb-4">
                    <div class="card animated-card">
                        <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->title }}" class="card-img-top">
                        <div class="card-body">
                            <h3 class="card-title">{{ $about->title }}</h3>
                            <p class="card-text">{{ $about->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
