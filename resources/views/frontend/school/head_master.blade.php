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
                <div class="quote-text">
                    "{{ $headmasterSpeech }}"
                </div>
            </div>
        </div>
    </section>

@endsection