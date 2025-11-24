@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-bold">Eligibility Criteria of College Campus</h6>
        </div>
        <div class="card-body">
            @php
                $data = $eligibilityCriteria ? json_decode($eligibilityCriteria->description, true) : null;
                $pdfs = $data && isset($data['pdfs']) ? $data['pdfs'] : [];
                // Handle backward compatibility - convert string paths to objects
                if (!empty($pdfs) && is_string($pdfs[0] ?? null)) {
                    $pdfs = array_map(function($path) {
                        return ['path' => $path, 'title' => basename($path)];
                    }, $pdfs);
                }
            @endphp
            <form action="{{ $eligibilityCriteria ? route('eligibility_criteria_of_college_campus.update', $eligibilityCriteria->id) : route('eligibility_criteria_of_college_campus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($eligibilityCriteria)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Image Upload -->
                    <div class="col-md-12">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" {{ $eligibilityCriteria ? '' : 'required' }}>
                        @if($eligibilityCriteria && $eligibilityCriteria->file_path)
                            <div class="mt-2">
                                <img src="{{ asset($eligibilityCriteria->file_path) }}" alt="Eligibility Criteria Image" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                            </div>
                        @endif
                        <small class="text-muted">Upload an image for eligibility criteria (Max: 2MB, Formats: jpeg, png, jpg, gif)</small>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="6" placeholder="Enter description here...">{{ $data['description'] ?? '' }}</textarea>
                    </div>

                    <!-- PDF Uploads Section -->
                    <div class="col-md-12">
                        <label class="form-label">PDF Documents</label>
                        
                        <!-- Existing PDFs -->
                        @if(count($pdfs) > 0)
                            <div class="mb-3" id="existing-pdfs-container">
                                <label class="form-label small text-muted">Existing PDFs:</label>
                                @foreach($pdfs as $index => $pdf)
                                    @php
                                        $pdfPath = is_array($pdf) ? ($pdf['path'] ?? '') : $pdf;
                                        $pdfTitle = is_array($pdf) ? ($pdf['title'] ?? basename($pdfPath)) : basename($pdfPath);
                                    @endphp
                                    <div class="existing-pdf-row mb-3 p-3 border rounded" data-pdf-path="{{ $pdfPath }}">
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <label class="form-label small">PDF Title</label>
                                                <input type="text" name="existing_pdf_titles[{{ $index }}]" class="form-control form-control-sm" value="{{ $pdfTitle }}" placeholder="Enter PDF title">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">PDF File</label>
                                                <div>
                                                    <a href="{{ asset($pdfPath) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fa fa-file-pdf"></i> View PDF
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeExistingPdf(this, '{{ $pdfPath }}')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="existing_pdfs[{{ $index }}]" value="{{ $pdfPath }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- New PDF Upload Fields -->
                        <div id="pdfs-container">
                            <div class="pdf-row mb-3 border p-3 rounded">
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <label class="form-label small">PDF Title</label>
                                        <input type="text" name="pdf_titles[]" class="form-control form-control-sm" placeholder="Enter PDF title">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Upload PDF</label>
                                        <input type="file" name="pdfs[]" class="form-control form-control-sm" accept="application/pdf">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removePdfRow(this)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addPdfRow()">
                            <i class="fa fa-plus"></i> Add PDF
                        </button>
                        <small class="text-muted d-block mt-1">Upload PDF documents (Max: 10MB per file, Format: PDF)</small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ $eligibilityCriteria ? 'Update' : 'Save' }} Eligibility Criteria
                        </button>
                        @if($eligibilityCriteria)
                            <a href="{{ route('eligibility_criteria_of_college_campus.status', $eligibilityCriteria->id) }}" class="btn btn-{{ $eligibilityCriteria->is_published ? 'success' : 'secondary' }}">
                                {{ $eligibilityCriteria->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $eligibilityCriteria->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>
            </form>
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
                Are you sure you want to delete this eligibility criteria? This action cannot be undone.
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
    function addPdfRow() {
        const container = document.getElementById('pdfs-container');
        const newRow = document.createElement('div');
        newRow.className = 'pdf-row mb-3 border p-3 rounded';
        newRow.innerHTML = `
            <div class="row g-2">
                <div class="col-md-5">
                    <label class="form-label small">PDF Title</label>
                    <input type="text" name="pdf_titles[]" class="form-control form-control-sm" placeholder="Enter PDF title">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Upload PDF</label>
                    <input type="file" name="pdfs[]" class="form-control form-control-sm" accept="application/pdf">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removePdfRow(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
    }

    function removePdfRow(button) {
        const row = button.closest('.pdf-row');
        row.remove();
    }

    function removeExistingPdf(button, pdfPath) {
        const row = button.closest('.existing-pdf-row');
        // Change the hidden input to mark it for deletion
        const hiddenInput = row.querySelector('input[name="existing_pdfs[]"]');
        hiddenInput.name = 'deleted_pdfs[]';
        hiddenInput.value = pdfPath;
        // Hide the row visually
        row.style.display = 'none';
    }

    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("/dashboard/eligibility-criteria-of-college-campus") }}/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

