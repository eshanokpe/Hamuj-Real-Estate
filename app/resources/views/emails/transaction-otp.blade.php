<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Verification Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #4F46E5;
        }
        .header h1 {
            color: #4F46E5;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .otp-code {
            text-align: center;
            margin: 30px 0;
        }
        .otp-code span {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #4F46E5;
            background: #F3F4F6;
            padding: 15px 25px;
            border-radius: 12px;
            display: inline-block;
            font-family: monospace;
        }
        .info-box {
            background-color: #F9FAFB;
            border-left: 4px solid #4F46E5;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .warning {
            color: #DC2626;
            font-size: 14px;
            margin-top: 20px;
            padding: 12px;
            background-color: #FEF2F2;
            border-radius: 8px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6B7280;
            border-top: 1px solid #E5E7EB;
        }
        .button {
            display: inline-block;
            background-color: #4F46E5;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
        }
        @media only screen and (max-width: 600px) {
            .otp-code span {
                font-size: 32px;
                letter-spacing: 4px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $companyName }}</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Hello {{ $userName }},
            </div>

            <p>We received a request to verify a transaction on your account. Please use the verification code below to complete your transaction:</p>

            <div class="otp-code">
                <span>{{ $otp }}</span>
            </div>

            <div class="info-box">
                <strong>💡 Important Information:</strong>
                <ul style="margin: 8px 0 0 20px; padding: 0;">
                    <li>This code will expire in <strong>{{ $expiryMinutes }} minutes</strong></li>
                    <li>For security reasons, never share this code with anyone</li>
                    <li>Our support team will never ask for this code</li>
                </ul>
            </div>

            <p>If you did not initiate this transaction, please secure your account immediately by:</p>
            <ul>
                <li>Changing your password</li>
                <li>Contacting our support team</li>
                <li>Reviewing your recent account activity</li>
            </ul>

            <div class="warning">
                ⚠️ <strong>Security Alert:</strong> Do not share this OTP with anyone, including our support staff. We will never ask for this code.
            </div>
        </div>

        <div class="footer">
            <p>© {{ $year }} {{ $companyName }}. All rights reserved.</p>
            <p>Need help? Contact us at <a href="mailto:{{ $companyEmail }}">{{ $companyEmail }}</a> or call {{ $companyPhone }}</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>