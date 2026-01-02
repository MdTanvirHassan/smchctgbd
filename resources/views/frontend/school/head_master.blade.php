@extends('frontend.school.layouts.app')

@section('content')
@php
    $headmasterName = get_setting('headmaster_name_' . app()->getLocale()) ?: get_setting('headmaster_name');
    $headmasterDesignation = get_setting('headmaster_designation_' . app()->getLocale()) ?: get_setting('headmaster_designation');
    $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
    $headmasterPhone = get_setting('headmaster_phone');
    $headmasterEmail = get_setting('headmaster_email');
    $headmasterImage = get_setting('headmaster_image');
    $headmasterSpeech = get_setting('headmaster_speech_' . app()->getLocale()) ?: get_setting('headmaster_speech');
@endphp

    <!-- ✅ Header Master -->
    <section class="head-master-section container my-5">
        <div class="row principal-message">
            <div class="col-md-4 principal-photo">
                <img src="{{asset($headmasterImage)}}" alt="{{ $headmasterName }}">
                <div class="text-center mt-3 social-icons">
                    <!-- <i class="fab fa-facebook"></i>
                                                        <i class="fab fa-twitter"></i>
                                                        <i class="fab fa-instagram"></i>
                                                        <i class="fab fa-linkedin"></i> -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="principal-name"><strong>{{ __('head_master.name') ?? 'Name' }}:</strong> {{ $headmasterName }}</div>
                <div class="principal-title mb-2"><strong>{{ __('head_master.designation') }}:</strong> {{ $headmasterDesignation }}</div>
                <div class="principal-school"><strong>{{ __('head_master.school') }}:</strong> {{ $schoolName }}</div>
                <div class="principal-title mt-2"><strong>{{ __('head_master.phone') }}:</strong> {{ $headmasterPhone }}</div>
                <div class="principal-title mt-2"><strong>{{ __('head_master.email') }}:</strong> {{ $headmasterEmail }}</div>
                <div class="quote-text summernote-content">
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