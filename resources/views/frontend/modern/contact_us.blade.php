@extends('frontend.modern.layouts.app')

@section('content')
@php
  $contactTitle = get_setting('contact_page_title') ?: __('contact_us.page_title');
  $contactSubtitle = get_setting('contact_page_subtitle');
  $contactDescription = get_setting('contact_page_description');
  $contactExtraInfo = get_setting('contact_extra_info');
  $primaryMapUrl = get_setting('contact_map_embed_url');
  $secondaryMapUrl = get_setting('contact_map_embed_url_alt');

  $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
  $schoolAddress = get_setting('school_address_' . app()->getLocale()) ?: get_setting('school_address');

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
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
  <div class="hero-inner py-4">
    <h1 class="display-4 fw-bold mb-0">{{ $contactTitle }}</h1>
    @if($contactSubtitle)
      <p class="lead mb-0">{{ $contactSubtitle }}</p>
    @endif
  </div>
</section>


<section class="contact-us-section my-5">
  <div class="container shadow-sm rounded p-5">
    @if($contactDescription)
      <div class="row mb-4">
        <div class="col-12">
          <div class="mb-0">{!! $contactDescription !!}</div>
        </div>
      </div>
    @endif

    <div class="row text-center text-md-start g-4">

      <!-- Location -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-item d-flex flex-column align-items-center align-items-md-start">
          <div class="icon mb-3">
            <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
          </div>
          <h4 class="mb-3 fw-bold">{{ __('contact_us.our_location') }}</h4>
          <p class="mb-0">
            @php
              $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
              $schoolAddress = get_setting('school_address_' . app()->getLocale()) ?: get_setting('school_address');
            @endphp
            <a href="https://www.google.com/maps/search/{{ urlencode($schoolAddress) }}" target="_blank" rel="noopener" class="text-decoration-none text-dark">
              {{ $schoolName }}<br>
              {{ $schoolAddress }}
            </a>
          </p>
        </div>
      </div>

      <!-- College Office -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-item d-flex flex-column align-items-center align-items-md-start">
          <div class="icon mb-3">
            <i class="fas fa-building fa-3x text-primary"></i>
          </div>
          <h4 class="mb-3 fw-bold">{{ $collegeOfficeName }}</h4>
          <p class="mb-1">{{ $collegeOfficeAddress }}</p>
          <p class="mb-1">
            {{ __('contact_us.email') }}:
            <a href="mailto:{{ $collegeOfficeEmail }}" class="text-decoration-none text-dark">{{ $collegeOfficeEmail }}</a>
          </p>
          <p class="mb-1">
            {{ __('contact_us.number') }}:
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $collegeOfficePhone) }}" class="text-decoration-none text-dark">{{ $collegeOfficePhone }}</a>
          </p>
          <p class="mb-0 text-muted">{{ $collegeOfficeTime }}<br>{{ $collegeOfficeOffday }}</p>
        </div>
      </div>

      <!-- Hospital Office -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-item d-flex flex-column align-items-center align-items-md-start">
          <div class="icon mb-3">
            <i class="fas fa-hospital fa-3x text-primary"></i>
          </div>
          <h4 class="mb-3 fw-bold">{{ $hospitalOfficeName }}</h4>
          <p class="mb-1">{{ $hospitalOfficeAddress }}</p>
          <p class="mb-1">
            {{ __('contact_us.email') }}:
            <a href="mailto:{{ $hospitalOfficeEmail }}" class="text-decoration-none text-dark">{{ $hospitalOfficeEmail }}</a>
          </p>
          <p class="mb-1">
            {{ __('contact_us.number') }}:
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hospitalOfficePhone) }}" class="text-decoration-none text-dark">{{ $hospitalOfficePhone }}</a>
          </p>
          <p class="mb-0 text-muted">{{ $hospitalOfficeTime }}<br>{{ $hospitalOfficeOffday }}</p>
        </div>
      </div>

    </div>

    @if($contactExtraInfo)
      <div class="row mt-4">
        <div class="col-12">
          <div class="text-muted mb-0">{!! $contactExtraInfo !!}</div>
        </div>
      </div>
    @endif

    @php
      $primaryMapIsIframe = $primaryMapUrl && \Illuminate\Support\Str::contains($primaryMapUrl, '<iframe');
      $secondaryMapIsIframe = $secondaryMapUrl && \Illuminate\Support\Str::contains($secondaryMapUrl, '<iframe');
    @endphp
    @if($primaryMapUrl || $secondaryMapUrl)
      <div class="row mt-4 g-3">
        @if($primaryMapUrl)
          <div class="col-12 col-lg-6">
            @if($primaryMapIsIframe)
              {!! $primaryMapUrl !!}
            @else
              <iframe title="Primary map" src="{{ $primaryMapUrl }}" allowfullscreen loading="lazy" style="width: 100%; min-height: 280px; border: 0; border-radius: 12px;"></iframe>
            @endif
          </div>
        @endif
        @if($secondaryMapUrl)
          <div class="col-12 col-lg-6">
            @if($secondaryMapIsIframe)
              {!! $secondaryMapUrl !!}
            @else
              <iframe title="Additional map" src="{{ $secondaryMapUrl }}" allowfullscreen loading="lazy" style="width: 100%; min-height: 280px; border: 0; border-radius: 12px;"></iframe>
            @endif
          </div>
        @endif
      </div>
    @endif
  </div>
</section>



@endsection