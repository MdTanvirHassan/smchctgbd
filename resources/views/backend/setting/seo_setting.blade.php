@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white border-1 border-bottom py-3 d-flex align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="fas fa-search fs-4"></i>
            </div>
            <h5 class="mb-0 fw-bold">SEO Settings</h5>
        </div>

        <form action="{{ route('seo.setting.update') }}" method="POST" enctype="multipart/form-data" class="card-body" novalidate>
            @csrf

            @php
            $seoFields = [
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'meta_author' => 'Meta Author',
            'og_title' => 'Open Graph Title',
            'og_description' => 'Open Graph Description',
            'og_image' => 'Open Graph Image',
            'twitter_title' => 'Twitter Title',
            'twitter_description' => 'Twitter Description',
            'twitter_image' => 'Twitter Image',
            ];
            @endphp

            <section class="mb-4 p-3 rounded bg-light bg-opacity-8">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Meta Information</h6>
                <div class="row g-3">
                    @foreach (['meta_title', 'meta_keywords', 'meta_author'] as $field)
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $field }}"
                                name="{{ $field }}"
                                placeholder="{{ $seoFields[$field] }}"
                                value="{{ old($field, get_setting($field)) }}">
                            <label for="{{ $field }}">{{ $seoFields[$field] }}</label>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-12">
                        <div class="form-floating">
                            <input type="hidden" name="types[]" value="meta_description">
                            <textarea
                                class="form-control"
                                id="meta_description"
                                name="meta_description"
                                placeholder="{{ $seoFields['meta_description'] }}"
                                style="height: 100px">{{ old('meta_description', get_setting('meta_description')) }}</textarea>
                            <label for="meta_description">{{ $seoFields['meta_description'] }}</label>
                        </div>
                    </div>
                </div>
            </section>


            <section class="mb-4 p-3 rounded bg-light bg-opacity-8">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Open Graph (Facebook & Others)</h6>
                <div class="row g-3">
                    @foreach (['og_title', 'og_description'] as $field)
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $field }}"
                                name="{{ $field }}"
                                placeholder="{{ $seoFields[$field] }}"
                                value="{{ old($field, get_setting($field)) }}">
                            <label for="{{ $field }}">{{ $seoFields[$field] }}</label>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold d-block mb-2">{{ $seoFields['og_image'] }}</label>
                        <input type="hidden" name="types[]" value="og_image">
                        <input
                            type="file"
                            name="og_image_file"
                            class="form-control form-control-sm mb-2 preview-image-input"
                            accept="image/*"
                            data-preview-target="#preview-og_image">
                        <input type="hidden" name="og_image" value="{{ get_setting('og_image') }}">
                        <div id="preview-og_image" class="image-preview-box border rounded overflow-hidden d-flex justify-content-center align-items-center" style="height: 100px; background: #fff;">
                            @if(get_setting('og_image'))
                            <img src="{{ asset(get_setting('og_image')) }}" alt="OG Image" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                            @else
                            <span class="text-muted small">No Image</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            

            <section class="mb-4 p-3 rounded bg-light bg-opacity-8">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Twitter</h6>
                <div class="row g-3">
                    @foreach (['twitter_title', 'twitter_description'] as $field)
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $field }}"
                                name="{{ $field }}"
                                placeholder="{{ $seoFields[$field] }}"
                                value="{{ old($field, get_setting($field)) }}">
                            <label for="{{ $field }}">{{ $seoFields[$field] }}</label>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold d-block mb-2">{{ $seoFields['twitter_image'] }}</label>
                        <input type="hidden" name="types[]" value="twitter_image">
                        <input
                            type="file"
                            name="twitter_image_file"
                            class="form-control form-control-sm mb-2 preview-image-input"
                            accept="image/*"
                            data-preview-target="#preview-twitter_image">
                        <input type="hidden" name="twitter_image" value="{{ get_setting('twitter_image') }}">
                        <div id="preview-twitter_image" class="image-preview-box border rounded overflow-hidden d-flex justify-content-center align-items-center" style="height: 100px; background: #fff;">
                            @if(get_setting('twitter_image'))
                            <img src="{{ asset(get_setting('twitter_image')) }}" alt="Twitter Image" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                            @else
                            <span class="text-muted small">No Image</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-5 d-flex justify-content-end">
                <button type="submit" class="btn btn-outline-success px-4 py-2 fs-6 fw-semibold">Save SEO Settings</button>
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
                const previewSelector = this.getAttribute('data-preview-target');
                const preview = document.querySelector(previewSelector);

                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Clear old preview content
                        preview.innerHTML = '';

                        // Create image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxHeight = '80px';
                        img.style.objectFit = 'contain';
                        img.classList.add('img-fluid');

                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    // If no file selected, optionally restore default (e.g., "No Image" text)
                    preview.innerHTML = '<span class="text-muted small">No Image</span>';
                }
            });
        });
    });
</script>
@endsection