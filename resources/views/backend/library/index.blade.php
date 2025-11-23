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
            <h6 class="mb-0 fw-bold">Library</h6>
        </div>
        <div class="card-body">
            @php
                $libraryData = $library ? json_decode($library->description, true) : null;
            @endphp
            <form action="{{ $library ? route('library.update', $library->id) : route('library.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($library)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Image 1</label>
                        <input type="file" name="image1" class="form-control" accept="image/*" {{ !$library ? 'required' : '' }}>
                        @if($libraryData && isset($libraryData['images'][0]))
                            <div class="mt-2">
                                <img src="{{ asset($libraryData['images'][0]) }}" alt="Image 1" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Image 2</label>
                        <input type="file" name="image2" class="form-control" accept="image/*" {{ !$library ? 'required' : '' }}>
                        @if($libraryData && isset($libraryData['images'][1]))
                            <div class="mt-2">
                                <img src="{{ asset($libraryData['images'][1]) }}" alt="Image 2" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="6">{{ $libraryData['description'] ?? '' }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            {{ $library ? 'Update' : 'Save' }} Library
                        </button>
                        @if($library)
                            <a href="{{ route('library.status', $library->id) }}" class="btn btn-{{ $library->is_published ? 'success' : 'secondary' }}">
                                {{ $library->is_published ? 'Published' : 'Unpublished' }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

