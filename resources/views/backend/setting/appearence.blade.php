@extends('backend.layouts.app')

@section('contents')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                    style="width: 38px; height: 38px;">
                    <i class="fas fa-home fs-4"></i>
                </div>
                <h5 class="mb-0 fw-bold">Homepage Content Settings</h5>
            </div>

            <form action="{{ route('appearence.setting.update') }}" method="POST" enctype="multipart/form-data"
                class="card-body" novalidate>
                @csrf

                @php
                    $sections = [
                        'Banner Slider Images' => [
                            'banner_slider_1_image' => 'Slider Image 1',
                            'banner_slider_2_image' => 'Slider Image 2',
                            'banner_slider_3_image' => 'Slider Image 3',
                            'caption_is_active' => 'Enable Caption',
                        ],
                        'About Us Section' => [
                            'about_us_title' => 'Title',
                            'about_us_description' => 'Description',
                            'about_us_image' => 'Image',
                        ],
                        'School Information' => [
                            'boys_seat' => 'Number of Boys Seats',
                            'girls_seat' => 'Number of Girls Seats',
                            'monthly_fee' => 'Monthly Fee',
                            'admission_fee' => 'Admission Fee',
                            'admission_description' => 'Admission Information',
                            'admission_form_image' => 'Admission Form Attachment',
                        ],
                        'Institution History Section' => [
                            'school_history_title' => 'Title',
                            'school_history_description' => 'Description',
                            'school_history_image' => 'Image',
                        ],
                        'Headmaster / Principal' => [
                            'headmaster_name' => 'Name',
                            'headmaster_designation' => 'Designation',
                            'headmaster_phone' => 'Phone',
                            'headmaster_email' => 'Email',
                            'headmaster_speech' => 'Speech',
                            'headmaster_image' => 'Image',
                        ],
                        'Secretary' => [
                            'secretary_name' => 'Name',
                            'secretary_designation' => 'Designation',
                            'secretary_speech' => 'Speech',
                            'secretary_image' => 'Image',
                        ],
                    ];
                @endphp

                @foreach($sections as $sectionTitle => $fields)
                    <section class="mb-4 p-3 rounded bg-light bg-opacity-8">
                        <h6 class="text-uppercase fw-semibold text-secondary mb-3">{{ $sectionTitle }}</h6>
                        <div class="row g-3 align-items-end">
                            @foreach($fields as $field => $label)
                                @php $value = old($field, get_setting($field)); @endphp

                                @if (Str::endsWith($field, '_image'))
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold d-block">{{ $label }}</label>
                                        <input type="hidden" name="types[]" value="{{ $field }}">
                                        <input type="file" name="{{ $field }}_file"
                                            class="form-control form-control-sm mb-2 preview-image-input" accept="image/*"
                                            data-preview-target="#preview-{{ $field }}">
                                        <input type="hidden" name="{{ $field }}" value="{{ $value }}">
                                        <div id="preview-{{ $field }}"
                                            class="image-preview-box border rounded overflow-hidden d-flex justify-content-center align-items-center"
                                            style="height: 100px; background: #fff;">
                                            @if($value)
                                                <img src="{{ asset($value) }}" alt="{{ $label }}" class="img-fluid"
                                                    style="max-height: 100%; object-fit: contain;">
                                            @else
                                                <span class="text-muted small">No Image</span>
                                            @endif
                                        </div>
                                    </div>

                                @elseif (Str::endsWith($field, '_description') || Str::endsWith($field, '_speech'))
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" style="height: 120px"
                                                placeholder="{{ $label }}">{{ $value }}</textarea>
                                            <label for="{{ $field }}">{{ $label }}</label>
                                        </div>
                                        <input type="hidden" name="types[]" value="{{ $field }}">
                                    </div>
                                @elseif (Str::endsWith($field, '_active'))
                                    <div class="col-6">
                                        <div class="d-flex align-items-center justify-content-between border rounded p-3 shadow-sm">
                                            <label class="form-check-label fw-semibold" for="{{ $field }}">
                                                {{ $label }}
                                            </label>
                                            <div class="form-check form-switch m-0">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    id="{{ $field }}" 
                                                    name="{{ $field }}" 
                                                    value="1" 
                                                    {{ $value == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <input type="hidden" name="types[]" value="{{ $field }}">
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}"
                                                placeholder="{{ $label }}" value="{{ $value }}">
                                            <label for="{{ $field }}">{{ $label }}</label>
                                        </div>
                                        <input type="hidden" name="types[]" value="{{ $field }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </section>
                @endforeach

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-primary px-4 py-2 fs-6 fw-semibold">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('.preview-image-input');

            inputs.forEach(input => {
                input.addEventListener('change', function () {
                    const previewSelector = input.getAttribute('data-preview-target');
                    const previewContainer = document.querySelector(previewSelector);

                    if (!previewContainer) return;

                    // Clear previous preview content
                    previewContainer.innerHTML = '';

                    const file = input.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxHeight = '80px';
                            img.style.objectFit = 'contain';
                            img.classList.add('img-fluid');
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // If no image, show fallback text
                        const span = document.createElement('span');
                        span.classList.add('text-muted', 'small');
                        span.textContent = 'No Image';
                        previewContainer.appendChild(span);
                    }
                });
            });
        });
    </script>
@endsection