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
                    <h6 class="mb-0 fw-bold">Official Link</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addOfficialLinkModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="officialLinkSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                <th class="py-2">SL.</th>
                                <th class="py-2">Title</th>
                                <th class="py-2">Link</th>
                                <th class="text-end py-2">Action</th>
                            </tr>
                        </thead>

                        <tbody class="small text-muted">
                            @foreach($officiallinks as $officiallink)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $officiallink->title }}</td>
                                    <td>
                                        @if($officiallink->link_url)
                                            <a href="{{ asset($officiallink->link_url) }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm rounded-pill">
                                                <i class="fa-solid fa-eye me-1"></i> View
                                            </a>
                                        @else
                                            No file
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <!-- Publish/Unpublish -->
                                        <a href="{{ route('officiallink.status', $officiallink->id) }}"
                                            class="btn @if($officiallink->is_published == 1) btn-soft-success @else btn-soft-danger @endif btn-sm rounded-2">
                                            <i class="fas fa-check"></i>
                                        </a>

                                        <!-- Edit -->
                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-notice"
                                            data-bs-toggle="modal" data-bs-target="#editOfficialLinkModal"
                                            data-id="{{ $officiallink->id }}" data-title="{{ $officiallink->title }}"
                                            data-link_url="{{ $officiallink->link_url }}"
                                            data-action="{{ route('officiallink.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('officiallink.destroy', $officiallink->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this official link?');">
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

    <!-- Add New Official Link Modal -->
    <div class="modal fade" id="addOfficialLinkModal" tabindex="-1" aria-labelledby="addOfficialLinkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form action="{{ route('officiallink.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="addOfficialLinkModalLabel">Add Official Link
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">
                                Please enter a title.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Link</label>
                            <input type="url" name="link_url" id="add_link_url" class="form-control form-control-sm"
                                required>
                            <div class="invalid-feedback">
                                Please enter a valid URL.
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

    <!-- Edit Official Link Modal -->
    <div class="modal fade" id="editOfficialLinkModal" tabindex="-1" aria-labelledby="editOfficialLinkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editOfficialLinkForm" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="editOfficialLinkModalLabel">Edit Official
                            Link
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <input type="hidden" name="officiallink_id" id="officiallink_id">
                        <div class="mb-3">
                            <label class="form-label small">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control form-control-sm" required>
                            <div class="invalid-feedback">
                                Please enter a title.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Link</label>
                            <input type="url" name="link_url" id="edit_link_url" class="form-control form-control-sm"
                                required>
                            <div class="invalid-feedback">
                                Please enter a valid URL.
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
        // Populate Edit Modal
        $('#editOfficialLinkModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var id = button.data('id');
            var title = button.data('title');
            var link_url = button.data('link_url');
            var action = button.data('action').replace(':id', id);

            var form = $('#editOfficialLinkForm');
            form.attr('action', action);

            form.find('#officiallink_id').val(id);
            form.find('#edit_title').val(title);
            form.find('#edit_link_url').val(link_url);
        });

        // Bootstrap validation
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

        function Filters() {
            const query = $('#officialLinkSearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#officialLinkSearch').on('keyup', Filters);

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