@extends('frontend.college.layouts.app')

@section('content')
    <section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
        <div class="hero-inner py-4">
            <h1 class="display-4 fw-bold mb-0">ছাত্রছাত্রীর আসন সংখ্যা</h1>
        </div>
    </section>


    <!-- ✅ Total Student -->
<section class="total-student-section my-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 fw-bold text-primary">
                    🎓 ছাত্রছাত্রীর আসন সংখ্যা
                </h4>

                <div class="table-responsive">
                    <table class="table align-middle text-center mb-0">
                        <thead class="text-white" style="background: linear-gradient(90deg, #0062E6, #33AEFF);">
                            <tr>
                                <th>No</th>
                                <th>ছাত্রের আসন সংখ্যা <i class="fas fa-male ms-1"></i></th>
                                <th>ছাত্রীর আসন সংখ্যা <i class="fas fa-female ms-1"></i></th>
                                <th>মোট আসন সংখ্যা <i class="fas fa-users ms-1"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-hover">
                                <td class="fw-semibold">01</td>
                                <td>
                                    <span class="badge bg-primary px-3 py-2">
                                        {{ get_setting('boys_seat') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-pink px-3 py-2 text-white">
                                        {{ get_setting('girls_seat') }}
                                    </span>
                                </td>
                                <td class="fw-bold text-success">
                                    <span class="fs-5">
                                        {{ (int) get_setting('boys_seat') + (int) get_setting('girls_seat') }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .table-hover:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transition: 0.3s;
    }

    .badge.bg-pink {
        background-color: #e83e8c !important;
    }

    .table th, .table td {
        vertical-align: middle;
        font-size: 16px;
    }

    .table thead th {
        border: none;
    }

    .table tbody td {
        border-top: 1px solid #dee2e6;
    }
</style>


@endsection