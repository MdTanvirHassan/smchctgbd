@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">গ্যালারী</h1>
    </div>
</section>

<!--  ✅ Gallery -->
<section class="gallery-section my-5">
    <div class="container py-5 bg-white">
        <div class="text-center mb-4">
            <h2 class="fw-bold">গ্যালারী</h2>
        </div>
        <style>
            .gallery-card {
                position: relative;
                border-radius: 15px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                cursor: pointer;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }

            .gallery-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            }

            .gallery-card img {
                object-fit: cover;
                width: 100%;
                height: 220px;
                transition: transform 0.3s ease;
                display: block;
            }

            .gallery-card:hover img {
                transform: scale(1.05);
            }

            .gallery-card .card-body {
                position: absolute;
                bottom: 0;
                width: 100%;
                padding: 1rem 0.5rem;
                background: rgba(0, 0, 0, 0.5);
                color: white;
                text-align: center;
                font-weight: 600;
                font-size: 1.1rem;
                backdrop-filter: blur(5px);
            }

            .gallery-card .overlay {
                position: absolute;
                top: 0;
                left: 0;
                height: 220px;
                width: 100%;
                background: rgba(0, 0, 0, 0.3);
                opacity: 0;
                transition: opacity 0.3s ease;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
                font-weight: 700;
                font-size: 1rem;
                letter-spacing: 1px;
                text-transform: uppercase;
            }

            .gallery-card:hover .overlay {
                opacity: 1;
            }
        </style>

        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-4">
                <a href="{{ route('image_gallery', $category->id) }}" class="text-decoration-none">
                    <div class="card gallery-card h-100 shadow-sm">
                        <img src="{{ asset($category->thumbnail_path) }}" alt="{{ $category->name }}" class="card-img-top img-fluid">
                        <div class="overlay">View Gallery</div>
                        <div class="card-body">
                            {{ $category->name }}
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <img src="" id="modalImage" class="img-fluid rounded-3 shadow">
        </div>
    </div>
</div>

@endsection