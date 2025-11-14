<!-- ✅ Header -->
<section class="headers-section">
  <div class="container-fluid header-section">
    <div class="row align-items-center text-center">
      <div class="col-md-2">
        <a href="#"><img
            src="{{ asset(get_setting('left_logo', 'left')) }}"
            alt="Left Logo" class="school-logo"></a>
      </div>
      <div class="col-md-8">
        <a href="#">
          <h2 class="school-title">{{ get_setting('school_name', 'Biddaniketon College || 4axiz') }}</h2>
        </a>
        <span class="school-subtitle">{{ get_setting('school_address', 'Mirpur-12, Dhaka') }}</span>
        <br>
        <span class="school-estd">{{ get_setting('school_est', '2024') }}, {{ get_setting('school_eiin', '100001') }}</span>
      </div>
      <div class="col-md-2">
        <a href="#"><img
            src="{{ asset(get_setting('right_logo', 'right')) }}"
            alt="Right Logo" class="school-logo"></a>
      </div>
    </div>
  </div>
</section>
<!-- ✅ Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top ">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      @php
        $currentLocale = app()->getLocale();
      @endphp
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('header.home') }}</a>
        </li>

        <!-- প্রশাসন -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('head_master','teacher_team','governing_body') ? 'active' : '' }}" href="#" role="button"
            data-bs-toggle="dropdown">{{ __('header.administration') }}</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item {{ request()->routeIs('head_master') ? 'active' : '' }}" href="{{ route('head_master') }}">{{ __('header.head_teacher') }}</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('teacher_team') ? 'active' : '' }}" href="{{ route('teacher_team') }}">{{ __('header.teacher_team') }}</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('governing_body') ? 'active' : '' }}" href="{{ route('governing_body') }}">{{ __('header.governing_body') }}</a></li>
          </ul>
        </li>

        <!-- শিক্ষার্থী -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('total_students','class_summery') ? 'active' : '' }}" href="#" role="button"
            data-bs-toggle="dropdown">{{ __('header.students') }}</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item {{ request()->routeIs('total_students') ? 'active' : '' }}" href="{{ route('total_students') }}">{{ __('header.seat_capacity') }}</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('class_summery') ? 'active' : '' }}" href="{{ route('class_summery') }}">{{ __('header.class_summary') }}</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('admission_info') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">{{ __('header.admission') }}</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admission_info') }}">{{ __('header.admission_info') }}</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link {{ request()->routeIs('routine') ? 'active' : '' }}" href="{{ route('routine') }}">{{ __('header.routine') }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('exam_result') ? 'active' : '' }}" href="{{ route('exam_result') }}">{{ __('header.results') }}</a></li>

        <!-- Notice & Meeting Minutes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('notice','meeting_minutes') ? 'active' : '' }}" href="#" role="button"
            data-bs-toggle="dropdown">{{ __('header.notice') }}</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item {{ request()->routeIs('notice') ? 'active' : '' }}" href="{{ route('notice') }}">{{ __('header.notice') }}</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('meeting_minutes') ? 'active' : '' }}" href="{{ route('meeting_minutes') }}">{{ __('header.meeting_minutes') }}</a></li>
          </ul>
        </li>
        
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('event') ? 'active' : '' }}" href="{{ route('event') }}">{{ __('header.event') }}</a></li>
        
        <!-- Gallery Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('image_category','image_gallery','video_category','video_gallery') ? 'active' : '' }}" href="#" role="button"
            data-bs-toggle="dropdown">{{ __('header.gallery') }}</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item {{ request()->routeIs('image_category','image_gallery') ? 'active' : '' }}" href="{{ route('image_category') }}">{{ __('header.image_gallery') }}</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('video_category','video_gallery') ? 'active' : '' }}" href="{{ route('video_category') }}">{{ __('header.video_gallery') }}</a></li>
          </ul>
        </li>
        
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact_us') ? 'active' : '' }}" href="{{ route('contact_us') }}">{{ __('header.contact') }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('header.login') }}</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ $currentLocale === 'bn' ? __('header.language_bangla') : __('header.language_english') }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
            <li>
              <a class="dropdown-item {{ $currentLocale === 'en' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'en']) }}">
                {{ __('header.language_english') }}
              </a>
            </li>
            <li>
              <a class="dropdown-item {{ $currentLocale === 'bn' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'bn']) }}">
                {{ __('header.language_bangla') }}
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>