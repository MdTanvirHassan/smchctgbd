@extends('backend.layouts.app')

@section('contents')
    @include('backend.inc.table_css')

    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Teachers</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addteacherModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="TeacherSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                <th class="py-2">SL.</th>
                                <th class="py-2">Name</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Phone</th>
                                <th class="py-2">Designation</th>
                                <th class="text-end py-2">Action</th>
                            </tr>
                        </thead>

                        <tbody class="small text-muted">
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($teacher->photo_path) }}"
                                            style="width:40px; height:40px; object-fit:cover; border-radius:15%; margin-right:8px;"
                                            onerror="this.onerror=null; this.src='{{ asset('/public/assets/icons/user.png') }}'">{{ $teacher->name }}
                                    </td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->designation->name }}</td>
                                    <td class="text-end">

                                        <!-- Edit button -->
                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-teacher"
                                            data-action="{{ route('teacher.update', ':id') }}" data-bs-toggle="modal"
                                            data-bs-target="#editteacherModal" data-id="{{ $teacher->id }}"
                                            data-name="{{ $teacher->name }}" data-designation="{{ $teacher->designation_id }}"
                                            data-email="{{ $teacher->email }}" data-phone="{{ $teacher->phone }}"
                                            data-join_date="{{ $teacher->join_date }}"
                                            data-qualification="{{ $teacher->qualification }}"
                                            data-biography="{{ $teacher->biography }}"
                                            data-photo="{{ asset($teacher->photo_path) }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this teacher?');">
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

    <!-- Add New teacher Modal -->
    <div class="modal fade" id="addteacherModal" tabindex="-1" aria-labelledby="addteacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="addteacherForm" class="needs-validation" action="{{ route('teacher.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="addteacherModalLabel">
                            <i class="fas fa-user-plus me-1"></i> Add New Teacher
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body small text-muted">
                        {{-- Row 1: Name & Designation --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">Please enter the teacher's name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Designation <span class="text-danger">*</span></label>
                                <select name="designation" class="form-select form-select-sm" required>
                                    <option value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a designation.</div>
                            </div>
                        </div>

                        {{-- Row 2: Email & Phone --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control">
                                <!-- <div class="invalid-feedback">Please enter a valid email.</div> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>

                        {{-- Row 3: Join Date & Qualification --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Joining Date <span class="text-danger"></span></label>
                                <input type="date" name="join_date" class="form-control">
                                <!-- <div class="invalid-feedback">Please select joining date.</div> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Qualification <span
                                        class="text-danger"></span></label>
                                <input type="text" name="qualification" class="form-control">
                                <!-- <div class="invalid-feedback">Please enter qualification.</div> -->
                            </div>
                        </div>

                        {{-- Biography --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Biography <span class="text-danger"></span></label>
                            <textarea name="biography" class="form-control" rows="3"></textarea>
                            <!-- <div class="invalid-feedback">Please enter biography.</div> -->
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Photo <span class="text-danger"></span></label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <!-- <div class="invalid-feedback">Please upload a photo.</div> -->
                            <div class="mt-2 photo-preview"></div>
                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Single Edit teacher Modal -->
    <div class="modal fade" id="editteacherModal" tabindex="-1" aria-labelledby="editteacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editteacherForm" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="editteacherModalLabel">Edit teacher</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">

                        {{-- Row 1: Name & Designation --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">Please enter the teacher's name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Designation <span class="text-danger">*</span></label>
                                <select name="designation" class="form-select form-select-sm" required>
                                    <option value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a designation.</div>
                            </div>
                        </div>

                        {{-- Row 2: Email & Phone --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control">
                                <!-- <div class="invalid-feedback">Please enter a valid email.</div> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>

                        {{-- Row 3: Join Date & Qualification --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Joining Date <span class="text-danger"></span></label>
                                <input type="date" name="join_date" class="form-control">
                                <!-- <div class="invalid-feedback">Please select joining date.</div> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Qualification<span class="text-danger"></span></label>
                                <input type="text" name="qualification" class="form-control">
                                <!-- <div class="invalid-feedback">Please enter qualification.</div> -->
                            </div>
                        </div>

                        {{-- Biography --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Biography <span class="text-danger"></span></label>
                            <textarea name="biography" class="form-control" rows="3"></textarea>
                            <!-- <div class="invalid-feedback">Please enter biography.</div> -->
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <div class="mt-2">
                                <img id="photoPreview" src="" alt="Photo Preview"
                                    style="max-height: 120px; max-width: 150px; object-fit: contain; border: 1px solid #ddd; padding: 4px; border-radius: 6px; display: none;">
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
        // Bootstrap 5 Form Validation
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

        // Edit Teacher Modal Populate
        $('#editteacherModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var designation = button.data('designation');
            var email = button.data('email');
            var phone = button.data('phone');
            var join_date = button.data('join_date');
            var qualification = button.data('qualification');
            var biography = button.data('biography');
            var photo = button.data('photo');

            var form = $('#editteacherForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            form.find('input[name="name"]').val(name);
            form.find('select[name="designation"]').val(designation);
            form.find('input[name="email"]').val(email);
            form.find('input[name="phone"]').val(phone);
            form.find('input[name="join_date"]').val(join_date);
            form.find('input[name="qualification"]').val(qualification);
            form.find('textarea[name="biography"]').val(biography);

            var preview = $('#photoPreview');
            if (photo) {
                preview.attr('src', photo).show();
            } else {
                preview.hide();
            }
        });

        // Live Photo Preview
        document.addEventListener('DOMContentLoaded', function () {
            const addPhotoInput = document.querySelector('#addteacherModal input[name="photo"]');
            const editPhotoInput = document.querySelector('#editteacherModal input[name="photo"]');
            const editPhotoPreview = document.querySelector('#photoPreview');

            if (addPhotoInput) {
                addPhotoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            let preview = addPhotoInput.closest('.mb-3').querySelector('.photo-preview');
                            if (!preview) {
                                preview = document.createElement('div');
                                preview.classList.add('mt-2', 'photo-preview');
                                addPhotoInput.closest('.mb-3').appendChild(preview);
                            }
                            preview.innerHTML = `<img src="${e.target.result}" style="max-height:120px; max-width:150px; object-fit:contain; border:1px solid #ddd; padding:4px; border-radius:6px;">`;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            if (editPhotoInput) {
                editPhotoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            editPhotoPreview.src = e.target.result;
                            editPhotoPreview.style.display = 'block';
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
        function Filters() {
            const query = $('#TeacherSearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#TeacherSearch').on('keyup', Filters);

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