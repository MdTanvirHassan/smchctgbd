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
                <p>
                    {{ $admissionDescription }}
                </p>
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

@endsection