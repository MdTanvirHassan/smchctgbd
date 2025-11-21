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
            <h6 class="mb-0 fw-bold">Organogram</h6>
        </div>
        <div class="card-body">
            <form action="{{ $organogram ? route('organogram.update', $organogram->id) : route('organogram.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($organogram)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-12">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $organogram->title ?? '' }}" required placeholder="Enter organogram title">
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="6" placeholder="Enter description here...">{{ $organogram->description ?? '' }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="col-md-12">
                        <label class="form-label">Image <span class="text-danger">{{ $organogram ? '' : '*' }}</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" {{ $organogram ? '' : 'required' }}>
                        @if($organogram && $organogram->file_path)
                            <div class="mt-2">
                                <img src="{{ asset($organogram->file_path) }}" alt="Organogram Image" class="img-thumbnail" style="max-width: 400px; max-height: 400px;">
                                <p class="text-muted small mt-2">Current image. Upload a new image to replace it.</p>
                            </div>
                        @endif
                        <small class="text-muted">Upload an image for organogram (Max: 2MB, Formats: jpeg, png, jpg, gif)</small>
                    </div>

                    <!-- Link URL -->
                    <div class="col-md-12">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link_url" class="form-control" value="{{ $organogram->link_url ?? '' }}" placeholder="https://example.com">
                        <small class="text-muted">Optional: Add a link URL if needed</small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ $organogram ? 'Update' : 'Save' }} Organogram
                        </button>
                        @if($organogram)
                            <a href="{{ route('organogram.status', $organogram->id) }}" class="btn btn-{{ $organogram->is_published ? 'success' : 'secondary' }}">
                                {{ $organogram->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $organogram->id }})">
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
                Are you sure you want to delete this organogram? This action cannot be undone.
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
        form.action = '{{ url("/dashboard/organogram") }}/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

