@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">Hospital Department</h1>
    </div>
</section>

<!-- Hospital Department Section -->
<section class="hospital-department-section my-5">
    <div class="container">
        <!-- Section Navigation Tabs -->
        <ul class="nav nav-tabs mb-4 justify-content-center" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $department === 'indoor_patient_department' ? 'active' : '' }}" href="{{ route('hospital_department.frontend', 'indoor_patient_department') }}">
                    Indoor Patient Department
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $department === 'out_patient_department' ? 'active' : '' }}" href="{{ route('hospital_department.frontend', 'out_patient_department') }}">
                    Out Patient Department
                </a>
            </li>
        </ul>

        <!-- Indoor Patient Department -->
        @if($department === 'indoor_patient_department')
            @if($indoorPatient)
                @php
                    $indoorData = json_decode($indoorPatient->description, true);
                    $indoorCategories = $indoorData && isset($indoorData['categories']) ? $indoorData['categories'] : [];
                @endphp
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Indoor Patient Department</h3>
                    </div>
                    <div class="card-body p-4">
                        @if(count($indoorCategories) > 0)
                            @foreach($indoorCategories as $categoryIndex => $category)
                                <div class="category-section mb-5 {{ $categoryIndex > 0 ? 'border-top pt-4' : '' }}">
                                    <h4 class="fw-bold mb-4 text-primary">{{ $category['name'] }}</h4>
                                    
                                    @if(isset($category['images']) && count($category['images']) > 0)
                                        <div class="row g-3">
                                            @foreach($category['images'] as $image)
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="image-card position-relative">
                                                        <img src="{{ asset($image) }}" 
                                                             alt="{{ $category['name'] }}" 
                                                             class="img-fluid rounded shadow-sm w-100" 
                                                             style="height: 250px; object-fit: cover; cursor: pointer;"
                                                             data-bs-toggle="modal" 
                                                             data-bs-target="#imageModal"
                                                             data-src="{{ asset($image) }}">
                                                        <div class="overlay">
                                                            <i class="fas fa-search-plus fa-2x text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No images available for this category.</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <p class="mb-0">No categories available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5>No Indoor Patient Department information available at the moment.</h5>
                    <p>Please check back later.</p>
                </div>
            @endif
        @endif

        <!-- Out Patient Department -->
        @if($department === 'out_patient_department')
            @if($outPatient)
                @php
                    $outData = json_decode($outPatient->description, true);
                    $outCategories = $outData && isset($outData['categories']) ? $outData['categories'] : [];
                @endphp
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">Out Patient Department</h3>
                    </div>
                    <div class="card-body p-4">
                        @if(count($outCategories) > 0)
                            @foreach($outCategories as $categoryIndex => $category)
                                <div class="category-section mb-5 {{ $categoryIndex > 0 ? 'border-top pt-4' : '' }}">
                                    <h4 class="fw-bold mb-4 text-success">{{ $category['name'] }}</h4>
                                    
                                    @if(isset($category['images']) && count($category['images']) > 0)
                                        <div class="row g-3">
                                            @foreach($category['images'] as $image)
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="image-card position-relative">
                                                        <img src="{{ asset($image) }}" 
                                                             alt="{{ $category['name'] }}" 
                                                             class="img-fluid rounded shadow-sm w-100" 
                                                             style="height: 250px; object-fit: cover; cursor: pointer;"
                                                             data-bs-toggle="modal" 
                                                             data-bs-target="#imageModal"
                                                             data-src="{{ asset($image) }}">
                                                        <div class="overlay">
                                                            <i class="fas fa-search-plus fa-2x text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No images available for this category.</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <p class="mb-0">No categories available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5>No Out Patient Department information available at the moment.</h5>
                    <p>Please check back later.</p>
                </div>
            @endif
        @endif
    </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 p-0 position-relative">
            <img src="" id="modalImage" class="img-fluid rounded-3 shadow mx-auto d-block" style="max-height: 80vh; width: 100%; object-fit: contain;">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 bg-dark bg-opacity-50 rounded" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
</div>

<style>
    .hospital-department-section .image-card {
        overflow: hidden;
        border-radius: 8px;
    }
    
    .hospital-department-section .image-card .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .hospital-department-section .image-card:hover .overlay {
        opacity: 1;
    }
    
    .hospital-department-section .image-card img {
        transition: transform 0.3s ease;
    }
    
    .hospital-department-section .image-card:hover img {
        transform: scale(1.05);
    }
</style>

<script>
    // Image Modal functionality
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const imageSrc = button.getAttribute('data-src');
            const modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageSrc;
        });
    }
</script>
@endsection

