<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to Dohmayn...</title>
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
        .logo { width: 64px; height: 64px; margin: 0 auto 24px; }
        h1 { font-size: 22px; font-weight: 700; color: #1A1A2E; margin-bottom: 8px; }
        p { font-size: 14px; color: #9E9EB0; line-height: 1.6; margin-bottom: 24px; }
        .btn {
            display: inline-block;
            background: #7B6EF6;
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 16px;
            width: 100%;
        }
        .btn-outline {
            display: inline-block;
            border: 1.5px solid #e0e0e0;
            color: #1A1A2E;
            padding: 14px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            width: 100%;
        }
        .spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #f0efff;
            border-top-color: #7B6EF6;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="card">
        <div class="spinner" id="spinner"></div>
        <h1>Opening Dohmayn...</h1>
        <p>We're redirecting you to the app to reset your password.</p>

        <a href="{{ $deepLink }}" class="btn" id="openApp">
            Open in Dohmayn App
        </a>

        <p style="font-size: 12px; color: #C0C0D0; margin-top: 12px;">
            If the app doesn't open automatically, tap the button above.
        </p>
    </div>

    <script>
        // Auto-redirect after 1.5 seconds
        setTimeout(function() {
            window.location.href = "{{ $deepLink }}";
            // Hide spinner after attempt
            document.getElementById('spinner').style.display = 'none';
        }, 1500);
    </script>
</body>
</html>