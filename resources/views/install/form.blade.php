<!DOCTYPE html>
<html>

<head>
    <title>System Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .install-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            box-shadow: none;
        }

        .btn-success {
            background: #28a745;
            border: none;
            font-weight: bold;
        }

        .card-header {
            /* background: rgba(255, 255, 255, 0.1); */
            font-weight: bold;
        }

        small.text-muted {
            color: #ccc !important;
        }

        .alert {
            backdrop-filter: blur(10px);
            background: rgba(255, 0, 0, 0.2);
            color: #fff;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="install-card">
                    <div class="card-header text-center mb-3">
                        <h3>🚀 Install Your System</h3>
                        <small>Please fill in the details to complete installation</small>
                    </div>

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/install') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Template Name</label>
                            <input type="text" name="template" value="{{ old('template') }}" class="form-control"
                                placeholder="e.g. school" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="admin@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Password</label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Installation Password</label>
                            <input type="password" name="install_password" class="form-control"
                                placeholder="Enter installation key" required>
                            <small class="text-muted">This password is required to confirm the installation.</small>
                        </div>
                        <button class="btn btn-success w-100">Install Now</button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Installer v1.0</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
