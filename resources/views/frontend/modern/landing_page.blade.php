@extends('frontend.modern.layouts.app')

@section('content')
<div class="container-fluid px-4 pt-4">
    <div class="row mx-4 gx-4 ">
        <div class="col-md-8 bg-white">
            <section id="home" class="hero-section rounded">
                <div id="heroCarousel" class="carousel slide rounded border" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0"
                            class="active"></button>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://images.pexels.com/photos/207692/pexels-photo-207692.jpeg?auto=compress&cs=tinysrgb&w=1200&h=600&fit=crop"
                                class="d-block w-100" alt="School Campus">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="display-4 fw-bold">Excellence in Education</h3>
                                <button class="btn btn-outline-light btn-lg">Contact Us</button>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.pexels.com/photos/1181534/pexels-photo-1181534.jpeg?auto=compress&cs=tinysrgb&w=1200&h=600&fit=crop"
                                class="d-block w-100" alt="Students Learning">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="display-4 fw-bold">Excellence in Education</h3>
                                <button class="btn btn-outline-light btn-lg">Contact Us</button>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.pexels.com/photos/1181519/pexels-photo-1181519.jpeg?auto=compress&cs=tinysrgb&w=1200&h=600&fit=crop"
                                class="d-block w-100" alt="School Activities">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="display-4 fw-bold">Excellence in Education</h3>
                                <button class="btn btn-outline-light btn-lg">Contact Us</button>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </section>
        </div>
        <div class="col-md-4 bg-white">

            <div class="card sidebar-box">
                <div class="card-header bg-primary text-white">
                    <h5 class="my-2"><i class="fas fa-bullhorn me-2"></i>Latest Notices</h5>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        @foreach($notices as $notice)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#noticeModal"
                            data-title="{{ $notice->title }}"
                            data-date="{{ \Carbon\Carbon::parse($notice->start_date)->format('F j, Y') }}"
                            data-description="{{ $notice->description }}"
                            onclick="showNoticeModal(this)"
                            class="list-group-item list-group-item-action">

                            <div class="d-flex align-items-start">
                                <i class="fas fa-bullhorn text-warning me-2 mt-1"></i>
                                <div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <small class="text-primary fw-bold">
                                            {{ \Carbon\Carbon::parse($notice->start_date)->format('F j, Y') }}
                                        </small>
                                    </div>
                                    <p class="mb-1">{{ $notice->title }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="notice-ticker d-flex align-items-center py-2 border rounded" style="white-space: nowrap;">
                <!-- Label -->
                <div class="ticker-label fw-bold px-3 py-1 bg-warning text-dark ms-0 flex-shrink-0 z-1">
                    IMPORTANT NOTICES:
                </div>

                <!-- Ticker Content -->
                <div class="ticker-content d-flex align-items-center">
                    @foreach($important_notices as $important_notice)
                    <a href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#newsModal"
                        data-content="{{ $important_notice->description }}"
                        onclick="showNewsModal(this)"
                        class="d-flex align-items-center text-decoration-none text-dark me-3">

                        <!-- Date Badge -->
                        <span class="badge bg-transparent text-dark border border-secondary me-2 rounded-pill py-1 px-2">
                            {{ \Carbon\Carbon::parse($important_notice->start_date)->format('F j, Y') }}
                        </span>
                        <!-- Title -->
                        <span>{{ $important_notice->title }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row mx-4 g-3">

        <!-- Left Column -->
        <div class="col-md-8  bg-white">
            <!-- Hero Carousel -->

            <div class="main-content p-4">

                <section class="section-block">
                    <div class="section-header">
                        <h2 class="section-title">Our Achievements</h2>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users text-primary"></i>
                                </div>
                                <h3 class="counter" data-count="1250">0</h3>
                                <p class="stat-label">Students</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-chalkboard-teacher text-success"></i>
                                </div>
                                <h3 class="counter" data-count="85">0</h3>
                                <p class="stat-label">Teachers</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-graduation-cap text-warning"></i>
                                </div>
                                <h3 class="counter" data-count="98">0</h3>
                                <p class="stat-label">Pass Rate %</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-trophy text-danger"></i>
                                </div>
                                <h3 class="counter" data-count="150">0</h3>
                                <p class="stat-label">Awards Won</p>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- About Section -->
                <section id="about" class="section-block">
                    <div class="section-header">
                        <h2 class="section-title">{{ get_setting('about_us_title')}}</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="lead"> {{ \Illuminate\Support\Str::words(get_setting('about_us_description'), 80, '...') }}</p>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ asset(get_setting('about_us_image'))}}"
                                class="img-fluid rounded" alt="About School">
                        </div>
                    </div>
                </section>

                <!-- Headmaster Speech -->
                <section class="section-block">
                    <div class="section-header">
                        <h2 class="section-title">{{ get_setting('headmaster_designation') ?? 'Principal/ Headmaster' }}'s Message</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <img src="{{asset(get_setting('headmaster_image') )}}"
                                class="img-fluid rounded" alt="Principal">
                        </div>
                        <div class="col-md-8">
                            <blockquote class="blockquote">
                                <p class="mb-3">"{{ \Illuminate\Support\Str::words(get_setting('headmaster_speech'), 35, '...') }}"
                                </p>
                                <footer class="blockquote-footer">
                                    <strong>{{get_setting('headmaster_name')}}</strong>, {{get_setting('headmaster_designation')}}
                                    <br><small>{{get_setting('school_name')}}</small>
                                </footer>
                            </blockquote>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-md-4 bg-white">

            <!-- Important Links -->
            <div class="card mt-4 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-link me-2"></i>Important Links</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-graduate me-2 text-primary"></i>Student Portal
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2 text-success"></i>Parent Portal
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-chalkboard-teacher me-2 text-warning"></i>Teacher Portal
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-book me-2 text-info"></i>Online Library
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-alt me-2 text-danger"></i>Academic Calendar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Official Links -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-external-link-alt me-2"></i>Official Links</h5>
                </div>
                <div class="card-body px-2">
                    <div class="list-group list-group-flush">
                        @php
                        $icons = [
                        'fas fa-university text-primary',
                        'fas fa-graduation-cap text-success',
                        'fas fa-landmark text-warning',
                        'fas fa-flag text-danger',
                        'fas fa-book-reader text-info'
                        ];
                        @endphp

                        @foreach($officiallinks as $index => $officiallink)
                        <a href="{{ $officiallink->url }}" class="list-group-item list-group-item-action" target="_blank">
                            <i class="{{ $icons[$index] ?? 'fas fa-link text-secondary' }} me-2"></i>
                            {{ $officiallink->title }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Important Files -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-file-download me-2"></i>Important Files</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>Admission Form (PDF)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-word me-2 text-primary"></i>Fee Structure (DOC)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>Academic Calendar (PDF)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>School Brochure (PDF)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-word me-2 text-primary"></i>Transport Application (DOC)
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4 sidebar-box">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Upcoming Events</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <h6>Annual Sports Day</h6>
                            <p class="text-muted mb-1">March 15, 2024</p>
                            <small>Grand sports competition and cultural program</small>
                        </div>
                        <div class="timeline-item">
                            <h6>Science Exhibition</h6>
                            <p class="text-muted mb-1">March 20, 2024</p>
                            <small>Students showcase their innovative projects</small>
                        </div>
                        <div class="timeline-item">
                            <h6>Parent-Teacher Conference</h6>
                            <p class="text-muted mb-1">March 25, 2024</p>
                            <small>Discussion on student progress and development</small>
                        </div>
                        <div class="timeline-item">
                            <h6>Science Exhibition</h6>
                            <p class="text-muted mb-1">March 20, 2024</p>
                            <small>Students showcase their innovative projects</small>
                        </div>
                        <div class="timeline-item">
                            <h6>Parent-Teacher Conference</h6>
                            <p class="text-muted mb-1">March 25, 2024</p>
                            <small>Discussion on student progress and development</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="section-title text-center">Frequently Asked Questions</h4>
                </div>
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
            </div>
        </div>
        <section class="section-block container px-5">
            <div class="section-header">
                <h2 class="section-title">Our Faculty</h2>
            </div>
            <div id="teacherCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($teachers->chunk(4) as $chunkIndex => $teacherChunk)
                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach($teacherChunk as $teacher)
                            <div class="col-md-3">
                                <div class="teacher-card text-center p-3">
                                    <img src="{{ asset($teacher->photo ?? 'default-teacher.jpg') }}"
                                        class="rounded-circle mb-3"
                                        alt="{{ $teacher->name }}"
                                        width="120" height="120">
                                    <h5>{{ $teacher->name }}</h5>
                                    <p class="text-muted">{{ $teacher->designation }}</p>
                                    <p><small>{{ $teacher->qualification }}</small></p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#teacherCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#teacherCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="section-block">
            <div class="section-header">
                <h2 class="section-title">School Gallery</h2>
            </div>

            <div class="grid-gallery">
                <!-- Left: Tall Image -->
                <div class="gallery-item tall">
                    <img src="https://images.pexels.com/photos/1181534/pexels-photo-1181534.jpeg" alt="Classroom">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </div>

                <!-- Right: Two stacked images -->
                <div class="gallery-item small">
                    <img src="https://images.pexels.com/photos/1181519/pexels-photo-1181519.jpeg" alt="Sports Day">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </div>
                <div class="gallery-item small">
                    <img src="https://images.pexels.com/photos/1181533/pexels-photo-1181533.jpeg" alt="Laboratory">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </div>
            </div>
        </section>


        <section class="section-block news-events">
            <div class="section-header">
                <h2 class="section-title">News & Events</h2>
            </div>

            <div class="row g-4">
                <!-- News Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Annual Science Fair 2024</h5>
                            <p class="card-date text-muted"><i class="fas fa-calendar-alt me-2"></i>March 25, 2024
                            </p>
                            <p class="card-text">Students showcase innovative science projects and experiments.
                                Awards for best projects in each category.</p>
                            <a href="#" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Inter-School Cricket Championship</h5>
                            <p class="card-date text-muted"><i class="fas fa-calendar-alt me-2"></i>April 10, 2024
                            </p>
                            <p class="card-text">Our school cricket team participates in the regional championship.
                                Come support our young athletes!</p>
                            <a href="#" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Cultural Program - Spring Festival</h5>
                            <p class="card-date text-muted"><i class="fas fa-calendar-alt me-2"></i>April 15, 2024
                            </p>
                            <p class="card-text">A vibrant celebration of arts, culture, and traditions featuring
                                student performances and exhibitions.</p>
                            <a href="#" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Parent Workshop on Digital Safety</h5>
                            <p class="card-date text-muted"><i class="fas fa-calendar-alt me-2"></i>May 5, 2024</p>
                            <p class="card-text">Interactive workshop for parents on keeping children safe in the
                                digital age. Expert speakers and practical tips.</p>
                            <a href="#" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection