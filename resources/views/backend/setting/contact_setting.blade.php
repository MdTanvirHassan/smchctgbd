@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="fas fa-address-card fs-4"></i>
            </div>
            <h5 class="mb-0 fw-bold">Contact Page Settings</h5>
        </div>

        <form action="{{ route('contact.setting.update') }}" method="POST" class="card-body" novalidate>
            @csrf

            @php
                $settingsValues = isset($settings) ? collect($settings) : collect();

                $pageFields = [
                    'contact_page_title' => 'Page Title',
                    'contact_page_subtitle' => 'Subtitle',
                    'contact_page_description' => 'Description',
                    'contact_extra_info' => 'Additional Information',
                ];

                $mapFields = [
                    'contact_map_embed_url' => 'Map Embed URL or Iframe',
                ];

                $collegeOfficeFields = [
                    'college_office_name' => 'College Office Name',
                    'college_office_address' => 'College Office Address',
                    'college_office_phone' => 'College Office Phone',
                    'college_office_email' => 'College Office Email',
                    'college_office_time' => 'College Office Time Slot',
                    'college_office_offday' => 'College Office Off Day',
                ];

                $hospitalOfficeFields = [
                    'hospital_office_name' => 'Hospital Office Name',
                    'hospital_office_address' => 'Hospital Office Address',
                    'hospital_office_phone' => 'Hospital Office Phone',
                    'hospital_office_email' => 'Hospital Office Email',
                    'hospital_office_time' => 'Hospital Office Time Slot',
                    'hospital_office_offday' => 'Hospital Office Off Day',
                ];
            @endphp

            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Page Content</h6>
                <div class="row g-3">
                    @foreach ($pageFields as $field => $label)
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="{{ $field }}">{{ $label }}</label>
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            @if (in_array($field, ['contact_page_description', 'contact_extra_info']))
                                <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="4" placeholder="{{ $label }}">{{ old($field, $settingsValues->get($field)) }}</textarea>
                            @else
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" placeholder="{{ $label }}" value="{{ old($field, $settingsValues->get($field)) }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">College Office</h6>
                <div class="row g-3">
                    @foreach ($collegeOfficeFields as $field => $label)
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="hidden" name="types[]" value="{{ $field }}">
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" placeholder="{{ $label }}" value="{{ old($field, $settingsValues->get($field)) }}">
                                <label for="{{ $field }}">{{ $label }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Hospital Office</h6>
                <div class="row g-3">
                    @foreach ($hospitalOfficeFields as $field => $label)
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="hidden" name="types[]" value="{{ $field }}">
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" placeholder="{{ $label }}" value="{{ old($field, $settingsValues->get($field)) }}">
                                <label for="{{ $field }}">{{ $label }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="mb-4 p-3 rounded bg-light bg-opacity-50">
                <h6 class="text-uppercase fw-semibold text-secondary mb-3">Maps</h6>
                <div class="row g-3">
                    @foreach ($mapFields as $field => $label)
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="{{ $field }}">{{ $label }}</label>
                            <input type="hidden" name="types[]" value="{{ $field }}">
                            <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="3" placeholder="{{ $label }}">{{ old($field, $settingsValues->get($field)) }}</textarea>
                            <small class="text-muted d-block mt-1">Paste the Google Maps embed URL or the full iframe code.</small>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4 py-2 fs-6 fw-semibold">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
