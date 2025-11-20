@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="departmentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-dark" id="indoor-patient-tab" data-bs-toggle="tab" data-bs-target="#indoor-patient" type="button" role="tab">
                Indoor Patient Department
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="out-patient-tab" data-bs-toggle="tab" data-bs-target="#out-patient" type="button" role="tab">
                Out Patient Department
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="departmentTabsContent">
        <!-- Indoor Patient Department -->
        <div class="tab-pane fade show active" id="indoor-patient" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Indoor Patient Department</h6>
                </div>
                <div class="card-body">
                    @php
                        $indoorData = $indoorPatient ? json_decode($indoorPatient->description, true) : null;
                        $indoorCategories = $indoorData && isset($indoorData['categories']) ? $indoorData['categories'] : [];
                    @endphp
                    <form action="{{ $indoorPatient ? route('hospital_department.update', ['department' => 'indoor_patient_department', 'id' => $indoorPatient->id]) : route('hospital_department.store', 'indoor_patient_department') }}" method="POST" enctype="multipart/form-data" id="indoor-form">
                        @csrf
                        @if($indoorPatient)
                            @method('PUT')
                        @endif

                        <div id="indoor-categories-container">
                            @if(count($indoorCategories) > 0)
                                @foreach($indoorCategories as $catIndex => $category)
                                    <div class="category-item mb-4 border p-4 rounded" data-category-index="{{ $catIndex }}">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Category {{ $catIndex + 1 }}</h6>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeCategory(this, 'indoor')">
                                                <i class="fa fa-trash"></i> Remove Category
                                            </button>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="categories[{{ $catIndex }}][name]" class="form-control" value="{{ $category['name'] ?? '' }}" required>
                                        </div>

                                        <!-- Existing Images -->
                                        @if(isset($category['images']) && count($category['images']) > 0)
                                            <div class="mb-3">
                                                <label class="form-label">Existing Images ({{ count($category['images']) }}) - Click X to remove</label>
                                                <div class="row g-2" id="indoor-existing-images-{{ $catIndex }}">
                                                    @foreach($category['images'] as $imgIndex => $image)
                                                        <div class="col-md-3 existing-image-item">
                                                            <div class="position-relative border rounded p-2">
                                                                <img src="{{ asset($image) }}" alt="Category Image" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                                                                <input type="hidden" name="categories[{{ $catIndex }}][existing_images][]" value="{{ $image }}">
                                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removeExistingImage(this)" title="Remove this image">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- New Image Upload Section -->
                                        <div class="mb-3 border-top pt-3">
                                            <label class="form-label fw-bold">Add New Images to This Category</label>
                                            <div id="indoor-upload-container-{{ $catIndex }}">
                                                <div class="mb-2">
                                                    <input type="file" name="categories[{{ $catIndex }}][images][]" class="form-control image-upload-input" accept="image/*" multiple onchange="previewNewImages(this, 'indoor', {{ $catIndex }})">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-info" onclick="addMoreImageInput('indoor', {{ $catIndex }})">
                                                <i class="fa fa-plus"></i> Add More Image Fields
                                            </button>
                                            <small class="text-muted d-block mt-2">
                                                <i class="fa fa-info-circle"></i> You can select multiple images in one field, or add more fields to upload in batches
                                            </small>
                                        </div>

                                        <!-- Preview New Images -->
                                        <div class="mb-3">
                                            <label class="form-label">Preview New Images ({{ count($category['images'] ?? []) > 0 ? 'will be added to existing' : '' }})</label>
                                            <div class="row g-2" id="indoor-preview-{{ $catIndex }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="category-item mb-4 border p-4 rounded" data-category-index="0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Category 1</h6>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeCategory(this, 'indoor')">
                                            <i class="fa fa-trash"></i> Remove Category
                                        </button>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="categories[0][name]" class="form-control" required>
                                    </div>

                                    <div class="mb-3 border-top pt-3">
                                        <label class="form-label fw-bold">Add Images to This Category</label>
                                        <div id="indoor-upload-container-0">
                                            <div class="mb-2">
                                                <input type="file" name="categories[0][images][]" class="form-control image-upload-input" accept="image/*" multiple onchange="previewNewImages(this, 'indoor', 0)">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-info" onclick="addMoreImageInput('indoor', 0)">
                                            <i class="fa fa-plus"></i> Add More Image Fields
                                        </button>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fa fa-info-circle"></i> You can select multiple images in one field, or add more fields to upload in batches
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Preview Images</label>
                                        <div class="row g-2" id="indoor-preview-0"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-success" onclick="addCategory('indoor')">
                                <i class="fa fa-plus"></i> Add Category
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> {{ $indoorPatient ? 'Update' : 'Save' }} Indoor Patient Department
                            </button>
                            @if($indoorPatient)
                                <a href="{{ route('hospital_department.status', $indoorPatient->id) }}" class="btn btn-{{ $indoorPatient->is_published ? 'success' : 'secondary' }}">
                                    {{ $indoorPatient->is_published ? 'Published' : 'Unpublished' }}
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $indoorPatient->id }}, 'indoor')">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Out Patient Department -->
        <div class="tab-pane fade" id="out-patient" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Out Patient Department</h6>
                </div>
                <div class="card-body">
                    @php
                        $outData = $outPatient ? json_decode($outPatient->description, true) : null;
                        $outCategories = $outData && isset($outData['categories']) ? $outData['categories'] : [];
                    @endphp
                    <form action="{{ $outPatient ? route('hospital_department.update', ['department' => 'out_patient_department', 'id' => $outPatient->id]) : route('hospital_department.store', 'out_patient_department') }}" method="POST" enctype="multipart/form-data" id="out-form">
                        @csrf
                        @if($outPatient)
                            @method('PUT')
                        @endif

                        <div id="out-categories-container">
                            @if(count($outCategories) > 0)
                                @foreach($outCategories as $catIndex => $category)
                                    <div class="category-item mb-4 border p-4 rounded" data-category-index="{{ $catIndex }}">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Category {{ $catIndex + 1 }}</h6>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeCategory(this, 'out')">
                                                <i class="fa fa-trash"></i> Remove Category
                                            </button>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="categories[{{ $catIndex }}][name]" class="form-control" value="{{ $category['name'] ?? '' }}" required>
                                        </div>

                                        <!-- Existing Images -->
                                        @if(isset($category['images']) && count($category['images']) > 0)
                                            <div class="mb-3">
                                                <label class="form-label">Existing Images ({{ count($category['images']) }}) - Click X to remove</label>
                                                <div class="row g-2" id="out-existing-images-{{ $catIndex }}">
                                                    @foreach($category['images'] as $imgIndex => $image)
                                                        <div class="col-md-3 existing-image-item">
                                                            <div class="position-relative border rounded p-2">
                                                                <img src="{{ asset($image) }}" alt="Category Image" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                                                                <input type="hidden" name="categories[{{ $catIndex }}][existing_images][]" value="{{ $image }}">
                                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removeExistingImage(this)" title="Remove this image">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- New Image Upload Section -->
                                        <div class="mb-3 border-top pt-3">
                                            <label class="form-label fw-bold">Add New Images to This Category</label>
                                            <div id="out-upload-container-{{ $catIndex }}">
                                                <div class="mb-2">
                                                    <input type="file" name="categories[{{ $catIndex }}][images][]" class="form-control image-upload-input" accept="image/*" multiple onchange="previewNewImages(this, 'out', {{ $catIndex }})">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-info" onclick="addMoreImageInput('out', {{ $catIndex }})">
                                                <i class="fa fa-plus"></i> Add More Image Fields
                                            </button>
                                            <small class="text-muted d-block mt-2">
                                                <i class="fa fa-info-circle"></i> You can select multiple images in one field, or add more fields to upload in batches
                                            </small>
                                        </div>

                                        <!-- Preview New Images -->
                                        <div class="mb-3">
                                            <label class="form-label">Preview New Images ({{ count($category['images'] ?? []) > 0 ? 'will be added to existing' : '' }})</label>
                                            <div class="row g-2" id="out-preview-{{ $catIndex }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="category-item mb-4 border p-4 rounded" data-category-index="0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Category 1</h6>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeCategory(this, 'out')">
                                            <i class="fa fa-trash"></i> Remove Category
                                        </button>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="categories[0][name]" class="form-control" required>
                                    </div>

                                    <div class="mb-3 border-top pt-3">
                                        <label class="form-label fw-bold">Add Images to This Category</label>
                                        <div id="out-upload-container-0">
                                            <div class="mb-2">
                                                <input type="file" name="categories[0][images][]" class="form-control image-upload-input" accept="image/*" multiple onchange="previewNewImages(this, 'out', 0)">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-info" onclick="addMoreImageInput('out', 0)">
                                            <i class="fa fa-plus"></i> Add More Image Fields
                                        </button>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fa fa-info-circle"></i> You can select multiple images in one field, or add more fields to upload in batches
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Preview Images</label>
                                        <div class="row g-2" id="out-preview-0"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-success" onclick="addCategory('out')">
                                <i class="fa fa-plus"></i> Add Category
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> {{ $outPatient ? 'Update' : 'Save' }} Out Patient Department
                            </button>
                            @if($outPatient)
                                <a href="{{ route('hospital_department.status', $outPatient->id) }}" class="btn btn-{{ $outPatient->is_published ? 'success' : 'secondary' }}">
                                    {{ $outPatient->is_published ? 'Published' : 'Unpublished' }}
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $outPatient->id }}, 'out')">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this department? This action cannot be undone and will delete all categories and images.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let indoorCategoryIndex = {{ count($indoorCategories) > 0 ? count($indoorCategories) : 1 }};
    let outCategoryIndex = {{ count($outCategories) > 0 ? count($outCategories) : 1 }};

    function addCategory(type) {
        const container = document.getElementById(type + '-categories-container');
        const categoryIndex = type === 'indoor' ? indoorCategoryIndex : outCategoryIndex;
        
        const newCategory = document.createElement('div');
        newCategory.className = 'category-item mb-4 border p-4 rounded';
        newCategory.setAttribute('data-category-index', categoryIndex);
        newCategory.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Category ${categoryIndex + 1}</h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeCategory(this, '${type}')">
                    <i class="fa fa-trash"></i> Remove Category
                </button>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="categories[${categoryIndex}][name]" class="form-control" required>
            </div>

            <div class="mb-3 border-top pt-3">
                <label class="form-label fw-bold">Add Images to This Category</label>
                <div id="${type}-upload-container-${categoryIndex}">
                    <div class="mb-2">
                        <input type="file" name="categories[${categoryIndex}][images][]" class="form-control image-upload-input" accept="image/*" multiple onchange="previewNewImages(this, '${type}', ${categoryIndex})">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-info" onclick="addMoreImageInput('${type}', ${categoryIndex})">
                    <i class="fa fa-plus"></i> Add More Image Fields
                </button>
                <small class="text-muted d-block mt-2">
                    <i class="fa fa-info-circle"></i> You can select multiple images in one field, or add more fields to upload in batches
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Preview Images</label>
                <div class="row g-2" id="${type}-preview-${categoryIndex}"></div>
            </div>
        `;
        
        container.appendChild(newCategory);
        
        if (type === 'indoor') {
            indoorCategoryIndex++;
        } else {
            outCategoryIndex++;
        }
    }

    function removeCategory(button, type) {
        const container = document.getElementById(type + '-categories-container');
        const categoryItems = container.querySelectorAll('.category-item');
        
        if (categoryItems.length <= 1) {
            alert('You must have at least one category.');
            return;
        }
        
        const categoryItem = button.closest('.category-item');
        categoryItem.remove();
        
        // Reindex categories
        reindexCategories(type);
    }

    function reindexCategories(type) {
        const container = document.getElementById(type + '-categories-container');
        const categoryItems = container.querySelectorAll('.category-item');
        
        categoryItems.forEach((item, index) => {
            item.setAttribute('data-category-index', index);
            const nameInput = item.querySelector('input[type="text"]');
            const fileInput = item.querySelector('input[type="file"]');
            const previewDiv = item.querySelector(`#${type}-preview-${item.getAttribute('data-category-index')}`);
            
            if (nameInput) {
                nameInput.name = `categories[${index}][name]`;
            }
            if (fileInput) {
                fileInput.name = `categories[${index}][images][]`;
                fileInput.setAttribute('onchange', `previewNewImages(this, '${type}', ${index})`);
            }
            if (previewDiv) {
                previewDiv.id = `${type}-preview-${index}`;
            }
            
            const heading = item.querySelector('h6');
            if (heading) {
                heading.textContent = `Category ${index + 1}`;
            }
        });
    }

    function previewNewImages(input, type, categoryIndex) {
        const previewDiv = document.getElementById(`${type}-preview-${categoryIndex}`);
        previewDiv.innerHTML = '';
        
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3';
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removePreviewImage(this, '${type}', ${categoryIndex}, ${index})">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewDiv.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function removePreviewImage(button, type, categoryIndex, imageIndex) {
        const previewDiv = document.getElementById(`${type}-preview-${categoryIndex}`);
        const imageCol = button.closest('.col-md-3');
        imageCol.remove();
        
        // Remove file from input
        const fileInput = button.closest('.category-item').querySelector('input[type="file"]');
        const dt = new DataTransfer();
        const files = Array.from(fileInput.files);
        files.splice(imageIndex, 1);
        files.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    function removeExistingImage(button) {
        if (confirm('Are you sure you want to remove this image? It will be deleted when you save.')) {
            const imageItem = button.closest('.existing-image-item');
            imageItem.remove();
        }
    }

    function addMoreImageInput(type, categoryIndex) {
        const container = document.getElementById(`${type}-upload-container-${categoryIndex}`);
        const newInputDiv = document.createElement('div');
        newInputDiv.className = 'mb-2 d-flex align-items-center gap-2';
        newInputDiv.innerHTML = `
            <input type="file" name="categories[${categoryIndex}][images][]" class="form-control image-upload-input" accept="image/*" multiple onchange="previewNewImages(this, '${type}', ${categoryIndex})">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeImageInput(this)">
                <i class="fa fa-times"></i>
            </button>
        `;
        container.appendChild(newInputDiv);
    }

    function removeImageInput(button) {
        const inputDiv = button.closest('.mb-2');
        inputDiv.remove();
    }

    function confirmDelete(id, type) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("/dashboard/hospital-department") }}/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

