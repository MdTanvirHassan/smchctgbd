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
                $pdfs = $data && isset($data['pdfs']) ? $data['pdfs'] : [];
                // Handle backward compatibility - convert string paths to objects
                if (!empty($pdfs) && is_string($pdfs[0] ?? null)) {
                    $pdfs = array_map(function($path) {
                        return ['path' => $path, 'title' => basename($path)];
                    }, $pdfs);
                }
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
                                <div class="description-content summernote-content" style="line-height: 1.8; text-align: justify;">
                                    {!! $data['description'] !!}
                                </div>
                            </div>
                        @endif

                        <!-- PDFs Section -->
                        @if(count($pdfs) > 0)
                            <div class="col-md-12">
                                <h5 class="mb-3 fw-bold">PDF Documents</h5>
                                <div class="list-group">
                                    @foreach($pdfs as $pdf)
                                        @php
                                            $pdfPath = is_array($pdf) ? ($pdf['path'] ?? '') : $pdf;
                                            $pdfTitle = is_array($pdf) ? ($pdf['title'] ?? basename($pdfPath)) : basename($pdfPath);
                                            $pdfUrl = asset($pdfPath);
                                        @endphp
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-file-pdf me-2 text-danger"></i>
                                                <span class="fw-semibold">{{ $pdfTitle }}</span>
                                            </div>
                                            <div class="btn-group" role="group">
                                                <a href="{{ $pdfUrl }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                                <a href="{{ $pdfUrl }}" download class="btn btn-sm btn-danger">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </div>
                                        </div>
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
        border-left: 4px solid #dc3545;
        margin-bottom: 0.5rem;
    }
    
    .eligibility-criteria-section .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-left-color: #c82333;
    }
    
    .eligibility-criteria-section .description-content {
        font-size: 1.1rem;
        color: #333;
    }
    
    /* Styles for Summernote rich text content */
    .eligibility-criteria-section .summernote-content {
        word-wrap: break-word;
    }
    
    .eligibility-criteria-section .summernote-content p {
        margin-bottom: 1rem;
    }
    
    .eligibility-criteria-section .summernote-content ul,
    .eligibility-criteria-section .summernote-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .eligibility-criteria-section .summernote-content li {
        margin-bottom: 0.5rem;
    }
    
    .eligibility-criteria-section .summernote-content h1,
    .eligibility-criteria-section .summernote-content h2,
    .eligibility-criteria-section .summernote-content h3,
    .eligibility-criteria-section .summernote-content h4,
    .eligibility-criteria-section .summernote-content h5,
    .eligibility-criteria-section .summernote-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .eligibility-criteria-section .summernote-content table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    
    .eligibility-criteria-section .summernote-content table td,
    .eligibility-criteria-section .summernote-content table th {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .eligibility-criteria-section .summernote-content table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .eligibility-criteria-section .summernote-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    .eligibility-criteria-section .summernote-content a {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    .eligibility-criteria-section .summernote-content a:hover {
        color: #0a58ca;
    }
    
    .eligibility-criteria-section .list-group-item .btn-group {
        gap: 0.5rem;
    }
    
    .eligibility-criteria-section .list-group-item .btn {
        white-space: nowrap;
    }
</style>
@endsection

