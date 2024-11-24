<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        } 
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #47008E;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section with Logo -->
        <div class="header">
            <img src="{{ asset('assets/admin/img/logo/nav-log-white.jpg')}}" alt="Dohmayn Logo">
            <h1>Welcome to Dohmayn</h1>
        </div>

        <!-- Content Section -->
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>Welcome to Dohmayn, your trusted partner in finding premium landed properties. We are excited to have you on board and look forward to helping you make informed decisions in the real estate market.</p>
            
            <p>To complete your registration and gain access to your exclusive property dashboard, please verify your email address by clicking the button below:</p>
            
            <p style="text-align: center;">
                <a href="{{ $verifyUrl }}" target="_blank" class="button">Verify Your Email</a>
            </p>
            
            <p>This link will expire in 24 hours, so please verify your email promptly to continue exploring our available properties and services.</p>

            <!-- Referral Code Section -->
            @if(isset($referralCode))
                <p>Your referral code is <strong>{{ $referralCode }}</strong>. Share it with your friends and earn rewards when they sign up.</p>
            @endif
            
            <p>If you did not initiate this request, please disregard this email.</p>
            <p>Warm regards,</p>
            <p><strong>The Dohmayn Team</strong></p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Dohmayn. All rights reserved.</p>
            <p> Your Gateway to Landed Properties!</p>
            <p><a href="https://www.dohmayn.com" style="color: #555; text-decoration: none;">www.dohmayn.com</a></p>
        </div>
    </div>
</body>
</html>
