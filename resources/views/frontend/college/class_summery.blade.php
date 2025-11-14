@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('class_summary.page_title') }}</h1>
    </div>
</section>

    <!-- ✅ Class Summary Section -->
    <section class="class-summary-section">
        <div class="container my-4 box-shadow">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-graduation-cap"></i>
                        <h5>{{ __('class_summary.class') }}</h5>
                        <div>৬ষ্ঠ শ্রেণী</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-male"></i>
                        <h5>{{ __('class_summary.boys') }}</h5>
                        <div>2</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-female"></i>
                        <h5>{{ __('class_summary.girls') }}</h5>
                        <div>0</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-users"></i>
                        <h5>{{ __('class_summary.total') }}</h5>
                        <div>2</div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>{{ __('class_summary.class') }}</th>
                            <th>{{ __('class_summary.boys') }}</th>
                            <th>{{ __('class_summary.girls') }}</th>
                            <th>{{ __('class_summary.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>৬ষ্ঠ শ্রেণী(A)</td>
                            <td>2</td>
                            <td>0</td>
                            <td>2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection