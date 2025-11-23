@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.Cafeteria') }}</h1>
    </div>
</section>

<section class="cafeteria-section container my-5">
    @if($cafeteria)
        @php
            $cafeteriaData = json_decode($cafeteria->description, true);
        @endphp
        <div class="row g-4">
            @if(isset($cafeteriaData['images']) && count($cafeteriaData['images']) > 0)
                @foreach($cafeteriaData['images'] as $image)
                    <div class="col-md-4 col-sm-6">
                        <div class="card shadow-sm">
                            <img src="{{ asset($image) }}" alt="Cafeteria Image" class="card-img-top" style="height: 250px; object-fit: cover;">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">Cafeteria information is not available at the moment.</p>
        </div>
    @endif
</section>
@endsection

