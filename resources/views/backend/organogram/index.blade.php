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
            <h6 class="mb-0 fw-bold">Organogram</h6>
        </div>
        <div class="card-body">
            <form action="{{ $organogram ? route('organogram.update', $organogram->id) : route('organogram.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($organogram)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-12">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $organogram->title ?? '' }}" required placeholder="Enter organogram title">
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="organogram-description" class="form-control" rows="6" placeholder="Enter description here...">{{ $organogram->description ?? '' }}</textarea>
                        <small class="text-muted">Format your text with bold, italic, colors, lists, and more using the toolbar above.</small>
                    </div>

                    <!-- Image Upload -->
                    <div class="col-md-12">
                        <label class="form-label">Image <span class="text-danger">{{ $organogram ? '' : '*' }}</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" {{ $organogram ? '' : 'required' }}>
                        @if($organogram && $organogram->file_path)
                            <div class="mt-2">
                                <img src="{{ asset($organogram->file_path) }}" alt="Organogram Image" class="img-thumbnail" style="max-width: 400px; max-height: 400px;">
                                <p class="text-muted small mt-2">Current image. Upload a new image to replace it.</p>
                            </div>
                        @endif
                        <small class="text-muted">Upload an image for organogram (Max: 2MB, Formats: jpeg, png, jpg, gif)</small>
                    </div>

                    <!-- Link URL -->
                    <div class="col-md-12">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link_url" class="form-control" value="{{ $organogram->link_url ?? '' }}" placeholder="https://example.com">
                        <small class="text-muted">Optional: Add a link URL if needed</small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ $organogram ? 'Update' : 'Save' }} Organogram
                        </button>
                        @if($organogram)
                            <a href="{{ route('organogram.status', $organogram->id) }}" class="btn btn-{{ $organogram->is_published ? 'success' : 'secondary' }}">
                                {{ $organogram->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $organogram->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this organogram? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#organogram-description').summernote({
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
        setTimeout(function() {
            $(document).off('click', '.note-color-palette .note-color-btn').on('click', '.note-color-palette .note-color-btn', function(e) {
                e.preventDefault(); e.stopPropagation();
                var $btn = $(this); var color = $btn.attr('data-value') || $btn.data('value');
                if (!color) { var bgColor = $btn.css('background-color'); if (bgColor && bgColor !== 'rgba(0, 0, 0, 0)' && bgColor !== 'transparent') color = bgColor; }
                if (!color) { var style = $btn.attr('style') || ''; var match = style.match(/background-color:\s*(#[0-9a-fA-F]{6}|rgb\([^)]+\))/); if (match) color = match[1]; }
                if (color) {
                    if (color.indexOf('rgb') !== -1) { var rgb = color.match(/\d+/g); if (rgb && rgb.length >= 3) color = '#' + ((1 << 24) + (parseInt(rgb[0]) << 16) + (parseInt(rgb[1]) << 8) + parseInt(rgb[2])).toString(16).slice(1); }
                    $('#organogram-description').summernote('foreColor', color);
                    setTimeout(function() { $('.note-color').removeClass('open show'); $('.note-color .dropdown-menu').removeClass('show'); }, 50);
                }
                return false;
            });
            $(document).on('click', '.note-color', function(e) { if ($(e.target).closest('.dropdown-menu').length) e.stopPropagation(); });
        }, 300);
    });

    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("/dashboard/organogram") }}/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

