@extends('frontend.' . get_setting('template_name') . '.layouts.app')
@section('content')
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        max-width: 850px;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }

    .login-form {
        padding: 3rem;
        flex: 1 1 50%;
    }

    .login-image {
        flex: 1 1 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        padding: 1rem;
    }

    .login-image img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .main-logo {
        max-width: 250px;
        /* Adjust the main image size */
    }

    .collab-logo1 {
        max-width: 100px !important;
    }

    .collab-logo2 {
        max-width: 180px !important;
    }

    @media (max-width: 768px) {
        .login-image {
            display: none;
            /* hide on mobile */
        }
    }

    .form-control:focus {
        border-color: #00465b;
        box-shadow: 0 0 0 0.2rem #00465b41;
    }

    .login-form h3 {
        font-weight: bold;
        color: #00465b;
    }

    .btn-login {
        background-color: #00465b;
        border: none;
        width: 100%;
    }

    .btn-login:hover {
        background-color: #AD2F23;
    }

    @media (max-width: 768px) {
        .login-card {
            flex-direction: column;
        }

        .login-image,
        .login-form {
            flex: 1 1 100%;
        }

        .login-image {
            padding: 2rem 1rem;
        }
    }
</style>

<div class="container login-container mt-4">
    <div class="login-card">
        <!-- Left Image -->
        <div class="login-image d-none d-md-flex flex-column align-items-center justify-content-center gap-3">
            <!-- Top small collaborator logo -->
            <img src="https://fouraxiz.com/wp-content/uploads/2023/02/logoo.png.webp"
                alt="Collaborator 2" class="collab-logo1">

            <!-- Main login image -->
            <img src="https://biddaniketon.com/wp-content/uploads/2025/03/biddaiketon1.png"
                alt="Main Login" class="main-logo">

            <!-- Bottom small collaborator logo -->
            <img src="https://biddaniketon.com/wp-content/uploads/2025/03/cropped-biddaniketon-logo-1-3-768x149.png"
                alt="Collaborator 1" class="collab-logo2">
        </div>

        <!-- Login Form -->
        <div class="login-form">
            <p class="fs-14 mb-0 fw-semibold text-danger">{{ __('Welcome to') }}</p>
            <h3>{{ get_setting('school_name') }}</h3>
            <p class="fs-14 fw-400 text-dark">{{ __('Login to your account') }}</p>

            <!-- Display Session Messages -->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div>

                <!-- Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-login btn-lg text-white">
                        {{ __('Login') }}
                    </button>
                </div>

                <!-- Forgot Password -->
                <!-- @if (Route::has('password.request'))
                    <div class="mt-3 text-center">
                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    </div>
                @endif -->
            </form>
        </div>
    </div>
</div>
@endsection