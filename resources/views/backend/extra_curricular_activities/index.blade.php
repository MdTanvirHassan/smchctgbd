@extends('backend.layouts.app')

@section('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    .note-color-palette { display: block !important; padding: 5px; min-width: 160px; }
    .note-color-palette .note-color-row { display: flex; flex-wrap: wrap; margin: 0; }
    .note-color-palette .note-color-btn { width: 24px; height: 24px; padding: 0; margin: 2px; border: 1px solid #ddd; cursor: pointer; display: inline-block; border-radius: 2px; }
    .note-color-palette .note-color-btn:hover { border-color: #333; transform: scale(1.1); }
    .note-color button { cursor: pointer; }
    .note-color .dropdown-toggle::after { display: none; }
    .note-color.open .dropdown-menu { display: block !important; }
    .note-color .dropdown-menu { display: none; position: absolute; z-index: 1000; min-width: 160px; padding: 5px; background-color: #fff; border: 1px solid rgba(0,0,0,.15); border-radius: 0.25rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
    .note-popover { z-index: 1050 !important; }
</style>
@endsection

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
            <h6 class="mb-0 fw-bold">Extra Curricular Activities</h6>
        </div>
        <div class="card-body">
            @php
                $extraCurricularData = $extraCurricularActivities ? json_decode($extraCurricularActivities->description, true) : null;
                $existingImages = $extraCurricularData['images'] ?? [];
            @endphp
            <form action="{{ $extraCurricularActivities ? route('extra_curricular_activities.update', $extraCurricularActivities->id) : route('extra_curricular_activities.store') }}" method="POST" enctype="multipart/form-data" id="extraCurricularForm">
                @csrf
                @if($extraCurricularActivities)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="extra-description" class="form-control" rows="6">{{ $extraCurricularData['description'] ?? '' }}</textarea>
                        <small class="text-muted">Format your text with bold, italic, colors, lists, and more using the toolbar above.</small>
                    </div>

                    <!-- Existing Images -->
                    @if(count($existingImages) > 0)
                        <div class="col-12">
                            <label class="form-label fw-bold">Existing Images</label>
                            <div class="row g-2" id="existingImagesContainer">
                                @foreach($existingImages as $index => $image)
                                    <div class="col-md-3 existing-image-item" data-image="{{ $image }}">
                                        <div class="position-relative">
                                            <img src="{{ asset($image) }}" alt="Extra Curricular Image" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
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
                            {{ $extraCurricularActivities ? 'Update' : 'Save' }} Extra Curricular Activities
                        </button>
                        @if($extraCurricularActivities)
                            <a href="{{ route('extra_curricular_activities.status', $extraCurricularActivities->id) }}" class="btn btn-{{ $extraCurricularActivities->is_published ? 'success' : 'secondary' }}">
                                {{ $extraCurricularActivities->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Summernote
    $('#extra-description').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']], ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontname', ['fontname']], ['fontsize', ['fontsize']], ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']], ['table', ['table']],
            ['insert', ['link', 'picture', 'video']], ['view', ['fullscreen', 'codeview', 'help']]
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
        placeholder: 'Enter description here...',
        dialogsInBody: true,
        disableDragAndDrop: true,
        popatmouse: true
    });
    // Fix color picker
    setTimeout(function() {
        $(document).off('click', '.note-color-palette .note-color-btn').on('click', '.note-color-palette .note-color-btn', function(e) {
            e.preventDefault(); e.stopPropagation();
            var $btn = $(this); var color = $btn.attr('data-value') || $btn.data('value');
            if (!color) { var bgColor = $btn.css('background-color'); if (bgColor && bgColor !== 'rgba(0, 0, 0, 0)' && bgColor !== 'transparent') color = bgColor; }
            if (!color) { var style = $btn.attr('style') || ''; var match = style.match(/background-color:\s*(#[0-9a-fA-F]{6}|rgb\([^)]+\))/); if (match) color = match[1]; }
            if (color) {
                if (color.indexOf('rgb') !== -1) { var rgb = color.match(/\d+/g); if (rgb && rgb.length >= 3) color = '#' + ((1 << 24) + (parseInt(rgb[0]) << 16) + (parseInt(rgb[1]) << 8) + parseInt(rgb[2])).toString(16).slice(1); }
                $('#extra-description').summernote('foreColor', color);
                setTimeout(function() { $('.note-color').removeClass('open show'); $('.note-color .dropdown-menu').removeClass('show'); }, 50);
            }
            return false;
        });
        $(document).on('click', '.note-color', function(e) { if ($(e.target).closest('.dropdown-menu').length) e.stopPropagation(); });
    }, 300);
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

