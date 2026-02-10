@extends('frontend.college.layouts.app')

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
  <div class="container">
    @if($contactDescription)
      <div class="row g-4 mb-3">
        <div class="col-12">
          <div class="contact-card">
            <h4>Contact Information</h4>
            <div>{!! $contactDescription !!}</div>
          </div>
        </div>
      </div>
    @endif

    <div class="row g-4">

      <!-- Location -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-card h-100">
          <div class="icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h4>{{ __('contact_us.our_location') }}</h4>
          <p>
            <a href="https://www.google.com/maps/search/{{ urlencode($schoolAddress) }}"
               target="_blank" rel="noopener" class="link-custom">
              {{ $schoolName }}<br>
              {{ $schoolAddress }}
            </a>
          </p>
        </div>
      </div>

      <!-- College Office -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-card h-100">
          <div class="icon">
            <i class="fas fa-building"></i>
          </div>
          <h4>{{ $collegeOfficeName }}</h4>
          <p>{{ $collegeOfficeAddress }}</p>
          <p>{{ __('contact_us.email') }}:
            <a href="mailto:{{ $collegeOfficeEmail }}" class="link-custom">{{ $collegeOfficeEmail }}</a>
          </p>
          <p>{{ __('contact_us.number') }}:
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $collegeOfficePhone) }}" class="link-custom">{{ $collegeOfficePhone }}</a>
          </p>
          <p>{{ $collegeOfficeTime }}<br>{{ $collegeOfficeOffday }}</p>
        </div>
      </div>

      <!-- Hospital Office -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-card h-100">
          <div class="icon">
            <i class="fas fa-hospital"></i>
          </div>
          <h4>{{ $hospitalOfficeName }}</h4>
          <p>{{ $hospitalOfficeAddress }}</p>
          <p>{{ __('contact_us.email') }}:
            <a href="mailto:{{ $hospitalOfficeEmail }}" class="link-custom">{{ $hospitalOfficeEmail }}</a>
          </p>
          <p>{{ __('contact_us.number') }}:
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hospitalOfficePhone) }}" class="link-custom">{{ $hospitalOfficePhone }}</a>
          </p>
          <p>{{ $hospitalOfficeTime }}<br>{{ $hospitalOfficeOffday }}</p>
        </div>
      </div>

    </div>

    @if($contactExtraInfo)
      <div class="row g-4 mt-3">
        <div class="col-12">
          <div class="contact-card">
            <h4>Additional Information</h4>
            <div>{!! $contactExtraInfo !!}</div>
          </div>
        </div>
      </div>
    @endif

    @php
      $primaryMapIsIframe = $primaryMapUrl && \Illuminate\Support\Str::contains($primaryMapUrl, '<iframe');
      $secondaryMapIsIframe = $secondaryMapUrl && \Illuminate\Support\Str::contains($secondaryMapUrl, '<iframe');
    @endphp
    @if($primaryMapUrl || $secondaryMapUrl)
      <div class="row g-4 mt-3">
        <div class="col-12">
          <div class="contact-card">
            <h4>Maps</h4>
            <div class="row g-3 contact-map">
              @if($primaryMapUrl)
                <div class="col-12 col-lg-6">
                  @if($primaryMapIsIframe)
                    {!! $primaryMapUrl !!}
                  @else
                    <iframe title="Primary map" src="{{ $primaryMapUrl }}" allowfullscreen loading="lazy"></iframe>
                  @endif
                </div>
              @endif
              @if($secondaryMapUrl)
                <div class="col-12 col-lg-6">
                  @if($secondaryMapIsIframe)
                    {!! $secondaryMapUrl !!}
                  @else
                    <iframe title="Additional map" src="{{ $secondaryMapUrl }}" allowfullscreen loading="lazy"></iframe>
                  @endif
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endif

  </div>
</section>

<style>
.contact-card {
  background: #00465b; /* solid dark for readability */
  border-radius: 20px;
  padding: 35px 25px;
  text-align: center;
  color: #eee;
  position: relative;
  border: 2px solid transparent;
  transition: all 0.4s ease;
  overflow: hidden;
}

.contact-card:hover {
  border-color: #00d1ff;
  box-shadow: 0 0 25px rgba(0, 209, 255, 0.6);
  transform: translateY(-8px);
}

.contact-card .icon {
  margin-bottom: 18px;
}

.contact-card .icon i {
  font-size: 2.2rem;
  color: #00d1ff;
  background: rgba(0, 209, 255, 0.15);
  border-radius: 50%;
  padding: 16px;
  transition: transform 0.3s ease, background 0.3s ease;
}

.contact-card:hover .icon i {
  transform: scale(1.15);
  background: rgba(0, 209, 255, 0.35);
}

.contact-card h4 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #fff;
  margin-bottom: 12px;
}

.contact-card p {
  margin: 0;
  font-size: 0.95rem;
  color: #ccc;
}

.link-custom {
  color: #00d1ff;
  font-weight: 600;
  text-decoration: none;
}

.link-custom:hover {
  text-decoration: underline;
  color: #fff;
}

.contact-map iframe {
  width: 100%;
  min-height: 280px;
  border: 0;
  border-radius: 12px;
}

@media (max-width: 768px) {
  .contact-card {
    text-align: center;
  }
}
</style>

@endsection