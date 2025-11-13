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
                    <h6 class="mb-0 fw-bold">Gallery Image</h6>
                </div>
                <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addGalleryImageModal">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="GalleryImageSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL.</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Caption</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($galleryimages as $galleryimage)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($galleryimage->file_path) }}"
                                            style="width:40px; height:40px; object-fit:cover; border-radius:15%;">
                                    </td>
                                    <td>{{ $galleryimage->title }}</td>
                                    <td>{{ $galleryimage->category->name ?? 'N/A' }}</td>
                                    <td>{{ $galleryimage->caption }}</td>
                                    <td class="text-end">
                                        <!-- Edit -->
                                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editGalleryImageModal" data-id="{{ $galleryimage->id }}"
                                            data-title="{{ $galleryimage->title }}" data-caption="{{ $galleryimage->caption }}"
                                            data-category="{{ $galleryimage->category_id }}"
                                            data-active="{{ $galleryimage->is_active }}"
                                            data-photo="{{ asset($galleryimage->file_path) }}"
                                            data-action="{{ route('galleryimage.update', ':id') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('galleryimage.destroy', $galleryimage->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this gallery image?')">
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
    <div class="modal fade" id="addGalleryImageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addGalleryImageForm" class="needs-validation" novalidate
                    action="{{ route('galleryimage.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h6>Add Gallery Image</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                            <div class="invalid-feedback">Please enter the title.</div>
                        </div>

                        <div class="mb-3">
                            <label>Caption</label>
                            <textarea name="caption" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($gallerycategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        <div class="mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                            <div class="invalid-feedback">Please upload a photo.</div>
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
    <div class="modal fade" id="editGalleryImageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editGalleryImageForm" class="needs-validation" novalidate method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6>Edit Gallery Image</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="galleryimage_id" id="galleryimage_id">

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                            <div class="invalid-feedback">Please enter the title.</div>
                        </div>

                        <div class="mb-3">
                            <label>Caption</label>
                            <textarea name="caption" id="edit_caption" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category_id" id="edit_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($gallerycategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
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
        // Bootstrap 5 validation
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

        // Edit Modal Data
        $('#editGalleryImageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var caption = button.data('caption');
            var category = button.data('category');
            var is_active = button.data('active');
            var photo = button.data('photo');

            var form = $('#editGalleryImageForm');
            var action = button.data('action').replace(':id', id);
            form.attr('action', action);

            $('#edit_title').val(title);
            $('#edit_caption').val(caption);
            $('#edit_category_id').val(category);

            var preview = $('#photoPreview');
            if (photo) {
                preview.attr('src', photo).show();
            } else {
                preview.hide();
            }
        });

        // Image Live Preview
        document.addEventListener('DOMContentLoaded', function () {
            const addPhotoInput = document.querySelector('#addGalleryImageModal input[name="photo"]');
            const editPhotoInput = document.querySelector('#editGalleryImageModal input[name="photo"]');
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
            const query = $('#GalleryImageSearch').val().toLowerCase();

            $('table tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                const matchesSearch = rowText.indexOf(query) !== -1;
                $(this).toggle(matchesSearch);
            });
        }

        // Trigger search
        $('#GalleryImageSearch').on('keyup', Filters);

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