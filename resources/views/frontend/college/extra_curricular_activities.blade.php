@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.Extra Curricular Activities') }}</h1>
    </div>
</section>

<section class="extra-curricular-section container my-5">
    @if($extraCurricularActivities)
        @php
            $extraCurricularData = json_decode($extraCurricularActivities->description, true);
        @endphp
        <div class="row g-4">
            @if(isset($extraCurricularData['description']) && !empty($extraCurricularData['description']))
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="summernote-content" style="line-height: 1.8; text-align: justify;">
                                {!! $extraCurricularData['description'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($extraCurricularData['images']) && count($extraCurricularData['images']) > 0)
                <div class="col-12">
                    <div class="row g-4">
                        @foreach($extraCurricularData['images'] as $image)
                            <div class="col-md-4 col-sm-6">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($image) }}" alt="Extra Curricular Activity Image" class="card-img-top" style="height: 250px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">Extra Curricular Activities information is not available at the moment.</p>
        </div>
    @endif
</section>
@endsection

