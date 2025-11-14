@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.video_gallery') }}</h1>
    </div>
</section>

<!-- Video Gallery -->
<section class="gallery-videos-section my-5">
    <div class="container py-5 bg-white rounded shadow-sm">
        <div class="text-center mb-4">
            <h2 class="fw-bold">{{ $name->name }}</h2>
        </div>

        <div class="row g-3">
            @foreach($galleries as $video)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="position-relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
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
                                     style="object-fit: cover; cursor: pointer;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#videoModal"
                                     data-video-url="{{ $video->video_url }}"
                                     data-title="{{ $video->title }}"
                                     data-caption="{{ $video->caption ?? '' }}">
                                <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 10; pointer-events: none;">
                                    <i class="fab fa-youtube text-danger" style="font-size: 64px; opacity: 0.9; text-shadow: 0 2px 8px rgba(0,0,0,0.7);"></i>
                                </div>
                            @else
                                <div class="position-absolute top-50 start-50 translate-middle text-white">
                                    <i class="fas fa-video" style="font-size: 48px;"></i>
                                </div>
                            @endif
                        @elseif($video->video_path && !empty(trim($video->video_path)))
                            @php
                                $videoPath = trim($video->video_path);
                                if (strpos($videoPath, 'public/') === 0) {
                                    $videoPath = substr($videoPath, 7);
                                }
                                $videoPath = ltrim($videoPath, '/');
                                $videoDisplayUrl = asset($videoPath);
                            @endphp
                            <video class="position-absolute top-0 start-0 w-100 h-100" 
                                   style="object-fit: cover; cursor: pointer;"
                                   muted 
                                   preload="metadata"
                                   data-bs-toggle="modal"
                                   data-bs-target="#videoModal"
                                   data-video-path="{{ $videoDisplayUrl }}"
                                   data-title="{{ $video->title }}"
                                   data-caption="{{ $video->caption ?? '' }}"
                                   onclick="event.preventDefault(); showVideoModal(this)">
                                <source src="{{ $videoDisplayUrl }}" type="video/mp4">
                            </video>
                            <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 10; pointer-events: none;">
                                <i class="fas fa-play-circle text-white" style="font-size: 64px; opacity: 0.9; text-shadow: 0 2px 8px rgba(0,0,0,0.7);"></i>
                            </div>
                        @else
                            <div class="position-absolute top-50 start-50 translate-middle text-white">
                                <i class="fas fa-video" style="font-size: 48px;"></i>
                                <p class="small mt-2">No Video</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        @if($video->caption)
                            <p class="card-text text-muted small">{{ $video->caption }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
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

<script>
    function showVideoModal(element) {
        const title = element.getAttribute('data-title') || element.closest('[data-title]')?.getAttribute('data-title') || '';
        const caption = element.getAttribute('data-caption') || element.closest('[data-caption]')?.getAttribute('data-caption') || '';
        const videoPath = element.getAttribute('data-video-path') || '';
        const videoUrl = element.getAttribute('data-video-url') || '';
        
        const modalLabel = document.getElementById('videoModalLabel');
        const videoContainer = document.getElementById('videoContainer');
        const videoCaption = document.getElementById('videoCaption');
        
        if (modalLabel) modalLabel.textContent = title || 'Video';
        if (videoCaption) videoCaption.textContent = caption || '';
        
        if (videoContainer) videoContainer.innerHTML = '';
        
        if (videoUrl && videoUrl.trim() !== '') {
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
            }
        } else if (videoPath && videoPath.trim() !== '' && videoContainer) {
            const video = document.createElement('video');
            video.src = videoPath;
            video.controls = true;
            video.style.width = '100%';
            video.style.maxHeight = '500px';
            video.style.borderRadius = '8px';
            video.style.backgroundColor = '#000';
            video.setAttribute('preload', 'metadata');
            videoContainer.appendChild(video);
        }
    }

    // Handle YouTube thumbnail clicks
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-video-url]').forEach(element => {
            element.addEventListener('click', function(e) {
                if (this.tagName === 'IMG') {
                    e.preventDefault();
                    showVideoModal(this);
                    const modal = new bootstrap.Modal(document.getElementById('videoModal'));
                    modal.show();
                }
            });
        });
    });

    // Clear video when modal is closed
    document.getElementById('videoModal')?.addEventListener('hidden.bs.modal', function () {
        const videoContainer = document.getElementById('videoContainer');
        if (videoContainer) {
            videoContainer.innerHTML = '';
        }
    });
</script>

@endsection

