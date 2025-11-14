@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('total_students.page_title') }}</h1>
    </div>
</section>


<!-- ✅ Total Student -->
<section class="total-student-section">
    <div class="container table-container">
        <h4 class="table-title">{{ __('total_students.section_title') }}</h4>
        <table class="table table-bordered">
            <thead class="custom-header">
                <tr>
                    <th>{{ __('total_students.no') }}</th>
                    <th>{{ __('total_students.boys_seat_capacity') }}</th>
                    <th>{{ __('total_students.girls_seat_capacity') }}</th>
                    <th>{{ __('total_students.total_seat_capacity') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>600</td>
                    <td>800</td>
                    <td>1400</td>
                </tr>
            </tbody>
        </table>
    </div>

</section>

@endsection