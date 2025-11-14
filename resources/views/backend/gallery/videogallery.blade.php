@extends('backend.layouts.app')

@section('contents')
    @include('backend.inc.table_css')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-video"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Video Gallery</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addVideoGalleryModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="VideoGallerySearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL.</th>
                                <th>Video</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Caption</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videogallerys as $videogallery)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($videogallery->video_url)
                                            @php
                                                // Extract YouTube video ID
                                                $youtubeId = null;
                                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videogallery->video_url, $matches)) {
                                                    $youtubeId = $matches[1];
                                                }
                                            @endphp
                                            @if($youtubeId)
                                                <img src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg" 
                                                     alt="YouTube Video"
                                                     style="width:60px; height:40px; object-fit:cover; border-radius:15%; cursor:pointer;"
                                                     onclick="window.open('{{ $videogallery->video_url }}', '_blank')"
                                                     title="Click to open YouTube video">
                                            @else
                                                <a href="{{ $videogallery->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-external-link-alt"></i> Video Link
                                                </a>
                                            @endif
                                        @elseif($videogallery->video_path)
                                            <video width="60" height="40" style="object-fit:cover; border-radius:15%;" controls>
                                                <source src="{{ asset($videogallery->video_path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <span class="text-muted small">No Video</span>
                                        @endif
                                    </td>
                                    <td>{{ $videogallery->title }}</td>
                                    <td>{{ $videogallery->category->name ?? 'N/A' }}</td>
                                    <td>{{ $videogallery->caption }}</td>
                                    <td class="text-end">
                                        <!-- Edit -->
                                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editVideoGalleryModal" data-id="{{ $videogallery->id }}"
                                            data-title="{{ $videogallery->title }}" data-caption="{{ $videogallery->caption }}"
                                            data-category="{{ $videogallery->category_id }}"
                                            data-active="{{ $videogallery->is_active }}"
                                            data-video="{{ $videogallery->video_path ? asset($videogallery->video_path) : '' }}"
                                            data-video-url="{{ $videogallery->video_url ?? '' }}"
                                            data-video-type="{{ $videogallery->video_url ? 'url' : 'upload' }}"
                                            data-action="{{ route('videogallery.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('videogallery.destroy', $videogallery->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this video gallery?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-3" style="
            display: flex;
            justify-content: space-between;">
                    <!-- Showing Info -->
                    <div id="showing-info" class="results-info mb-2 text-center text-muted small" style="
            margin-top: 15px;">
                        Showing 1 to 10 of 0 results
                    </div>


                    <ul id="pagination" class="pagination justify-content-center gap-2 flex-wrap">
                        <!-- Previous Button -->
                        <li class="page-item" id="prev-page">
                            <a class="page-link" href="#" aria-label="Previous">
                                &laquo;
                            </a>
                        </li>

                        <!-- Next Button -->
                        <li class="page-item" id="next-page">
                            <a class="page-link" href="#" aria-label="Next">
                                &raquo;
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addVideoGalleryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addVideoGalleryForm" class="needs-validation" novalidate
                    action="{{ route('videogallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h6>Add Video Gallery</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                            <div class="invalid-feedback">Please enter the title.</div>
                        </div>

                        <div class="mb-3">
                            <label>Caption</label>
                            <textarea name="caption" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($videogallerycategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        <div class="mb-3">
                            <label>Video Type</label>
                            <div class="d-flex gap-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_type" id="videoTypeUpload" value="upload" checked onchange="toggleVideoInput()">
                                    <label class="form-check-label" for="videoTypeUpload">
                                        Upload Video File
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_type" id="videoTypeUrl" value="url" onchange="toggleVideoInput()">
                                    <label class="form-check-label" for="videoTypeUrl">
                                        YouTube Video Link
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Video Upload Field -->
                        <div class="mb-3" id="videoUploadField">
                            <label>Video File</label>
                            <input type="file" name="video" id="addVideoFile" class="form-control" accept="video/*" required>
                            <small class="text-muted">Accepted formats: MP4, AVI, MOV, WMV, FLV, WEBM (Max: 100MB)</small>
                            <div class="invalid-feedback">Please upload a video file.</div>
                        </div>

                        <!-- Video URL Field -->
                        <div class="mb-3" id="videoUrlField" style="display: none;">
                            <label>YouTube Video URL</label>
                            <input type="url" name="video_url" id="addVideoUrl" class="form-control" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/...">
                            <small class="text-muted">Enter YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)</small>
                            <div class="invalid-feedback">Please enter a valid YouTube video URL.</div>
                        </div>

                        <div class="mt-2 video-preview"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editVideoGalleryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editVideoGalleryForm" class="needs-validation" novalidate method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6>Edit Video Gallery</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="videogallery_id" id="videogallery_id">

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                            <div class="invalid-feedback">Please enter the title.</div>
                        </div>

                        <div class="mb-3">
                            <label>Caption</label>
                            <textarea name="caption" id="edit_caption" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category_id" id="edit_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($videogallerycategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        <div class="mb-3">
                            <label>Video Type</label>
                            <div class="d-flex gap-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_type" id="editVideoTypeUpload" value="upload" onchange="toggleEditVideoInput()">
                                    <label class="form-check-label" for="editVideoTypeUpload">
                                        Upload Video File
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_type" id="editVideoTypeUrl" value="url" onchange="toggleEditVideoInput()">
                                    <label class="form-check-label" for="editVideoTypeUrl">
                                        YouTube Video Link
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Video Upload Field -->
                        <div class="mb-3" id="editVideoUploadField">
                            <label>Video File</label>
                            <input type="file" name="video" id="edit_video" class="form-control" accept="video/*">
                            <small class="text-muted">Accepted formats: MP4, AVI, MOV, WMV, FLV, WEBM (Max: 100MB)</small>
                        </div>

                        <!-- Video URL Field -->
                        <div class="mb-3" id="editVideoUrlField" style="display: none;">
                            <label>YouTube Video URL</label>
                            <input type="url" name="video_url" id="edit_video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/...">
                            <small class="text-muted">Enter YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)</small>
                        </div>

                        <div class="mt-2">
                            <video id="videoPreview" src="" controls
                                style="max-height: 200px; max-width: 100%; border: 1px solid #ddd; padding: 4px; border-radius: 6px; display: none;">
                                Your browser does not support the video tag.
                            </video>
                            <div id="youtubePreview" style="display: none;"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Bootstrap 5 validation with dynamic required fields
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    // Update required attributes based on video type
                    const videoType = form.querySelector('input[name="video_type"]:checked');
                    if (videoType) {
                        const videoFile = form.querySelector('input[name="video"]');
                        const videoUrl = form.querySelector('input[name="video_url"]');
                        
                        if (videoType.value === 'upload') {
                            if (videoFile) videoFile.setAttribute('required', 'required');
                            if (videoUrl) videoUrl.removeAttribute('required');
                        } else {
                            if (videoUrl) videoUrl.setAttribute('required', 'required');
                            if (videoFile) videoFile.removeAttribute('required');
                        }
                    }

                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();

        // Toggle video input for Add Modal
        function toggleVideoInput() {
            const videoType = $('input[name="video_type"]:checked').val();
            const uploadField = $('#videoUploadField');
            const urlField = $('#videoUrlField');
            const videoFile = $('#addVideoFile');
            const videoUrl = $('#addVideoUrl');

            if (videoType === 'upload') {
                uploadField.show();
                urlField.hide();
                videoFile.attr('required', 'required');
                videoUrl.removeAttr('required').val('');
            } else {
                uploadField.hide();
                urlField.show();
                videoFile.removeAttr('required').val('');
                videoUrl.attr('required', 'required');
            }
        }

        // Initialize on page load
        $(document).ready(function() {
            toggleVideoInput();
        });

        // Toggle video input for Edit Modal
        function toggleEditVideoInput() {
            const videoType = $('input[name="video_type"]:checked').val();
            const uploadField = $('#editVideoUploadField');
            const urlField = $('#editVideoUrlField');
            const videoFile = $('#edit_video');
            const videoUrl = $('#edit_video_url');

            if (videoType === 'upload') {
                uploadField.show();
                urlField.hide();
                videoUrl.val('');
            } else {
                uploadField.hide();
                urlField.show();
                videoFile.val('');
            }
        }

        // Edit Modal Data
        $('#editVideoGalleryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var caption = button.data('caption');
            var category = button.data('category');
            var is_active = button.data('active');
            var video = button.data('video');
            var videoUrl = button.data('video-url');
            var videoType = button.data('video-type') || 'upload';

            var form = $('#editVideoGalleryForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            $('#videogallery_id').val(id);
            $('#edit_title').val(title);
            $('#edit_caption').val(caption);
            $('#edit_category_id').val(category);

            // Set video type
            if (videoType === 'url') {
                $('#editVideoTypeUrl').prop('checked', true);
                $('#edit_video_url').val(videoUrl || '');
            } else {
                $('#editVideoTypeUpload').prop('checked', true);
            }
            toggleEditVideoInput();

            // Show preview
            var videoPreview = $('#videoPreview');
            var youtubePreview = $('#youtubePreview');
            
            if (videoUrl && videoType === 'url') {
                // Extract YouTube video ID
                var youtubeId = null;
                var match = videoUrl.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
                if (match) {
                    youtubeId = match[1];
                    youtubePreview.html(`<iframe width="100%" height="200" src="https://www.youtube.com/embed/${youtubeId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border: 1px solid #ddd; border-radius: 6px;"></iframe>`).show();
                    videoPreview.hide();
                } else {
                    youtubePreview.hide();
                    videoPreview.hide();
                }
            } else if (video) {
                videoPreview.attr('src', video).show();
                youtubePreview.hide();
            } else {
                videoPreview.hide();
                youtubePreview.hide();
            }
        });

        // Reset Add Modal on close
        $('#addVideoGalleryModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('input[name="video_type"][value="upload"]').prop('checked', true);
            toggleVideoInput();
            $('.video-preview').empty();
            $(this).find('form').removeClass('was-validated');
        });

        // Video File Selection Preview
        document.addEventListener('DOMContentLoaded', function () {
            const addVideoInput = document.querySelector('#addVideoGalleryModal input[name="video"]');
            const editVideoInput = document.querySelector('#editVideoGalleryModal input[name="video"]');
            const editVideoPreview = document.querySelector('#videoPreview');

            if (addVideoInput) {
                addVideoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Size in MB
                        const fileName = file.name;
                        
                        let previewContainer = document.querySelector('.video-preview');
                        if (!previewContainer) {
                            previewContainer = document.createElement('div');
                            previewContainer.classList.add('mt-2', 'video-preview');
                            this.closest('.mb-3').after(previewContainer);
                        }
                        previewContainer.innerHTML = `<div class="alert alert-info small">
                            <i class="fas fa-video"></i> Selected: ${fileName}<br>
                            <small>Size: ${fileSize} MB</small>
                        </div>`;
                    }
                });
            }

            // Handle YouTube URL preview in Add Modal
            const addVideoUrlInput = document.querySelector('#addVideoUrl');
            if (addVideoUrlInput) {
                addVideoUrlInput.addEventListener('blur', function () {
                    const url = this.value.trim();
                    if (url) {
                        // Extract YouTube video ID
                        const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
                        if (match) {
                            const youtubeId = match[1];
                            let previewContainer = document.querySelector('.video-preview');
                            if (!previewContainer) {
                                previewContainer = document.createElement('div');
                                previewContainer.classList.add('mt-2', 'video-preview');
                                addVideoUrlInput.closest('.mb-3').after(previewContainer);
                            }
                            previewContainer.innerHTML = `<div class="alert alert-success small">
                                <i class="fab fa-youtube text-danger"></i> YouTube video detected!<br>
                                <iframe width="100%" height="200" src="https://www.youtube.com/embed/${youtubeId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border: 1px solid #ddd; border-radius: 6px; margin-top: 10px;"></iframe>
                            </div>`;
                        } else {
                            let previewContainer = document.querySelector('.video-preview');
                            if (previewContainer) {
                                previewContainer.innerHTML = `<div class="alert alert-warning small">
                                    <i class="fas fa-exclamation-triangle"></i> Please enter a valid YouTube URL
                                </div>`;
                            }
                        }
                    }
                });
            }

            if (editVideoInput) {
                editVideoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const url = URL.createObjectURL(file);
                        editVideoPreview.src = url;
                        editVideoPreview.style.display = 'block';
                        $('#youtubePreview').hide();
                    }
                });
            }

            // Handle YouTube URL preview in Edit Modal
            const editVideoUrlInput = document.querySelector('#edit_video_url');
            if (editVideoUrlInput) {
                editVideoUrlInput.addEventListener('blur', function () {
                    const url = this.value.trim();
                    const videoPreview = $('#videoPreview');
                    const youtubePreview = $('#youtubePreview');
                    
                    if (url) {
                        // Extract YouTube video ID
                        const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
                        if (match) {
                            const youtubeId = match[1];
                            youtubePreview.html(`<iframe width="100%" height="200" src="https://www.youtube.com/embed/${youtubeId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border: 1px solid #ddd; border-radius: 6px;"></iframe>`).show();
                            videoPreview.hide();
                        } else {
                            youtubePreview.html(`<div class="alert alert-warning small">Please enter a valid YouTube URL</div>`).show();
                            videoPreview.hide();
                        }
                    } else {
                        youtubePreview.hide();
                    }
                });
            }
        });
        
        function Filters() {
            const query = $('#VideoGallerySearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#VideoGallerySearch').on('keyup', Filters);

        // ✅ Pagination
        $(document).ready(function () {
            var rowsPerPage = 10;
            var rows = $("#table-data tr");
            var rowsCount = rows.length;
            var pageCount = Math.ceil(rowsCount / rowsPerPage);
            var currentPage = 1;

            function showPage(page) {
                if (page < 1) page = 1;
                if (page > pageCount) page = pageCount;
                currentPage = page;

                var start = (page - 1) * rowsPerPage;
                var end = start + rowsPerPage;
                rows.hide();
                rows.slice(start, end).show();

                updatePagination();
                updateShowingInfo();
            }

            function updatePagination() {
                var pagination = $("#pagination");
                pagination.find(".page-number").remove(); // remove old page numbers

                for (var i = 1; i <= pageCount; i++) {
                    $('<li class="page-item page-number ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#">' + i + '</a></li>')
                        .insertBefore("#next-page");
                }

                // Enable/disable Prev/Next
                $("#prev-page").toggleClass("disabled", currentPage === 1);
                $("#next-page").toggleClass("disabled", currentPage === pageCount);
            }

            function updateShowingInfo() {
                var start = (currentPage - 1) * rowsPerPage + 1;
                var end = Math.min(currentPage * rowsPerPage, rowsCount);
                $("#showing-info").text(`Showing ${start} to ${end} of ${rowsCount} results`);
            }

            // Click events
            $(document).on("click", "#pagination .page-number a", function (e) {
                e.preventDefault();
                var page = parseInt($(this).text());
                showPage(page);
            });

            $("#prev-page a").click(function (e) {
                e.preventDefault();
                showPage(currentPage - 1);
            });

            $("#next-page a").click(function (e) {
                e.preventDefault();
                showPage(currentPage + 1);
            });

            // Initialize
            showPage(1);
        });
    </script>
@endsection

