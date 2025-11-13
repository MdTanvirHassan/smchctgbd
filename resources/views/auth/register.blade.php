@section('content')
    <style>
        body {
            background-image: linear-gradient(to right, rgba(0, 128, 0, 0.2), rgba(255, 0, 0, 0.1));
        }

        .register-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 850px;
            width: 100%;
            display: flex;
        }

        .register-image {
            background: url('/build/assets/img/loginimg.jpg') center center / cover no-repeat;
            width: 50%;
        }

        .register-form {
            padding: 3rem;
            width: 50%;
        }

        .form-control:focus {
            border-color: #1C753A;
            box-shadow: 0 0 0 0.2rem rgba(255, 78, 80, 0.25);
        }

        .register-form h3 {
            font-weight: bold;
            color: #1C753A;
        }

        .btn-register {
            background-color: #1C753A;
            border: none;
            width: 100%;
        }

        .btn-register:hover {
            background-color: #AD2F23;
        }

        @media (max-width: 768px) {
            .register-card {
                flex-direction: column;
            }

            .register-image,
            .register-form {
                width: 100%;
            }
        }
    </style>

    <div class="container register-container">
        <div class="register-card">
            <div class="register-image d-none d-md-block"></div>

            <div class="register-form">
                <h3>{{ __('Create Account') }}</h3>
                <p class="fs-14 fw-400 text-dark">{{ __('Register a new account') }}</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-register btn-lg text-white">
                            {{ __('Register') }}
                        </button>
                    </div>

                    <!-- Already have account -->
                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">{{ __('Already have an account? Login') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection