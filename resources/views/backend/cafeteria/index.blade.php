@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-bold">Cafeteria</h6>
        </div>
        <div class="card-body">
            @php
                $cafeteriaData = $cafeteria ? json_decode($cafeteria->description, true) : null;
                $existingImages = $cafeteriaData['images'] ?? [];
            @endphp
            <form action="{{ $cafeteria ? route('cafeteria.update', $cafeteria->id) : route('cafeteria.store') }}" method="POST" enctype="multipart/form-data" id="cafeteriaForm">
                @csrf
                @if($cafeteria)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Existing Images -->
                    @if(count($existingImages) > 0)
                        <div class="col-12">
                            <label class="form-label fw-bold">Existing Images</label>
                            <div class="row g-2" id="existingImagesContainer">
                                @foreach($existingImages as $index => $image)
                                    <div class="col-md-3 existing-image-item" data-image="{{ $image }}">
                                        <div class="position-relative">
                                            <img src="{{ asset($image) }}" alt="Cafeteria Image" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-existing-image" data-image="{{ $image }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_images[]" value="{{ $image }}" class="existing-image-input">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- New Images -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Add New Images</label>
                        <div id="newImagesContainer">
                            <div class="row g-2 mb-2 new-image-item">
                                <div class="col-md-10">
                                    <input type="file" name="images[]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger w-100 remove-new-image">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="addImageBtn">
                            <i class="fas fa-plus"></i> Add More Images
                        </button>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            {{ $cafeteria ? 'Update' : 'Save' }} Cafeteria
                        </button>
                        @if($cafeteria)
                            <a href="{{ route('cafeteria.status', $cafeteria->id) }}" class="btn btn-{{ $cafeteria->is_published ? 'success' : 'secondary' }}">
                                {{ $cafeteria->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new image input
    document.getElementById('addImageBtn').addEventListener('click', function() {
        const container = document.getElementById('newImagesContainer');
        const newItem = document.createElement('div');
        newItem.className = 'row g-2 mb-2 new-image-item';
        newItem.innerHTML = `
            <div class="col-md-10">
                <input type="file" name="images[]" class="form-control" accept="image/*">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100 remove-new-image">
                    <i class="fas fa-times"></i> Remove
                </button>
            </div>
        `;
        container.appendChild(newItem);
    });

    // Remove new image input
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-new-image')) {
            e.target.closest('.new-image-item').remove();
        }
    });

    // Remove existing image
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-existing-image')) {
            const item = e.target.closest('.existing-image-item');
            const input = item.querySelector('.existing-image-input');
            input.remove();
            item.remove();
        }
    });
});
</script>
@endsection

