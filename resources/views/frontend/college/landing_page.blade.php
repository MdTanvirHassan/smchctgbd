@extends('frontend.college.layouts.app')

@section('content')
<section class="special-announcement-section">
    <div class="container position-relative">
        <div class="marquee-title">
            <i class="fa fa-bell-o"></i>
            <span>{{ __('landing.special_announcement') }}</span>
        </div>
        <div class="top-marquee">
            <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop()"
                onmouseout="this.start()">
                <ul>
                    <li class="d-flex">
                        @foreach($important_notices as $important_notice)
                        <a class="me-5" href="#" data-bs-toggle="modal" data-bs-target="#newsModal"
                            data-content="{{$important_notice->description}}"
                            onclick="showNewsModal(this)">
                            <div class="datenews">{{ \Carbon\Carbon::parse($important_notice->start_date)->format('F j, Y') }}</div>
                            {{$important_notice->title}}
                        </a>
                        @endforeach
                    </li>
                </ul>
            </marquee>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newsModalLabel">{{ __('landing.modal_special_announcement') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <!-- Dynamic content will appear here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="slider-section position-relative">
    <div>
        <div id="schoolCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="@if(get_setting('caption_is_active') === '1')banner-overlay @endif"></div>
                    <img src="{{asset(get_setting('banner_slider_1_image'))}}" class="d-block w-100 banner-img" alt="School Banner">
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="@if(get_setting('caption_is_active') === '1')banner-overlay @endif"></div>
                    <img src="{{asset(get_setting('banner_slider_2_image'))}}" class="d-block w-100 banner-img" alt="School Banner">
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="@if(get_setting('caption_is_active') === '1')banner-overlay @endif"></div>
                    <img src="{{asset(get_setting('banner_slider_3_image'))}}" class="d-block w-100 banner-img" alt="School Banner">
                </div>
            </div>

            <!-- Carousel controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#schoolCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('landing.carousel_previous') }}</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#schoolCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('landing.carousel_next') }}</span>
            </button>
        </div>

        <!-- CTA Overlay -->
        @if(get_setting('caption_is_active') === '1')
        <div class="carousel-caption-custom position-absolute top-50 start-50 translate-middle">
            <div class="container text-center text-md-start carousel-caption-box rounded-4">
                <h1 class="fw-bold display-4 text-white mb-3">
                    {{ get_setting('school_name') }}
                </h1>
                <p class="fs-5 text-white mb-4">
                    {{ get_setting('school_eiin') }} <br>
                    {{ get_setting('school_est') }}
                </p>
                <div>
                    <a href="{{ route('admission_info') }}" class="btn btn-primary btn-lg me-2 rounded-pill shadow">{{ __('landing.cta_admission') }}</a>
                    <a href="{{ route('contact_us') }}" class="btn btn-outline-light btn-lg rounded-pill shadow">{{ __('landing.cta_contact_us') }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>


<section class="welcome-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- About Intro -->
            <div class="col-md-4 d-flex align-items-center">
                <div class="about-intro text-white">
                    <div class="sec-title mb-4">
                        <div class="subtitle">{{ __('landing.welcome_to') }}</div>
                        <h3 class="title mb-3">
                            <span>{{get_setting('school_name')}}</span>
                        </h3>
                        <div class="desc">
                            {{ \Illuminate\Support\Str::words(get_setting('about_us_description'), 70, '...') }}
                        </div>
                    </div>
                    <div class="btn-part">
                        <a class="btn btn-outline-primary rounded-pill px-4 py-2" href="#">{{ __('landing.read_more') }}</a>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            @php
            use Illuminate\Support\Str;

            $headteacherMessage = get_setting('headmaster_speech');

            $chairmanMessage = get_setting('secretary_speech');

            $headteacherPreview = Str::words(strip_tags($headteacherMessage), 30, '...');
            $chairmanPreview = Str::words(strip_tags($chairmanMessage), 30, '...');

            if (Str::endsWith($headteacherPreview, '...')) {
            $previewWithoutEllipsis = Str::replaceLast('...', '', $headteacherPreview);
            } else {
            $previewWithoutEllipsis = $headteacherPreview;
            }

            if (Str::endsWith($chairmanPreview, '...')) {
            $previewChairmanWithoutEllipsis = Str::replaceLast('...', '', $chairmanPreview);
            } else {
            $previewChairmanWithoutEllipsis = $chairmanPreview;
            }

            $headteacherRemaining = trim(str_replace($previewWithoutEllipsis, '', $headteacherMessage));
            $chairmanRemaining = trim(str_replace($previewChairmanWithoutEllipsis, '', $chairmanMessage));
            @endphp

            <div class="col-md-8">
                <!-- Headteacher Message -->
                <div class="p-3 rounded shadow-sm d-flex flex-md-row flex-column align-items-center bg-soft-blue mb-3">
                    <div class="image-wrap me-md-3 mb-3 mb-md-0">
                        <img src="{{asset(get_setting('headmaster_image') )}}"
                            alt="{{ __('landing.principal_photo_alt') }}" class="img-fluid rounded message-img" />
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-2" style="color: #00465b;">{{ __('landing.headteacher_message') }}</h5>
                        <p class="desc mb-2" style="line-height: 1.7;">
                            {!! nl2br(e($headteacherPreview)) !!}
                            @if($headteacherRemaining)
                            <span id="headteacherMore" class="collapse">
                                {!! nl2br(e($headteacherRemaining)) !!}
                            </span>
                            <a href="#" class="text-danger ms-1" data-bs-toggle="collapse"
                                data-bs-target="#headteacherMore" aria-expanded="false" data-toggle-type="readmore" aria-controls="headteacherMore"
                                onclick="toggleReadMore(this); return false;">
                                {{ __('landing.read_more') }}
                            </a>
                            @endif
                        </p>
                        <div class="mt-2">
                            <strong class="text-dark">{{ get_setting('headmaster_name') ?? 'Principal/ Headmaster' }}</strong><br />
                            <strong class="text-dark">- {{ get_setting('school_name') ?? 'school name' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Chairman Message -->
                <div
                    class="p-3 rounded shadow-sm d-flex flex-md-row flex-column align-items-center bg-soft-secondary mb-3">
                    <div class="image-wrap me-md-3 mb-3 mb-md-0">
                        <img src="{{asset(get_setting('secretary_image') )}}"
                            alt="{{ __('landing.chairman_photo_alt') }}" class="img-fluid rounded message-img" />
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-2" style="color: #660000;">{{ __('landing.chairman_message') }}</h5>
                        <p class="desc mb-2" style="line-height: 1.7;">
                            {!! nl2br(e($chairmanPreview)) !!}
                            @if($chairmanRemaining)
                            <span id="chairmanMore" class="collapse">
                                {!! nl2br(e($chairmanRemaining)) !!}
                            </span>
                            <a href="#" class="text-danger ms-1" data-bs-toggle="collapse" data-toggle-type="readmore"
                                data-bs-target="#chairmanMore" aria-expanded="false" aria-controls="chairmanMore"
                                onclick="toggleReadMore(this); return false;">
                                {{ __('landing.read_more') }}
                            </a>
                            @endif
                        </p>
                        <div>
                            <strong class="text-dark">{{ get_setting('secretary_name') ?? 'Secretary' }}</strong><br />
                            <strong class="text-dark">- {{ get_setting('school_name') ?? 'school name' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- ✅ Institution history -->
<section class="institution-information-section">
    <div class="container">
        <div class="row" style="padding: 0px;">
            <div class="col-md-9">
                <div class="col-md-12" style="padding: 0px; margin: 0px;">
                    <div class="history-school mb-2">
                        <h3>{{get_setting('school_history_title')}}</h3>
                    </div>
                </div>
                <div class="px-2 align-items-center">
                    <div class="row py-2 bg-white rounded shadow-sm align-items-center">
                        <div class="col-md-4">
                            <img src="{{asset(get_setting('school_history_image') )}}"
                                class="img-fluid image-size" />
                        </div>
                        <div class="col-md-8">
                            <p class="m-0 p-0" style="font-size: 16px; color:#000; text-align: justify;">
                                {{get_setting('school_history_description')}}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="row" style="margin-top: 30px;">
                    <!-- Card 1 -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="card-header-custom">{{ __('landing.student_info_card_title') }}</div>
                            <div class="card-body-custom">
                                <div class="card-icon">
                                    <img src="{{ asset('/public/assets/icons/students_Information.png') }}"
                                        alt="Icon">
                                </div>
                                <div class="card-list">
                                    <ul>
                                        <li><a href="{{ route('total_students') }}"><i class="fas fa-chair me-2"></i>{{ __('landing.student_info_links.seat_capacity') }}</a></li>
                                        <li><a href="{{ route('total_students') }}"><i class="fas fa-file-alt me-2"></i>{{ __('landing.student_info_links.admission_info') }}</a></li>
                                        <li><a href="{{ route('notice') }}"><i class="fas fa-bullhorn me-2"></i>{{ __('landing.student_info_links.notice') }}</a></li>
                                        <li><a href="{{ route('routine') }}"><i class="fas fa-calendar-alt me-2"></i>{{ __('landing.student_info_links.routine') }}</a></li>
                                        <li><a href="{{ get_setting('youtube_link') }}"><i class="fas fa-video me-2"></i>{{ __('landing.student_info_links.online_class_link') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="card-header-custom" style="background-color: #660000;">{{ __('landing.teacher_info_card_title') }}</div>
                            <div class="card-body-custom">
                                <div class="card-icon">
                                    <img src="{{ asset('/public/assets/icons/teachers_Information.png') }}" alt="Icon">
                                </div>
                                <div class="card-list">
                                    <ul>
                                        <li><a href="{{ route('teacher_team') }}"><i class="fas fa-users me-2"></i>{{ __('landing.teacher_info_links.teachers') }}</a></li>
                                        <li><a href="#"><i class="fas fa-briefcase me-2"></i>{{ __('landing.teacher_info_links.vacancy_list') }}</a></li>
                                        <li><a href="{{ route('head_master') }}"><i class="fas fa-user-tie me-2"></i>{{ __('landing.teacher_info_links.principal') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="card-header-custom" style="background-color: #00465b;">{{ __('landing.download_card_title') }}</div>
                            <div class="card-body-custom">
                                <div class="card-icon">
                                    <img src="{{ asset('/public/assets/icons/download.png') }}" alt="Icon">
                                </div>
                                <div class="card-list">
                                    <ul>
                                        <li><a href="{{ route('routine') }}"><i class="fas fa-file-download me-2"></i>{{ __('landing.download_links.exam_routine') }}</a></li>
                                        <li><a href="#"><i class="fas fa-file-download me-2"></i>{{ __('landing.download_links.holiday_notice') }}</a></li>
                                        <li><a href="{{ route('admission_info') }}"><i class="fas fa-file-download me-2"></i>{{ __('landing.download_links.admission_form') }}</a></li>
                                        <li><a href="{{ route('routine') }}"><i class="fas fa-file-download me-2"></i>{{ __('landing.download_links.exam_routine') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="card-header-custom" style="background-color: #660000;">{{ __('landing.academic_info_card_title') }}</div>
                            <div class="card-body-custom">
                                <div class="card-icon">
                                    <img src="{{ asset('/public/assets/icons/academic_Information.png') }}" alt="Icon">
                                </div>
                                <div class="card-list">
                                    <ul>
                                        <li><a href="{{ route('notice') }}"><i class="fas fa-bullhorn me-2"></i>{{ __('landing.academic_info_links.notice') }}</a></li>
                                        <li><a href="#"><i class="fas fa-door-open me-2"></i>{{ __('landing.academic_info_links.room_count') }}</a></li>
                                        <li><a href="#"><i class="fas fa-calendar-times me-2"></i>{{ __('landing.academic_info_links.holiday_list') }}</a></li>
                                        <li><a href="#"><i class="fas fa-projector me-2"></i>{{ __('landing.academic_info_links.multimedia_classroom') }}</a></li>
                                        <li><a href="{{ route('total_students') }}"><i class="fas fa-chair me-2"></i>{{ __('landing.academic_info_links.seat_capacity') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <section class="rounded" style="background-color: #00465b; padding: 40px 0;">
                    <div class="container text-center">
                        <h5 style="color: #ffffff; font-size: 18px;">{{ __('landing.governing_body_title') }}</h5>
                        <h3 style="color: #ffffff; font-size: 24px; font-weight: 500;">{{ __('landing.governing_body_subtitle') }}</h3>

                        <div class="mt-4 px-3">
                            <div class="committee-carousel-college">
                                @foreach($committees as $committee)
                                <div class="slide-item-college px-2">
                                    <div style="background: #ffffff; padding: 10px; border-radius: 8px; height: 100%; margin: 0 5px;">
                                        <img src="{{asset($committee->photo_path)}}"
                                            alt="{{$committee->name}}" class="img-fluid rounded mb-2"
                                            style="width: 100%; height: 160px; object-fit: cover;"
                                            onerror="this.onerror=null; this.src='{{ asset('/public/assets/icons/user.png') }}'">
                                        <h6 style="margin: 0; color: #660000; font-size: 0.95rem;">{{$committee->name}}</h6>
                                        <small style="color: #00465b;">{{ is_object($committee->designation) ? ($committee->designation->name ?? 'N/A') : ($committee->designation ?? 'N/A') }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-3">
                <div class="list-button">
                    <ul>
                        <li>
                            <a href="{{ route('admission_info') }}" class="button"><i class="fa fa-arrow-circle-o-right"></i>{{ __('landing.admission_info_button') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('admission_info') }}" class="button"><i class="fa fa-arrow-circle-o-right"
                                    aria-hidden="true"></i>{{ __('landing.admission_form_button') }}</a>
                        </li>
                        <li><a href="{{ route('image_category') }}" class="button"><i class="fa fa-arrow-circle-o-right"
                                    aria-hidden="true"></i>{{ __('landing.photo_gallery_button') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('image_category') }}" class="button"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>{{ __('landing.video_gallery_button') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="notice-board">
                    <h3>{{ __('landing.notice_board_title') }}</h3>
                    <div class="content-notice">
                        <ul class="notice-list mb-0">
                            @foreach($notices as $notice)
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noticeModal"
                                    data-title="{{ $notice->title }}" data-date="{{ $notice->start_date }}"
                                    data-description="{{ $notice->description }}" onclick="showNoticeModal(this)">
                                    <div class="datenews">{{ \Carbon\Carbon::parse($notice->start_date)->format('F j, Y') }}
                                    </div>
                                    {{ $notice->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- notice Modal -->
                <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-3">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="noticeModalLabel">{{ __('landing.notice_modal_title') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5 id="modalNoticeTitle" class="fw-semibold mb-3"></h5>
                                <small id="modalNoticeDate" class="text-muted d-block mb-2"></small>
                                <p id="modalNoticeContent" class="mb-0"></p>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('landing.notice_modal_close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>


                @if($admission_links->count() > 0)
                <div class="official-link mb-4">
                    <h3><i class="fas fa-link me-2"></i>{{ __('landing.admission_links_title', 'Admission Links') }}</h3>
                    <ul>
                        @foreach($admission_links as $admission_link)
                        <li><a href="{{ $admission_link->link_url }}" target="_blank"><i
                                    class="fa fa-external-link-alt"
                                    aria-hidden="true"></i>{{ $admission_link->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('frontend.admission_links') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View All Admission Links
                        </a>
                    </div>
                </div>
                @endif

                <div class="official-link">
                    <h3>{{ __('landing.official_links_title') }}</h3>
                    <ul>
                        @foreach($officiallinks as $officiallink)
                        <li><a href="{{ $officiallink->link_url }}" target="_blank"><i
                                    class="fa fa-arrow-circle-o-right"
                                    aria-hidden="true"></i>{{$officiallink->title}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>


                <div class="important-info">
                    <h3>{{ __('landing.important_info_title') }}</h3>
                    <ul>
                        @foreach($importantinformationlinks as $importantinformationlink)
                        <li><a href="{{ $importantinformationlink->link_url }}" target="_blank"><i
                                    class="fa fa-arrow-circle-o-right"
                                    aria-hidden="true"></i>{{$importantinformationlink->title}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>



                <div class="official-link" style="border: 1px solid #000;">
                    <h3 style="background:#ffffff; color:#000;">{{ __('landing.faqs_title') }}</h3>
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}" style="font-size: 1rem; font-weight: 500;">
                                    {{ $faq->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="font-size: 0.8rem; line-height: 1.4; max-height: 5.5em; overflow: hidden; text-overflow: ellipsis;">
                                    {!! nl2br(e($faq->description)) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="countdown-wrapper text-center mt-4">
                        <div class="mb-3">
                            <img src="{{ asset('public/uploads/countdown.jpg') }}" alt="Countdown" class="img-fluid rounded shadow-sm">
                        </div>
                        <div id="eventCountdown" class="d-flex justify-content-center gap-3 flex-wrap">
                            <div class="countdown-segment px-3 py-2 border rounded bg-light">
                                <div class="fs-3 fw-bold" data-unit="days">00</div>
                                <div class="text-uppercase small text-muted">Days</div>
                            </div>
                            <div class="countdown-segment px-3 py-2 border rounded bg-light">
                                <div class="fs-3 fw-bold" data-unit="hours">00</div>
                                <div class="text-uppercase small text-muted">Hours</div>
                            </div>
                            <div class="countdown-segment px-3 py-2 border rounded bg-light">
                                <div class="fs-3 fw-bold" data-unit="minutes">00</div>
                                <div class="text-uppercase small text-muted">Minutes</div>
                            </div>
                            <div class="countdown-segment px-3 py-2 border rounded bg-light">
                                <div class="fs-3 fw-bold" data-unit="seconds">00</div>
                                <div class="text-uppercase small text-muted">Seconds</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<!-- ✅ Teachers Team Section -->
<section class="teachers-team-section">
    <div class="container mb-5">
        <div class="row">
            <div class="testimonial-section" id="testimonial">
                <div class="col-md-12">
                    <div class="services-title text-center mt-5">
                        <h5 style="font-size:20px; color: #000;">{{ __('landing.teachers_section_title') }}</h5>
                        <h2 class="text-lg mt-3" style="font-size: 30px;font-weight: 500; color: #000;">{{ __('landing.teachers_section_subtitle') }}</h2>
                    </div>
                </div>

                <div id="teacherCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        @foreach($teachers->chunk(4) as $chunkIndex => $teacherChunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row justify-content-center">
                                    @foreach($teacherChunk as $teacher)
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="teacher-card text-center rounded" style="cursor:pointer;"
                                            data-bs-toggle="modal" data-bs-target="#teacherModal"
                                            data-name="{{ $teacher->name }}"
                                            data-designation="{{ $teacher->designation->name }}"
                                            data-photo="{{ asset($teacher->photo_path) }}"
                                            data-qualification="{{ $teacher->qualification }}"
                                            data-biography="{{ $teacher->biography }}"
                                            data-join_date="{{ \Carbon\Carbon::parse($teacher->join_date)->format('d M Y') }}">
                                            <img src="{{ asset($teacher->photo_path) }}" alt="Teacher"
                                                class="teacher-img">
                                            <div class="teacher-info mt-3">
                                                <h4>{{ $teacher->name }}</h4>
                                                <p>{{ $teacher->designation->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#teacherCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
                        <span class="visually-hidden">{{ __('landing.carousel_previous') }}</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#teacherCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
                        <span class="visually-hidden">{{ __('landing.carousel_next') }}</span>
                    </button>
                </div>

                <div class="btn-part d-flex justify-content-center">
                        <a class="btn btn-outline-primary rounded-pill px-4 py-2" href="{{ route('teacher_team') }}">{{ __('landing.view_more') }}</a>
                    </div>

                <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow rounded-3">

                            <!-- Modal Header -->
                            <div class="modal-header py-3 px-4 rounded-top">
                                <h5 class="modal-title fw-bold fs-4" id="teacherModalLabel">{{ __('landing.teacher_modal_title') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body px-4 py-4">

                                <!-- Flex container: photo on left, info on right -->
                                <div
                                    class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4 mb-4">

                                    <!-- Teacher Photo -->
                                    <img id="modalTeacherPhoto" src="" alt="Teacher Photo"
                                        class="rounded shadow-sm flex-shrink-0"
                                        style="width: 140px; height: 140px; object-fit: cover;" />

                                    <!-- Info container -->
                                    <div class="text-center text-md-start">
                                        <h4 id="modalTeacherName" class="fw-bold mb-2"></h4>
                                        <p id="modalTeacherDesignation" class="mb-1"></p>
                                        <p id="modalTeacherQualification" class="mb-1"></p>
                                        <p id="modalTeacherJoinDate" class="mb-0"></p>
                                    </div>
                                </div>

                                <!-- Biography section -->
                                <section>
                                    <h6 class="fw-semibold mb-3">{{ __('landing.teacher_modal_biography') }}</h6>
                                    <p id="modalTeacherBiography" class="mb-0"
                                        style="white-space: pre-wrap; line-height: 1.5; text-align: justify;"></p>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ✅ Video Gallery Section -->
@php
    // Ensure we have a collection - always initialize videos
    $displayVideos = isset($videos) && $videos ? $videos : collect();
    if (!($displayVideos instanceof \Illuminate\Support\Collection)) {
        $displayVideos = collect($displayVideos ?: []);
    }
    $hasVideos = $displayVideos->count() > 0;
    $chunkedVideos = $hasVideos ? $displayVideos->chunk(3) : collect();
@endphp
<section class="video-gallery-section">
    <div class="container mb-5">
        <div class="row">
            <div class="testimonial-section">
                <div class="col-md-12">
                    <div class="services-title text-center mt-5">
                        <h5 style="font-size:20px; color: #000;">{{ __('landing.video_gallery_section_title') }}</h5>
                        <h2 class="text-lg mt-3" style="font-size: 30px;font-weight: 500; color: #000;">{{ __('landing.video_gallery_section_subtitle') }}</h2>
                    </div>
                </div>

                @if($hasVideos)
                <div id="videoGalleryCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach($chunkedVideos as $chunkIndex => $videoChunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row justify-content-center">
                                    @foreach($videoChunk as $video)
                                    <div class="col-md-4 col-sm-6 mb-4">
                                        <div class="video-card text-center rounded shadow-sm" style="cursor:pointer; overflow: hidden; background: #fff; transition: transform 0.3s ease;"
                                            data-bs-toggle="modal" data-bs-target="#videoModal"
                                            data-title="{{ $video->title }}"
                                            data-caption="{{ $video->caption ?? '' }}"
                                            data-video-path="{{ $video->video_path ? asset(ltrim(str_replace('public/', '', $video->video_path), '/')) : '' }}"
                                            data-video-url="{{ $video->video_url ?? '' }}"
                                            onmouseover="this.style.transform='scale(1.02)'" 
                                            onmouseout="this.style.transform='scale(1)'"
                                            onclick="event.preventDefault(); showVideoModal(this)">
                                            <div class="position-relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000; border-radius: 8px 8px 0 0;">
                                                @if($video->video_url && !empty($video->video_url))
                                                    @php
                                                        // Extract YouTube video ID
                                                        $youtubeId = null;
                                                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->video_url, $matches)) {
                                                            $youtubeId = $matches[1];
                                                        }
                                                    @endphp
                                                    @if($youtubeId)
                                                        <img src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg" 
                                                             alt="{{ $video->title }}"
                                                             class="position-absolute top-0 start-0 w-100 h-100"
                                                             style="object-fit: cover;">
                                                        <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 10; pointer-events: none;">
                                                            <i class="fab fa-youtube text-danger" style="font-size: 56px; opacity: 0.95; text-shadow: 0 2px 8px rgba(0,0,0,0.7);"></i>
                                                        </div>
                                                    @else
                                                        <div class="position-absolute top-50 start-50 translate-middle text-white" style="z-index: 10;">
                                                            <i class="fas fa-video" style="font-size: 56px;"></i>
                                                        </div>
                                                    @endif
                                                @elseif($video->video_path && !empty(trim($video->video_path)))
                                                    @php
                                                        // Handle video path - remove 'public/' prefix if present for asset()
                                                        $videoPath = trim($video->video_path);
                                                        // Remove 'public/' prefix if it exists
                                                        if (strpos($videoPath, 'public/') === 0) {
                                                            $videoPath = substr($videoPath, 7);
                                                        }
                                                        // Also handle if it starts with just 'assets/'
                                                        $videoPath = ltrim($videoPath, '/');
                                                        $videoDisplayUrl = asset($videoPath);
                                                    @endphp
                                                    <video class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;" muted preload="metadata" loop>
                                                        <source src="{{ $videoDisplayUrl }}" type="video/mp4">
                                                        <source src="{{ $videoDisplayUrl }}" type="video/webm">
                                                        <source src="{{ $videoDisplayUrl }}" type="video/ogg">
                                                    </video>
                                                    <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 10; pointer-events: none;">
                                                        <i class="fas fa-play-circle text-white" style="font-size: 56px; opacity: 0.95; text-shadow: 0 2px 8px rgba(0,0,0,0.7);"></i>
                                                    </div>
                                                @else
                                                    <div class="position-absolute top-50 start-50 translate-middle text-white" style="z-index: 10;">
                                                        <i class="fas fa-video" style="font-size: 56px;"></i>
                                                        <p class="small mt-2">No Video</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="video-info p-3 bg-white">
                                                <h5 class="mb-1" style="font-size: 16px; font-weight: 600; color: #333;">{{ $video->title }}</h5>
                                                @if($video->category)
                                                    <p class="text-muted small mb-1" style="font-size: 12px;">
                                                        <i class="fas fa-folder"></i> {{ $video->category->name }}
                                                    </p>
                                                @endif
                                                @if($video->caption && !empty($video->caption))
                                                    <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit($video->caption, 60) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                        @if($chunkedVideos->count() > 1)
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#videoGalleryCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('landing.carousel_previous') }}</span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#videoGalleryCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('landing.carousel_next') }}</span>
                        </button>
                        @endif
                    </div>
                @else
                <div class="text-center py-5">
                    <p class="text-muted">{{ __('landing.no_videos_available') ?? 'No videos available at the moment.' }}</p>
                </div>
                @endif

                @if($hasVideos)
                <div class="btn-part d-flex justify-content-center mt-4">
                    <a class="btn btn-outline-primary rounded-pill px-4 py-2" href="{{ route('image_category') }}">
                        {{ __('landing.view_more') }} {{ __('landing.video_gallery_button') }}
                    </a>
                </div>
                @endif

                <!-- Video Modal -->
                <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-3">
                            <div class="modal-header py-3 px-4">
                                <h5 class="modal-title fw-bold" id="videoModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4 py-4">
                                <div id="videoContainer" class="mb-3">
                                    <!-- Video will be inserted here -->
                                </div>
                                <div id="videoCaption" class="text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readMoreTexts = {
            more: @json(__('landing.read_more')),
            less: @json(__('landing.read_less')),
        };

        // Only target toggles with data-toggle-type="readmore"
        const toggles = document.querySelectorAll('[data-bs-toggle="collapse"][data-toggle-type="readmore"]');

        toggles.forEach(function(link) {
            const targetSelector = link.getAttribute('data-bs-target');
            const target = document.querySelector(targetSelector);

            if (!target) return;

            target.addEventListener('shown.bs.collapse', function() {
                link.textContent = readMoreTexts.less;
            });

            target.addEventListener('hidden.bs.collapse', function() {
                link.textContent = readMoreTexts.more;
            });
        });

        const countdownContainer = document.getElementById('eventCountdown');
        if (countdownContainer) {
            const targetDate = new Date('December 4, 2025 09:00:00');
            const unitElements = {
                days: countdownContainer.querySelector('[data-unit="days"]'),
                hours: countdownContainer.querySelector('[data-unit="hours"]'),
                minutes: countdownContainer.querySelector('[data-unit="minutes"]'),
                seconds: countdownContainer.querySelector('[data-unit="seconds"]'),
            };

            const pad = (value) => String(value).padStart(2, '0');

            const updateCountdown = () => {
                const now = new Date();
                let diff = targetDate - now;

                if (diff <= 0) {
                    unitElements.days.textContent = '00';
                    unitElements.hours.textContent = '00';
                    unitElements.minutes.textContent = '00';
                    unitElements.seconds.textContent = '00';
                    return;
                }

                const secondsTotal = Math.floor(diff / 1000);
                const days = Math.floor(secondsTotal / (60 * 60 * 24));
                const hours = Math.floor((secondsTotal % (60 * 60 * 24)) / (60 * 60));
                const minutes = Math.floor((secondsTotal % (60 * 60)) / 60);
                const seconds = secondsTotal % 60;

                unitElements.days.textContent = pad(days);
                unitElements.hours.textContent = pad(hours);
                unitElements.minutes.textContent = pad(minutes);
                unitElements.seconds.textContent = pad(seconds);
            };

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    });


    function showNoticeModal(element) {
        const title = element.getAttribute('data-title');
        const date = element.getAttribute('data-date');
        const description = element.getAttribute('data-description');

        document.getElementById('modalNoticeTitle').innerText = title;
        document.getElementById('modalNoticeDate').innerText = date;
        document.getElementById('modalNoticeContent').innerText = description;
    }

    $(document).ready(function() {
        const teacherModalLabels = {
            qualification: @json(__('landing.teacher_modal_qualification')),
            joinedOn: @json(__('landing.teacher_modal_joined_on')),
        };

        $('#teacherModal').on('show.bs.modal', function(event) {
            let trigger = $(event.relatedTarget);
            let name = trigger.data('name');
            let designation = trigger.data('designation');
            let photo = trigger.data('photo');
            let qualification = trigger.data('qualification');
            let biography = trigger.data('biography');
            let joinDate = trigger.data('join_date');

            let modal = $(this);
            modal.find('#modalTeacherName').text(name);
            modal.find('#modalTeacherDesignation').text(designation);
            modal.find('#modalTeacherPhoto').attr('src', photo);
            modal.find('#modalTeacherQualification').text(qualification ? `${teacherModalLabels.qualification} ${qualification}` : '');
            modal.find('#modalTeacherJoinDate').text(joinDate ? `${teacherModalLabels.joinedOn} ${joinDate}` : '');
            modal.find('#modalTeacherBiography').text(biography);
        });
    });

    // Video Modal Function
    function showVideoModal(element) {
        const title = element.getAttribute('data-title');
        const caption = element.getAttribute('data-caption');
        const videoPath = element.getAttribute('data-video-path');
        const videoUrl = element.getAttribute('data-video-url');
        
        const modalLabel = document.getElementById('videoModalLabel');
        const videoContainer = document.getElementById('videoContainer');
        const videoCaption = document.getElementById('videoCaption');
        
        if (modalLabel) modalLabel.textContent = title || 'Video';
        if (videoCaption) videoCaption.textContent = caption || '';
        
        // Clear previous video
        if (videoContainer) videoContainer.innerHTML = '';
        
        // Show YouTube video
        if (videoUrl && videoUrl.trim() !== '') {
            // Extract YouTube video ID
            const match = videoUrl.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            if (match && videoContainer) {
                const youtubeId = match[1];
                const iframe = document.createElement('iframe');
                iframe.src = `https://www.youtube.com/embed/${youtubeId}`;
                iframe.width = '100%';
                iframe.height = '450';
                iframe.style.border = 'none';
                iframe.style.borderRadius = '8px';
                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                iframe.setAttribute('allowfullscreen', 'true');
                videoContainer.appendChild(iframe);
            } else if (videoContainer) {
                // If not YouTube, show as link
                videoContainer.innerHTML = `<div class="alert alert-info text-center">
                    <i class="fas fa-external-link-alt me-2"></i>
                    <a href="${videoUrl}" target="_blank" class="btn btn-primary">Open Video Link</a>
                </div>`;
            }
        } 
        // Show uploaded video
        else if (videoPath && videoPath.trim() !== '' && videoContainer) {
            const video = document.createElement('video');
            video.src = videoPath;
            video.controls = true;
            video.style.width = '100%';
            video.style.maxHeight = '500px';
            video.style.borderRadius = '8px';
            video.style.backgroundColor = '#000';
            video.setAttribute('preload', 'metadata');
            videoContainer.appendChild(video);
        } else if (videoContainer) {
            videoContainer.innerHTML = '<div class="alert alert-warning">No video available</div>';
        }
    }

    // Clear video when modal is closed
    $(document).on('hidden.bs.modal', '#videoModal', function () {
        const videoContainer = document.getElementById('videoContainer');
        if (videoContainer) {
            videoContainer.innerHTML = '';
        }
    });

    // Committee Carousel Initialization - College Template
    $(window).on('load', function() {
        setTimeout(function() {
            if (typeof $.fn.slick !== 'undefined') {
                if ($('.committee-carousel-college').hasClass('slick-initialized')) {
                    $('.committee-carousel-college').slick('unslick');
                }
                
                $('.committee-carousel-college').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,
                    dots: true,
                    infinite: true,
                    speed: 500,
                    pauseOnHover: true,
                    pauseOnFocus: true,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: true,
                                dots: true
                            }
                        }
                    ]
                });
            }
        }, 500);
    });

    // Backup initialization
    $(document).ready(function() {
        if ($('.committee-carousel-college').length > 0 && typeof $.fn.slick !== 'undefined') {
            setTimeout(function() {
                if (!$('.committee-carousel-college').hasClass('slick-initialized')) {
                    $('.committee-carousel-college').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 3000,
                        arrows: true,
                        dots: true,
                        infinite: true,
                        speed: 500,
                        pauseOnHover: true,
                        pauseOnFocus: true,
                        responsive: [
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: true,
                                    dots: true
                                }
                            }
                        ]
                    });
                }
            }, 1000);
        }
    });
</script>

<style>
    /* Committee Carousel Styles - College Template */
    .committee-carousel-college {
        position: relative;
        padding: 0 50px;
        margin: 0 auto;
    }
    
    .committee-carousel-college .slide-item-college {
        outline: none;
    }
    
    .committee-carousel-college .slick-list {
        margin: 0 -5px;
    }
    
    .committee-carousel-college .slick-slide > div {
        padding: 0 5px;
    }
    
    .committee-carousel-college .slick-prev,
    .committee-carousel-college .slick-next {
        z-index: 100;
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.95) !important;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.4);
        transition: all 0.3s ease;
    }
    
    .committee-carousel-college .slick-prev {
        left: 0;
    }
    
    .committee-carousel-college .slick-next {
        right: 0;
    }
    
    .committee-carousel-college .slick-prev:before,
    .committee-carousel-college .slick-next:before {
        font-size: 28px;
        color: #00465b !important;
        opacity: 1 !important;
        line-height: 45px;
    }
    
    .committee-carousel-college .slick-prev:hover,
    .committee-carousel-college .slick-next:hover {
        background: rgba(255, 255, 255, 1) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        transform: scale(1.1);
    }
    
    .committee-carousel-college .slick-dots {
        bottom: -45px;
        position: absolute;
        width: 100%;
    }
    
    .committee-carousel-college .slick-dots li {
        margin: 0 4px;
    }
    
    .committee-carousel-college .slick-dots li button:before {
        font-size: 14px;
        color: #ffffff;
        opacity: 0.6;
    }
    
    .committee-carousel-college .slick-dots li.slick-active button:before {
        color: #ffffff;
        opacity: 1;
    }

    @media (max-width: 768px) {
        .committee-carousel-college {
            padding: 0 45px;
        }
        
        .committee-carousel-college .slick-prev {
            left: -5px;
        }
        
        .committee-carousel-college .slick-next {
            right: -5px;
        }
    }

    @media (max-width: 576px) {
        .committee-carousel-college {
            padding: 0 40px;
        }
        
        .committee-carousel-college .slick-prev {
            left: -10px;
            width: 35px;
            height: 35px;
        }
        
        .committee-carousel-college .slick-next {
            right: -10px;
            width: 35px;
            height: 35px;
        }
        
        .committee-carousel-college .slick-prev:before,
        .committee-carousel-college .slick-next:before {
            font-size: 20px;
            line-height: 35px;
        }
    }
</style>
@endsection