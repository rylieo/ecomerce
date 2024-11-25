<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .otp-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('images/wp.jpeg') }}') no-repeat center center/cover;
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

        .otp-form {
            position: relative;
            z-index: 2;
            color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .otp-form h1 {
            color: #fff;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .otp-form p {
            color: #fff;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert-success {
            background-color: transparent;
            border: none;
            color: #fff;
            margin-bottom: 30px;
        }

        .btn-danger {
            background-color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 30px;
            color: #000000;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #9e9e9e;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 768px) {
            .otp-form {
                padding: 20px;
                width: 90%;
            }

            .btn-danger {
                font-size: 14px;
            }
        }

        /* Alert Styling */
        .alert {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.8);
            border-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>
    <section class="otp-section text-center text-lg-start">
        <div class="bg-overlay"></div> <!-- Overlay to darken background -->
        <div class="container">
            <div class="otp-form">
                <div class="alert alert-success" role="alert">
                    <h1 class="display-4">Verifikasi Berhasil</h1>
                    <p class="lead">Email Anda telah berhasil diverifikasi. Anda sekarang dapat menutup halaman ini.</p>
                </div>

                <!-- Logout Button with POST Method -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger mb-3">
                        Kembali Ke Halaman Login
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
