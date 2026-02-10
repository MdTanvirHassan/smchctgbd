@extends('frontend.school.layouts.app')

@section('content')
    @php
        $contactTitle = get_setting('contact_page_title') ?: __('contact_us.page_title');
        $contactSubtitle = get_setting('contact_page_subtitle');
        $contactDescription = get_setting('contact_page_description');
        $contactExtraInfo = get_setting('contact_extra_info');
        $primaryMapUrl = get_setting('contact_map_embed_url');
        $secondaryMapUrl = get_setting('contact_map_embed_url_alt');

        $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
        $schoolAddress = get_setting('school_address_' . app()->getLocale()) ?: get_setting('school_address', 'Mirpur-12, Dhaka');

        $collegeOfficeName = get_setting('college_office_name') ?: 'College Office';
        $collegeOfficeAddress = get_setting('college_office_address') ?: $schoolAddress;
        $collegeOfficePhone = get_setting('college_office_phone') ?: get_setting('school_phone');
        $collegeOfficeEmail = get_setting('college_office_email') ?: get_setting('school_email');
        $collegeOfficeTime = get_setting('college_office_time') ?: __('contact_us.working_hours_schedule');
        $collegeOfficeOffday = get_setting('college_office_offday') ?: __('contact_us.off_day');

        $hospitalOfficeName = get_setting('hospital_office_name') ?: 'Hospital Office';
        $hospitalOfficeAddress = get_setting('hospital_office_address') ?: $schoolAddress;
        $hospitalOfficePhone = get_setting('hospital_office_phone') ?: get_setting('school_phone');
        $hospitalOfficeEmail = get_setting('hospital_office_email') ?: get_setting('school_email');
        $hospitalOfficeTime = get_setting('hospital_office_time') ?: __('contact_us.working_hours_schedule');
        $hospitalOfficeOffday = get_setting('hospital_office_offday') ?: __('contact_us.off_day');
    @endphp
    <!-- ✅ Contact Us -->
    <section class="contact-us-section">
        <div class="container shadow-bg p-4 mt-5 mb-5 bg-light rounded">
            <h1>{{ $contactTitle }}</h1>
            @if($contactSubtitle)
                <p class="text-muted mb-3">{{ $contactSubtitle }}</p>
            @endif

            @if($contactDescription)
                <div class="text-muted">{!! $contactDescription !!}</div>
            @endif

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

                <!-- College Office -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/call.png') }}" class="img-hover" alt="Call Icon" />
                        <h3>{{ $collegeOfficeName }}</h3>
                        <p class="subtitle">{{ $collegeOfficeAddress }}</p>
                        <p class="subtitle">
                            {{ __('contact_us.email') }} :
                            <a href="mailto:{{ $collegeOfficeEmail }}">
                                {{ $collegeOfficeEmail }}
                            </a>
                        </p>
                        <p class="subtitle">
                            {{ __('contact_us.number') }} :
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $collegeOfficePhone) }}">
                                {{ $collegeOfficePhone }}
                            </a>
                        </p>
                        <p class="subtitle">
                            <span class='items'>{{ $collegeOfficeTime }}</span><br>
                            <span class='items'>{{ $collegeOfficeOffday }}</span>
                        </p>


                        <!-- <div id="tooltip-modal">
                                                                                            <div class="tooltip-content">
                                                                                                <img src="" alt="Payment QR" />
                                                                                            </div>
                                                                                        </div> -->
                    </div>
                </div>

                <!-- Hospital Office -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/watch.png') }}" class="img-hover"
                            alt="Hospital Office Icon" />
                        <h3>{{ $hospitalOfficeName }}</h3>
                        <p class="subtitle">{{ $hospitalOfficeAddress }}</p>
                        <p class="subtitle">
                            {{ __('contact_us.email') }} :
                            <a href="mailto:{{ $hospitalOfficeEmail }}">
                                {{ $hospitalOfficeEmail }}
                            </a>
                        </p>
                        <p class="subtitle">
                            {{ __('contact_us.number') }} :
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hospitalOfficePhone) }}">
                                {{ $hospitalOfficePhone }}
                            </a>
                        </p>
                        <p class="subtitle">
                            <span class='items'>{{ $hospitalOfficeTime }}</span><br>
                            <span class='items'>{{ $hospitalOfficeOffday }}</span>
                        </p>
                    </div>
                </div>
            </div>

            @if($contactExtraInfo)
                <div class="mt-3">
                    <div class="text-muted">{!! $contactExtraInfo !!}</div>
                </div>
            @endif

            @php
                $primaryMapIsIframe = $primaryMapUrl && \Illuminate\Support\Str::contains($primaryMapUrl, '<iframe');
                $secondaryMapIsIframe = $secondaryMapUrl && \Illuminate\Support\Str::contains($secondaryMapUrl, '<iframe');
            @endphp
            @if($primaryMapUrl || $secondaryMapUrl)
                <div class="mt-4 row g-3">
                    @if($primaryMapUrl)
                        <div class="col-12 col-lg-6">
                            @if($primaryMapIsIframe)
                                {!! $primaryMapUrl !!}
                            @else
                                <iframe title="Primary map" src="{{ $primaryMapUrl }}" allowfullscreen loading="lazy"
                                    style="border: 0; width: 100%; min-height: 280px; border-radius: 12px;"></iframe>
                            @endif
                        </div>
                    @endif
                    @if($secondaryMapUrl)
                        <div class="col-12 col-lg-6">
                            @if($secondaryMapIsIframe)
                                {!! $secondaryMapUrl !!}
                            @else
                                <iframe title="Additional map" src="{{ $secondaryMapUrl }}" allowfullscreen loading="lazy"
                                    style="border: 0; width: 100%; min-height: 280px; border-radius: 12px;"></iframe>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

@endsection