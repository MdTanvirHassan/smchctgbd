@extends('frontend.college.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row bg-primary text-white py-4 mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-link me-3"></i>Admission Links
            </h1>
            <p class="lead mb-0">Important admission-related links and resources</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($admission_links->count() > 0)
                    <div class="row g-4">
                        @foreach($admission_links as $link)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px; min-width: 50px;">
                                                <i class="fas fa-external-link-alt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="card-title fw-bold text-primary mb-2">{{ $link->title }}</h5>
                                                @if($link->description)
                                                    <p class="text-muted mb-3">{{ $link->description }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if($link->start_date || $link->end_date)
                                            <div class="mb-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    @if($link->start_date && $link->end_date)
                                                        {{ \Carbon\Carbon::parse($link->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($link->end_date)->format('M d, Y') }}
                                                    @elseif($link->start_date)
                                                        From: {{ \Carbon\Carbon::parse($link->start_date)->format('M d, Y') }}
                                                    @elseif($link->end_date)
                                                        Until: {{ \Carbon\Carbon::parse($link->end_date)->format('M d, Y') }}
                                                    @endif
                                                </small>
                                            </div>
                                        @endif

                                        <div class="d-flex gap-2">
                                            <a href="{{ $link->link_url }}" target="_blank" 
                                               class="btn btn-primary btn-sm flex-grow-1">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                Visit Link
                                            </a>
                                            <button class="btn btn-outline-secondary btn-sm" 
                                                    onclick="copyToClipboard('{{ $link->link_url }}')" 
                                                    title="Copy Link">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>

                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                Added: {{ $link->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-link text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="text-muted mb-3">No Admission Links Available</h3>
                        <p class="text-muted">Currently, there are no admission links published. Please check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Toast for copy notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="copyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-check-circle text-success me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Link copied to clipboard!
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-title {
    line-height: 1.3;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}
</style>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show toast notification
        var toastEl = document.getElementById('copyToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        // Fallback for older browsers
        var textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            var toastEl = document.getElementById('copyToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        } catch (err) {
            console.error('Fallback: Could not copy text: ', err);
        }
        document.body.removeChild(textArea);
    });
}
</script>
@endsection
