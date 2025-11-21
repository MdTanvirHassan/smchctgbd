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
            <h6 class="mb-0 fw-bold">Application Process</h6>
        </div>
        <div class="card-body">
            <form action="{{ $applicationProcess ? route('application_process.update', $applicationProcess->id) : route('application_process.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($applicationProcess)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-12">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $applicationProcess->title ?? '' }}" required placeholder="Enter application process title">
                    </div>

                    <!-- Link URL -->
                    <div class="col-md-12">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link_url" class="form-control" value="{{ $applicationProcess->link_url ?? '' }}" placeholder="https://example.com">
                        <small class="text-muted">Optional: Add a link URL (e.g., admission circular link, application portal, etc.)</small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ $applicationProcess ? 'Update' : 'Save' }} Application Process
                        </button>
                        @if($applicationProcess)
                            <a href="{{ route('application_process.status', $applicationProcess->id) }}" class="btn btn-{{ $applicationProcess->is_published ? 'success' : 'secondary' }}">
                                {{ $applicationProcess->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $applicationProcess->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        @endif
                    </div>

                     <!-- Primary Image Upload -->
                     <div class="col-md-6">
                        <label class="form-label">Primary Image <span class="text-danger">{{ $applicationProcess ? '' : '*' }}</span></label>
                        <input type="file" name="primary_image" class="form-control" accept="image/*" {{ $applicationProcess ? '' : 'required' }}>
                        @if($applicationProcess && $applicationProcess->file_path)
                            <div class="mt-2">
                                <img src="{{ asset($applicationProcess->file_path) }}" alt="Primary Image" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                <p class="text-muted small mt-2">Current primary image. Upload a new image to replace it.</p>
                            </div>
                        @endif
                        <small class="text-muted">Main image for application process (Max: 2MB, Formats: jpeg, png, jpg, gif)</small>
                    </div>

                    <!-- Secondary Image Upload -->
                    <div class="col-md-6">
                        <label class="form-label">Secondary Image</label>
                        <input type="file" name="secondary_image" class="form-control" accept="image/*">
                        @if($applicationProcess && $applicationProcess->description)
                            <div class="mt-2">
                                <img src="{{ asset($applicationProcess->description) }}" alt="Secondary Image" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                <p class="text-muted small mt-2">Current secondary image. Upload a new image to replace it.</p>
                            </div>
                        @endif
                        <small class="text-muted">Optional secondary image (Max: 2MB, Formats: jpeg, png, jpg, gif)</small>
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
                Are you sure you want to delete this application process? This action cannot be undone.
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
    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("/dashboard/application-process") }}/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

