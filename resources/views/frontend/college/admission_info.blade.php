@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('admission_info.page_title') }}</h1>
    </div>
</section>

<!-- ✅ Admission Information -->
<section class="admission-info-section py-5">
    <div class="container p-4 rounded-4 shadow-sm bg-light position-relative overflow-hidden">

        <!-- Decorative background shapes -->
        <div class="bg-shape"></div>

        <!-- Title -->
        <h2 class="admission-title text-center mb-4">{{ __('admission_info.section_title') }}</h2>

        <div class="row g-5 align-items-center">

            <!-- Admission Content -->
            <div class="col-md-7">
                <div class="admission-content p-4 rounded-3 bg-white shadow-sm">
                    @php
                        $admissionDescription = get_setting('admission_description_' . app()->getLocale()) ?: get_setting('admission_description');
                    @endphp
                    <p class="fs-5 text-muted">
                        {{ $admissionDescription }}
                    </p>

                    <p class="mt-3 fs-5">
                        <strong>{{ __('admission_info.form_price') }} :</strong> {{ get_setting('monthly_fee') }} <br>
                        <strong>{{ __('admission_info.admission_fee') }} :</strong> {{ get_setting('admission_fee') }}
                    </p>

                    <div class="principal-signature mt-5 pt-3 border-top text-end">
                        @php
                            $headmasterName = get_setting('headmaster_name_' . app()->getLocale()) ?: get_setting('headmaster_name');
                            $headmasterDesignation = get_setting('headmaster_designation_' . app()->getLocale()) ?: get_setting('headmaster_designation');
                            $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
                        @endphp
                        <strong>{{ $headmasterName }}</strong><br>
                        <span class="text-muted">{{ $headmasterDesignation }}</span><br>
                        <span>{{ $schoolName }}</span>
                    </div>
                </div>

                <!-- Apply Button -->

            </div>

            <!-- Form Image -->
            <div class="col-md-5">
                <div class="form-img">
                    <img src="{{ get_setting('admission_form_image') }}"
                        alt="{{ __('admission_info.form_image_alt') }}"
                        class="img-fluid rounded-4 shadow-sm border">
                </div>

                <div class="apply-btn mt-4 text-end">
                    <a href="{{ get_setting('admission_form_image') }}"
                        download="admission_form.jpg"
                        class="btn btn-success btn-lg px-4 rounded-pill shadow-sm">
                        {{ __('admission_info.download') }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
<style>
    .admission-title {
        font-size: 2rem;
        font-weight: 700;
        color: #00465b;
        position: relative;
        display: inline-block;
    }

    .admission-title::after {
        content: "";
        display: block;
        width: 60px;
        height: 4px;
        margin: 8px auto 0;
        background: #00465b;
        border-radius: 4px;
    }

    .bg-shape {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(40, 167, 69, 0.1);
        border-radius: 50%;
        z-index: 0;
    }

    .admission-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .apply-btn .btn {
        transition: all 0.3s ease;
    }

    .apply-btn .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px #00465b;
    }
</style>
@endsection