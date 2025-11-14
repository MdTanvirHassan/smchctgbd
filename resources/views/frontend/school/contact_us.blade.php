@extends('frontend.school.layouts.app')

@section('content')
    <!-- ✅ Contact Us -->
    <section class="contact-us-section">
        <div class="container shadow-bg p-4 mt-5 mb-5 bg-light rounded">
            <h1>{{ __('contact_us.page_title') }}</h1>

            <div class="row">
                <!-- Location -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/location.png') }}" class="img-hover" alt="Location Icon" />
                        <h3>{{ __('contact_us.our_location') }}</h3>
                        <p class="subtitle">
                            @php
                              $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
                              $schoolAddress = get_setting('school_address_' . app()->getLocale()) ?: get_setting('school_address', 'Mirpur-12, Dhaka');
                            @endphp
                            {{ $schoolName }}<br>
                            {{ $schoolAddress }}
                        </p>
                    </div>
                </div>

                <!-- Call Us -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/call.png') }}" class="img-hover" alt="Call Icon" />
                        <h3>{{ __('contact_us.call_us') }}</h3>
                        <p class="subtitle">
                            {{ __('contact_us.email') }} :
                            <a href="mailto:{{ get_setting('school_email') }}">
                                {{ get_setting('school_email') }}
                            </a>
                        </p>
                        <p class="subtitle">
                            {{ __('contact_us.number') }} :
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('school_phone')) }}">
                                {{ get_setting('school_phone') }}
                            </a>
                        </p>


                        <!-- <div id="tooltip-modal">
                                                                                            <div class="tooltip-content">
                                                                                                <img src="" alt="Payment QR" />
                                                                                            </div>
                                                                                        </div> -->
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/watch.png') }}" class="img-hover"
                            alt="Working Hours Icon" />
                        <h3>{{ __('contact_us.working_hours') }}</h3>
                        <p class="subtitle">
                            <span class='items'>
                                {{ __('contact_us.working_hours_schedule') }}
                            </span><br>
                            <span class='items'>{{ __('contact_us.off_day') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Google Map -->
            <!-- <div class="mt-4">
                                                                                <iframe allowfullscreen height="450" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src=""
                                                                                    style="border: 0; width: 100%;"></iframe>
                                                                            </div> -->
        </div>
    </section>

@endsection