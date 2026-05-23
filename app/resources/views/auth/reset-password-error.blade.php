<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Link — Dohmayn</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 40px 32px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .icon {
            width: 64px; height: 64px;
            background: #fff0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 28px;
        }
        h1 { font-size: 20px; font-weight: 700; color: #1A1A2E; margin-bottom: 8px; }
        p { font-size: 14px; color: #9E9EB0; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">⚠️</div>
        <h1>Link Invalid or Expired</h1>
        <p>{{ $message ?? 'This password reset link is invalid or has expired.' }}</p>
        <p style="margin-top: 16px;">Please open the Dohmayn app and request a new reset link.</p>
    </div>
</body>
</html>