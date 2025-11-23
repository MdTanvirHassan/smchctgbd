@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.Hostel') }}</h1>
    </div>
</section>

<section class="hostel-section container my-5">
    @if($hostel)
        @php
            $hostelData = json_decode($hostel->description, true);
        @endphp
        <div class="row g-4">
            <!-- Boys Hostel -->
            @if(isset($hostelData['boys_images']) && count($hostelData['boys_images']) > 0)
                <div class="col-12">
                    <h3 class="mb-4">Boys Hostel</h3>
                    <div class="row g-4">
                        @foreach($hostelData['boys_images'] as $image)
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($image) }}" alt="Boys Hostel Image" class="card-img-top" style="height: 300px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Girls Hostel -->
            @if(isset($hostelData['girls_images']) && count($hostelData['girls_images']) > 0)
                <div class="col-12 mt-5">
                    <h3 class="mb-4">Girls Hostel</h3>
                    <div class="row g-4">
                        @foreach($hostelData['girls_images'] as $image)
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($image) }}" alt="Girls Hostel Image" class="card-img-top" style="height: 300px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">Hostel information is not available at the moment.</p>
        </div>
    @endif
</section>
@endsection

