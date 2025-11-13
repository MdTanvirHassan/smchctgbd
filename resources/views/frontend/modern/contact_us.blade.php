@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">যোগাযোগ</h1>
    </div>
</section>


<section class="contact-us-section my-5">
  <div class="container shadow-sm rounded p-5">
    <div class="row text-center text-md-start g-4">

      <!-- Location -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-item d-flex flex-column align-items-center align-items-md-start">
          <div class="icon mb-3">
            <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
          </div>
          <h4 class="mb-3 fw-bold">Our Location</h4>
          <p class="mb-0">
            <a href="https://www.google.com/maps/search/{{ urlencode(get_setting('school_address')) }}" target="_blank" rel="noopener" class="text-decoration-none text-dark">
              {{ get_setting('school_name') }}<br>
              {{ get_setting('school_address') }}
            </a>
          </p>
        </div>
      </div>

      <!-- Call Us -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-item d-flex flex-column align-items-center align-items-md-start">
          <div class="icon mb-3">
            <i class="fas fa-phone fa-3x text-primary"></i>
          </div>
          <h4 class="mb-3 fw-bold">Call Us</h4>
          <p class="mb-1">
            ইমেইল: 
            <a href="mailto:{{ get_setting('school_email') }}" class="text-decoration-none text-dark">
              {{ get_setting('school_email') }}
            </a>
          </p>
          <p class="mb-0">
            নম্বর: 
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('school_phone')) }}" class="text-decoration-none text-dark">
              {{ get_setting('school_phone') }}
            </a>
          </p>
        </div>
      </div>

      <!-- Working Hours -->
      <div class="col-md-4 col-sm-6">
        <div class="contact-item d-flex flex-column align-items-center align-items-md-start">
          <div class="icon mb-3">
            <i class="fas fa-clock fa-3x text-primary"></i>
          </div>
          <h4 class="mb-3 fw-bold">Working Hours</h4>
          <p class="text-muted mb-0">
            <span>Sat-Thurs: 8AM to 6PM</span><br>
            <span>Off Day: Friday</span>
          </p>
        </div>
      </div>

    </div>
  </div>
</section>



@endsection