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
                    <h6 class="mb-0 fw-bold">Result File Upload</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addClassResultModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search & Date Filters -->
                <div class="row g-2 mb-3 align-items-center">

                    <!-- Search -->
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="classresultSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-3 col-sm-6">
                        <input type="date" id="publishedDateFilter" class="form-control form-control-sm">
                    </div>

                    <!-- Gap -->
                    <div class="col-md-3 col-sm-6"></div>

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
                            <tr class="text-uppercase text-muted fw-semibold" style="letter-spacing: 0.05em;">
                                <th class="py-2">SL.</th>
                                <th class="py-2">Class</th>
                                <th class="py-2">Shift</th>
                                <th class="py-2">Result Title</th>
                                <th class="py-2">Published Date</th>
                                <th class="py-2">File</th>
                                <th class="text-end py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-muted">
                            @foreach($classresults as $classresult)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $classresult->class->name }}</td>
                                    <td>{{ $classresult->shift }}</td>
                                    <td>{{ $classresult->result_title }}</td>
                                    <td>{{ $classresult->published_date }}</td>
                                    <td>
                                        @if($classresult->file_path)
                                            <a href="{{ asset($classresult->file_path) }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm rounded-pill">
                                                <i class="fa-solid fa-eye me-1"></i> View
                                            </a>
                                            <a href="{{ route('classresult.download', $classresult->id) }}"
                                                class="btn btn-outline-secondary btn-sm rounded-pill">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            No file
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <!-- Publish/Unpublish button -->
                                        <a href="{{ route('classresult.status', $classresult->id) }}"
                                            class="btn @if($classresult->is_active == 1) btn-soft-success @else btn-soft-danger @endif btn-sm rounded-2">
                                            <i class="fas fa-check"></i>
                                        </a>

                                        <!-- Edit button -->
                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-file"
                                            data-bs-toggle="modal" data-bs-target="#editClassResultModal"
                                            data-id="{{ $classresult->id }}" data-class_id="{{ $classresult->class_id }}"
                                            data-shift="{{ $classresult->shift }}"
                                            data-result_title="{{ $classresult->result_title }}"
                                            data-published_date="{{ $classresult->published_date }}"
                                            data-is_active="{{ $classresult->is_active }}"
                                            data-file="{{ $classresult->file_path }}"
                                            data-action="{{ route('classresult.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('classresult.destroy', $classresult->id) }}" method="POST"
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

    <!-- Add Modal -->
    <div class="modal fade" id="addClassResultModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form action="{{ route('classresult.store') }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold">Add New File</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-muted">
                        <div class="row g-3">
                            <!-- Result Title -->
                            <div class="col-md-12">
                                <label class="form-label">Result Title</label>
                                <input type="text" name="result_title" class="form-control" required>
                                <div class="invalid-feedback">Result title is required.</div>
                            </div>

                            <!-- Class -->
                            <div class="col-md-4">
                                <label class="form-label">Class</label>
                                <select name="class_id" class="form-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a class.</div>
                            </div>

                            <!-- Shift -->
                            <div class="col-md-4">
                                <label class="form-label">Shift</label>
                                <input type="text" name="shift" class="form-control" required>
                                <div class="invalid-feedback">Shift is required.</div>
                            </div>

                            <!-- Published Date -->
                            <div class="col-md-4">
                                <label class="form-label">Published Date</label>
                                <input type="date" name="published_date" class="form-control" required>
                                <div class="invalid-feedback">Published date is required.</div>
                            </div>

                            <!-- File -->
                            <div class="col-md-12">
                                <label class="form-label">File</label>
                                <input type="file" name="file_path" class="form-control" required>
                                <div class="invalid-feedback">Please upload a file.</div>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editClassResultModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editClassResultForm" method="POST" enctype="multipart/form-data" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold">Edit File</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-muted">
                        <input type="hidden" name="classresult_id" id="classresult_id">

                        <div class="row g-3">
                            <!-- Result Title -->
                            <div class="col-md-12">
                                <label class="form-label">Result Title</label>
                                <input type="text" name="result_title" id="edit_result_title" class="form-control" required>
                                <div class="invalid-feedback">Result title is required.</div>
                            </div>

                            <!-- Class -->
                            <div class="col-md-4">
                                <label class="form-label">Class</label>
                                <select name="class_id" id="edit_class_id" class="form-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a class.</div>
                            </div>

                            <!-- Shift -->
                            <div class="col-md-4">
                                <label class="form-label">Shift</label>
                                <input type="text" name="shift" id="edit_shift" class="form-control" required>
                                <div class="invalid-feedback">Shift is required.</div>
                            </div>

                            <!-- Published Date -->
                            <div class="col-md-4">
                                <label class="form-label">Published Date</label>
                                <input type="date" name="published_date" id="edit_published_date" class="form-control"
                                    required>
                                <div class="invalid-feedback">Published date is required.</div>
                            </div>

                            <!-- File -->
                            <div class="col-md-12">
                                <label class="form-label">Replace File (optional)</label>
                                <input type="file" name="file_path" id="edit_file_path" class="form-control">
                                <div id="current_file" class="mt-2"></div>
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
    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();

        // Edit modal fill data
        $('#editClassResultModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var id = button.data('id');
            var class_id = button.data('class_id');
            var shift = button.data('shift');
            var result_title = button.data('result_title');
            var published_date = button.data('published_date');
            var file = button.data('file');
            var action = button.data('action');

            var form = $('#editClassResultForm');
            form.attr('action', action.replace(':id', id));

            form.find('#classresult_id').val(id);
            form.find('#edit_class_id').val(class_id);
            form.find('#edit_shift').val(shift);
            form.find('#edit_result_title').val(result_title);
            form.find('#edit_published_date').val(published_date);

            // if (file) {
            //     $('#current_file').html('<small class="text-muted">Current File: <a href="/' + file + '" target="_blank">' + file + '</a></small>');
            // } else {
            //     $('#current_file').html('<small class="text-muted">No file uploaded.</small>');
            // }
        });
        // Text + Date filter
        function Filters() {
            const query = $('#classresultSearch').val().toLowerCase();
            const filterDate = $('#publishedDateFilter').val() ? new Date($('#publishedDateFilter').val()) : null;

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const rowDateText = $(this).find('td:nth-child(4)').text().trim(); // published date in column 4
                const rowDate = rowDateText ? new Date(rowDateText) : null;

                let matchesSearch = rowText.indexOf(query) !== -1;
                let matchesDate = true;

                if (filterDate && rowDate) {
                    matchesDate = rowDate.toDateString() === filterDate.toDateString();
                }

                $(this).toggle(matchesSearch && matchesDate);
            });
        }

        // Trigger search
        $('#classresultSearch').on('keyup', Filters);

        // Trigger date filter
        $('#publishedDateFilter').on('change', Filters);

        // Reset filters
        $('#resetFilters').on('click', function (e) {
            e.preventDefault();
            $('#classresultSearch').val('');
            $('#publishedDateFilter').val('');
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