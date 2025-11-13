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
                    <h6 class="mb-0 fw-bold">Gallery Category</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addGalleryCategoryModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="GalleryCategorySearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <!-- <th>Description</th> -->
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gallerycategorys as $gallerycategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($gallerycategory->thumbnail_path) }}"
                                            style="width:40px; height:40px; object-fit:cover; border-radius:15%; margin-right:8px;">

                                    </td>
                                    <td>{{ $gallerycategory->name }}</td>
                                    <!-- <td>{{ $gallerycategory->description }}</td> -->
                                    <td class="text-end">
                                        <!-- Edit -->
                                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editGalleryCategoryModal" data-id="{{ $gallerycategory->id }}"
                                            data-name="{{ $gallerycategory->name }}"
                                            data-description="{{ $gallerycategory->description }}"
                                            data-photo="{{ asset($gallerycategory->thumbnail_path) }}"
                                            data-action="{{ route('gallerycategory.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('gallerycategory.destroy', $gallerycategory->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this gallery category?')">
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
    <div class="modal fade" id="addGalleryCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addGalleryCategoryForm" class="needs-validation" novalidate
                    action="{{ route('gallerycategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h6>Add Gallery Category</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                            <div class="invalid-feedback">Please enter a category name.</div>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                            <div class="invalid-feedback">Please upload a category photo.</div>
                        </div>
                        <div class="mt-2 photo-preview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editGalleryCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editGalleryCategoryForm" class="needs-validation" novalidate method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6>Edit Gallery Category</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="gallerycategory_id" id="gallerycategory_id">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                            <div class="invalid-feedback">Please enter a category name.</div>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" id="edit_description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo" id="edit_photo" class="form-control" accept="image/*">
                        </div>
                        <div class="mt-2">
                            <img id="photoPreview" src="" alt="Photo Preview"
                                style="max-height: 120px; max-width: 150px; object-fit: contain; border: 1px solid #ddd; padding: 4px; border-radius: 6px; display: none;">
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
        // Bootstrap 5 form validation
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

        // Edit modal populate
        $('#editGalleryCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');
            var photo = button.data('photo');

            var form = $('#editGalleryCategoryForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            form.find('input[name="name"]').val(name);
            form.find('textarea[name="description"]').val(description);

            var preview = $('#photoPreview');
            if (photo) {
                preview.attr('src', photo).show();
            } else {
                preview.hide();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Add photo live preview
            const addPhotoInput = document.querySelector('#addGalleryCategoryModal input[name="photo"]');
            const addPhotoPreviewContainer = document.querySelector('#addGalleryCategoryModal .photo-preview');

            if (addPhotoInput) {
                addPhotoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            addPhotoPreviewContainer.innerHTML = `<img src="${e.target.result}" style="max-height:120px; max-width:150px; object-fit:contain; border:1px solid #ddd; padding:4px; border-radius:6px;">`;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Edit photo live preview
            const editPhotoInput = document.querySelector('#editGalleryCategoryModal input[name="photo"]');
            const editPhotoPreview = document.querySelector('#photoPreview');
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
            const query = $('#GalleryCategorySearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#GalleryCategorySearch').on('keyup', Filters);

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