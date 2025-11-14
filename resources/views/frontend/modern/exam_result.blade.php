@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0"><i class="fa fa-map-o me-3"></i>{{ __('exam_result.page_title') }}</h1>
    </div>
</section>

<!-- ✅ Exam Result Section -->
<section class="exam-result">
    <div class="container mt-5">
        <div class="content">
            <div class="row">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('exam_result.exam_results_list') }}
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>{{ __('exam_result.session') }}</th>
                                <th>{{ __('exam_result.subject') }}</th>
                                <th>{{ __('exam_result.total_student') }}</th>
                                <th>{{ __('exam_result.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025 - 2026</td>
                                <td>English</td>
                                <td>40</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">{{ __('exam_result.view') }}</a> |
                                    <a href="#" class="btn btn-sm btn-success">{{ __('exam_result.download') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2025 - 2026</td>
                                <td>Math</td>
                                <td>50</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">{{ __('exam_result.view') }}</a> |
                                    <a href="#" class="btn btn-sm btn-success">{{ __('exam_result.download') }}</a>
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