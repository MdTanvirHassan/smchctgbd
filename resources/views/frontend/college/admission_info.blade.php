@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">ভর্তি তথ্য</h1>
    </div>
</section>

<!-- ✅ Admission Information -->
<section class="admission-info-section py-5">
    <div class="container p-4 rounded-4 shadow-sm bg-light position-relative overflow-hidden">

        <!-- Decorative background shapes -->
        <div class="bg-shape"></div>

        <!-- Title -->
        <h2 class="admission-title text-center mb-4">ভর্তি তথ্য</h2>

        <div class="row g-5 align-items-center">

            <!-- Admission Content -->
            <div class="col-md-7">
                <div class="admission-content p-4 rounded-3 bg-white shadow-sm">
                    <p class="fs-5 text-muted">
                        {{ get_setting('admission_description') }}
                    </p>

                    <p class="mt-3 fs-5">
                        <strong>ফরম মূল্য :</strong> {{ get_setting('monthly_fee') }} <br>
                        <strong>ভর্তি ফি :</strong> {{ get_setting('admission_fee') }}
                    </p>

                    <div class="principal-signature mt-5 pt-3 border-top text-end">
                        <strong>{{get_setting('headmaster_name')}}</strong><br>
                        <span class="text-muted">{{get_setting('headmaster_designation')}}</span><br>
                        <span>{{ get_setting('school_name') }}</span>
                    </div>
                </div>

                <!-- Apply Button -->

            </div>

            <!-- Form Image -->
            <div class="col-md-5">
                <div class="form-img">
                    <img src="{{ get_setting('admission_form_image') }}"
                        alt="Student Application Form"
                        class="img-fluid rounded-4 shadow-sm border">
                </div>

                <div class="apply-btn mt-4 text-end">
                    <a href="{{ get_setting('admission_form_image') }}"
                        download="admission_form.jpg"
                        class="btn btn-success btn-lg px-4 rounded-pill shadow-sm">
                        Download
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