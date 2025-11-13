@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">রুটিন</h1>
    </div>
</section>
<!-- ✅ Routine -->
<section class="routine-section my-5">
    <div class="container">
        <!-- Class Routine -->
        <div class="routine-wrapper mb-5">
            <h2 class="text-center fw-bold mb-4">📘 ক্লাস রুটিন</h2>

            <!-- Filter -->
            <div class="row mb-3">
                <div class="col-md-4 offset-md-4">
                    <select id="classFilter" class="form-select shadow-sm">
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
                            <th>Shift</th>
                            <th>Routine Title</th>
                            <th>Published Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="routineTable">
                        @foreach($classroutines as $key => $classroutine)
                        <tr data-class="{{ $classroutine->class->name }}">
                            <td>{{ $key + 1 }}</td>
                            <td><span class="badge bg-info">{{ $classroutine->class->name }}</span></td>
                            <td>{{ $classroutine->shift }}</td>
                            <td>{{ $classroutine->routine_title }}</td>
                            <td>{{ \Carbon\Carbon::parse($classroutine->published_date)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ asset($classroutine->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ asset($classroutine->file_path) }}" download
                                    class="btn btn-sm btn-outline-success">
                                    <i class="fa fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exam Routine -->
        <div class="routine-wrapper">
            <h2 class="text-center fw-bold mb-4">✏️ পরীক্ষা রুটিন</h2>

            <!-- Filter -->
            <div class="row mb-3">
                <div class="col-md-4 offset-md-4">
                    <select id="examClassFilter" class="form-select shadow-sm">
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
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th>Shift</th>
                            <th>Routine Title</th>
                            <th>Published Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="examRoutineTable">
                        @foreach($examroutines as $key => $examroutine)
                        <tr data-class="{{ $examroutine->class->name }}">
                            <td>{{ $key + 1 }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $examroutine->class->name }}</span></td>
                            <td>{{ $examroutine->shift }}</td>
                            <td>{{ $examroutine->routine_title }}</td>
                            <td>{{ \Carbon\Carbon::parse($examroutine->published_date)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ asset($examroutine->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ asset($examroutine->file_path) }}" download
                                    class="btn btn-sm btn-outline-success">
                                    <i class="fa fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Filtering Script -->
<script>
    document.getElementById('classFilter').addEventListener('change', function() {
        let selectedClass = this.value;
        let rows = document.querySelectorAll('#routineTable tr');
        rows.forEach(row => {
            row.style.display = (selectedClass === "" || row.getAttribute('data-class') === selectedClass) ? "" : "none";
        });
    });

    document.getElementById('examClassFilter').addEventListener('change', function() {
        let selectedClass = this.value;
        let rows = document.querySelectorAll('#examRoutineTable tr');
        rows.forEach(row => {
            row.style.display = (selectedClass === "" || row.getAttribute('data-class') === selectedClass) ? "" : "none";
        });
    });
</script>
@endsection