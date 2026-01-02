@extends('backend.layouts.app')

@section('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    /* Fix for Summernote color picker with Bootstrap 5 */
    .note-color-palette {
        display: block !important;
        padding: 5px;
        min-width: 160px;
    }
    .note-color-palette .note-color-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0;
    }
    .note-color-palette .note-color-btn {
        width: 24px;
        height: 24px;
        padding: 0;
        margin: 2px;
        border: 1px solid #ddd;
        cursor: pointer;
        display: inline-block;
        border-radius: 2px;
        position: relative;
    }
    .note-color-palette .note-color-btn:hover {
        border-color: #333;
        transform: scale(1.1);
    }
    .note-color button {
        cursor: pointer;
    }
    .note-color .dropdown-toggle::after {
        display: none;
    }
    .note-color.open .dropdown-menu {
        display: block !important;
    }
    .note-color .dropdown-menu {
        display: none;
        position: absolute;
        z-index: 1000;
        min-width: 160px;
        padding: 5px;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 0.25rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .note-popover {
        z-index: 1050 !important;
    }
    .note-popover .popover {
        z-index: 1050 !important;
    }
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

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="facilityTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-dark" id="academic-facility-tab" data-bs-toggle="tab" data-bs-target="#academic-facility" type="button" role="tab">
                Academic Facility
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="teaching-activities-tab" data-bs-toggle="tab" data-bs-target="#teaching-activities" type="button" role="tab">
                Teaching Activities
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="activities-of-meu-tab" data-bs-toggle="tab" data-bs-target="#activities-of-meu" type="button" role="tab">
                Activities of MEU
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="research-cell-tab" data-bs-toggle="tab" data-bs-target="#research-cell" type="button" role="tab">
                Research Cell
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="facilityTabsContent">
        <!-- Academic Facility -->
        <div class="tab-pane fade show active" id="academic-facility" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Academic Facility</h6>
                </div>
                <div class="card-body">
                    @php
                        $academicData = $academicFacility ? json_decode($academicFacility->description, true) : null;
                    @endphp
                    <form action="{{ $academicFacility ? route('facilities.update', ['section' => 'academic_facility', 'id' => $academicFacility->id]) : route('facilities.store', 'academic_facility') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($academicFacility)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Image 1</label>
                                <input type="file" name="image1" class="form-control" accept="image/*">
                                @if($academicData && isset($academicData['images'][0]))
                                    <div class="mt-2">
                                        <img src="{{ asset($academicData['images'][0]) }}" alt="Image 1" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Image 2</label>
                                <input type="file" name="image2" class="form-control" accept="image/*">
                                @if($academicData && isset($academicData['images'][1]))
                                    <div class="mt-2">
                                        <img src="{{ asset($academicData['images'][1]) }}" alt="Image 2" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="academic-description" class="form-control" rows="4">{{ $academicData['description'] ?? '' }}</textarea>
                                <small class="text-muted">Format your text with bold, italic, colors, lists, and more using the toolbar above.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $academicFacility->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Academic Calendar Image</label>
                                <input type="file" name="academic_calendar_image" class="form-control" accept="image/*">
                                @if($academicFacility && $academicFacility->file_path)
                                    <div class="mt-2">
                                        <img src="{{ asset($academicFacility->file_path) }}" alt="Academic Calendar" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $academicFacility ? 'Update' : 'Save' }} Academic Facility
                                </button>
                                @if($academicFacility)
                                    <a href="{{ route('facilities.status', $academicFacility->id) }}" class="btn btn-{{ $academicFacility->is_published ? 'success' : 'secondary' }}">
                                        {{ $academicFacility->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Teaching Activities -->
        <div class="tab-pane fade" id="teaching-activities" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Teaching Activities</h6>
                </div>
                <div class="card-body">
                    @php
                        $teachingData = $teachingActivities ? json_decode($teachingActivities->description, true) : null;
                    @endphp
                    <form action="{{ $teachingActivities ? route('facilities.update', ['section' => 'teaching_activities', 'id' => $teachingActivities->id]) : route('facilities.store', 'teaching_activities') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($teachingActivities)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            @for($i = 1; $i <= 4; $i++)
                                <div class="col-md-6">
                                    <label class="form-label">Image {{ $i }}</label>
                                    <input type="file" name="image{{ $i }}" class="form-control" accept="image/*">
                                    @if($teachingData && isset($teachingData['images'][$i-1]))
                                        <div class="mt-2">
                                            <img src="{{ asset($teachingData['images'][$i-1]) }}" alt="Image {{ $i }}" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                            @endfor

                            <div class="col-md-6">
                                <label class="form-label">Description 1 (for Images 1 & 2)</label>
                                <textarea name="description1" id="teaching-description1" class="form-control" rows="3">{{ $teachingData['description1'] ?? '' }}</textarea>
                                <small class="text-muted">Format your text with the toolbar above.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Description 2 (for Images 3 & 4)</label>
                                <textarea name="description2" id="teaching-description2" class="form-control" rows="3">{{ $teachingData['description2'] ?? '' }}</textarea>
                                <small class="text-muted">Format your text with the toolbar above.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $teachingActivities->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $teachingActivities ? 'Update' : 'Save' }} Teaching Activities
                                </button>
                                @if($teachingActivities)
                                    <a href="{{ route('facilities.status', $teachingActivities->id) }}" class="btn btn-{{ $teachingActivities->is_published ? 'success' : 'secondary' }}">
                                        {{ $teachingActivities->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Activities of MEU -->
        <div class="tab-pane fade" id="activities-of-meu" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Activities of MEU</h6>
                </div>
                <div class="card-body">
                    @php
                        $meuData = $activitiesOfMeu ? json_decode($activitiesOfMeu->description, true) : null;
                    @endphp
                    <form action="{{ $activitiesOfMeu ? route('facilities.update', ['section' => 'activities_of_meu', 'id' => $activitiesOfMeu->id]) : route('facilities.store', 'activities_of_meu') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($activitiesOfMeu)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image1" class="form-control" accept="image/*">
                                @if($meuData && isset($meuData['images'][0]))
                                    <div class="mt-2">
                                        <img src="{{ asset($meuData['images'][0]) }}" alt="MEU Image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="meu-description" class="form-control" rows="4">{{ $meuData['description'] ?? '' }}</textarea>
                                <small class="text-muted">Format your text with bold, italic, colors, lists, and more using the toolbar above.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $activitiesOfMeu->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $activitiesOfMeu ? 'Update' : 'Save' }} Activities of MEU
                                </button>
                                @if($activitiesOfMeu)
                                    <a href="{{ route('facilities.status', $activitiesOfMeu->id) }}" class="btn btn-{{ $activitiesOfMeu->is_published ? 'success' : 'secondary' }}">
                                        {{ $activitiesOfMeu->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Research Cell -->
        <div class="tab-pane fade" id="research-cell" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Research Cell</h6>
                </div>
                <div class="card-body">
                    @php
                        $researchData = $researchCell ? json_decode($researchCell->description, true) : null;
                    @endphp
                    <form action="{{ $researchCell ? route('facilities.update', ['section' => 'research_cell', 'id' => $researchCell->id]) : route('facilities.store', 'research_cell') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($researchCell)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image1" class="form-control" accept="image/*">
                                @if($researchCell && $researchCell->file_path)
                                    <div class="mt-2">
                                        <img src="{{ asset($researchCell->file_path) }}" alt="Research Cell Image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="research-description" class="form-control" rows="4">{{ $researchData['description'] ?? '' }}</textarea>
                                <small class="text-muted">Format your text with bold, italic, colors, lists, and more using the toolbar above.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $researchCell->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $researchCell ? 'Update' : 'Save' }} Research Cell
                                </button>
                                @if($researchCell)
                                    <a href="{{ route('facilities.status', $researchCell->id) }}" class="btn btn-{{ $researchCell->is_published ? 'success' : 'secondary' }}">
                                        {{ $researchCell->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
    // Initialize Summernote editor for all description fields
    $(document).ready(function() {
        // Common Summernote configuration
        var summernoteConfig = {
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
            placeholder: 'Enter description here...',
            dialogsInBody: true,
            disableDragAndDrop: true,
            popatmouse: true
        };

        // Initialize all description fields
        $('#academic-description').summernote(summernoteConfig);
        $('#teaching-description1').summernote(summernoteConfig);
        $('#teaching-description2').summernote(summernoteConfig);
        $('#meu-description').summernote(summernoteConfig);
        $('#research-description').summernote(summernoteConfig);

        // Fix for color picker dropdown with Bootstrap 5
        setTimeout(function() {
            $(document).off('click', '.note-color-palette .note-color-btn').on('click', '.note-color-palette .note-color-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var $btn = $(this);
                var color = $btn.attr('data-value') || $btn.data('value');
                
                if (!color) {
                    var bgColor = $btn.css('background-color');
                    if (bgColor && bgColor !== 'rgba(0, 0, 0, 0)' && bgColor !== 'transparent') {
                        color = bgColor;
                    }
                }
                
                if (!color) {
                    var style = $btn.attr('style') || '';
                    var match = style.match(/background-color:\s*(#[0-9a-fA-F]{6}|rgb\([^)]+\))/);
                    if (match) {
                        color = match[1];
                    }
                }
                
                if (color) {
                    if (color.indexOf('rgb') !== -1) {
                        var rgb = color.match(/\d+/g);
                        if (rgb && rgb.length >= 3) {
                            color = '#' + ((1 << 24) + (parseInt(rgb[0]) << 16) + (parseInt(rgb[1]) << 8) + parseInt(rgb[2])).toString(16).slice(1);
                        }
                    }
                    
                    // Find the active editor
                    var $activeEditor = $('.note-editor.note-frame').has($btn);
                    var editorId = $activeEditor.find('textarea').attr('id');
                    
                    if (editorId) {
                        $('#' + editorId).summernote('foreColor', color);
                    }
                    
                    setTimeout(function() {
                        $('.note-color').removeClass('open show');
                        $('.note-color .dropdown-menu').removeClass('show');
                    }, 50);
                }
                
                return false;
            });
            
            $(document).on('click', '.note-color', function(e) {
                if ($(e.target).closest('.dropdown-menu').length) {
                    e.stopPropagation();
                }
            });
        }, 300);
    });
</script>
@endsection

