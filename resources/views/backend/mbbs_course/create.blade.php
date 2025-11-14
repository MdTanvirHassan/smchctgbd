@extends('backend.layouts.app')

@section('contents')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Add MBBS Course Category with Subcategories</h6>
                </div>
                <a href="{{ route('mbbs-course.index') }}" class="btn btn-soft-secondary btn-sm rounded-pill">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validation Errors:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('mbbs-course.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Parent Category Section -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-folder"></i> Parent Category</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="parent_name" class="form-label">Parent Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                           id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required>
                                    @error('parent_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please provide a parent category name.</div>
                                    @enderror
                                    <small class="text-muted">e.g., "1st Professional MBBS Course", "2nd Professional MBBS Course"</small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="parent_description" class="form-label">Parent Category Description</label>
                                    <textarea class="form-control @error('parent_description') is-invalid @enderror" 
                                              id="parent_description" name="parent_description" rows="3">{{ old('parent_description') }}</textarea>
                                    @error('parent_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="parent_order" class="form-label">Order</label>
                                    <input type="number" class="form-control @error('parent_order') is-invalid @enderror" 
                                           id="parent_order" name="parent_order" value="{{ old('parent_order', 0) }}" min="0">
                                    @error('parent_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Lower numbers appear first.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="parent_is_active" 
                                               name="parent_is_active" {{ old('parent_is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="parent_is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Child Categories Section -->
                    <div class="card border-info">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-list"></i> Child Categories (Subcategories)</h6>
                            <button type="button" class="btn btn-sm btn-light" id="addChildRow">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="childCategoriesContainer">
                                <!-- Dynamic child category rows will be added here -->
                                <div class="child-row mb-3 p-3 border rounded">
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <label class="form-label">Child Category Name</label>
                                            <input type="text" class="form-control child-name" 
                                                   name="child_names[]" placeholder="e.g., Department of Anatomy">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Description (Optional)</label>
                                            <input type="text" class="form-control child-description" 
                                                   name="child_descriptions[]" placeholder="Brief description">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Order</label>
                                            <input type="number" class="form-control child-order" 
                                                   name="child_orders[]" value="1" min="0">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input child-active" type="checkbox" 
                                                       name="child_is_active[]" value="1" checked>
                                                <label class="form-check-label">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-muted small mt-2">
                                <i class="fas fa-info-circle"></i> Leave child category name empty if you don't want to add that subcategory.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('mbbs-course.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Parent & Child Categories
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Add child category row
        let rowCounter = 1;
        document.getElementById('addChildRow').addEventListener('click', function() {
            rowCounter++;
            const container = document.getElementById('childCategoriesContainer');
            const newRow = document.createElement('div');
            newRow.className = 'child-row mb-3 p-3 border rounded';
            newRow.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-5">
                        <label class="form-label">Child Category Name</label>
                        <input type="text" class="form-control child-name" 
                               name="child_names[]" placeholder="e.g., Department of Anatomy">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Description (Optional)</label>
                        <input type="text" class="form-control child-description" 
                               name="child_descriptions[]" placeholder="Brief description">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Order</label>
                        <input type="number" class="form-control child-order" 
                               name="child_orders[]" value="${rowCounter}" min="0">
                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input child-active" type="checkbox" 
                                                   name="child_is_active[]" value="1" checked>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger mt-2 remove-row">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                </div>
            `;
            container.appendChild(newRow);

            // Add remove functionality
            newRow.querySelector('.remove-row').addEventListener('click', function() {
                newRow.remove();
            });
        });

        // Remove row functionality for existing rows
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
                const btn = e.target.classList.contains('remove-row') ? e.target : e.target.closest('.remove-row');
                const row = btn.closest('.child-row');
                if (row && document.querySelectorAll('.child-row').length > 1) {
                    row.remove();
                } else {
                    alert('You must have at least one child category row.');
                }
            }
        });
    </script>
@endsection

