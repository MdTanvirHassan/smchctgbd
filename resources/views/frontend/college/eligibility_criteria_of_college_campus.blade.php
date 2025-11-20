@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.eligibility_criteria_of_college_campus') }}</h1>
    </div>
</section>

<!-- Eligibility Criteria Section -->
<section class="eligibility-criteria-section my-5">
    <div class="container">
        @if($eligibilityCriteria)
            @php
                $data = json_decode($eligibilityCriteria->description, true);
                $links = $data && isset($data['links']) ? $data['links'] : [];
            @endphp
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('header.eligibility_criteria_of_college_campus') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Image -->
                        @if($eligibilityCriteria->file_path)
                            <div class="col-md-12 text-center mb-4">
                                <img src="{{ asset($eligibilityCriteria->file_path) }}" alt="Eligibility Criteria" class="img-fluid rounded shadow" style="max-height: 500px; object-fit: contain;">
                            </div>
                        @endif

                        <!-- Description -->
                        @if($data && isset($data['description']) && !empty($data['description']))
                            <div class="col-md-12">
                                <div class="description-content" style="line-height: 1.8; text-align: justify;">
                                    {!! nl2br(e($data['description'])) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Links Section -->
                        @if(count($links) > 0)
                            <div class="col-md-12">
                                <h5 class="mb-3 fw-bold">Related Links</h5>
                                <div class="list-group">
                                    @foreach($links as $link)
                                        <a href="{{ $link['url'] }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-external-link-alt me-2 text-primary"></i>
                                                <span class="fw-semibold">{{ $link['title'] }}</span>
                                            </div>
                                            <button class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </button>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                <h5>No Eligibility Criteria available at the moment.</h5>
                <p>Please check back later.</p>
            </div>
        @endif
    </div>
</section>

<style>
    .eligibility-criteria-section .list-group-item {
        transition: all 0.3s ease;
        border-left: 4px solid #007bff;
    }
    
    .eligibility-criteria-section .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .eligibility-criteria-section .description-content {
        font-size: 1.1rem;
        color: #333;
    }
</style>
@endsection

