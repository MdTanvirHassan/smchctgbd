@extends('backend.layouts.app')

@section('contents')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Edit Admission Link</h6>
                </div>
                <a href="{{ route('admission_links.index') }}" class="btn btn-soft-secondary btn-sm rounded-pill">
                    <i class="fas fa-arrow-left"></i> Back to Links
                </a>
            </div>

            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admission_links.update', $admissionLink->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Link Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $admissionLink->title) }}" 
                                       placeholder="Enter admission link title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Enter link description (optional)">{{ old('description', $admissionLink->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Link URL -->
                            <div class="mb-3">
                                <label for="link_url" class="form-label fw-bold">Link URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                       id="link_url" name="link_url" value="{{ old('link_url', $admissionLink->link_url) }}" 
                                       placeholder="https://example.com" required>
                                @error('link_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Duration -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Duration (Optional)</label>
                                
                                <div class="mb-2">
                                    <label for="start_date" class="form-label text-muted small">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date', $admissionLink->start_date) }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label for="end_date" class="form-label text-muted small">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" value="{{ old('end_date', $admissionLink->end_date) }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_published" 
                                           name="is_published" value="1" {{ old('is_published', $admissionLink->is_published) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Published (visible on frontend)
                                    </label>
                                </div>
                            </div>

                            <!-- Current Link Preview -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Link</label>
                                <div class="p-2 bg-light rounded">
                                    <a href="{{ $admissionLink->link_url }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt me-1"></i>
                                        {{ \Illuminate\Support\Str::limit($admissionLink->link_url, 30) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Link
                        </button>
                        <a href="{{ route('admission_links.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-set end date when start date is selected
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('end_date');
            
            if (startDate && !endDateInput.value) {
                // Set end date to 30 days after start date
                const start = new Date(startDate);
                start.setDate(start.getDate() + 30);
                endDateInput.value = start.toISOString().split('T')[0];
            }
        });
    </script>
@endsection
