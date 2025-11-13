@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="fas fa-cogs fs-4"></i>
            </div>
            <h5 class="mb-0 fw-bold">Site Settings</h5>
        </div>

        <form action="{{ route('site.setting.update') }}" method="POST" enctype="multipart/form-data" class="card-body" novalidate>
            @csrf

            @php
            $imageFields = [
            'school_logo' => 'Institution Logo',
            'left_logo' => 'Left Logo',
            'right_logo' => 'Right Logo',
            ];
            $textFields = [
            'school_name' => 'Institution Name',
            'school_eiin' => 'EIIN',
            'school_est' => 'Established',
            'site_title' => 'Site Title',
            'school_address' => 'Address',
            'school_phone' => 'Phone',
            'school_email' => 'Email',
            ];
            $otherFields = [
            'facebook_link' => 'Facebook',
            'instagram_link' => 'Instagram',
            'youtube_link' => 'Youtube',
            ];


            @endphp

            {{-- Logo Section --}}
            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Logos</h6>
                <div class="row g-3">
                    @foreach ($imageFields as $field => $label)
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold d-block">{{ $label }}</label>
                        <input type="hidden" name="types[]" value="{{ $field }}">
                        <input type="file" name="{{ $field }}_file" class="form-control form-control-sm mb-2 preview-image-input" accept="image/*" data-preview-target="#preview-{{ $field }}">
                        <input type="hidden" name="{{ $field }}" value="{{ get_setting($field) }}">
                        <div id="preview-{{ $field }}" class="image-preview-box border rounded overflow-hidden d-flex justify-content-center align-items-center" style="height: 120px; background: #fff;">
                            @if(get_setting($field))
                            <img src="{{ asset(get_setting($field)) }}" alt="{{ $label }}" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                            @else
                            <span class="text-muted small">No Image</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- General Info Section --}}
            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">General Information</h6>
                <div class="row g-3">
                    @foreach ($textFields as $field => $label)
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" placeholder="{{ $label }}" value="{{ old($field, get_setting($field)) }}">
                            <label for="{{ $field }}">{{ $label }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>


            {{-- Other Info Section --}}
            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Other Information</h6>
                <div class="row g-3">
                    @foreach ($otherFields as $field => $label)
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" placeholder="{{ $label }}" value="{{ old($field, get_setting($field)) }}">
                            <label for="{{ $field }}">{{ $label }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>


                @php
                $quickLinksRaw = json_decode(get_setting('quick_links', '{}'), true) ?? [];
                $titles = $quickLinksRaw['title'] ?? [];
                $urls = $quickLinksRaw['url'] ?? [];

                // If no saved links, prepare one empty item for UI
                if (empty($titles) && empty($urls)) {
                $titles = [''];
                $urls = [''];
                }
                @endphp

                {{-- Quick Links Section --}}
                <div class="mt-4">
                    <h6 class="fw-semibold text-secondary">Quick Links</h6>
                    <input type="hidden" name="types[]" value="quick_links">

                    <div id="quickLinksContainer">
                        @foreach ($titles as $i => $title)
                        <div class="row g-2 mb-2 align-items-center quick-link-row">
                            <div class="col-md-5">
                                <input type="text" name="quick_links[title][]" class="form-control"
                                    placeholder="Title" value="{{ old("quick_links.title.$i", $title) }}">
                            </div>
                            <div class="col-md-6">
                                <input type="url" name="quick_links[url][]" class="form-control"
                                    placeholder="URL" value="{{ old("quick_links.url.$i", $urls[$i] ?? '') }}">
                            </div>
                            <div class="col-md-1 d-grid">
                                <button type="button" class="btn btn-outline-danger remove-link" title="Remove this link">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-2">
                        <button type="button" id="addQuickLink" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-lg"></i> Add Link
                        </button>
                    </div>
                </div>

            </section>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4 py-2 fs-6 fw-semibold">Save Settings</button>
            </div>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.preview-image-input');
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.dataset.previewTarget;
                const previewBox = document.querySelector(previewId);
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewBox.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-fluid" style="max-height: 80px; object-fit: contain;">`;
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewBox.innerHTML = '<span class="text-muted small">No Image</span>';
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('quickLinksContainer');
        const addBtn = document.getElementById('addQuickLink');

        addBtn.addEventListener('click', () => {
            const row = `
            <div class="row g-2 mb-2 align-items-center quick-link-row">
                <div class="col-md-5">
                    <input type="text" name="quick_links[title][]" class="form-control" placeholder="Title">
                </div>
                <div class="col-md-6">
                    <input type="url" name="quick_links[url][]" class="form-control" placeholder="URL">
                </div>
                <div class="col-md-1 d-grid">
                    <button type="button" class="btn btn-outline-danger remove-link" title="Remove this link">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', row);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-link')) {
                e.target.closest('.quick-link-row').remove();
            }
        });
    });
</script>
@endsection