@extends('layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background: #ddd;
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
            font-size: 0.8rem;
            font-weight: bold;
            margin-top: 110px;
        }

        .title {
            margin-bottom: 5vh;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInUp 0.5s forwards;
        }

        .card {
            width: 100%;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.19);
            border-radius: 1rem;
            border: transparent;
            margin: 20px 0;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.7s forwards;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .cart {
            background-color: #fff;
            padding: 4vh 5vh;
            border-radius: 1rem;
        }

        .btn {
            background-color: #000;
            border-color: #000;
            color: white;
            width: 100%;
            font-size: 0.7rem;
            margin-top: 4vh;
            padding: 1vh;
            border-radius: 0;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            color: white;
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

        .related-products {
            margin-top: 5vh;
            margin-bottom: 5vh;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .related-products .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .related-products .card:hover .card-img-top {
            transform: scale(1.1);
        }

        .related-products .card-body {
            flex: 1;
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .related-products .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1d1d1d;
        }

        .related-products .card-text {
            color: #555;
            font-size: 0.9rem;
        }

        .btn-detail {
            background-color: #2C3E50;
            color: #fff;
            font-size: 0.8rem;
            border: none;
            padding: 0.5rem 1.5rem;
            transition: background-color 0.3s ease-in-out, transform 0.2s;
        }

        .btn-detail:hover {
            background-color: #34495E;
            transform: scale(1.05);
        }

        .btn-detail i {
            margin-right: 0.5rem;
        }

        /* Styling untuk pesan jika produk tidak ditemukan */
        .no-products {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #d9534f;
            margin-top: 50px;
        }

        .no-products i {
            font-size: 3rem;
            color: #d9534f;
            margin-bottom: 20px;
        }

        .no-products p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
        }

        .search-again-btn {
            display: inline-block;
            background-color: #000000;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 1rem;
            text-transform: uppercase;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
        }

        .search-again-btn:hover {
            background-color: #414141;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
    </style>

    <section class="py-5">
        <div class="container-fluid px-4 px-lg-5 mt-5">
            @if ($products->isEmpty())
                <div class="no-products">
                    <i class="fa fa-search"></i> <!-- Ikon pencarian -->
                    <p>Maaf, produk yang Anda cari tidak ditemukan.</p>
                </div>
            @else
                <div class="row related-products">
                    @foreach ($products as $product)
                        <div class="col-md-2 col-lg-2 col-sm-4 col-xs-6">
                            <div class="card">
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <p class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-detail">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i> Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/js/scripts.js') }}"></script>
@endsection
