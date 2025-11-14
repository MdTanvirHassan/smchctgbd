@extends('backend.layouts.app')

@section('contents')
    @include('backend.inc.table_css')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-video"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Video Gallery Category</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addVideoGalleryCategoryModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="VideoGalleryCategorySearch" class="form-control form-control-sm"
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
                            @foreach($videogallerycategorys as $videogallerycategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($videogallerycategory->thumbnail_path)
                                            <img src="{{ asset($videogallerycategory->thumbnail_path) }}"
                                                style="width:40px; height:40px; object-fit:cover; border-radius:15%; margin-right:8px;">
                                        @else
                                            <span class="text-muted small">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $videogallerycategory->name }}</td>
                                    <!-- <td>{{ $videogallerycategory->description }}</td> -->
                                    <td class="text-end">
                                        <!-- Edit -->
                                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editVideoGalleryCategoryModal" data-id="{{ $videogallerycategory->id }}"
                                            data-name="{{ $videogallerycategory->name }}"
                                            data-description="{{ $videogallerycategory->description }}"
                                            data-photo="{{ $videogallerycategory->thumbnail_path ? asset($videogallerycategory->thumbnail_path) : '' }}"
                                            data-action="{{ route('videogallerycategory.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('videogallerycategory.destroy', $videogallerycategory->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this video gallery category?')">
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
    <div class="modal fade" id="addVideoGalleryCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addVideoGalleryCategoryForm" class="needs-validation" novalidate
                    action="{{ route('videogallerycategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h6>Add Video Gallery Category</h6>
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
    <div class="modal fade" id="editVideoGalleryCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editVideoGalleryCategoryForm" class="needs-validation" novalidate method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6>Edit Video Gallery Category</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="videogallerycategory_id" id="videogallerycategory_id">
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
        $('#editVideoGalleryCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');
            var photo = button.data('photo');

            var form = $('#editVideoGalleryCategoryForm');
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
            const addPhotoInput = document.querySelector('#addVideoGalleryCategoryModal input[name="photo"]');
            const addPhotoPreviewContainer = document.querySelector('#addVideoGalleryCategoryModal .photo-preview');

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
            const editPhotoInput = document.querySelector('#editVideoGalleryCategoryModal input[name="photo"]');
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
            const query = $('#VideoGalleryCategorySearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#VideoGalleryCategorySearch').on('keyup', Filters);

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

