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
                    <h6 class="mb-0 fw-bold">Events</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addEventModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">

                <!-- 🔍 Search & Date Filters -->
                <div class="row g-2 mb-3 align-items-center">

                    <!-- Search -->
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="eventSearch" class="form-control form-control-sm" placeholder="🔍 Search...">
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
                            @foreach($events as $event)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->description }}</td>
                                    <td>{{ $event->start_date }}</td>
                                    <td>{{ $event->end_date }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('event.status', $event->id) }}"
                                            class="btn @if($event->is_published == 1) btn-soft-success @else btn-soft-danger @endif btn-sm rounded-2">
                                            <i class="fas fa-check"></i>
                                        </a>

                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-event"
                                            data-bs-toggle="modal" data-bs-target="#editEventModal" data-id="{{ $event->id }}"
                                            data-title="{{ $event->title }}" data-description="{{ $event->description }}"
                                            data-start_date="{{ $event->start_date }}" data-end_date="{{ $event->end_date }}"
                                            data-action="{{ route('event.update', ':id') }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this event?');">
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

    <!-- Add New Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form action="{{ route('event.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="addEventModalLabel">Add New Event</h6>
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
                            <textarea name="description" class="form-control form-control-sm" rows="3" required></textarea>
                            <div class="invalid-feedback">Please enter a description.</div>
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

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editEventForm" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="editEventModalLabel">Edit Event</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <input type="hidden" name="event_id" id="event_id">
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">Please enter a title.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Description</label>
                            <textarea name="description" id="description" class="form-control form-control-sm" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">Please enter a description.</div>
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
    <script>
        // Fill Edit Modal
        $('#editEventModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var description = button.data('description');
            var start_date = button.data('start_date');
            var end_date = button.data('end_date');
            var form = $('#editEventForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);
            form.find('#event_id').val(id);
            form.find('#title').val(title);
            form.find('#description').val(description);
            form.find('#start_date').val(start_date);
            form.find('#end_date').val(end_date);
        });

        // Bootstrap Validation + Date Check
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    // Extra validation: End Date >= Start Date
                    var startDate = form.querySelector('[name="start_date"]');
                    var endDate = form.querySelector('[name="end_date"]');
                    if (startDate && endDate && startDate.value && endDate.value) {
                        if (new Date(endDate.value) < new Date(startDate.value)) {
                            event.preventDefault()
                            event.stopPropagation()
                            endDate.setCustomValidity("End date must be greater than or equal to start date.");
                            endDate.reportValidity();
                        } else {
                            endDate.setCustomValidity("");
                        }
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
        // Text + Date filter
        function Filters() {
            const query = $('#eventSearch').val().toLowerCase();
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
        $('#eventSearch').on('keyup', Filters);

        // Trigger date filters
        $('#startDateFilter, #endDateFilter').on('change', Filters);

        // Reset filters
        $('#resetFilters').on('click', function (e) {
            e.preventDefault();
            $('#eventSearch').val('');
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