<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Product List')</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
        }
        body {
            background: #fff;
            color: #000;
            font-family: sans-serif;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .card {
            margin: 2rem auto;
            max-width: 950px;
            width: 90%;
            border: 1px solid #ccc;
            background: #fff;
        }
        .cart {
            background-color: #fff;
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
        }
        .summary {
            background-color: #e9ecef;
            border-radius: 0 0 1rem 1rem;
            padding: 2rem;
        }
        .title {
            margin-bottom: 1.5rem;
        }
        .main {
            padding: 1.5rem 0;
        }
        .row {
            margin: 0;
        }
        .close {
            margin-left: auto;
            font-size: 1.2rem;
            color: #dc3545;
        }
        img {
            width: 100px;
            height: 70px;
            object-fit: cover;
        }
        .btn {
            background-color: #000;
            color: #fff;
        }
        .btn-light {
            color: #000;
            border: 1px solid #000;
        }
        .btn-light:hover {
            background-color: #000;
            color: #fff;
        }
        a {
            color: #007bff;
        }
        a:hover {
            text-decoration: none;
        }
        .back-to-shop {
            margin-top: 2rem;
            font-size: 0.9rem;
        }
        hr {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            border-color: #ccc;
        }
        .quantity-btn {
            background-color: #000;
            border: 1px solid #000;
            color: white;
        }
        .quantity-btn:hover {
            background-color: #444;
            color: white;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
        }
        .checkbox-container input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <header>
            <!-- Optional: Add a responsive navbar or branding here -->
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-4">
            <!-- Optional: Add a responsive footer here -->
        </footer>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
