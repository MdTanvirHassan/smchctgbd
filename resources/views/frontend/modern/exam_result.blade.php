@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0"><i class="fa fa-map-o me-3"></i>রুটিন</h1>
    </div>
</section>

<!-- ✅ Exam Result Section -->
<section class="exam-result">
    <div class="container mt-5">
        <div class="content">
            <div class="row">
                <div class="box-header with-border">
                    <h3 class="box-title"></i>Exam Results List
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Session</th>
                                <th>Subject</th>
                                <th>Total Student</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025 - 2026</td>
                                <td>English</td>
                                <td>40</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">View</a> |
                                    <a href="#" class="btn btn-sm btn-success">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2025 - 2026</td>
                                <td>Math</td>
                                <td>50</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">View</a> |
                                    <a href="#" class="btn btn-sm btn-success">Download</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection