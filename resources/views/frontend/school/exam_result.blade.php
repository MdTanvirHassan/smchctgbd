@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Exam Result Section -->
    <section class="exam-result">
        <div class="content-wrapper">
            <div class="content-header mb-4">
                <h1 style="color:#000"><i class="fa fa-map-o"></i> Exam Result</h1>
            </div>

            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-list" style="margin-right:5px;"></i>Exam Results List
                                </h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Class</th>
                                            <th>Shift</th>
                                            <th>Result Title</th>
                                            <th>Published Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classresults as $classresult)
                                            <tr>
                                                <td>{{ $classresult->class->name }}</td>
                                                <td>{{ $classresult->shift }}</td>
                                                <td>{{ $classresult->result_title }}</td>
                                                <td>{{ $classresult->published_date }}</td>
                                                <td>
                                                    <a href="{{ asset($classresult->file_path) }}" target="_blank"
                                                        class="btn btn-sm btn-primary">View</a> |
                                                    <a href="{{ asset($classresult->file_path) }}" download
                                                        class="btn btn-sm btn-success">Download</a>
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

@endsection