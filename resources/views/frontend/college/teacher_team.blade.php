@extends('frontend.college.layouts.app')

@section('content')

<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">শিক্ষক মণ্ডলী</h1>
        <h2 class="mt-3">আমাদের সম্মানিত শিক্ষক মণ্ডলী</h2>
    </div>
</section>

<section class="teachers-team-section">
    <div class="container mb-5">
        <div class="row">
            <div class="testimonial-section" id="testimonial">
                <div class="col-md-12">
                    <div class="services-title text-center mt-5">

                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        @foreach($teachers as $teacher)
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="teacher-card text-center rounded" style="cursor:pointer;"
                                data-bs-toggle="modal" data-bs-target="#teacherModal"
                                data-name="{{ $teacher->name }}"
                                data-designation="{{ $teacher->designation->name }}"
                                data-photo="{{ asset($teacher->photo_path) }}"
                                data-qualification="{{ $teacher->qualification }}"
                                data-biography="{{ $teacher->biography }}"
                                data-join_date="{{ \Carbon\Carbon::parse($teacher->join_date)->format('d M Y') }}">
                                <img src="{{ asset($teacher->photo_path) }}" alt="Teacher"
                                    class="teacher-img">
                                <div class="teacher-info mt-3">
                                    <h4>{{ $teacher->name }}</h4>
                                    <p>{{ $teacher->designation->name }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow rounded-3">

                            <!-- Modal Header -->
                            <div class="modal-header py-3 px-4 rounded-top">
                                <h5 class="modal-title fw-bold fs-4" id="teacherModalLabel">Teacher Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body px-4 py-4">

                                <!-- Flex container: photo on left, info on right -->
                                <div
                                    class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4 mb-4">

                                    <!-- Teacher Photo -->
                                    <img id="modalTeacherPhoto" src="" alt="Teacher Photo"
                                        class="rounded shadow-sm flex-shrink-0"
                                        style="width: 140px; height: 140px; object-fit: cover;" />

                                    <!-- Info container -->
                                    <div class="text-center text-md-start">
                                        <h4 id="modalTeacherName" class="fw-bold mb-2"></h4>
                                        <p id="modalTeacherDesignation" class="mb-1"></p>
                                        <p id="modalTeacherQualification" class="mb-1"></p>
                                        <p id="modalTeacherJoinDate" class="mb-0"></p>
                                    </div>
                                </div>

                                <!-- Biography section -->
                                <section>
                                    <h6 class="fw-semibold mb-3">Biography</h6>
                                    <p id="modalTeacherBiography" class="mb-0"
                                        style="white-space: pre-wrap; line-height: 1.5; text-align: justify;"></p>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#teacherModal').on('show.bs.modal', function(event) {
            let trigger = $(event.relatedTarget);
            let name = trigger.data('name');
            let designation = trigger.data('designation');
            let photo = trigger.data('photo');
            let qualification = trigger.data('qualification');
            let biography = trigger.data('biography');
            let joinDate = trigger.data('join_date');

            let modal = $(this);
            modal.find('#modalTeacherName').text(name);
            modal.find('#modalTeacherDesignation').text(designation);
            modal.find('#modalTeacherPhoto').attr('src', photo);
            modal.find('#modalTeacherQualification').text("Qualification: " + qualification);
            modal.find('#modalTeacherJoinDate').text("Joined on: " + joinDate);
            modal.find('#modalTeacherBiography').text(biography);
        });
    });
</script>
@endsection