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
                $links = $data && isset($data['links']) ? $data['links'] : [];
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

                    <!-- Links Section -->
                    <div class="col-md-12">
                        <label class="form-label">Links</label>
                        <div id="links-container">
                            @if(count($links) > 0)
                                @foreach($links as $index => $link)
                                    <div class="link-row mb-3 border p-3 rounded">
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <label class="form-label small">Link Title</label>
                                                <input type="text" name="links[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $link['title'] ?? '' }}" placeholder="Enter link title">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Link URL</label>
                                                <input type="url" name="links[{{ $index }}][url]" class="form-control form-control-sm" value="{{ $link['url'] ?? '' }}" placeholder="https://example.com">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-link" onclick="removeLinkRow(this)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="link-row mb-3 border p-3 rounded">
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <label class="form-label small">Link Title</label>
                                            <input type="text" name="links[0][title]" class="form-control form-control-sm" placeholder="Enter link title">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small">Link URL</label>
                                            <input type="url" name="links[0][url]" class="form-control form-control-sm" placeholder="https://example.com">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-link" onclick="removeLinkRow(this)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addLinkRow()">
                            <i class="fa fa-plus"></i> Add Link
                        </button>
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
    let linkIndex = {{ count($links) > 0 ? count($links) : 1 }};

    function addLinkRow() {
        const container = document.getElementById('links-container');
        const newRow = document.createElement('div');
        newRow.className = 'link-row mb-3 border p-3 rounded';
        newRow.innerHTML = `
            <div class="row g-2">
                <div class="col-md-5">
                    <label class="form-label small">Link Title</label>
                    <input type="text" name="links[${linkIndex}][title]" class="form-control form-control-sm" placeholder="Enter link title">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Link URL</label>
                    <input type="url" name="links[${linkIndex}][url]" class="form-control form-control-sm" placeholder="https://example.com">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-link" onclick="removeLinkRow(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        linkIndex++;
    }

    function removeLinkRow(button) {
        const row = button.closest('.link-row');
        row.remove();
    }

    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("/dashboard/eligibility-criteria-of-college-campus") }}/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

