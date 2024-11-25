@extends('layouts.customer')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400&display=swap" rel="stylesheet">

    <style>
    body {
        background: #ddd;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: bold;
        color: #000;
        min-height: 100vh;
        margin-top: 110px;
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
    .cart, .summary {
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
    }
    .quantity-btn:hover {
        background-color: #ff6f61;
        transform: scale(1.1);
    }
    .btn-primary {
        background-color: #000;
        color: #fff;
        width: 100%;
        border-radius: 30px;
        transition: all 0.3s ease-in-out;
    }
    .btn-primary:hover {
        background-color: #ff6f61;
        box-shadow: 0 4px 15px rgba(255, 111, 97, 0.4);
    }
    .back-to-shop {
        margin-top: 4.5rem;
        font-size: 0.9rem;
    }
    </style>

    <div class="container mt-5">
        <div class="card">
            <div class="row no-gutters">
                <!-- Cart Section -->
                <div class="col-md-8 cart p-4">
                    <div class="title">
                        <h4><b>Checkout</b></h4>
                        <div class="text-muted">{{ $carts->count() }} items</div>
                    </div>

                    <div class="mt-3">
                        @foreach ($carts as $cart)
                            @php
                                $product = $cart->product;
                                $itemTotal = $product->price * $cart->quantity;
                            @endphp
                            <div class="row border-top border-bottom py-3">
                                <div class="col-2 d-flex align-items-center justify-content-center">
                                    <img class="card-img-top" src="{{ asset('storage/' . $cart->product->photo) }}" alt="{{ $cart->product->name }}">
                                </div>
                                <div class="col product-details">
                                    <div class="product-info">
                                        <div class="text-muted">{{ $product->name }}</div>
                                        <div class="text-muted" style="font-size: 0.8rem;">{{ $product->description }}</div>
                                        <span class="mx-2">{{ $cart->quantity }}</span>
                                    </div>
                                    <div class="text-right">
                                        <b>Total: Rp {{ number_format($itemTotal, 0, ',', '.') }}</b>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="back-to-shop">
                            <a href="{{ route('cart.index') }}" class="text-muted">&leftarrow; Back to shop</a>
                        </div>
                </div>
                <div class="col-md-4 summary p-4">
                    <h5><b>Summary</b></h5>
                    <hr>
                    <div class="row">
                        <div class="col">ITEMS {{ $carts->count() }}</div>
                        <div class="col text-right" id="total-price">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><b>TOTAL</b></div>
                        <div class="col text-right" id="total-amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                    </div>
                    <form action="{{ route('checkout.process') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                            <div>
                                <input type="hidden" name="shipping_address" id="shipping_address" value="{{ Auth::user()->alamat }}">

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping_address_option" id="primary_address" value="primary" checked onclick="usePrimaryAddress()">
                                    <label class="form-check-label" for="primary_address">Alamat Utama</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping_address_option" id="additional_address" value="additional" onclick="toggleAdditionalAddress(true)">
                                    <label class="form-check-label" for="additional_address">Alamat Tambahan</label>
                                </div>
                                <input type="text" class="form-control mt-2" id="additional_address_input" name="additional_addresses[]" placeholder="Masukkan Alamat Tambahan" style="display: none;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="bank_transfer">Transfer Bank</option>
                            </select>
                        </div>

                        @foreach ($carts as $cart)
                            <input type="hidden" name="selected_items[]" value="{{ $cart->id }}">
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-cart"></i> Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menggunakan alamat utama
        function usePrimaryAddress() {
            const addressInput = document.getElementById('shipping_address');
            addressInput.value = '{{ Auth::user()->alamat }}';
            toggleAdditionalAddress(false);
        }

        // Fungsi untuk menampilkan atau menyembunyikan input alamat tambahan
        function toggleAdditionalAddress(show) {
            const addressInput = document.getElementById('additional_address_input');
            if (show) {
                addressInput.style.display = 'block';
                addressInput.required = true;
            } else {
                addressInput.style.display = 'none';
                addressInput.required = false;
                addressInput.value = '';  // Kosongkan input jika tidak diperlukan
            }
        }

        // Fungsi untuk menangani pengiriman form
        document.addEventListener('DOMContentLoaded', function() {
            toggleAdditionalAddress(false); // Default state

            // Tambahkan event listener untuk menangani pengiriman form
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const additionalAddressInput = document.getElementById('additional_address_input').value;
                const shippingAddressInput = document.getElementById('shipping_address');

                // Cek apakah alamat tambahan diisi
                if (additionalAddressInput) {
                    shippingAddressInput.value = additionalAddressInput;  // Gunakan alamat tambahan
                } else {
                    shippingAddressInput.value = '{{ Auth::user()->alamat }}';  // Gunakan alamat utama
                }
            });
        });
    </script>

@endsection
