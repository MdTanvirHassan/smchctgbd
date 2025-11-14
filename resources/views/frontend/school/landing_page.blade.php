@extends('frontend.school.layouts.app')

@section('content')
    <style>
        .slick-next:before {
            font-family: 'none';
            font-size: 0px;
        }
    </style>
    <section class="slider-section">

        <div id="schoolCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset(get_setting('banner_slider_1_image'))}}" class="d-block w-100" alt="Classroom">
                </div>
                <div class="carousel-item active">
                    <img src="{{asset(get_setting('banner_slider_2_image'))}}" class="d-block w-100" alt="Classroom">
                </div>
                <div class="carousel-item active">
                    <img src="{{asset(get_setting('banner_slider_3_image'))}}" class="d-block w-100" alt="Classroom">
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
    </section>


    <section class="special-announcement-section">
        <div>
            <div class="marquee-title">{{ __('landing.special_announcement') }}</div>
            <div class="top-marquee" style="text-align: center; padding-top: 5px;">
                <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop()"
                    onmouseout="this.start()">
                    <ul>
                        <li>
                            @foreach($important_notices as $important_notice)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#newsModal"
                                    data-content="{{$important_notice->description}}" onclick="showNewsModal(this)">
                                    <div class="datenews">{{$important_notice->start_date}}</div>
                                    {{$important_notice->title}}
                                </a>
                            @endforeach
                        </li>
                    </ul>
                </marquee>
            </div>
            <!-- Bootstrap Modal -->
            <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newsModalLabel">{{ __('landing.modal_special_announcement') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('landing.notice_modal_close') }}"></button>
                        </div>
                        <div class="modal-body" id="modalContent">
                            <!-- Dynamic content will appear here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Institution Information -->
    <section class="institution-information-section">
        <div style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
            <div class="container">
                <div class="row " style="padding: 0px;">
                    <div class="col-md-9" style="margin-top: 5px;">
                        <div class="col-md-12" style="padding: 0px; margin: 0px;">
                            <div class="history-school mb-3">
                                <h3>{{get_setting('school_history_title')}}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                <img src="{{asset(get_setting('school_history_image'))}}" class="img-fluid image-size"
                                    style="margin-bottom:10px;" />
                            </div>
                            <div class="col-md-8">
                                <div>
                                    {{-- Preview (limit words for short view) --}}
                                    <p id="schoolHistoryPreview" style="font-size: 16px; color:#000; text-align: justify;">
                                        {{ \Illuminate\Support\Str::words(strip_tags(get_setting('school_history_description')), 150, '...') }}
                                    </p>

                                    {{-- Full text (hidden initially) --}}
                                    <div class="collapse" id="schoolHistoryMore">
                                        <p style="font-size: 16px; color:#000; text-align: justify;">
                                            {{ get_setting('school_history_description') }}
                                        </p>
                                    </div>

                                    {{-- Toggle Button --}}
                                    <a href="#" class="text-danger ms-1" data-bs-toggle="collapse"
                                        data-bs-target="#schoolHistoryMore" aria-expanded="false"
                                        aria-controls="schoolHistoryMore" onclick="toggleReadMore(this); return false;">
                                        {{ __('landing.read_more') }}
                                    </a>
                                </div>

                                <script>
                                    function toggleReadMore(el) {
                                        const readMore = "{{ __('landing.read_more') }}";
                                        const readLess = "{{ __('landing.read_less') }}";
                                        if (el.getAttribute("aria-expanded") === "true") {
                                            el.innerText = readMore;
                                        } else {
                                            el.innerText = readLess;
                                        }
                                    }
                                </script>


                            </div>
                        </div>
                        <div class="col-md-12" style="padding: 0px; margin-top: 30px;">
                            <div class="history-school mb-3 mt-5">
                                <h3>{{ __('landing.headteacher_message') }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{asset(get_setting('headmaster_image'))}}" alt="{{ __('landing.principal_photo_alt') }}"
                                    style="width:100%; height:330px; margin-bottom:10px;">

                            </div>
                            <div class="col-md-8" style="font-size: 16px; color:#000;text-align: justify;">
                                @php
                                    $headmasterSpeech = get_setting('headmaster_speech_' . app()->getLocale()) ?: get_setting('headmaster_speech');
                                    $headmasterName = get_setting('headmaster_name_' . app()->getLocale()) ?: get_setting('headmaster_name');
                                    $headmasterDesignation = get_setting('headmaster_designation_' . app()->getLocale()) ?: get_setting('headmaster_designation');
                                    $schoolName = get_setting('school_name_' . app()->getLocale()) ?: get_setting('school_name', '4axiz');
                                @endphp
                                <p>
                                    {{ $headmasterSpeech }}
                                </p>

                                <div style="line-height: 1.6em; font-weight: bold;">
                                    <div>{{ $headmasterName }}</div>
                                    <div>{{ $headmasterDesignation }}</div>
                                    <div>{{ $schoolName }}</div>
                                </div>
                            </div>

                        </div>
                        <!-- Info Cards -->
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="card-header-custom"
                                        style="background: linear-gradient(90deg, rgba(253, 29, 29, 1) 50%, rgba(252, 176, 69, 1) 100%);">
                                        <h5 class="mb-0">{{ __('landing.student_info_card_title') }}</h5>
                                    </div>
                                    <div class="card-body-custom">
                                        <div class="card-icon">
                                            <img src="{{ asset('/public/assets/icons/students_Information.png') }}"
                                                alt="Icon">
                                        </div>
                                        <div class="card-list">
                                            <ul>
                                                <li><a href="{{ route('total_students') }}">{{ __('landing.student_info_links.seat_capacity') }}</a></li>
                                                <li><a href="{{ route('admission_info') }}">{{ __('landing.student_info_links.admission_info') }}</a></li>
                                                <li><a href="{{ route('notice') }}">{{ __('landing.student_info_links.notice') }}</a></li>
                                                <li><a href="{{ route('routine') }}">{{ __('landing.student_info_links.routine') }}</a></li>
                                                <li><a href="{{get_setting('youtube_link')}}">{{ __('landing.student_info_links.online_class_link') }}</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="card-header-custom"
                                        style="background: linear-gradient(90deg, rgba(0, 36, 12, 1) 0%, rgba(9, 121, 18, 1) 35%, rgba(60, 190, 27, 1) 70%);">
                                        <h5 class="mb-0">{{ __('landing.teacher_info_card_title') }}</h5>
                                    </div>
                                    <div class="card-body-custom" style="padding: 25px;">
                                        <div class="card-icon">
                                            <img src="{{ asset('/public/assets/icons/teachers_Information.png') }}"
                                                alt="Icon">
                                        </div>
                                        <div class="card-list">
                                            <ul>
                                                <li><a href="{{ route('teacher_team') }}">{{ __('landing.teacher_info_links.teachers') }}</a></li>
                                                <li><a href="{{ route('head_master') }}">{{ __('landing.teacher_info_links.head_teacher') }}</a></li>
                                                <li><a href="{{ route('managing_committee') }}">{{ __('landing.governing_body') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="card-header-custom"
                                        style="background: linear-gradient(90deg, rgba(99, 83, 2, 1) 0%, rgba(121, 95, 9, 1) 35%, rgba(198, 255, 0, 1) 100%);">
                                        <h5 class="mb-0">{{ __('landing.download_card_title') }}</h5>
                                    </div>
                                    <div class="card-body-custom">
                                        <div class="card-icon">
                                            <img src="{{ asset('/public/assets/icons/download.png') }}" alt="Icon">
                                        </div>
                                        <div class="card-list">


                                            <ul>
                                                @foreach($files as $file)
                                                    <li><a
                                                            href="{{ route('fileupload.download', $file->id) }}">{{ $file->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="card-header-custom"
                                        style="background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);">
                                        <h5 class="mb-0">{{ __('landing.academic_info_card_title') }}</h5>
                                    </div>
                                    <div class="card-body-custom">
                                        <div class="card-icon">
                                            <img src="{{ asset('/public/assets/icons/academic_Information.png') }}"
                                                alt="Icon">
                                        </div>
                                        <div class="card-list">
                                            <ul>
                                                <li><a href="#">{{ __('landing.academic_info_links.room_count') }}</a></li>
                                                <li><a href="#">{{ __('landing.academic_info_links.holiday_list') }}</a></li>
                                                <li><a href="#">{{ __('landing.academic_info_links.multimedia_classroom') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3" style="margin-top: 10px;">
                        <div class="list-button">
                            <ul>
                                <li><a href="{{ route('admission_info') }}" class="button"><i
                                            class="fa fa-arrow-circle-o-right"></i>{{ __('landing.admission_info_button') }}</a></li>
                                <li><a href="https://www.ebook.com.bd/" class="button"><i class="fa fa-arrow-circle-o-right"
                                            aria-hidden="true"></i>{{ __('landing.e_book_form') }}</a></li>
                                <li><a href="{{ route('image_category') }}" class="button"><i
                                            class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>{{ __('landing.photo_gallery_button') }}</a></li>
                                <li><a href="http://www.educationboardresults.gov.bd/" class="button"><i
                                            class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>{{ __('landing.ssc_hsc_results') }}</a></li>
                            </ul>
                        </div>

                        <div class="notice-board">
                            <h3 style='background: #FA0000;'>{{ __('landing.notice_board_title') }}</h3>
                            <div class="content-notice p-1">
                                <ul>
                                    <li>
                                        @foreach($notices as $notice)
                                            <div class="notice-item">
                                                <a href="#" class="notice-link" data-content="{{$notice->description}}">
                                                    <div class="datenews">{{$notice->start_date}}</div>
                                                    {{$notice->title}}
                                                </a>
                                            </div>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="noticeModalLabel">{{ __('landing.notice_modal_title') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="{{ __('landing.notice_modal_close') }}"></button>
                                    </div>
                                    <div class="modal-body" id="modalNoticeContent">
                                        <!-- Content will be added dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="official-link ">
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
                        <div class="official-link">
                            <h3>{{ __('landing.important_info_title') }}</h3>
                            <ul style='font-size: 16px!important;'>
                                @foreach($importantinformationlinks as $importantinformationlink)
                                    <li><a href="{{ $importantinformationlink->link_url }}" target="_blank"><i
                                                class="fa fa-arrow-circle-o-right"
                                                aria-hidden="true"></i>{{$importantinformationlink->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="official-link rounded-lg shadow-sm">
                            <h3 class="fw-bold text-center mb-4"
                                style="color:#222; font-size:1.4rem; border-bottom:2px solid #eee; padding-bottom:10px;">
                                {{ __('landing.faqs_title') }}
                            </h3>
                            <div class="accordion" id="faqAccordion">
                                @foreach($faqs as $index => $faq)
                                    <div class="accordion-item mb-2 border-0 shadow-sm rounded-lg overflow-hidden">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button collapsed py-3 px-4 fw-semibold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="false" aria-controls="collapse{{ $index }}"
                                                style="font-size: 1rem; background:#f9fafb; transition: all 0.3s ease;">
                                                <i class="bi bi-question-circle me-2 text-primary"></i>
                                                {{ $faq->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body px-4 py-3"
                                                style="font-size: 0.9rem; line-height: 1.6; background:#fff; border-left:3px solid #0d6efd;">
                                                {!! nl2br(e($faq->description)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>
            </div>



    </section>

    <!-- ✅ Managing Team Section -->
    <section class="managing-team-section">
        <div class="container">
            <div class="row" style="background: #dfe3d4; padding: 50px 0;">

                <!-- Section Title -->
                <div class="col-md-12 text-center">
                    <h5 style="font-size:20px; color: #000;">{{ __('landing.managing_committee_title') }}</h5>
                    <h2 class="text-lg mt-3" style="font-size: 30px; font-weight: 500; color: #000;">
                        {{ __('landing.managing_committee_subtitle') }}
                    </h2>
                </div>

                <!-- Committee Members Carousel -->
                <div class="row justify-content-center gy-4 mt-4">
                    <div class="col-md-12">
                        <div class="committee-carousel testimonial-clients teachers-bg mt-4">
                            @foreach($committees as $committe)
                                <div class="px-2">
                                    <div class="testimonial-item p-2" style="border:2px solid #ccc; cursor:pointer; height: 100%;"
                                        data-bs-toggle="modal" data-bs-target="#committeModal" data-name="{{ $committe->name }}"
                                        data-title="{{ is_object($committe->designation) ? ($committe->designation->name ?? 'N/A') : ($committe->designation ?? 'N/A') }}"
                                        data-subject="{{ $committe->subject ?? 'N/A' }}"
                                        data-email="{{ $committe->email ?? 'N/A' }}" data-phone="{{ $committe->phone ?? 'N/A' }}"
                                        data-qualification="{{ $committe->qualification ?? 'N/A' }}"
                                        data-join="{{ $committe->join_date ? \Carbon\Carbon::parse($committe->join_date)->format('d M, Y') : 'N/A' }}"
                                        data-img="{{ asset($committe->photo_path) }}" data-committe-id="{{ $committe->id }}">

                                        <div class="techers-wrap text-center">
                                            <img src="{{ asset($committe->photo_path) }}" alt="{{ $committe->name }}"
                                                class="img-fluid"
                                                onerror="this.onerror=null; this.src='{{ asset('/public/assets/icons/user.png') }}'">

                                            <div class="teachers-dig mt-3">
                                                <h4>{{ $committe->name }}</h4>
                                                <p>
                                                    {{ is_object($committe->designation) ? ($committe->designation->name ?? 'N/A') : ($committe->designation ?? 'N/A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Hidden biography div --}}
                                    <div class="d-none bio-content" id="bio-{{ $committe->id }}">
                                        {!! nl2br(e($committe->biography ?? 'N/A')) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- View More Button -->
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('managing_committee') }}" class="btn btn-outline-primary rounded-pill px-4 py-2"
                        style="position: relative; z-index: 9999;">
                        {{ __('landing.view_more') }}
                    </a>
                </div>
            </div> <!-- end row -->

        </div> <!-- end container -->
    </section>


    <!-- ✅ Teachers Team Section -->
    <section class="teachers-team-section">
        <div class="container mb-5">
            <div class="row">

                <div class="testimonial-section" id="testimonial">
                    <div class="col-md-12">
                        <div class="services-title text-center mt-5">
                            <h5 style="font-size:20px; color: #000;">{{ __('landing.teachers_section_title') }}</h5>
                            <h2 class="text-lg mt-3" style="font-size: 30px;font-weight: 500; color: #000;">
                                {{ __('landing.teachers_section_subtitle_success') }}
                            </h2>
                        </div>
                    </div>
                    <div class="row justify-content-center gy-4 mt-4">
                        <div class="testimonial-clients teachers-bg mt-4 row">
                            @foreach($teachers as $teacher)
                                <div class="col-md-3 mb-4">
                                    <div class="testimonial-item p-2" style="border:2px solid #ccc; cursor:pointer;"
                                        data-bs-toggle="modal" data-bs-target="#teacherModal" data-name="{{ $teacher->name }}"
                                        data-title="{{ $teacher->designation->name }}"
                                        data-subject="{{ $teacher->subject ?? 'N/A' }}"
                                        data-email="{{ $teacher->email ?? 'N/A' }}" data-phone="{{ $teacher->phone ?? 'N/A' }}"
                                        data-qualification="{{ $teacher->qualification ?? 'N/A' }}"
                                        data-join="{{ $teacher->join_date ? \Carbon\Carbon::parse($teacher->join_date)->format('d M, Y') : 'N/A' }}"
                                        data-img="{{ asset($teacher->photo_path) }}" data-teacher-id="{{ $teacher->id }}">
                                        <div class="techers-wrap text-center">
                                            <img src="{{ asset($teacher->photo_path) }}" alt="{{ $teacher->name }}"
                                                class="img-fluid"
                                                onerror="this.onerror=null; this.src='{{ asset('/public/assets/icons/user.png') }}'">

                                            <div class="teachers-dig mt-3">
                                                <h4>{{ $teacher->name }}</h4>
                                                <p>{{ $teacher->designation->name }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Hidden biography div --}}
                                    <div class="d-none bio-content" id="bio-{{ $teacher->id }}">
                                        {!! nl2br(e($teacher->biography ?? 'N/A')) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="btn-part d-flex justify-content-center">
                        <a class="btn btn-outline-primary rounded-pill px-4 py-2" href="{{ route('teacher_team') }}">{{ __('landing.view_more') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Teacher Info Modal -->
    <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header" style="color: #000;">
                    <h5 class="modal-title fw-bold" id="teacherModalLabel">{{ __('landing.teacher_modal_title') }}</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="{{ __('landing.teacher_modal_close') }}"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Image -->
                        <div class="col-md-3 text-center">
                            <img id="modalTeacherImg" src="" alt="{{ __('landing.principal_photo_alt') }}" class="img-fluid rounded shadow-sm mb-2"
                                style="max-width: 120px;">
                        </div>

                        <!-- Right: Info -->
                        <div class="col-md-9">
                            <h5 class="fw-bold mb-1" id="modalTeacherName">SS</h5>
                            <p class="mb-1"><strong>{{ __('teacher_team.designation') }}:</strong> <span id="modalTeacherTitle">Principal</span></p>
                            <p class="mb-1"><strong>{{ __('landing.teacher_modal_qualification') }}</strong> <span id="modalTeacherQualification">ddd</span>
                            </p>
                            <!-- <p class="mb-1"><strong>{{ __('landing.teacher_modal_joined_on') }}</strong> <span id="modalTeacherJoin">19 Aug 2025</span></p> -->
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="mt-3">
                        <h6 class="fw-bold">{{ __('landing.teacher_modal_biography') }}</h6>
                        <p id="modalTeacherBiography" class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Commitee Modal -->
    <div class="modal fade" id="committeModal" tabindex="-1" aria-labelledby="committeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header" style="color: #000;">
                    <h5 class="modal-title fw-bold" id="committeModalLabel">{{ __('landing.committee_modal_title') }}</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="{{ __('landing.notice_modal_close') }}"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Image -->
                        <div class="col-md-3 text-center">
                            <img id="modalCommiteeImg" src="" alt="{{ __('landing.chairman_photo_alt') }}" class="img-fluid rounded shadow-sm mb-2"
                                style="max-width: 120px;">
                        </div>

                        <!-- Right: Info -->
                        <div class="col-md-9">
                            <h5 class="fw-bold mb-1" id="modalCommiteeName">SS</h5>
                            <p class="mb-1"><strong>{{ __('teacher_team.designation') }}:</strong> <span id="modalCommiteeTitle">Principal</span></p>
                            <p class="mb-1"><strong>{{ __('landing.teacher_modal_qualification') }}</strong> <span id="modalCommiteeQualification">ddd</span>
                            </p>
                            <!-- <p class="mb-1"><strong>{{ __('landing.teacher_modal_joined_on') }}</strong> <span id="modalCommiteeJoin">19 Aug 2025</span></p> -->
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="mt-3">
                        <h6 class="fw-bold">{{ __('landing.committee_modal_biography') }}</h6>
                        <p id="modalCommiteeBiography" class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


<!-- ✅ Modal Script -->
<script>
    // Teacher
    document.addEventListener('DOMContentLoaded', function () {
        var teacherModal = document.getElementById('teacherModal');
        teacherModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var name = button.getAttribute('data-name');
            var title = button.getAttribute('data-title');
            var qualification = button.getAttribute('data-qualification');
            // var join = button.getAttribute('data-join');
            var img = button.getAttribute('data-img');
            var teacherId = button.getAttribute('data-teacher-id');

            // Get hidden bio div content
            var bioDiv = document.getElementById('bio-' + teacherId);
            var bioContent = bioDiv ? bioDiv.innerHTML : 'N/A';

            document.getElementById('modalTeacherName').textContent = name;
            document.getElementById('modalTeacherTitle').textContent = title;
            document.getElementById('modalTeacherQualification').textContent = qualification;
            // document.getElementById('modalTeacherJoin').textContent = join;
            document.getElementById('modalTeacherBiography').innerHTML = bioContent;
            document.getElementById('modalTeacherImg').src = img;
        });
    });

    // Committe

    document.addEventListener('DOMContentLoaded', function () {
        var committeModal = document.getElementById('committeModal');

        if (committeModal) {
            committeModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var name = button.getAttribute('data-name');
                var title = button.getAttribute('data-title');
                var qualification = button.getAttribute('data-qualification');
                var img = button.getAttribute('data-img');
                var committeId = button.getAttribute('data-committe-id');

                // Get hidden bio div content
                var bioDiv = document.getElementById('bio-' + committeId);
                var bioContent = bioDiv ? bioDiv.innerHTML : 'N/A';

                document.getElementById('modalCommiteeName').textContent = name;
                document.getElementById('modalCommiteeTitle').textContent = title;
                document.getElementById('modalCommiteeQualification').textContent = qualification;
                document.getElementById('modalCommiteeBiography').innerHTML = bioContent;
                document.getElementById('modalCommiteeImg').src = img;
            });
        }
    });

    // Committee Carousel Initialization
    $(document).ready(function() {
        $('.committee-carousel').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            dots: true,
            infinite: true,
            speed: 500,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
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
    });
</script>

<style>
    .committee-carousel .slick-prev,
    .committee-carousel .slick-next {
        z-index: 10;
        width: 40px;
        height: 40px;
    }
    
    .committee-carousel .slick-prev {
        left: -15px;
    }
    
    .committee-carousel .slick-next {
        right: -15px;
    }
    
    .committee-carousel .slick-prev:before,
    .committee-carousel .slick-next:before {
        font-size: 30px;
        color: #007bff;
        opacity: 0.8;
    }
    
    .committee-carousel .slick-prev:hover:before,
    .committee-carousel .slick-next:hover:before {
        opacity: 1;
    }
    
    .committee-carousel .slick-dots {
        bottom: -40px;
    }
    
    .committee-carousel .slick-dots li button:before {
        font-size: 12px;
        color: #007bff;
    }
    
    .committee-carousel .slick-dots li.slick-active button:before {
        color: #007bff;
    }

    @media (max-width: 576px) {
        .committee-carousel .slick-prev {
            left: 10px;
        }
        
        .committee-carousel .slick-next {
            right: 10px;
        }
    }
</style>