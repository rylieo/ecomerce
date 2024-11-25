<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #555;
            font-size: 16px;
        }
        .content {
            margin-bottom: 20px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #1a73e8;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verification</h1>
            <p>Your OTP code for verification is below:</p>
        </div>
        <div class="content">
            <div class="otp-code">
                {{ $otpCode }}
            </div>
        </div>
        <div class="footer">
            <p>Thank you for using our application.</p>
            <p>If you did not request this code, please ignore this email.</p>
        </div>
    </div>
</body>
</html>
