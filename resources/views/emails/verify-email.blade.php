<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
            margin-bottom: 20px;
        }
        a.verify-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifikasi Email</h1>
        <p>Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.</p>
        <a href="{{ $verificationUrl }}" class="verify-button">Verify Email Address</a>
        <p>Terima kasih telah menggunakan aplikasi kami.</p>
        <p>Jika Anda tidak meminta Tautan ini, abaikan email ini.</p>
    </div>
</body>
</html>
