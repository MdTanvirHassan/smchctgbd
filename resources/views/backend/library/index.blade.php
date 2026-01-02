@extends('backend.layouts.app')

@section('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    /* Fix for Summernote color picker with Bootstrap 5 */
    .note-color-palette { display: block !important; padding: 5px; min-width: 160px; }
    .note-color-palette .note-color-row { display: flex; flex-wrap: wrap; margin: 0; }
    .note-color-palette .note-color-btn { width: 24px; height: 24px; padding: 0; margin: 2px; border: 1px solid #ddd; cursor: pointer; display: inline-block; border-radius: 2px; }
    .note-color-palette .note-color-btn:hover { border-color: #333; transform: scale(1.1); }
    .note-color button { cursor: pointer; }
    .note-color .dropdown-toggle::after { display: none; }
    .note-color.open .dropdown-menu { display: block !important; }
    .note-color .dropdown-menu { display: none; position: absolute; z-index: 1000; min-width: 160px; padding: 5px; background-color: #fff; border: 1px solid rgba(0,0,0,.15); border-radius: 0.25rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
    .note-popover { z-index: 1050 !important; }
    .note-popover .popover { z-index: 1050 !important; }
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
            <h6 class="mb-0 fw-bold">Library</h6>
        </div>
        <div class="card-body">
            @php
                $libraryData = $library ? json_decode($library->description, true) : null;
            @endphp
            <form action="{{ $library ? route('library.update', $library->id) : route('library.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($library)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Image 1</label>
                        <input type="file" name="image1" class="form-control" accept="image/*" {{ !$library ? 'required' : '' }}>
                        @if($libraryData && isset($libraryData['images'][0]))
                            <div class="mt-2">
                                <img src="{{ asset($libraryData['images'][0]) }}" alt="Image 1" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Image 2</label>
                        <input type="file" name="image2" class="form-control" accept="image/*" {{ !$library ? 'required' : '' }}>
                        @if($libraryData && isset($libraryData['images'][1]))
                            <div class="mt-2">
                                <img src="{{ asset($libraryData['images'][1]) }}" alt="Image 2" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="library-description" class="form-control" rows="6">{{ $libraryData['description'] ?? '' }}</textarea>
                        <small class="text-muted">Format your text with bold, italic, colors, lists, and more using the toolbar above.</small>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            {{ $library ? 'Update' : 'Save' }} Library
                        </button>
                        @if($library)
                            <a href="{{ route('library.status', $library->id) }}" class="btn btn-{{ $library->is_published ? 'success' : 'secondary' }}">
                                {{ $library->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#library-description').summernote({
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
                    $('#library-description').summernote('foreColor', color);
                    setTimeout(function() { $('.note-color').removeClass('open show'); $('.note-color .dropdown-menu').removeClass('show'); }, 50);
                }
                return false;
            });
            $(document).on('click', '.note-color', function(e) { if ($(e.target).closest('.dropdown-menu').length) e.stopPropagation(); });
        }, 300);
    });
</script>
@endsection

