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
            <h6 class="mb-0 fw-bold">Hostel</h6>
        </div>
        <div class="card-body">
            @php
                $hostelData = $hostel ? json_decode($hostel->description, true) : null;
            @endphp
            <form action="{{ $hostel ? route('hostel.update', $hostel->id) : route('hostel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($hostel)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-12">
                        <h5 class="mb-3">Boys Hostel</h5>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Boys Hostel Image 1</label>
                        <input type="file" name="boys_image1" class="form-control" accept="image/*" {{ !$hostel ? 'required' : '' }}>
                        @if($hostelData && isset($hostelData['boys_images'][0]))
                            <div class="mt-2">
                                <img src="{{ asset($hostelData['boys_images'][0]) }}" alt="Boys Hostel Image 1" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Boys Hostel Image 2</label>
                        <input type="file" name="boys_image2" class="form-control" accept="image/*" {{ !$hostel ? 'required' : '' }}>
                        @if($hostelData && isset($hostelData['boys_images'][1]))
                            <div class="mt-2">
                                <img src="{{ asset($hostelData['boys_images'][1]) }}" alt="Boys Hostel Image 2" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-12 mt-4">
                        <h5 class="mb-3">Girls Hostel</h5>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Girls Hostel Image 1</label>
                        <input type="file" name="girls_image1" class="form-control" accept="image/*" {{ !$hostel ? 'required' : '' }}>
                        @if($hostelData && isset($hostelData['girls_images'][0]))
                            <div class="mt-2">
                                <img src="{{ asset($hostelData['girls_images'][0]) }}" alt="Girls Hostel Image 1" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Girls Hostel Image 2</label>
                        <input type="file" name="girls_image2" class="form-control" accept="image/*" {{ !$hostel ? 'required' : '' }}>
                        @if($hostelData && isset($hostelData['girls_images'][1]))
                            <div class="mt-2">
                                <img src="{{ asset($hostelData['girls_images'][1]) }}" alt="Girls Hostel Image 2" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            {{ $hostel ? 'Update' : 'Save' }} Hostel
                        </button>
                        @if($hostel)
                            <a href="{{ route('hostel.status', $hostel->id) }}" class="btn btn-{{ $hostel->is_published ? 'success' : 'secondary' }}">
                                {{ $hostel->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

