@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Class Summary Section -->
    <section class="class-summary-section">
        <div class="container my-4 box-shadow">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-graduation-cap"></i>
                        <h5>শ্রেণী</h5>
                        <div>৬ষ্ঠ শ্রেণী</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-male"></i>
                        <h5>বালক</h5>
                        <div>2</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-female"></i>
                        <h5>বালিকা</h5>
                        <div>0</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-card-summary">
                        <i class="fas fa-users"></i>
                        <h5>মোট</h5>
                        <div>2</div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>শ্রেণী</th>
                            <th>বালক</th>
                            <th>বালিকা</th>
                            <th>মোট</th>
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