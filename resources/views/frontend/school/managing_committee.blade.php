@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Managing Team Section -->
    <section class="managing-team-section">
        <div class="container">
            <div class="row">
                <div class=" col-md-12 text-center" style="
            margin-top: 50px;">
                    <h5 style=" font-size:20px; color: #000;">ম্যানেজিং কমিটি</h5>
                    <h2 class="text-lg mt-3" style="font-size: 30px;font-weight: 500; color: #000;">আমাদের সফল ম্যানেজিং
                        কমিটি</h2>
                </div>

                <div class="row justify-content-center gy-4 mt-4">
                    <div class="teachers-bg mt-4 row">
                        @foreach($committees as $committe)
                            <div class="col-md-3 mb-4">
                                <div class="testimonial-item p-2" style="border:2px solid #ccc; cursor:pointer;"
                                    data-bs-toggle="modal" data-bs-target="#committeModal" data-name="{{ $committe->name }}"
                                    data-title="{{ is_object($committe->designation) ? ($committe->designation->name ?? 'N/A') : ($committe->designation ?? 'N/A') }}"
                                    data-subject="{{ $committe->subject ?? 'N/A' }}"
                                    data-email="{{ $committe->email ?? 'N/A' }}" data-phone="{{ $committe->phone ?? 'N/A' }}"
                                    data-qualification="{{ $committe->qualification ?? 'N/A' }}"
                                    data-join="{{ $committe->join_date ? \Carbon\Carbon::parse($committe->join_date)->format('d M, Y') : 'N/A' }}"
                                    data-img="{{ asset($committe->photo_path) }}" data-committe-id="{{ $committe->id }}">

                                    <div class="techers-wrap text-center">
                                        <img src="{{ asset($committe->photo_path) }}" alt="{{ $committe->name }}"
                                            class="img-fluid"
                                            onerror="this.onerror=null; this.src='{{ asset('/public/assets/img/user.png') }}'">

                                        <div class="teachers-dig mt-3">
                                            <h4>{{ $committe->name }}</h4>
                                            <p>{{ is_object($committe->designation) ? ($committe->designation->name ?? 'N/A') : ($committe->designation ?? 'N/A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hidden biography div --}}
                                <div class="d-none bio-content" id="bio-{{ $committe->id }}">
                                    {!! nl2br(e($committe->biography ?? 'N/A')) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>

        </div>
        </div>
        </div>
    </section>

    <!-- ✅ Commitee Modal -->
    <div class="modal fade" id="committeModal" tabindex="-1" aria-labelledby="committeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header" style="color: #000;">
                    <h5 class="modal-title fw-bold" id="committeModalLabel">Committee Person Details</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Image -->
                        <div class="col-md-3 text-center">
                            <img id="modalCommiteeImg" src="" alt="Commitee Photo" class="img-fluid rounded shadow-sm mb-2"
                                style="max-width: 120px;">
                        </div>

                        <!-- Right: Info -->
                        <div class="col-md-9">
                            <h5 class="fw-bold mb-1" id="modalCommiteeName">SS</h5>
                            <p class="mb-1"><strong>Designation:</strong> <span id="modalCommiteeTitle">Principal</span></p>
                            <p class="mb-1"><strong>Qualification:</strong> <span id="modalCommiteeQualification">ddd</span>
                            </p>
                            <!-- <p class="mb-1"><strong>Joined on:</strong> <span id="modalCommiteeJoin">19 Aug 2025</span></p> -->
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="mt-3">
                        <h6 class="fw-bold">Biography</h6>
                        <p id="modalCommiteeBiography" class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Modal Script -->
    <script>
        // Committe

        document.addEventListener('DOMContentLoaded', function () {
            var committeModal = document.getElementById('committeModal');

            if (committeModal) {
                committeModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;

                    var name = button.getAttribute('data-name');
                    var title = button.getAttribute('data-title');
                    var qualification = button.getAttribute('data-qualification');
                    var img = button.getAttribute('data-img');
                    var committeId = button.getAttribute('data-committe-id');

                    // Get hidden bio div content
                    var bioDiv = document.getElementById('bio-' + committeId);
                    var bioContent = bioDiv ? bioDiv.innerHTML : 'N/A';

                    document.getElementById('modalCommiteeName').textContent = name;
                    document.getElementById('modalCommiteeTitle').textContent = title;
                    document.getElementById('modalCommiteeQualification').textContent = qualification;
                    document.getElementById('modalCommiteeBiography').innerHTML = bioContent;
                    document.getElementById('modalCommiteeImg').src = img;
                });
            }
        });
    </script>
@endsection