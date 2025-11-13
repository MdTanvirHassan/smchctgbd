@extends('backend.layouts.app')

@section('contents')
    <style>
        /* Soft, subtle borders for a cleaner look */
        .table td,
        .table th {
            border-color: rgba(0, 0, 0, 0.05) !important;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .card-header {
            height: 65px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .modal-content {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }
    </style>

    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Students</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addstudentModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                <th class="py-2">SL.</th>
                                <th class="py-2">Name</th>
                                <th class="py-2">Class</th>
                                <th class="py-2">Roll</th>
                                <th class="py-2">Contact</th>
                                <th class="text-end py-2">Action</th>
                            </tr>
                        </thead>

                        <tbody class="small text-muted">
                            @foreach($students as $key => $student)
                                <tr>
                                    <td>{{ $students->firstItem() + $key }}</td>
                                    <td>
                                        <img src="{{ asset($student->photo_path) }}"
                                            style="width:40px; height:40px; object-fit:cover; border-radius:15%; margin-right:8px;">
                                        {{ $student->name }}
                                    </td>
                                    <td>{{ $student->studentClass->name }}</td>
                                    <td>{{ $student->roll_number}}</td>
                                    <td>{{ $student->guardian_contact}}</td>
                                    <td class="text-end">

                                        <!-- Edit button -->
                                        <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-student"
                                            data-action="{{ route('student.update', ':id') }}" data-bs-toggle="modal"
                                            data-bs-target="#editstudentModal" data-id="{{ $student->id }}"
                                            data-name="{{ $student->name }}" data-class="{{ $student->class_id }}"
                                            data-email="{{ $student->email }}" data-phone="{{ $student->phone }}"
                                            data-join_date="{{ $student->join_date }}"
                                            data-qualification="{{ $student->qualification }}"
                                            data-biography="{{ $student->biography }}"
                                            data-photo="{{ asset($student->photo_path) }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('student.destroy', $student->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this student?');">
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
            </div>
        </div>
    </div>

    <!-- Add New student Modal -->
    <div class="modal fade" id="addstudentModal" tabindex="-1" aria-labelledby="addstudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form class="needs-validation" action="{{ route('student.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="addstudentModalLabel">
                            <i class="fas fa-user-plus me-1"></i> Add New Student
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body small text-muted">

                        {{-- Row 1: Name & Class --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">Please enter the student name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                                <select name="class" class="form-select form-select-sm" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a class.</div>
                            </div>
                        </div>

                        {{-- Row 2: Email & Phone --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control">
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control">
                                <div class="invalid-feedback">Please enter phone number.</div>
                            </div>
                        </div>

                        {{-- Row 3: Join Date & Qualification --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Joining Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="join_date" class="form-control" required>
                                <div class="invalid-feedback">Please select joining date.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Qualification <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="qualification" class="form-control" required>
                                <div class="invalid-feedback">Please enter qualification.</div>
                            </div>
                        </div>

                        {{-- Biography --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Biography <span class="text-danger">*</span></label>
                            <textarea name="biography" class="form-control" rows="3" required></textarea>
                            <div class="invalid-feedback">Please enter biography.</div>
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Photo <span class="text-danger">*</span></label>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                            <div class="invalid-feedback">Please upload a photo.</div>
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

    <!-- Single Edit student Modal -->
    <div class="modal fade" id="editstudentModal" tabindex="-1" aria-labelledby="editstudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded border-0 shadow-sm">
                <form id="editstudentForm" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0">
                        <h6 class="modal-title text-muted fw-semibold" id="editstudentModalLabel">Edit student</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body small text-muted">

                        {{-- Row 1: Name & Class --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">Please enter the student name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                                <select name="class" class="form-select form-select-sm" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a class.</div>
                            </div>
                        </div>

                        {{-- Row 2: Email & Phone --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control">
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control">
                                <div class="invalid-feedback">Please enter phone number.</div>
                            </div>
                        </div>

                        {{-- Row 3: Join Date & Qualification --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Joining Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="join_date" class="form-control" required>
                                <div class="invalid-feedback">Please select joining date.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Qualification <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="qualification" class="form-control" required>
                                <div class="invalid-feedback">Please enter qualification.</div>
                            </div>
                        </div>

                        {{-- Biography --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Biography <span class="text-danger">*</span></label>
                            <textarea name="biography" class="form-control" rows="3" required></textarea>
                            <div class="invalid-feedback">Please enter biography.</div>
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Photo <span class="text-danger">*</span></label>
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

        // Edit modal setup
        $('#editstudentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var id = button.data('id');
            var name = button.data('name');
            var classId = button.data('class');
            var email = button.data('email');
            var phone = button.data('phone');
            var join_date = button.data('join_date');
            var qualification = button.data('qualification');
            var biography = button.data('biography');
            var photo = button.data('photo');

            var form = $('#editstudentForm');

            // Replace :id in the data-action URL
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            // Fill inputs
            form.find('input[name="name"]').val(name);
            form.find('select[name="class"]').val(classId);
            form.find('input[name="email"]').val(email);
            form.find('input[name="phone"]').val(phone);
            form.find('input[name="join_date"]').val(join_date);
            form.find('input[name="qualification"]').val(qualification);
            form.find('textarea[name="biography"]').val(biography);

            // Set photo preview
            var preview = $('#photoPreview');
            if (photo) {
                preview.attr('src', photo).show();
            } else {
                preview.hide();
            }
        });
    </script>
@endsection