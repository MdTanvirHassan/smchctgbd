<!DOCTYPE html>
<html>
<head>
    <title>Installation Complete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        .success-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            font-weight: bold;
        }

        ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="success-card">
    <div class="success-icon">✅</div>
    <h2 class="mt-3">Installation Complete!</h2>
    <p>One user has been created:</p>
    <ul class="list-unstyled">
        <li>{{ $email }} — (Your custom admin)</li>
    </ul>
    <p>Template set to: <strong>{{ $template }}</strong></p>
    <a href="{{ url('/login') }}" class="btn btn-primary w-100 mt-3">Go to Login</a>
</div>
</body>
</html>
