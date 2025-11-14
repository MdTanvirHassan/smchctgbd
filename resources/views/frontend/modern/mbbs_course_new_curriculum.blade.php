@extends('frontend.modern.layouts.app')

@section('content')

<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.mbbs_course_new_curriculum') }}</h1>
        <h2 class="mt-3">Medical Education Programs</h2>
    </div>
</section>

<section class="mb-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="services-title text-center mb-5">
                    <h5 style="font-size:20px; color: #000;">{{ __('header.mbbs_course_new_curriculum') }}</h5>
                    <h2 class="text-lg mt-3" style="font-size: 30px;font-weight: 500; color: #000;">Course Curriculum Structure</h2>
                </div>
            </div>
        </div>

        @if($categories->isEmpty())
            <div class="alert alert-info text-center">
                <p class="mb-0">No courses available at the moment.</p>
            </div>
        @else
            <div class="row">
                @foreach($categories as $parentCategory)
                    <div class="col-md-12 mb-4">
                        <!-- Parent Category Card -->
                        <div class="card border-0 shadow-sm mb-3" style="border-left: 4px solid #007bff !important;">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    {{ $parentCategory->name }}
                                </h4>
                                @if($parentCategory->description)
                                    <p class="mb-0 mt-2 small">{{ $parentCategory->description }}</p>
                                @endif
                            </div>

                            @if($parentCategory->activeChildren->count() > 0)
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($parentCategory->activeChildren as $childCategory)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card h-100 border-left-child" style="border-left: 3px solid #28a745 !important;">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-success mb-2">
                                                            <i class="fas fa-book me-2"></i>
                                                            {{ $childCategory->name }}
                                                        </h5>
                                                        @if($childCategory->description)
                                                            <p class="card-text text-muted small mb-0">{{ $childCategory->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="card-body">
                                    <p class="text-muted mb-0"><em>No subcategories available.</em></p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    .border-left-child {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .border-left-child:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }

    .card-header h4 {
        font-weight: 600;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.1rem;
    }
</style>

@endsection

