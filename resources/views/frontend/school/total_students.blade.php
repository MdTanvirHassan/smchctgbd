@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Hero -->
    <!-- <section class="hero-section">
                        <div class="hero p-5">
                            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6); height: 100%;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <div class="text-white">
                                        <h1 class="mb-3">School</h1>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> -->

    <!-- ✅ Total Student -->
    <section class="total-student-section">
        <div class="container table-container">
            <h4 class="table-title">ছাত্রছাত্রীর আসন সংখ্যা</h4>
            <table class="table table-bordered">
                <thead class="custom-header">
                    <tr>
                        <th>No</th>
                        <th>ছাত্রের আসন সংখ্যা</th>
                        <th>ছাত্রীর আসন সংখ্যা</th>
                        <th>মোট আসন সংখ্যা</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01</td>
                        <td>{{ get_setting('boys_seat') }}</td>
                        <td>{{ get_setting('girls_seat') }}</td>
                        <td>{{ (int) get_setting('boys_seat') + (int) get_setting('girls_seat') }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </section>

@endsection