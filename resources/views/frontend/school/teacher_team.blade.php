@extends('frontend.school.layouts.app')

@section('content')
    <!-- ✅ Teacher Section -->
    <section class="teachers-section">
        <div class="container mb-5">
            <div class="row">
                <div class="testimonial-section" id="testimonial">
                    <div class="col-md-12">
                        <div class="services-title text-center mt-5">
                            <h5 style="font-size:20px;">শিক্ষক</h5>
                            <h2 class="text-lg">আমাদের সফল শিক্ষক</h2>
                        </div>
                    </div>

                    <div class="row justify-content-center gy-4 mt-4">
                        <div class="teachers-bg mt-4 row">
                            @foreach($teachers as $teacher)
                                <div class="col-md-3 mb-4">
                                    <div class="testimonial-item p-2" style="border:2px solid #ccc; cursor:pointer;"
                                        data-bs-toggle="modal" data-bs-target="#teacherModal" data-name="{{ $teacher->name }}"
                                        data-title="{{ $teacher->designation->name }}"
                                        data-subject="{{ $teacher->subject ?? 'N/A' }}"
                                        data-email="{{ $teacher->email ?? 'N/A' }}" data-phone="{{ $teacher->phone ?? 'N/A' }}"
                                        data-qualification="{{ $teacher->qualification ?? 'N/A' }}"
                                        data-join="{{ $teacher->join_date ? \Carbon\Carbon::parse($teacher->join_date)->format('d M, Y') : 'N/A' }}"
                                        data-img="{{ asset($teacher->photo_path) }}" data-teacher-id="{{ $teacher->id }}">
                                        <div class="techers-wrap text-center">
                                            <img src="{{ asset($teacher->photo_path) }}" alt="{{ $teacher->name }}"
                                                class="img-fluid"
                                                onerror="this.onerror=null; this.src='{{ asset('/public/assets/img/user.png') }}'">

                                            <div class="teachers-dig mt-3">
                                                <h4>{{ $teacher->name }}</h4>
                                                <p>{{ $teacher->designation->name }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Hidden biography div --}}
                                    <div class="d-none bio-content" id="bio-{{ $teacher->id }}">
                                        {!! nl2br(e($teacher->biography ?? 'N/A')) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Teacher Info Modal -->
    <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header" style="color: #000;">
                    <h5 class="modal-title fw-bold" id="teacherModalLabel">Teacher Details</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Image -->
                        <div class="col-md-3 text-center">
                            <img id="modalTeacherImg" src="" alt="Teacher Photo" class="img-fluid rounded shadow-sm mb-2"
                                style="max-width: 120px;">
                        </div>

                        <!-- Right: Info -->
                        <div class="col-md-9">
                            <h5 class="fw-bold mb-1" id="modalTeacherName">SS</h5>
                            <p class="mb-1"><strong>Designation:</strong> <span id="modalTeacherTitle">Principal</span></p>
                            <p class="mb-1"><strong>Qualification:</strong> <span id="modalTeacherQualification">ddd</span>
                            </p>
                            <!-- <p class="mb-1"><strong>Joined on:</strong> <span id="modalTeacherJoin">19 Aug 2025</span></p> -->
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="mt-3">
                        <h6 class="fw-bold">Biography</h6>
                        <p id="modalTeacherBiography" class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- ✅ Modal Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var teacherModal = document.getElementById('teacherModal');
        teacherModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var name = button.getAttribute('data-name');
            var title = button.getAttribute('data-title');
            var qualification = button.getAttribute('data-qualification');
            // var join = button.getAttribute('data-join');
            var img = button.getAttribute('data-img');
            var teacherId = button.getAttribute('data-teacher-id');

            // Get hidden bio div content
            var bioDiv = document.getElementById('bio-' + teacherId);
            var bioContent = bioDiv ? bioDiv.innerHTML : 'N/A';

            document.getElementById('modalTeacherName').textContent = name;
            document.getElementById('modalTeacherTitle').textContent = title;
            document.getElementById('modalTeacherQualification').textContent = qualification;
            // document.getElementById('modalTeacherJoin').textContent = join;
            document.getElementById('modalTeacherBiography').innerHTML = bioContent;
            document.getElementById('modalTeacherImg').src = img;
        });
    });
</script>