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
                <h6 class="mb-0 fw-bold">Important Notices</h6>
            </div>
            <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                data-bs-target="#addImportantNoticeModal">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>

        <div class="card-body">
          <!-- 🔍 Search & Date Filters -->
            <div class="row g-2 mb-3 align-items-center">

                <!-- Search -->
                <div class="col-md-4 col-sm-12">
                    <input type="text" id="importantnoticeSearch" class="form-control form-control-sm" placeholder="🔍 Search...">
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
                            <th class="text-end py-2">Action</th>
                        </tr>
                    </thead>

                    <tbody class="small text-muted">
                        @foreach($importantnotices as  $notice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $notice->title }}</td>
                                <td>{{ $notice->description }}</td>
                                <td>{{ $notice->start_date }}</td>
                                <td>{{ $notice->end_date }}</td>
                                <td class="text-end">
                                    <!-- Publish/Unpublish button -->
                                    <a href="{{ route('important.notice.status', $notice->id) }}"
                                        class="btn @if($notice->is_published == 1) btn-soft-success @else btn-soft-danger @endif btn-sm rounded-2">
                                        <i class="fas fa-check"></i>
                                    </a>

                                    <!-- Edit button -->
                                    <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-notice"
                                        data-bs-toggle="modal" data-bs-target="#editImportantNoticeModal" data-id="{{ $notice->id }}"
                                        data-title="{{ $notice->title }}" data-description="{{ $notice->description }}"
                                        data-start_date="{{ $notice->start_date }}" data-end_date="{{ $notice->end_date }}"
                                        data-action="{{ route('important.notice.update', ':id') }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete button -->
                                    <form action="{{ route('important.notice.destroy', $notice->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this important notice?');">
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

<!-- Add New Important Notice Modal -->
<div class="modal fade" id="addImportantNoticeModal" tabindex="-1" aria-labelledby="addImportantNoticeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-sm">
            <form action="{{ route('important.notice.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-header border-0">
                    <h6 class="modal-title text-muted fw-semibold" id="addImportantNoticeModalLabel">Add New Notice</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small text-muted">
                    <div class="mb-3">
                        <label class="form-label small">Title</label>
                        <input type="text" name="title" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">Please enter a title.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Description</label>
                        <textarea name="description" id="add-important-description" class="form-control form-control-sm" rows="3" required></textarea>
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
                            <div class="invalid-feedback">Please select an end date.</div>
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

<!-- Edit Important Notice Modal -->
<div class="modal fade" id="editImportantNoticeModal" tabindex="-1" aria-labelledby="editImportantNoticeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-sm">
            <form id="editImportantNoticeForm" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h6 class="modal-title text-muted fw-semibold" id="editImportantNoticeModalLabel">Edit Important
                        Notice</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small text-muted">
                    <input type="hidden" name="notice_id" id="notice_id">
                    <div class="mb-3">
                        <label class="form-label small">Title</label>
                        <input type="text" name="title" id="title" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">Please enter a title.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Description</label>
                        <textarea name="description" id="edit-important-description" class="form-control form-control-sm" rows="3" required></textarea>
                        <div class="invalid-feedback">Please enter a description.</div>
                        <small class="text-muted">Format your text with bold, italic, colors, lists, and more.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please select a start date.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please select an end date.</div>
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
    $('#addImportantNoticeModal').on('shown.bs.modal', function () {
        if (!$('#add-important-description').next('.note-editor').length) {
            $('#add-important-description').summernote(summernoteConfig);
        }
    });

    // Initialize Summernote for Edit Modal
    $('#editImportantNoticeModal').on('shown.bs.modal', function () {
        if (!$('#edit-important-description').next('.note-editor').length) {
            $('#edit-important-description').summernote(summernoteConfig);
        }
    });

    // Destroy Summernote when modals close
    $('#addImportantNoticeModal').on('hidden.bs.modal', function () {
        if ($('#add-important-description').next('.note-editor').length) {
            $('#add-important-description').summernote('destroy');
        }
    });

    $('#editImportantNoticeModal').on('hidden.bs.modal', function () {
        if ($('#edit-important-description').next('.note-editor').length) {
            $('#edit-important-description').summernote('destroy');
        }
    });

    // Bootstrap form validation
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                let start = form.querySelector('[name="start_date"]');
                let end = form.querySelector('[name="end_date"]');
                if (start && end && start.value && end.value && new Date(end.value) < new Date(start.value)) {
                    end.setCustomValidity("End date cannot be earlier than start date.");
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

    // Fill Edit Modal with existing data
    $('#editImportantNoticeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var title = button.data('title');
        var description = button.data('description');
        var start_date = button.data('start_date');
        var end_date = button.data('end_date');

        var form = $('#editImportantNoticeForm');
        var action = button.data('action').replace(':id', id);
        form.attr('action', action);

        form.find('#notice_id').val(id);
        form.find('#title').val(title);
        form.find('#edit-important-description').val(description);
        // Update Summernote content if already initialized
        setTimeout(function() {
            if ($('#edit-important-description').next('.note-editor').length) {
                $('#edit-important-description').summernote('code', description);
            }
        }, 100);
        form.find('#start_date').val(start_date);
        form.find('#end_date').val(end_date);
    });

// Text + Date filter
function Filters() {
    const query = $('#importantnoticeSearch').val().toLowerCase();
    const startDate = $('#startDateFilter').val() ? new Date($('#startDateFilter').val()) : null;
    const endDate = $('#endDateFilter').val() ? new Date($('#endDateFilter').val()) : null;

    $('table tbody tr').each(function () {
        const rowText = $(this).text().toLowerCase();
        const rowStart = new Date($(this).find('td:nth-child(4)').text().trim()); // Start Date
        const rowEnd = new Date($(this).find('td:nth-child(5)').text().trim());   // End Date

        let matchesSearch = rowText.indexOf(query) !== -1;

        let matchesDate = true;
        if (startDate && rowStart < startDate) matchesDate = false;
        if (endDate && rowEnd > endDate) matchesDate = false;

        $(this).toggle(matchesSearch && matchesDate);
    });
}

// Trigger search
$('#importantnoticeSearch').on('keyup', Filters);

// Trigger date filters
$('#startDateFilter, #endDateFilter').on('change', Filters);

// Reset filters
$('#resetFilters').on('click', function (e) {
    e.preventDefault();
    $('#importantnoticeSearch').val('');
    $('#startDateFilter').val('');
    $('#endDateFilter').val('');
    $('table tbody tr').show(); // Show all rows again
});

// ✅ Pagination
   $(document).ready(function() {
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
    $(document).on("click", "#pagination .page-number a", function(e) {
        e.preventDefault();
        var page = parseInt($(this).text());
        showPage(page);
    });

    $("#prev-page a").click(function(e) {
        e.preventDefault();
        showPage(currentPage - 1);
    });

    $("#next-page a").click(function(e) {
        e.preventDefault();
        showPage(currentPage + 1);
    });

    // Initialize
    showPage(1);
});

</script>
@endsection
