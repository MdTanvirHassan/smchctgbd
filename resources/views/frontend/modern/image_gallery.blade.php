@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">গ্যালারী</h1>
    </div>
</section>

<!-- Gallery -->
<section class="gallery-images-section my-5">
    <div class="container py-5 bg-white rounded shadow-sm">
        <div class="text-center mb-4">
            <h2 class="fw-bold">{{ $name->name }}</h2>
        </div>

        <div class="row g-3">
            @foreach($galleries as $image)
            <div class="col-6 col-md-4 col-lg-3 text-center">
                <img
                    src="{{ asset($image->file_path) }}"
                    alt="{{ $image->title }}"
                    class="img-fluid rounded shadow-sm gallery-thumb mb-2"
                    style="cursor:pointer; height: 200px; object-fit: cover; width: 100%;"
                    data-bs-toggle="modal"
                    data-bs-target="#imageModal"
                    data-src="{{ asset($image->file_path) }}"
                >
                <div class="small text-truncate" title="{{ $image->title }}">{{ $image->title }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 p-0 position-relative">
            <img src="" id="modalImage" class="img-fluid rounded-3 shadow mx-auto d-block" style="max-height: 80vh; width: 100%; object-fit: contain;">
            <button type="button" class="btn-close btn-close-dark bg-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const imageModal = document.getElementById('imageModal')
    imageModal.addEventListener('show.bs.modal', event => {
        const img = event.relatedTarget
        const src = img.getAttribute('data-src')

        const modalImage = imageModal.querySelector('#modalImage')
        modalImage.src = src
    })
</script>


@endsection