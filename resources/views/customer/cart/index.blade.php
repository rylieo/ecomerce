@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Cart</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400&display=swap"
            rel="stylesheet">

        <style>
            body {
                background: #ddd;
                font-family: 'Poppins', sans-serif;
                font-size: 0.9rem;
                font-weight: bold;
                color: #000;
                min-height: 100vh;
                margin-top: 130px;
            }

            .card {
                margin: 60px auto;
                max-width: 950px;
                width: 90%;
                border: 1px solid #ccc;
                background: #fff;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.19);
                border-radius: 1rem;
                animation: slideUp 0.6s ease-out;
                /* Animasi muncul dari bawah */
            }

            @keyframes slideUp {
                from {
                    transform: translateY(100px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .cart,
            .summary {
                padding: 2rem;
            }

            .summary {
                background-color: #e9ecef;
                border-radius: 1rem;
            }

            .title {
                margin-bottom: 1.5rem;
            }

            img {
                width: 100px;
                height: 70px;
                object-fit: cover;
            }

            .quantity-btn {
                background-color: #000;
                color: white;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                transition: all 0.3s ease-in-out;
                /* Animasi saat hover */
            }

            .quantity-btn:hover {
                background-color: #ff6f61;
                transform: scale(1.1);
                /* Efek hover */
            }

            .btn-primary {
                background-color: #000;
                color: #fff;
                width: 100%;
                border-radius: 30px;
                /* Membuat tombol lebih modern */
                transition: all 0.3s ease-in-out;
                /* Animasi tombol */
            }

            .btn-primary:hover {
                background-color: #ff6f61;
                box-shadow: 0 4px 15px rgba(255, 111, 97, 0.4);
                /* Efek hover dengan bayangan */
            }

            .back-to-shop {
                margin-top: 4.5rem;
                font-size: 0.9rem;
            }

            .checkbox-container {
                display: flex;
                align-items: center;
            }

            .product-image {
                height: 400px;
                width: 100%;
                object-fit: contain;
            }

            .product-card {
                background-color: #f8f9fa;
                transition: all 0.3s ease;
            }
        </style>
    </head>

    <body>
        <div class="card">
            <div class="row">
                <div class="col-md-8 cart">
                    <div class="title">
                        <h4><b>Shopping Cart</b></h4>
                        <div class="text-muted">{{ $itemCount }} items</div>
                    </div>
                    <form action="{{ route('checkout') }}" method="GET">
                        @csrf
                        @if ($isEmpty)
                            <div class="alert alert-warning text-center">
                                <strong>Belum ada produk yang dimasukkan ke keranjang!</strong>
                            </div>
                        @else
                            <div class="row border-top border-bottom py-3">
                                <div class="col-12">
                                    <input type="checkbox" id="select-all" onchange="selectAll(this)">
                                    <label for="select-all">Select All</label>
                                </div>
                            </div>

                            @foreach ($carts as $cart)
                                <div class="row border-top border-bottom py-3">
                                    <div class="col-2">
                                        <div class="checkbox-container">
                                            <input type="checkbox" name="selected_items[]" value="{{ $cart->id }}"
                                                data-price="{{ $cart->product->price }}"
                                                data-quantity="{{ $cart->quantity }}" onchange="updateTotal()">
                                            <img class="card-img-top" src="{{ asset('storage/' . $cart->product->photo) }}"
                                                alt="{{ $cart->product->name }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row text-muted">{{ $cart->product->name }}</div>
                                        <div class="row text-muted" style="font-size: 0.8rem;">
                                            {{ $cart->product->description }}</div>
                                        <div class="d-flex align-items-center">
                                            <button type="button"
                                                onclick="location.href='{{ route('cart.decreaseQuantity', $cart->id) }}'"
                                                class="btn btn-sm quantity-btn">-</button>
                                            <span class="mx-2">{{ $cart->quantity }}</span>
                                            <button type="button"
                                                onclick="location.href='{{ route('cart.increaseQuantity', $cart->id) }}'"
                                                class="btn btn-sm quantity-btn">+</button>
                                        </div>
                                    </div>
                                    <div class="col text-right d-flex flex-column align-items-end">
                                        <span>{{ number_format($cart->product->price * $cart->quantity, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-cart"></i> Process Checkout
                        </button>
                        <div class="back-to-shop">
                            <a href="/" class="text-muted">&leftarrow; Back to shop</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 summary">
                    <div>
                        <h5><b>Summary</b></h5>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col" style="padding-left:0;">ITEMS <span id="item-count">{{ $itemCount }}</span>
                        </div>
                        <div class="col text-right" id="total-price">{{ number_format($total, 2) }}</div>
                    </div>
                    <div class="row">
                        <div class="col" style="padding-left:0;"><b>TOTAL </b></div>
                        <div class="col text-right" id="total-amount">{{ number_format($total, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery and Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

        <script>
            function updateTotal() {
                let total = 0;
                let itemCount = 0;
                document.querySelectorAll('input[name="selected_items[]"]:checked').forEach(function(item) {
                    const price = parseFloat(item.getAttribute('data-price'));
                    const quantity = parseInt(item.getAttribute('data-quantity'));
                    total += price * quantity;
                    itemCount++;
                });
                document.getElementById('total-amount').innerText = total.toFixed(2);
                document.getElementById('total-price').innerText = total.toFixed(2);
                document.getElementById('item-count').innerText = itemCount;
            }

            // "Select All" function
            function selectAll(selectAllCheckbox) {
                const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateTotal(); // Update total when Select All changes
            }
        </script>
    </body>
    </html>
@endsection
