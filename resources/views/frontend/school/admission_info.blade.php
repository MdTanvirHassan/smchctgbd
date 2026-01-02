@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Admission Information -->
    <section class="admission-info-section">
        <div class="container admission-section">
            <div class="admission-title">{{ __('admission_info.section_title') }}</div>

            <div class="admission-content">
                @php
                    $admissionDescription = get_setting('admission_description_' . app()->getLocale()) ?: get_setting('admission_description');
                @endphp
                <div class="summernote-content">
                    {!! $admissionDescription !!}
                </div>
                <p><strong>{{ __('admission_info.form_price') }} :</strong> {{ get_setting('monthly_fee') }}<br><strong>{{ __('admission_info.admission_fee') }} :</strong> {{ get_setting('admission_fee') }}</p>

                <div class="principal-signature">
                    @php
                        $headmasterName = get_setting('headmaster_name_' . app()->getLocale()) ?: get_setting('headmaster_name');
                        $headmasterDesignation = get_setting('headmaster_designation_' . app()->getLocale()) ?: get_setting('headmaster_designation');
                        $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
                    @endphp
                    <strong>{{ $headmasterName }}</strong>
                    {{ $headmasterDesignation }}<br>
                    {{ $schoolName }}<br>
                </div>
            </div>

            <div class="form-img">
                <img src="{{ get_setting('admission_form_image') }}" alt="{{ __('admission_info.form_image_alt') }}">
            </div>
            <div class="apply-btn">
                <a href="{{ get_setting('admission_form_image') }}" 
                   download="admission_form.jpg" 
                   class="btn btn-success btn-lg mt-3">{{ __('admission_info.download') }}</a>
            </div>
        </div>

    </section>

<style>
    /* Styles for Summernote rich text content */
    .admission-info-section .summernote-content {
        word-wrap: break-word;
    }
    
    .admission-info-section .summernote-content p {
        margin-bottom: 1rem;
    }
    
    .admission-info-section .summernote-content ul,
    .admission-info-section .summernote-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .admission-info-section .summernote-content li {
        margin-bottom: 0.5rem;
    }
    
    .admission-info-section .summernote-content h1,
    .admission-info-section .summernote-content h2,
    .admission-info-section .summernote-content h3,
    .admission-info-section .summernote-content h4,
    .admission-info-section .summernote-content h5,
    .admission-info-section .summernote-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .admission-info-section .summernote-content table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    
    .admission-info-section .summernote-content table td,
    .admission-info-section .summernote-content table th {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .admission-info-section .summernote-content table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .admission-info-section .summernote-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    .admission-info-section .summernote-content a {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    .admission-info-section .summernote-content a:hover {
        color: #0a58ca;
    }
</style>
@endsection