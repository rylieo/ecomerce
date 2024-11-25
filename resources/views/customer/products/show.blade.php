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
        margin-top: 140px;
    }
    .title {
        margin-bottom: 5vh;
        opacity: 0;
        transform: translateY(-20px);
        animation: fadeInUp 0.5s forwards;
    }
    .card {
        margin: auto;
        max-width: 950px;
        width: 90%;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.19);
        border-radius: 1rem;
        border: transparent;
        margin-top: 60px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.7s forwards;
    }
    .cart {
        background-color: #fff;
        padding: 4vh 5vh;
        border-radius: 1rem;
    }
    .summary {
        background-color: #ddd;
        border-radius: 1rem;
        padding: 4vh;
        color: rgb(65, 65, 65);
    }
    .title b {
        font-size: 1.5rem;
    }
    .back-to-shop {
        margin-top: 4.5rem;
    }
    .btn {
        background-color: #2C3E50;
        border-color: #34495E;
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
    .product-image {
        height: 400px;
        width: 100%;
        object-fit: contain;
        opacity: 0;
        transform: scale(0.9);
        animation: fadeInScale 0.5s forwards 0.2s; /* Delay for image */
    }
    .related-products {
        margin-top: 5vh;
        margin-bottom: 5vh;
    }
    .related-products .card {
        margin-bottom: 1.5rem;
        background-color: #fff;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        height: 100%;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.7s forwards;
    }
    .related-products .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .related-products .card-img-top {
        width: 100%;
        height: 200px; /* Sesuaikan tinggi gambar */
        object-fit: cover;
    }
    @media (min-width: 992px) {
        .related-products .col-md-3 {
            flex: 0 0 24%;
            max-width: 24%;
        }
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
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Produk Terkait */
.product-card {
    background-color: #f8f9fa;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.product-card img {
    transition: transform 0.5s ease;
}

.product-card:hover img {
    transform: scale(1.1);
}

.product-card .card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #2c3e50;
}

.product-card .card-text {
    color: #95a5a6;
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
</style>

<div class="container">
    <div class="card">
        <div class="cart">
            <div class="title">
                <h4><b>Detail Produk</b></h4>
            </div>
            <hr class="sidebar-divider">

            <div class="row">
                <div class="col-md-6">
                    <img class="product-image" src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}">
                </div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
                    <div class="fs-5 mb-5">
                        <span class="fs-4 fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="card-text">{{ $product->description }}</p>
                    <form id="addToCartForm" action="{{ route('cart.store') }}" method="POST" data-url="{{ route('cart.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input class="form-control text-center me-3" id="inputQuantity" name="quantity" type="number" value="1" min="1" style="max-width: 4rem" />
                        <button class="btn" type="submit">
                            <i class="fa fa-cart-plus me-1"></i>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    <div id="cartMessage" class="mt-3"></div>
                    <div class="back-to-shop">
                        <a href="{{ url('/') }}">&leftarrow;</a><span class="text-muted"> Kembali ke Toko</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4 px-lg-5 my-5">
    <h3 class="text-center" style="color: #2C3E50; font-weight: bold;">Produk Terkait</h3>
    <div class="row related-products">
        @foreach ($relatedProducts as $relatedProduct)
            <div class="col-md-2 col-lg-2 col-sm-4 col-xs-6 mb-4">
                <div class="card product-card">
                    <img src="{{ asset('storage/' . $relatedProduct->photo) }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                        <p class="card-text">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-detail">
                            <i class="fa fa-info-circle"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>



<!-- jQuery and Bootstrap JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const form = $('#addToCartForm');
        const cartMessage = $('#cartMessage');
        const submitButton = form.find('button[type="submit"]');

        form.on('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            // Tambahkan efek loading
            submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menambahkan...');

            fetch(form.data('url'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                cartMessage.html('<div class="alert alert-success">Produk berhasil ditambahkan ke keranjang!</div>');
                submitButton.prop('disabled', false).html('<i class="fa fa-cart-plus me-1"></i> Tambah ke Keranjang');
            })
            .catch(error => {
                cartMessage.html('<div class="alert alert-success">Produk berhasil ditambahkan ke keranjang!</div>');
                submitButton.prop('disabled', false).html('<i class="fa fa-cart-plus me-1"></i> Tambah ke Keranjang');
            });
        });
    });
</script>
@endsection
