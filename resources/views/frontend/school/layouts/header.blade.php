<!-- ✅ Header -->
<section class="headers-section">
    <div class="container-fluid header-section">
        <div class="row align-items-center text-center">
            <div class="col-md-2">
                <a href="{{ route('home') }}"><img src="{{ asset(get_setting('left_logo', 'left')) }}" alt="Left Logo"
                        class="school-logo"></a>
            </div>
            <div class="col-md-8">
                <a href="{{ route('home') }}">
                    <h2 class="school-title">{{ get_setting('school_name', 'Biddaniketon Edu | 4axiz') }}</h2>
                </a>
                <span class="school-subtitle">{{ get_setting('school_address', 'Mirpur-12, Dhaka') }}</span>
                <br>
                <span class="school-estd">{{ get_setting('school_est', '2024') }}
                    {{ get_setting('school_eiin', '100001') }}</span>
            </div>
            <div class="col-md-2">
                <a href="{{ route('home') }}"><img src="{{ asset(get_setting('right_logo', 'right')) }}"
                        alt="Right Logo" class="school-logo"></a>
            </div>
        </div>
    </div>
</section>

<!-- ✅ Navigation -->
<section class="navigation-section">
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">প্রচ্ছদ</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">প্রশাসন</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('head_master') }}">প্রধান শিক্ষক</a></li>
                            <li><a class="dropdown-item" href="{{ route('teacher_team') }}">শিক্ষকবৃন্দ</a></li>
                            <li><a class="dropdown-item" href="{{ route('managing_committee') }}">ম্যানেজিং কমিটি </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">শিক্ষার্থীদের
                            তথ্য</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('total_students') }}">ছাত্রছাত্রীর আসন
                                    সংখ্যা</a></li>
                            <!-- <li><a class="dropdown-item" href="{{ route('class_summery') }}">শ্রেণি বিবরণ</a></li> -->
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">ভর্তি</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admission_info') }}">ভর্তি তথ্য</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('routine') }}">রুটিন</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('exam_result') }}">ফলাফল</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('notice') }}">নোটিশ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('event') }}">ইভেন্ট</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">গ্যালারী</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('image_category') }}">ছবি</a></li>
                            <!-- <li><a class="dropdown-item" href="#">ভিডিও</a></li> -->
                        </ul>
                    </li>

                    <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">বিভিন্ন তথ্য</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">পাঠ্যপুস্তক</a></li>
                                <li><a class="dropdown-item" href="#">সার্টিফিকেট</a></li>
                            </ul>
                        </li> -->

                    <li class="nav-item"><a class="nav-link" href="{{ route('contact_us') }}">যোগাযোগ</a></li>

                    <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">লগইন</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">শিক্ষার্থী লগইন</a></li>
                                <li><a class="dropdown-item" href="#">অ্যাডমিন</a></li>
                            </ul>
                        </li> -->

                </ul>
            </div>
        </div>
    </nav>
</section>