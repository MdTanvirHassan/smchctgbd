<!-- Top Bar -->
<div class="top-bar bg-primary text-white py-2 small">
  <div class="container">
    <div class="row align-items-center">
      <!-- Contact Info -->
      <div class="col-md-8 d-flex flex-wrap align-items-center gap-3">
        <span><i class="fas fa-phone me-1"></i>{{ get_setting('school_phone') }}</span>
        <span><i class="fas fa-envelope me-1"></i>{{ get_setting('school_email') }}</span>
        <span><i class="fas fa-map-marker-alt me-1"></i>{{ get_setting('school_address', 'Mirpur-12, Dhaka') }}</span>

      </div>

      <!-- Social Links -->
      <div class="col-md-4 text-md-end text-center">
        <span>Established: {{ get_setting('school_est', '2024') }}</span>
      </div>
    </div>
  </div>
</div>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container-fluid mx-5">
    <!-- Logo & Name -->
    <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset(get_setting('school_logo', 'school')) }}" alt="Logo" class="rounded-circle me-2" width="40" height="40">
      {{ get_setting('school_name', 'Biddaniketon College || 4axiz') }}
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Items -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">প্রচ্ছদ</a></li>

        <!-- প্রশাসন -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('head_master','teacher_team') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">প্রশাসন</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item {{ request()->routeIs('head_master') ? 'active' : '' }}" href="{{ route('head_master') }}">প্রধান শিক্ষক</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('teacher_team') ? 'active' : '' }}" href="{{ route('teacher_team') }}">শিক্ষকবৃন্দ</a></li>
          </ul>
        </li>

        <!-- শিক্ষার্থী -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('total_students','class_summery') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">শিক্ষার্থী</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item {{ request()->routeIs('total_students') ? 'active' : '' }}" href="{{ route('total_students') }}">আসন সংখ্যা</a></li>
            <li><a class="dropdown-item {{ request()->routeIs('class_summery') ? 'active' : '' }}" href="{{ route('class_summery') }}">শ্রেণি বিবরণ</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link {{ request()->routeIs('routine') ? 'active' : '' }}" href="{{ route('routine') }}">রুটিন</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('exam_result') ? 'active' : '' }}" href="{{ route('exam_result') }}">ফলাফল</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('notice') ? 'active' : '' }}" href="{{ route('notice') }}">নোটিশ</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('event') ? 'active' : '' }}" href="{{ route('event') }}">ইভেন্ট</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('image_category') ? 'active' : '' }}" href="{{ route('image_category') }}">গ্যালারী</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact_us') ? 'active' : '' }}" href="{{ route('contact_us') }}">যোগাযোগ</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Floating EIIN & Social Links -->
<div class="floating-info">
  <div class="eiin">{{ get_setting('school_eiin', '100001') }}</div>
  <div class="social-icons">
    <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
    <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube" title="YouTube"><i class="fab fa-youtube"></i></a>
  </div>
</div>



<style>
  /* Floating Container */
  .floating-info {
    position: fixed;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
  }

  /* EIIN Badge */
  .floating-info .eiin {
    width: 44px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(32, 32, 32, 0.95);
    color: #fff;
    border-radius: 8px;
    font-size: 12px;
    /* slightly smaller so text fits */
    font-weight: 600;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    line-height: 1.2;
    padding: 4px;
    /* small padding inside */
  }


  /* Social Icons Container */
  .floating-info .social-icons {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  /* Icon Box Base Style */
  .floating-info .social-icons a {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    border-radius: 8px;
    text-decoration: none;
    transition: transform 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  }

  /* Minimal Hover Effect */
  .floating-info .social-icons a:hover {
    transform: scale(1.1);
  }

  /* Facebook */
  .floating-info .social-icons a.facebook {
    background-color: #1877F2;
    color: white;
  }

  /* Instagram (Gradient Box) */
  .floating-info .social-icons a.instagram {
    background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af, #515bd4);
    color: white;
  }

  /* YouTube */
  .floating-info .social-icons a.youtube {
    background-color: #FF0000;
    color: white;
  }
</style>