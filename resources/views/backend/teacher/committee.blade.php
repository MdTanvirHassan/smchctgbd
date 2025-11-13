@extends('backend.layouts.app')

@section('contents')
    @include('backend.inc.table_css')

    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;"><i class="fas fa-chalkboard-user"></i></div>
                    <h6 class="mb-0 fw-bold">Committee</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addcommitteeModal"><i class="fas fa-plus"></i> Add New</button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="CommitteeSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small fw-semibold">
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody class="small text-muted">
                            @foreach($committees as $committee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($committee->photo_path) }}"
                                            style="width:40px; height:40px; object-fit:cover; border-radius:15%; margin-right:8px;"
                                            onerror="this.onerror=null; this.src='{{ asset('/public/assets/icons/user.png') }}'">
                                        {{ $committee->name }}</td>
                                    <td>{{ $committee->email }}</td>
                                    <td>{{ $committee->phone }}</td>
                                    <td>{{ $committee->designation }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-committee"
                                            data-action="{{ route('committee.update', ':id') }}" data-bs-toggle="modal"
                                            data-bs-target="#editcommitteeModal" data-id="{{ $committee->id }}"
                                            data-name="{{ $committee->name }}" data-designation="{{ $committee->designation }}"
                                            data-email="{{ $committee->email }}" data-phone="{{ $committee->phone }}"
                                            data-join_date="{{ $committee->join_date }}"
                                            data-biography="{{ $committee->biography }}"
                                            data-photo="{{ asset($committee->photo_path) }}" title="Edit"><i
                                                class="fas fa-edit"></i></button>

                                        <form action="{{ route('committee.destroy', $committee->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm rounded-2" title="Delete"><i
                                                    class="fas fa-trash"></i></button>
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
    <div class="modal fade" id="addcommitteeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="addcommitteeForm" class="needs-validation" action="{{ route('committee.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title"><i class="fas fa-user-plus me-1"></i> Add New Committee</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">Please enter full name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" class="form-control" required>
                                <div class="invalid-feedback">Please enter designation.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger"></span></label>
                                <input type="email" name="email" class="form-control">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone <span class="text-danger"></span></label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Joining Date <span class="text-danger"></span></label>
                                <input type="date" name="join_date" class="form-control">
                                <!-- <div class="invalid-feedback">Select joining date.</div> -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Biography <span class="text-danger"></span></label>
                            <textarea name="biography" class="form-control" rows="3"></textarea>
                            <!-- <div class="invalid-feedback">Enter biography.</div> -->
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <div class="mt-2 photo-preview"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editcommitteeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editcommitteeForm" class="needs-validation" method="POST" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title">Edit Committee</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger"></span></label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone <span class="text-danger"></span></label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Joining Date <span class="text-danger"></span></label>
                                <input type="date" name="join_date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Biography <span class="text-danger"></span></label>
                            <textarea name="biography" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <!-- <div class="mt-2"><img id="photoPreview"
                                                                            style="max-height:120px; max-width:150px; object-fit:contain; display:none; border:1px solid #ddd; padding:4px; border-radius:6px;"
                                                                            onerror="this.onerror=null; this.src='{{ asset('/public/assets/img/user.png') }}'"> -->
                            <img id="photoPreview"
                                style="max-height:120px; max-width:150px; object-fit:contain; display:none; border:1px solid #ddd; padding:4px; border-radius:6px;">
                        </div>
                    </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Bootstrap validation
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

        // Edit modal fill
        $('#editcommitteeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var form = $('#editcommitteeForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            form.find('input[name="name"]').val(button.data('name'));
            form.find('input[name="designation"]').val(button.data('designation'));
            form.find('input[name="email"]').val(button.data('email'));
            form.find('input[name="phone"]').val(button.data('phone'));
            form.find('input[name="join_date"]').val(button.data('join_date'));
            form.find('textarea[name="biography"]').val(button.data('biography'));

            var photo = button.data('photo');
            var preview = $('#photoPreview');
            if (photo) { preview.attr('src', photo).show(); } else { preview.hide(); }
        });

        // Photo preview
        document.addEventListener('DOMContentLoaded', function () {
            // Add form preview
            const addPhotoInput = document.querySelector('#addcommitteeModal input[name="photo"]');
            if (addPhotoInput) {
                addPhotoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            let preview = addPhotoInput.closest('.mb-3').querySelector('.photo-preview');
                            preview.innerHTML = `<img src="${e.target.result}" style="max-height:120px; max-width:150px; object-fit:contain; border:1px solid #ddd; padding:4px; border-radius:6px;">`;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Edit form preview
            const editPhotoInput = document.querySelector('#editcommitteeModal input[name="photo"]');
            const editPhotoPreview = document.querySelector('#photoPreview');
            if (editPhotoInput) {
                editPhotoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            editPhotoPreview.src = e.target.result;
                            editPhotoPreview.style.display = 'block';
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
        function Filters() {
            const query = $('#CommitteeSearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#CommitteeSearch').on('keyup', Filters);

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