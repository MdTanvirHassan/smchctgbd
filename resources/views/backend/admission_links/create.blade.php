@extends('backend.layouts.app')

@section('contents')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-link"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Add New Admission Link</h6>
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

                <form action="{{ route('admission_links.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold">Admission Links</h6>
                            <button type="button" class="btn btn-success btn-sm" onclick="addLinkEntry()">
                                <i class="fas fa-plus"></i> Add Another Link
                            </button>
                        </div>
                        
                        <div id="linksContainer">
                            <!-- First link entry -->
                            <div class="link-entry card mb-3" data-index="0">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                    <span class="fw-bold">Link #1</span>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeLinkEntry(this)" style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Title -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Link Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('titles.0') is-invalid @enderror" 
                                                       name="titles[]" value="{{ old('titles.0') }}" 
                                                       placeholder="Enter admission link title" required>
                                                @error('titles.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Link URL -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Link URL <span class="text-danger">*</span></label>
                                                <input type="url" class="form-control @error('link_urls.0') is-invalid @enderror" 
                                                       name="link_urls[]" value="{{ old('link_urls.0') }}" 
                                                       placeholder="https://example.com" required>
                                                @error('link_urls.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Description -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Description</label>
                                                <textarea class="form-control @error('descriptions.0') is-invalid @enderror" 
                                                          name="descriptions[]" rows="2" 
                                                          placeholder="Enter link description (optional)">{{ old('descriptions.0') }}</textarea>
                                                @error('descriptions.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- Start Date -->
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Start Date</label>
                                                <input type="date" class="form-control @error('start_dates.0') is-invalid @enderror" 
                                                       name="start_dates[]" value="{{ old('start_dates.0') }}">
                                                @error('start_dates.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- End Date -->
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">End Date</label>
                                                <input type="date" class="form-control @error('end_dates.0') is-invalid @enderror" 
                                                       name="end_dates[]" value="{{ old('end_dates.0') }}">
                                                @error('end_dates.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Status -->
                                            <div class="mb-3">
                                                <label class="form-label text-muted small">Status</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="is_published[]" value="1" checked>
                                                    <label class="form-check-label">
                                                        Published
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Link
                        </button>
                        <a href="{{ route('admission_links.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .link-entry {
            border: 1px solid #e3e6f0;
            transition: all 0.3s ease;
        }
        
        .link-entry:hover {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .link-entry .card-header {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            border-bottom: 1px solid #e3e6f0;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #13855c 0%, #0e6b47 100%);
        }
        
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        @media (max-width: 768px) {
            .card-header .btn {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
        }
    </style>

    <script>
        let linkIndex = 1;

        function addLinkEntry() {
            const container = document.getElementById('linksContainer');
            const newEntry = document.createElement('div');
            newEntry.className = 'link-entry card mb-3';
            newEntry.setAttribute('data-index', linkIndex);
            
            newEntry.innerHTML = `
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <span class="fw-bold">Link #${linkIndex + 1}</span>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeLinkEntry(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" 
                                       name="titles[]" 
                                       placeholder="Enter admission link title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Link URL -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" 
                                       name="link_urls[]" 
                                       placeholder="https://example.com" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea class="form-control" 
                                          name="descriptions[]" rows="2" 
                                          placeholder="Enter link description (optional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <!-- Start Date -->
                            <div class="mb-3">
                                <label class="form-label text-muted small">Start Date</label>
                                <input type="date" class="form-control start-date" name="start_dates[]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- End Date -->
                            <div class="mb-3">
                                <label class="form-label text-muted small">End Date</label>
                                <input type="date" class="form-control end-date" name="end_dates[]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label text-muted small">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_published[]" value="1" checked>
                                    <label class="form-check-label">
                                        Published
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(newEntry);
            linkIndex++;
            
            // Show remove buttons if more than one entry
            updateRemoveButtons();
            
            // Add event listener for auto-setting end date
            setupDateListeners(newEntry);
        }

        function removeLinkEntry(button) {
            const entry = button.closest('.link-entry');
            entry.remove();
            
            // Update link numbers
            updateLinkNumbers();
            
            // Update remove button visibility
            updateRemoveButtons();
        }

        function updateLinkNumbers() {
            const entries = document.querySelectorAll('.link-entry');
            entries.forEach((entry, index) => {
                const header = entry.querySelector('.card-header span');
                header.textContent = `Link #${index + 1}`;
                entry.setAttribute('data-index', index);
            });
        }

        function updateRemoveButtons() {
            const entries = document.querySelectorAll('.link-entry');
            const removeButtons = document.querySelectorAll('.link-entry .btn-danger');
            
            removeButtons.forEach((button, index) => {
                if (entries.length > 1) {
                    button.style.display = 'inline-block';
                } else {
                    button.style.display = 'none';
                }
            });
        }

        function setupDateListeners(container = document) {
            const startDateInputs = container.querySelectorAll('.start-date');
            startDateInputs.forEach(startInput => {
                startInput.addEventListener('change', function() {
                    const startDate = this.value;
                    const endDateInput = this.closest('.row').querySelector('.end-date');
                    
                    if (startDate && !endDateInput.value) {
                        // Set end date to 30 days after start date
                        const start = new Date(startDate);
                        start.setDate(start.getDate() + 30);
                        endDateInput.value = start.toISOString().split('T')[0];
                    }
                });
            });
        }

        // Initialize date listeners for existing entries
        document.addEventListener('DOMContentLoaded', function() {
            setupDateListeners();
            updateRemoveButtons();
            
            // Handle old input values if validation failed
            @if(old('titles'))
                const oldTitles = @json(old('titles', []));
                const oldDescriptions = @json(old('descriptions', []));
                const oldUrls = @json(old('link_urls', []));
                const oldStartDates = @json(old('start_dates', []));
                const oldEndDates = @json(old('end_dates', []));
                const oldPublished = @json(old('is_published', []));
                
                // Add additional entries if there were more than 1
                for (let i = 1; i < oldTitles.length; i++) {
                    addLinkEntry();
                }
                
                // Fill in the old values
                const entries = document.querySelectorAll('.link-entry');
                entries.forEach((entry, index) => {
                    if (oldTitles[index]) {
                        entry.querySelector('input[name="titles[]"]').value = oldTitles[index];
                    }
                    if (oldDescriptions[index]) {
                        entry.querySelector('textarea[name="descriptions[]"]').value = oldDescriptions[index];
                    }
                    if (oldUrls[index]) {
                        entry.querySelector('input[name="link_urls[]"]').value = oldUrls[index];
                    }
                    if (oldStartDates[index]) {
                        entry.querySelector('input[name="start_dates[]"]').value = oldStartDates[index];
                    }
                    if (oldEndDates[index]) {
                        entry.querySelector('input[name="end_dates[]"]').value = oldEndDates[index];
                    }
                    if (oldPublished[index]) {
                        entry.querySelector('input[name="is_published[]"]').checked = true;
                    }
                });
            @endif
        });
    </script>
@endsection
