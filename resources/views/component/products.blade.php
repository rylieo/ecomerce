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
    /* Card styling */
    .card {
        width: 100%; /* Full width */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.19);
        border-radius: 1rem;
        border: transparent;
        margin: 20px 0; /* Jarak atas dan bawah */
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.7s forwards;
        transition: transform 0.3s, box-shadow 0.3s; /* Tambah transisi */
        overflow: hidden; /* Mencegah gambar zoom melewati batas card */
    }
    .card:hover {
        transform: translateY(-10px); /* Efek saat hover */
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

    /* Animasi */
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

    /* Styling untuk produk */
    .related-products {
        margin-top: 5vh;
        margin-bottom: 5vh;
        display: flex;
        flex-wrap: wrap; /* Enable wrapping of cards */
        justify-content: space-between; /* Space out the cards */
    }
    .related-products .card-img-top {
        width: 100%;
        height: 200px; /* Sesuaikan tinggi gambar */
        object-fit: cover;
        transition: transform 0.3s; /* Tambah transisi zoom */
    }
    .related-products .card:hover .card-img-top {
        transform: scale(1.1); /* Zoom gambar saat hover */
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

    .search-container {
        text-align: center;
        margin-bottom: 2rem;
    }
    .search-input {
        width: 80%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .search-button {
        padding: 0.5rem 1rem;
        background-color: #2C3E50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .search-button:hover {
        background-color: #34495E;
    }
</style>

<section class="py-5">
    <div class="search-container">
        <form id="search-form" action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Search..." class="search-input" id="search-input">
            <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="container-fluid px-4 px-lg-5 mt-5"> <!-- Use container-fluid for full width -->
        <div class="row related-products">
            @foreach ($products as $product)
            <div class="col-md-2 col-lg-2 col-sm-4 col-xs-6"> <!-- Adjusted for 6 cards per row -->
                <div class="card">
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="card-img-top">
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
    </div>
</section>

@endsection

@section('scripts')
    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/js/scripts.js') }}"></script>
@endsection
