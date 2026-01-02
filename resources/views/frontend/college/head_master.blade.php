@extends('frontend.college.layouts.app')

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
        <h1 class="display-4 fw-bold mb-0">{{ __('head_master.principal') }}</h1>
        <h2 class="mt-3">{{ __('head_master.principal_subtitle') }}</h2>
    </div>
</section>
<!-- ✅ Headmaster Section -->
<section class="head-master-section container my-5">
    <div class="row align-items-center principal-message">

        <!-- Photo -->
        <div class="col-md-4 text-center principal-photo mb-4 mb-md-0">
            @php
                $headmasterImage = get_setting('headmaster_image');
                $headmasterName = get_setting('headmaster_name_' . app()->getLocale()) ?: get_setting('headmaster_name');
            @endphp
            <img src="{{ asset($headmasterImage) }}"
                alt="{{ $headmasterName }}"
                class="img-fluid rounded-circle shadow-lg border border-3 border-white">
        </div>

        <!-- Details -->
        <div class="col-md-8 d-flex flex-column justify-content-between">

            <!-- Name & Social -->
            <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                <div>
                    @php
                        $headmasterName = get_setting('headmaster_name_' . app()->getLocale()) ?: get_setting('headmaster_name');
                        $headmasterDesignation = get_setting('headmaster_designation_' . app()->getLocale()) ?: get_setting('headmaster_designation');
                        $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
                        $headmasterPhone = get_setting('headmaster_phone');
                        $headmasterEmail = get_setting('headmaster_email');
                    @endphp
                    <h3 class="principal-name fw-bold mb-1">{{ $headmasterName }}</h3>
                    <p class="principal-title text-muted mb-1">
                        <strong>{{ __('head_master.designation') }}:</strong> {{ $headmasterDesignation }}
                    </p>
                    <p class="principal-school fw-semibold mb-1">
                        <strong>{{ __('head_master.school') }}:</strong> {{ $schoolName }}
                    </p>
                    <p class="principal-contact mb-1">
                        <i class="fas fa-phone-alt me-2"></i><strong>{{ __('head_master.phone') }}:</strong> {{ $headmasterPhone }}
                    </p>
                    <p class="principal-contact mb-0">
                        <i class="fas fa-envelope me-2"></i><strong>{{ __('head_master.email') }}:</strong> {{ $headmasterEmail }}
                    </p>
                </div>

                <!-- Social Icons -->
                <div class="social-icons text-end">
                    <a href="{{ get_setting('headmaster_facebook') }}" class="mx-2 text-primary"><i class="fab fa-facebook fa-lg"></i></a>

                    <a href="{{ get_setting('headmaster_instagram') }}" class="mx-2 text-danger"><i class="fab fa-instagram fa-lg"></i></a> <a href="{{ get_setting('headmaster_linkedin') }}" class="mx-2 text-primary"><i class="fab fa-linkedin fa-lg"></i></a>

                </div>
            </div>

            <!-- Quote -->
            <div class="quote-text mt-4 p-3 rounded shadow-sm bg-light text-dark summernote-content">
                @php
                    $headmasterSpeech = get_setting('headmaster_speech_' . app()->getLocale()) ?: get_setting('headmaster_speech');
                @endphp
                {!! $headmasterSpeech !!}
            </div>

        </div>
    </div>
</section>

<style>
    /* Styles for Summernote rich text content */
    .summernote-content {
        word-wrap: break-word;
    }
    
    .summernote-content p {
        margin-bottom: 1rem;
    }
    
    .summernote-content ul,
    .summernote-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .summernote-content li {
        margin-bottom: 0.5rem;
    }
    
    .summernote-content h1,
    .summernote-content h2,
    .summernote-content h3,
    .summernote-content h4,
    .summernote-content h5,
    .summernote-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .summernote-content table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    
    .summernote-content table td,
    .summernote-content table th {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .summernote-content table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .summernote-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    .summernote-content a {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    .summernote-content a:hover {
        color: #0a58ca;
    }
</style>
@endsection