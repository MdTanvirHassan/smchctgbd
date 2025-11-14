@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.facilities') }}</h1>
    </div>
</section>

<!-- Facilities Section -->
<section class="facilities-section my-5">
    <div class="container">
        <!-- Section Navigation Tabs -->
        <ul class="nav nav-tabs mb-4 justify-content-center" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $section === 'academic_facility' ? 'active' : '' }}" href="{{ route('facilities.frontend', 'academic_facility') }}">
                    {{ __('header.academic_facility') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $section === 'teaching_activities' ? 'active' : '' }}" href="{{ route('facilities.frontend', 'teaching_activities') }}">
                    {{ __('header.teaching_activities') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $section === 'activities_of_meu' ? 'active' : '' }}" href="{{ route('facilities.frontend', 'activities_of_meu') }}">
                    {{ __('header.activities_of_meu') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $section === 'research_cell' ? 'active' : '' }}" href="{{ route('facilities.frontend', 'research_cell') }}">
                    {{ __('header.research_cell') }}
                </a>
            </li>
        </ul>

        <!-- Academic Facility -->
        @if($section === 'academic_facility' && $academicFacility)
            @php
                $academicData = json_decode($academicFacility->description, true);
            @endphp
            <div id="academic-facility" class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('header.academic_facility') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @if(isset($academicData['images']))
                            @foreach($academicData['images'] as $index => $image)
                                <div class="col-md-6">
                                    <img src="{{ asset($image) }}" alt="Academic Facility Image {{ $index + 1 }}" class="img-fluid rounded shadow">
                                </div>
                            @endforeach
                        @endif
                        @if($academicData && isset($academicData['description']))
                            <div class="col-md-12">
                                <p class="lead">{{ $academicData['description'] }}</p>
                            </div>
                        @endif
                        @if($academicFacility->link_url)
                            <div class="col-md-12">
                                <a href="{{ $academicFacility->link_url }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>View More
                                </a>
                            </div>
                        @endif
                        @if($academicFacility->file_path)
                            <div class="col-md-12">
                                <h5 class="mb-3">Academic Calendar 2024</h5>
                                <img src="{{ asset( $academicFacility->file_path) }}" alt="Academic Calendar" class="img-fluid rounded shadow">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Teaching Activities -->
        @if($section === 'teaching_activities' && $teachingActivities)
            @php
                $teachingData = json_decode($teachingActivities->description, true);
            @endphp
            <div id="teaching-activities" class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">{{ __('header.teaching_activities') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @if(isset($teachingData['images']))
                            <div class="col-md-12 mb-3">
                                @if(isset($teachingData['description1']))
                                    <p class="lead mb-3">{{ $teachingData['description1'] }}</p>
                                @endif
                                <div class="row g-3">
                                    @foreach(array_slice($teachingData['images'], 0, 2) as $index => $image)
                                        <div class="col-md-6">
                                            <img src="{{ asset($image) }}" alt="Teaching Activity Image {{ $index + 1 }}" class="img-fluid rounded shadow">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                @if(isset($teachingData['description2']))
                                    <p class="lead mb-3">{{ $teachingData['description2'] }}</p>
                                @endif
                                <div class="row g-3">
                                    @foreach(array_slice($teachingData['images'], 2, 2) as $index => $image)
                                        <div class="col-md-6">
                                            <img src="{{ asset($image) }}" alt="Teaching Activity Image {{ $index + 3 }}" class="img-fluid rounded shadow">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($teachingActivities->link_url)
                            <div class="col-md-12">
                                <a href="{{ $teachingActivities->link_url }}" target="_blank" class="btn btn-success">
                                    <i class="fas fa-external-link-alt me-2"></i>View More
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Activities of MEU -->
        @if($section === 'activities_of_meu' && $activitiesOfMeu)
            @php
                $meuData = json_decode($activitiesOfMeu->description, true);
            @endphp
            <div id="activities-of-meu" class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0">{{ __('header.activities_of_meu') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @if($activitiesOfMeu->file_path)
                            <div class="col-md-6">
                                <img src="{{ asset($activitiesOfMeu->file_path) }}" alt="MEU Activities" class="img-fluid rounded shadow">
                            </div>
                        @endif
                        @if($meuData && isset($meuData['description']))
                            <div class="col-md-6">
                                <p class="lead">{{ $meuData['description'] }}</p>
                                @if($activitiesOfMeu->link_url)
                                    <a href="{{ $activitiesOfMeu->link_url }}" target="_blank" class="btn btn-info text-white">
                                        <i class="fas fa-external-link-alt me-2"></i>View More
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Research Cell -->
        @if($section === 'research_cell' && $researchCell)
            @php
                $researchData = json_decode($researchCell->description, true);
            @endphp
            <div id="research-cell" class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">{{ __('header.research_cell') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @if($researchCell->file_path)
                            <div class="col-md-6">
                                <img src="{{ asset($researchCell->file_path) }}" alt="Research Cell" class="img-fluid rounded shadow">
                            </div>
                        @endif
                        @if($researchData && isset($researchData['description']))
                            <div class="col-md-6">
                                <p class="lead">{{ $researchData['description'] }}</p>
                                @if($researchCell->link_url)
                                    <a href="{{ $researchCell->link_url }}" target="_blank" class="btn btn-warning">
                                        <i class="fas fa-external-link-alt me-2"></i>View More
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if(
            ($section === 'academic_facility' && !$academicFacility) ||
            ($section === 'teaching_activities' && !$teachingActivities) ||
            ($section === 'activities_of_meu' && !$activitiesOfMeu) ||
            ($section === 'research_cell' && !$researchCell)
        )
            <div class="alert alert-info text-center">
                <h5>
                    @if($section === 'academic_facility')
                        No {{ __('header.academic_facility') }}
                    @elseif($section === 'teaching_activities')
                        No {{ __('header.teaching_activities') }}
                    @elseif($section === 'activities_of_meu')
                        No {{ __('header.activities_of_meu') }}
                    @elseif($section === 'research_cell')
                        No {{ __('header.research_cell') }}
                    @endif
                    available at the moment.
                </h5>
                <p>Please check back later.</p>
            </div>
        @endif
    </div>
</section>
@endsection

