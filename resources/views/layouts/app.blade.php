<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')

    <style>
        body {
            font-family: 'Quicksand', Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }

        header {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            transition: background-color 0.5s ease, box-shadow 0.5s ease, height 0.5s ease;
        }

        .top-bar {
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .top-bar a {
            color: #333;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .top-bar a:hover {
            color: #555;
            transform: scale(1.1);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            transition: background-color 0.5s ease, color 0.5s ease, box-shadow 0.5s ease, height 0.5s ease;
        }

        .navbar .logo img {
            height: 60px;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .navigation {
            list-style: none;
            display: flex;
            gap: 30px;
            margin: 0;
            padding: 0;
        }

        .navigation li a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .navigation li a:hover {
            background-color: #333;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .icon-container a {
            font-size: 20px;
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .icon-container a:hover {
            color: #555;
            transform: scale(1.1);
        }

        .scroll-active {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
            height: 70px;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 10px 20px;
            }

            .navigation {
                flex-direction: column;
                align-items: center;
                width: 100%;
                gap: 10px;
            }

            .icon-container {
                margin-top: 10px;
            }

            .navbar .logo img {
                height: 50px;
            }

            .top-bar {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="top-bar">
            <a href="mailto:{{ isset($contacts) ? $contacts->email : 'example@example.com' }}">
                {{ isset($contacts) ? $contacts->email : 'Official@gmail.com' }}
            </a>
            <a href="tel:{{ isset($contacts) ? $contacts->phone : '+12345678910' }}">
                {{ isset($contacts) ? $contacts->phone : '+1 234 4567 8910' }}
            </a>
            <div class="icon-container">
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @else
                    @if (Auth::user()->hasVerifiedEmail())
                        <div class="dropdown">
                            <a href="{{ route('profile') }}">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                        </div>
                    @else
                        <div>
                            <p>Verifikasi email Anda</p>
                        </div>
                    @endif
                @endguest
            </div>
        </div>
        <nav class="navbar">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo">
                </a>
            </div>
            <ul class="navigation">
                <li><a href="{{ route('component.products') }}">Shop</a></li>
                <li><a href="{{ route('products.new') }}">New In</a></li>
                <li><a href="{{ route('about.index') }}">About</a></li>
            </ul>
            <div class="icon-container">
                <a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Place scripts here -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.navbar');
            const logo = document.querySelector('.logo img');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    navbar.classList.add('scroll-active');
                } else {
                    navbar.classList.remove('scroll-active');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
