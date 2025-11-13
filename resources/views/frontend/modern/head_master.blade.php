@extends('frontend.modern.layouts.app')

@section('content')
<style>
    .quote-text {
        background: #f8f9fa;
        border-left: 5px solid #00788c;
        font-style: italic;
    }
</style>
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">প্রধান শিক্ষক</h1>
        <h2 class="mt-3">আমাদের সম্মানিত প্রধান শিক্ষক</h2>
    </div>
</section>
<!-- ✅ Headmaster Section -->
<section class="head-master-section container my-5">
    <div class="row align-items-center principal-message">

        <!-- Photo -->
        <div class="col-md-4 text-center principal-photo mb-4 mb-md-0">
            <img src="{{ asset(get_setting('headmaster_image')) }}"
                alt="{{ get_setting('headmaster_name') }}"
                class="img-fluid rounded-circle shadow-lg border border-3 border-white">
        </div>

        <!-- Details -->
        <div class="col-md-8 d-flex flex-column justify-content-between">

            <!-- Name & Social -->
            <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                <div>
                    <h3 class="principal-name fw-bold mb-1">{{ get_setting('headmaster_name') }}</h3>
                    <p class="principal-title text-muted mb-1">{{ get_setting('headmaster_designation') }}</p>
                    <p class="principal-school fw-semibold mb-1">{{ get_setting('school_name') }}</p>
                    <p class="principal-contact mb-1">
                        <i class="fas fa-phone-alt me-2"></i>{{ get_setting('headmaster_phone') }}
                    </p>
                    <p class="principal-contact mb-0">
                        <i class="fas fa-envelope me-2"></i>{{ get_setting('headmaster_email') }}
                    </p>
                </div>

                <!-- Social Icons -->
                <div class="social-icons text-end">
                    <a href="{{ get_setting('headmaster_facebook') }}" class="mx-2 text-primary"><i class="fab fa-facebook fa-lg"></i></a>

                    <a href="{{ get_setting('headmaster_instagram') }}" class="mx-2 text-danger"><i class="fab fa-instagram fa-lg"></i></a> <a href="{{ get_setting('headmaster_linkedin') }}" class="mx-2 text-primary"><i class="fab fa-linkedin fa-lg"></i></a>

                </div>
            </div>

            <!-- Quote -->
            <div class="quote-text mt-4 p-3 rounded shadow-sm bg-light text-dark fst-italic">
                "{{ get_setting('headmaster_speech') }}"
            </div>

        </div>
    </div>
</section>

@endsection