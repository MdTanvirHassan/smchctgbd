@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
  <div class="hero-inner py-4">
    <h1 class="display-4 fw-bold mb-0">{{ __('contact_us.page_title') }}</h1>
  </div>
</section>


<section class="contact-us-section my-5">
  <div class="container">
    <div class="row g-4">

      <!-- Location -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-card h-100">
          <div class="icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h4>{{ __('contact_us.our_location') }}</h4>
          <p>
            @php
              $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name');
              $schoolAddress = get_setting('school_address_' . app()->getLocale()) ?: get_setting('school_address');
            @endphp
            <a href="https://www.google.com/maps/search/{{ urlencode($schoolAddress) }}" 
               target="_blank" rel="noopener" class="link-custom">
              {{ $schoolName }}<br>
              {{ $schoolAddress }}
            </a>
          </p>
        </div>
      </div>

      <!-- Call Us -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-card h-100">
          <div class="icon">
            <i class="fas fa-phone"></i>
          </div>
          <h4>{{ __('contact_us.call_us') }}</h4>
          <p>{{ __('contact_us.email') }}: 
            <a href="mailto:{{ get_setting('school_email') }}" class="link-custom">
              {{ get_setting('school_email') }}
            </a>
          </p>
          <p>{{ __('contact_us.number') }}: 
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('school_phone')) }}" class="link-custom">
              {{ get_setting('school_phone') }}
            </a>
          </p>
        </div>
      </div>

      <!-- Working Hours -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-card h-100">
          <div class="icon">
            <i class="fas fa-clock"></i>
          </div>
          <h4>{{ __('contact_us.working_hours') }}</h4>
          <p>
            {{ __('contact_us.working_hours_schedule') }}<br>
            {{ __('contact_us.off_day') }}
          </p>
        </div>
      </div>

    </div>
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

@media (max-width: 768px) {
  .contact-card {
    text-align: center;
  }
}
</style>

@endsection