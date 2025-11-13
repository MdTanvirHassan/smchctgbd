@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Routine -->
    <section class="routine-section shadow-bg" style="margin: 0 0 30px 0;">
        <div class="container shadow-bg">
            <div class="col-md-12">
                <div class="routine-wraper">
                    <h1 class="text-center" style="margin: 10px 0 0px 0;">ক্লাস রুটিন</h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size:18px; text-align:center;">
                        <thead>
                            <tr>
                                @foreach($classroutines as $key => $classroutine)
                                    <th class="text-center">
                                        <span class="badge bg-primary">{{ $classroutine->class->name }}</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($classroutines as $key => $classroutine)
                                    <td>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <a href="{{ asset($classroutine->file_path) }}" download>ডাউনলোড</a>
                                        <br>
                                        <small>Published:
                                            {{ \Carbon\Carbon::parse($classroutine->published_date)->format('d M, Y') }}</small>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="routine-wraper">
                    <h1 class="text-center" style="margin: 50px 0 0px 0;">পরীক্ষা রুটিন</h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size:18px; text-align:center;">
                        <thead>
                            <tr>
                                @foreach($examroutines as $key => $examroutine)
                                    <th class="text-center">
                                        <span class="badge bg-warning text-dark">{{ $examroutine->class->name }}</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($examroutines as $key => $examroutine)
                                    <td>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <a href="{{ asset($examroutine->file_path) }}" download>ডাউনলোড</a>
                                        <br>
                                        <small>Published:
                                            {{ \Carbon\Carbon::parse($examroutine->published_date)->format('d M, Y') }}</small>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection