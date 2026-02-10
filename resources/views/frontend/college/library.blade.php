@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.Library') }}</h1>
    </div>
</section>

<section class="library-section container my-5">
    @if($library)
        @php
            $libraryData = json_decode($library->description, true);
        @endphp
        <div class="row g-4">
            @if(isset($libraryData['description']) && !empty($libraryData['description']))
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="summernote-content" style="line-height: 1.8; text-align: justify;">
                                {!! $libraryData['description'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($libraryData['images']) && count($libraryData['images']) > 0)
                <div class="col-12">
                    <div class="row g-4">
                        @foreach($libraryData['images'] as $image)
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($image) }}" alt="Library Image" class="card-img-top" style="height: 300px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">Library information is not available at the moment.</p>
        </div>
    @endif
</section>
@endsection

