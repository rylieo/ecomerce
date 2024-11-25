@extends('layouts.customer')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center animated-container">
                <div class="alert alert-light shadow-sm p-4 rounded">
                    <!-- Animated Spinner Icon -->
                    <i class="fas fa-spinner fa-spin" style="font-size: 4rem; color: #ff8c00;"></i>
                    <!-- Menampilkan QR Code -->
                    <div class="mt-4">
                        @if(Storage::exists('public/qr_code.png'))
                            <h2 class="mt-4">Current Payment QR Code</h2>
                            <div class="qr-code-container">
                                <img src="{{ asset('storage/qr_code.png') }}" alt="Current Payment QR Code" class="qr-code">
                            </div>
                        @else
                            <p class="text-danger mt-2">QR Code not available.</p>
                        @endif
                    </div>

                    <!-- Judul Pesan -->
                    <h1 class="display-4 mt-3 font-weight-bold">Order Processing</h1>

                    <!-- Pesan Utama -->
                    <p class="lead mt-3 text-muted">Your order is currently being processed. Please wait until the admin contacts you.</p>

                    <!-- Kode Pesanan -->
                    <p class="font-weight-bold">Your Order Code:
                        <span class="badge" style="background-color: #ff8c00; color: white; font-size: 1.5rem;">{{ $orderCode }}</span>
                    </p>



                    <!-- Tombol kembali ke halaman utama -->
                    <a href="{{ route('welcome') }}" class="btn btn-orange mt-4" style="font-size: 1.1rem;">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Tambahkan animasi fade-in dari kiri dan kanan */
        .animated-container {
            opacity: 0;
            transform: translateX(-100%);
            animation: fadeInFromSides 0.8s forwards;
        }

        @keyframes fadeInFromSides {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        body {
            margin-top: 200px;
        }

        /* Tambahkan animasi fade-in */
        .alert {
            background-color: #fff; /* Warna latar belakang putih */
            border: none; /* Menghapus border default */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        }

        .qr-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            padding: 15px; /* Padding untuk memberi ruang di sekitar QR Code */
            background-color: rgba(255, 140, 0, 0.1); /* Latar belakang semi-transparan oranye */
            border-radius: 12px; /* Sudut kontainer melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Bayangan untuk kontainer */
        }


        .qr-code {
            height: 250px; /* Ukuran tinggi QR Code yang diperbesar */
            width: 250px; /* Ukuran lebar QR Code yang diperbesar untuk membuatnya persegi */
            margin-top: 10px;
            border: 4px solid #ff8c00; /* Border yang lebih tebal berwarna oranye */
            border-radius: 12px; /* Sudut melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Efek bayangan lebih halus */
            object-fit: contain; /* Memastikan gambar di dalam kontainer */
            transition: transform 0.3s, box-shadow 0.3s; /* Transisi saat hover */
        }

        .qr-code:hover {
            transform: scale(1.1); /* Efek zoom saat hover */
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.3); /* Bayangan saat hover */
        }

        /* Tombol hover */
        .btn-orange {
            background-color: #ff8c00; /* Warna latar oranye */
            color: white; /* Warna teks putih */
            border-radius: 25px; /* Sudut tombol melengkung */
            padding: 10px 20px; /* Padding tombol */
            transition: background-color 0.3s, transform 0.3s; /* Transisi saat hover */
        }

        .btn-orange:hover {
            background-color: #e07b00; /* Warna latar saat hover */
            transform: translateY(-2px); /* Efek naik saat hover */
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 575px) {
            .alert {
                padding: 3rem;
            }

            .alert .display-4 {
                font-size: 2rem;
            }

            .alert p {
                font-size: 1rem;
            }

            .alert .btn {
                font-size: 1rem;
            }
        }
    </style>
@endsection
