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
    @include('backend.inc.table_css')


    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Notices</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addNoticeModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search & Date Filters -->
                <div class="row g-2 mb-3 align-items-center">

                    <!-- Search -->
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="noticeSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-3 col-sm-6">
                        <input type="date" id="startDateFilter" class="form-control form-control-sm">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-3 col-sm-6">
                        <input type="date" id="endDateFilter" class="form-control form-control-sm">
                    </div>

                    <!-- Reset Button -->
                    <div class="col-md-2 col-sm-12">
                        <button class="btn btn-sm btn-outline-secondary w-100" id="resetFilters">
                            Reset
                        </button>
                    </div>

                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                <th class="py-2">SL.</th>
                                <th class="py-2">Title</th>
                                <th class="py-2">Description</th>
                                <th class="py-2">Start Date</th>
                                <th class="py-2">End Date</th>
                                <th class="py-2">Attachment</th>
                                <th class="text-end py-2">Action</th>
                            </tr>
                        </thead>

                        <tbody class="small text-muted">
                            @foreach($notices as $notice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notice->title }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($notice->description, 50) }}</td>
                                    <td>{{ $notice->start_date }}</td>
                                    <td>{{ $notice->end_date }}</td>
                                    <td>
                                        @if($notice->file_path)
                                            @php
                                                $webFilePath = str_starts_with($notice->file_path, 'public/')
                                                    ? $notice->file_path
                                                    : 'public/' . ltrim($notice->file_path, '/');
                                                $fileUrl = asset($webFilePath);
                                                $fileExtension = strtolower(pathinfo($notice->file_path, PATHINFO_EXTENSION));
                                                $isPdf = $fileExtension === 'pdf';
                                            @endphp
                                            @if($isPdf)
                                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill" title="Open PDF in new tab">
                                                    <i class="fas fa-file-pdf me-1"></i> View PDF
                                                </a>
                                                <a href="{{ $fileUrl }}" download class="btn btn-sm btn-outline-success rounded-pill ms-1" title="Download PDF">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <img src="{{ $fileUrl }}" alt="{{ $notice->title }}"
                                                    class="img-thumbnail" style="max-width: 80px; max-height: 80px; object-fit: cover; cursor: pointer;"
                                                    onclick="window.open('{{ $fileUrl }}', '_blank')"
                                                    title="Click to view full size">
                                            @endif
                                        @else
                                            <span class="text-muted small">No Attachment</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <!-- Publish/Unpublish button -->
                                        <a href="{{ route('notice.status', $notice->id) }}"
                                            class="btn @if($notice->is_published == 1) btn-soft-success @else btn-soft-danger @endif btn-sm rounded-2">
                                            <i class="fas fa-check"></i>
                                        </a>

                                        <!-- Edit button -->
                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-notice"
                                            data-bs-toggle="modal" data-bs-target="#editNoticeModal" data-id="{{ $notice->id }}"
                                            data-title="{{ $notice->title }}" data-description="{{ $notice->description }}"
                                            data-start_date="{{ $notice->start_date }}" data-end_date="{{ $notice->end_date }}"
                                            data-image_path="{{ $notice->file_path ?? '' }}"
                                            data-action="{{ route('notice.update', ':id') }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('notice.destroy', $notice->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm rounded-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="mt-3" style="
                                    display: flex;
                                    justify-content: space-between;">
                    <!-- Showing Info -->
                    <div id="showing-info" class="results-info mb-2 text-center text-muted small" style="
                                    margin-top: 15px;">
                        Showing 1 to 10 of 0 results
                    </div>

                    <!-- Pagination -->
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

    <!-- Add New Notice Modal -->
    <div class="modal fade" id="addNoticeModal" tabindex="-1" aria-labelledby="addNoticeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form action="{{ route('notice.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="addNoticeModalLabel">Add New Notice</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <div class="mb-3">
                            <label class="form-label small">Attachment (Image/PDF, Optional)</label>
                            <input type="file" name="image" id="addNoticeImage" class="form-control form-control-sm" accept="image/*,.pdf,application/pdf">
                            <div class="invalid-feedback">Please select a valid image or PDF file.</div>
                            <div id="addNoticeImagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover; display: none;">
                                <embed src="" type="application/pdf" class="img-thumbnail" style="width: 100%; max-width: 400px; height: 280px; display: none;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please enter a title.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Description</label>
                            <textarea name="description" id="add-notice-description" class="form-control form-control-sm" rows="3" required></textarea>
                            <div class="invalid-feedback">Please enter a description.</div>
                            <small class="text-muted">Format your text with bold, italic, colors, lists, and more.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Please select a start date.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">End date must be after start date.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Notice Modal -->
    <div class="modal fade" id="editNoticeModal" tabindex="-1" aria-labelledby="editNoticeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editNoticeForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="editNoticeModalLabel">Edit Notice</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <input type="hidden" name="notice_id" id="notice_id">
                        <div class="mb-3">
                            <label class="form-label small">Attachment (Image/PDF, Optional)</label>
                            <input type="file" name="image" id="editNoticeImage" class="form-control form-control-sm" accept="image/*,.pdf,application/pdf">
                            <div class="invalid-feedback">Please select a valid image or PDF file.</div>
                            <input type="hidden" name="existing_image" id="existing_image">
                            <div id="editNoticeImagePreview" class="mt-2">
                                <img id="currentImagePreview" src="" alt="Current Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover; display: none;">
                                <div id="currentPdfPreview" style="display: none;">
                                    <embed id="currentPdfEmbed" src="" type="application/pdf" style="width: 100%; max-width: 400px; height: 280px; border: 1px solid #dee2e6;">
                                    <div class="mt-1"><a id="currentPdfLink" href="#" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf me-1"></i> Open PDF in new tab</a></div>
                                </div>
                                <img id="newImagePreview" src="" alt="New Preview" class="img-thumbnail mt-2" style="max-width: 200px; max-height: 200px; object-fit: cover; display: none;">
                                <div id="newPdfPreview" style="display: none;" class="mt-2">
                                    <embed id="newPdfEmbed" src="" type="application/pdf" style="width: 100%; max-width: 400px; height: 280px; border: 1px solid #dee2e6;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please enter a title.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Description</label>
                            <textarea name="description" id="edit-notice-description" class="form-control form-control-sm" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">Please enter a description.</div>
                            <small class="text-muted">Format your text with bold, italic, colors, lists, and more.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm"
                                    required>
                                <div class="invalid-feedback">Please select a start date.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm"
                                    required>
                                <div class="invalid-feedback">End date must be after start date.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-save"></i> Update
                        </button>
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
        // Summernote configuration
        var summernoteConfig = {
            height: 250,
            toolbar: [
                ['style', ['style']], ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']], ['fontsize', ['fontsize']], ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']], ['table', ['table']],
                ['insert', ['link', 'picture']], ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
            placeholder: 'Enter description here...',
            dialogsInBody: true,
            disableDragAndDrop: true,
            popatmouse: true
        };

        // Initialize Summernote for Add Modal
        $('#addNoticeModal').on('shown.bs.modal', function () {
            if (!$('#add-notice-description').next('.note-editor').length) {
                $('#add-notice-description').summernote(summernoteConfig);
            }
        });

        // Initialize Summernote for Edit Modal
        $('#editNoticeModal').on('shown.bs.modal', function () {
            if (!$('#edit-notice-description').next('.note-editor').length) {
                $('#edit-notice-description').summernote(summernoteConfig);
            }
        });

        // Destroy Summernote when modals close
        $('#addNoticeModal').on('hidden.bs.modal', function () {
            if ($('#add-notice-description').next('.note-editor').length) {
                $('#add-notice-description').summernote('destroy');
            }
            $(this).find('form')[0].reset();
            $('#addNoticeImagePreview').hide();
            $(this).find('form').removeClass('was-validated');
        });

        $('#editNoticeModal').on('hidden.bs.modal', function () {
            if ($('#edit-notice-description').next('.note-editor').length) {
                $('#edit-notice-description').summernote('destroy');
            }
        });

        function isPdfFile(fileName) {
            return fileName.toLowerCase().endsWith('.pdf');
        }

        function showAddAttachmentPreview(file) {
            const preview = $('#addNoticeImagePreview');
            const imagePreview = preview.find('img');
            const pdfPreview = preview.find('embed');

            if (!file) {
                imagePreview.hide().attr('src', '');
                pdfPreview.hide().attr('src', '');
                preview.hide();
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (isPdfFile(file.name)) {
                    imagePreview.hide().attr('src', '');
                    pdfPreview.attr('src', e.target.result).show();
                } else {
                    pdfPreview.hide().attr('src', '');
                    imagePreview.attr('src', e.target.result).show();
                }
                preview.show();
            };
            reader.readAsDataURL(file);
        }

        function showEditAttachmentPreview(file, existingPath) {
            const currentImagePreview = $('#currentImagePreview');
            const currentPdfPreview = $('#currentPdfPreview');
            const newImagePreview = $('#newImagePreview');
            const newPdfPreview = $('#newPdfPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImagePreview.hide();
                    currentPdfPreview.hide();
                    if (isPdfFile(file.name)) {
                        newImagePreview.hide().attr('src', '');
                        newPdfPreview.find('embed').attr('src', e.target.result);
                        newPdfPreview.show();
                    } else {
                        newPdfPreview.hide().find('embed').attr('src', '');
                        newImagePreview.attr('src', e.target.result).show();
                    }
                };
                reader.readAsDataURL(file);
                return;
            }

            newImagePreview.hide().attr('src', '');
            newPdfPreview.hide().find('embed').attr('src', '');

            if (!existingPath) {
                currentImagePreview.hide().attr('src', '');
                currentPdfPreview.hide().find('embed').attr('src', '');
                return;
            }

            const cleanedPath = existingPath.replace(/^\/+/, '').replace(/\\/g, '/');
            const normalizedPath = cleanedPath.startsWith('public/') ? cleanedPath : 'public/' + cleanedPath;
            const fileUrl = '{{ asset("") }}' + normalizedPath;
            if (isPdfFile(existingPath)) {
                currentImagePreview.hide().attr('src', '');
                currentPdfPreview.find('embed').attr('src', fileUrl);
                currentPdfPreview.find('a').attr('href', fileUrl);
                currentPdfPreview.show();
            } else {
                currentPdfPreview.hide().find('embed').attr('src', '');
                currentImagePreview.attr('src', fileUrl).show();
            }
        }

        // Attachment Preview for Add Modal
        $('#addNoticeImage').on('change', function(e) {
            const file = e.target.files[0];
            showAddAttachmentPreview(file);
        });

        // Attachment Preview for Edit Modal
        $('#editNoticeImage').on('change', function(e) {
            const file = e.target.files[0];
            showEditAttachmentPreview(file, $('#existing_image').val());
        });

        // Edit Modal Data Fill
        $('#editNoticeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var description = button.data('description');
            var start_date = button.data('start_date');
            var end_date = button.data('end_date');
            var image_path = button.data('image_path');

            var form = $('#editNoticeForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            form.find('#notice_id').val(id);
            form.find('#title').val(title);
            form.find('#description').val(description);
            form.find('#start_date').val(start_date);
            form.find('#end_date').val(end_date);
            
            // Handle image
            var existingImageInput = $('#existing_image');
            var imageInput = $('#editNoticeImage');
            
            imageInput.val(''); // Reset file input
            $('#newImagePreview').hide().attr('src', '');
            $('#newPdfPreview').hide().find('embed').attr('src', '');
            
            if (image_path) {
                existingImageInput.val(image_path);
                showEditAttachmentPreview(null, image_path);
            } else {
                existingImageInput.val('');
                showEditAttachmentPreview(null, '');
            }
        });

        // Bootstrap Validation with Date Check
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    let start = form.querySelector('[name="start_date"]');
                    let end = form.querySelector('[name="end_date"]');

                    if (start && end && start.value && end.value && new Date(end.value) < new Date(start.value)) {
                        end.setCustomValidity("End date must be after start date.");
                    } else {
                        end.setCustomValidity("");
                    }

                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
        // Text + Date filter
        function Filters() {
            const query = $('#noticeSearch').val().toLowerCase();
            const startDate = $('#startDateFilter').val() ? new Date($('#startDateFilter').val()) : null;
            const endDate = $('#endDateFilter').val() ? new Date($('#endDateFilter').val()) : null;

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const rowStart = new Date($(this).find('td:nth-child(4)').text().trim()); // Start Date (column 4)
                const rowEnd = new Date($(this).find('td:nth-child(5)').text().trim());   // End Date (column 5)

                let matchesSearch = rowText.indexOf(query) !== -1;

                let matchesDate = true;
                if (startDate && rowStart < startDate) matchesDate = false;
                if (endDate && rowEnd > endDate) matchesDate = false;

                $(this).toggle(matchesSearch && matchesDate);
            });
        }

        // Trigger search
        $('#noticeSearch').on('keyup', Filters);

        // Trigger date filters
        $('#startDateFilter, #endDateFilter').on('change', Filters);

        // Reset filters
        $('#resetFilters').on('click', function (e) {
            e.preventDefault();
            $('#noticeSearch').val('');
            $('#startDateFilter').val('');
            $('#endDateFilter').val('');
            $('table tbody tr').show(); // Show all rows again
        });

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