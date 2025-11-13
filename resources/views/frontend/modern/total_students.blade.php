@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">ছাত্রছাত্রীর আসন সংখ্যা</h1>
    </div>
</section>


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
                    <td>600</td>
                    <td>800</td>
                    <td>1400</td>
                </tr>
            </tbody>
        </table>
    </div>

</section>

@endsection