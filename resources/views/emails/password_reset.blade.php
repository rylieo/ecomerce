<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 16px;
        }
        p {
            color: #555555;
            line-height: 1.5;
            margin-bottom: 16px;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset Request</h1>
        <p>We received a request to reset your password. Click the link below to reset your password:</p>
        <p><a href="{{ url('auth/password/reset', $token) }}" target="_blank">Reset Password</a></p>
        <p>If you did not request a password reset, please ignore this email.</p>
        <p>Thank you!</p>
    </div>
</body>
</html>
