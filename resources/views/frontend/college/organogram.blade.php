@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.organogram') }}</h1>
    </div>
</section>

<!-- Organogram Section -->
<section class="organogram-section my-5">
    <div class="container">
        @if($organogram)
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ $organogram->title }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Image -->
                        @if($organogram->file_path)
                            <div class="col-md-12 text-center mb-4">
                                <img src="{{ asset($organogram->file_path) }}" alt="{{ $organogram->title }}" class="img-fluid rounded shadow" style="max-height: 600px; object-fit: contain;">
                            </div>
                        @endif

                        <!-- Description -->
                        @if($organogram->description)
                            <div class="col-md-12">
                                <div class="description-content" style="line-height: 1.8; text-align: justify;">
                                    {!! nl2br(e($organogram->description)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Link URL -->
                        @if($organogram->link_url)
                            <div class="col-md-12 text-center">
                                <a href="{{ $organogram->link_url }}" target="_blank" class="btn btn-primary btn-lg">
                                    <i class="fas fa-external-link-alt me-2"></i>View More Information
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                <h5>No Organogram available at the moment.</h5>
                <p>Please check back later.</p>
            </div>
        @endif
    </div>
</section>

<style>
    .organogram-section .description-content {
        font-size: 1.1rem;
        color: #333;
    }
</style>
@endsection

