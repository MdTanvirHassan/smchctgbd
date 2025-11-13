@extends('backend.layouts.app')

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
                    <h6 class="mb-0 fw-bold">Download File Upload</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addFileUploadModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="FileSearch" class="form-control form-control-sm" placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                <th class="py-2">SL.</th>
                                <th class="py-2">Title</th>
                                <th class="py-2">File</th>
                                <th class="text-end py-2">Action</th>
                            </tr>
                        </thead>

                        <tbody class="small text-muted">
                            @foreach($fileuploads as $fileupload)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $fileupload->title }}</td>
                                    <td>
                                        @if($fileupload->file_path)
                                            <a href="{{ asset($fileupload->file_path) }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm rounded-pill">
                                                <i class="fa-solid fa-eye me-1"></i> View
                                            </a>
                                            <a href="{{ route('fileupload.download', $fileupload->id) }}"
                                                class="btn btn-outline-secondary btn-sm rounded-pill">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            No file
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('fileupload.status', $fileupload->id) }}"
                                            class="btn @if($fileupload->is_published == 1) btn-soft-success @else btn-soft-danger @endif btn-sm rounded-2">
                                            <i class="fas fa-check"></i>
                                        </a>

                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-file"
                                            data-bs-toggle="modal" data-bs-target="#editFileUploadModal"
                                            data-id="{{ $fileupload->id }}" data-title="{{ $fileupload->title }}"
                                            data-file="{{ $fileupload->file_path }}"
                                            data-action="{{ route('fileupload.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('fileupload.destroy', $fileupload->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this file?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm rounded-2">
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

    <!-- Add New File Modal -->
    <div class="modal fade" id="addFileUploadModal" tabindex="-1" aria-labelledby="addFileUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form action="{{ route('fileupload.store') }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="addFileUploadModalLabel">Add New File</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please provide a title.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">File</label>
                            <input type="file" name="file_path" id="file_path" class="form-control form-control-sm"
                                required>
                            <div class="invalid-feedback">Please upload a file.</div>
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

    <!-- Edit File Modal -->
    <div class="modal fade" id="editFileUploadModal" tabindex="-1" aria-labelledby="editFileUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editFileUploadForm" method="POST" enctype="multipart/form-data" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="editFileUploadModalLabel">Edit File</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <input type="hidden" name="fileupload_id" id="fileupload_id">
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please provide a title.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Replace File</label>
                            <input type="file" name="file_path" id="edit_file_path" class="form-control form-control-sm">
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
    <script>
        // Edit Modal setup
        $('#editFileUploadModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var file = button.data('file');
            var action = button.data('action');

            var form = $('#editFileUploadForm');
            if (action) {
                form.attr('action', action.replace(':id', id));
            }

            form.find('#fileupload_id').val(id);
            form.find('#title').val(title);
        });

        // Bootstrap 5 form validation
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
        function Filters() {
            const query = $('#FileSearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#FileSearch').on('keyup', Filters);

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