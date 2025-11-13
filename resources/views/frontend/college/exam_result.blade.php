@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0"><i class="fa fa-map-o me-3"></i>রুটিন</h1>
    </div>
</section>

<!-- ✅ Exam Result Section -->
<section class="exam-result my-5">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="exam-wrapper">
                        <h2 class="text-center fw-bold mb-4">📊 Exam Results</h2>

                        <!-- Filter -->
                        <div class="row mb-3">
                            <div class="col-md-4 offset-md-4">
                                <select id="resultClassFilter" class="form-select shadow-sm">
                                    <option value="">🔍 Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>Result Title</th>
                                        <th>Published Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="resultTable">
                                    @foreach($classresults as $key => $classresult)
                                    <tr data-class="{{ $classresult->class->name }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td><span class="badge bg-info">{{ $classresult->class->name }}</span></td>
                                        <td>{{ $classresult->result_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($classresult->published_date)->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ asset($classresult->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="{{ asset($classresult->file_path) }}" download
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtering Script -->
<script>
    document.getElementById('resultClassFilter').addEventListener('change', function() {
        let selectedClass = this.value;
        let rows = document.querySelectorAll('#resultTable tr');
        rows.forEach(row => {
            row.style.display = (selectedClass === "" || row.getAttribute('data-class') === selectedClass) ? "" : "none";
        });
    });
</script>
@endsection