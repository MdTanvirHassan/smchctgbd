@extends('frontend.college.layouts.app')

@section('content')

<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('header.governing_body') }}</h1>
        <h2 class="mt-3">{{ __('landing.managing_committee_subtitle') }}</h2>
    </div>
</section>

<section class="teachers-team-section">
    <div class="container mb-5">
        <div class="row">
            <div class="testimonial-section" id="testimonial">
                <div class="col-md-12">
                    <div class="services-title text-center mt-5">
                        <h5 style="font-size:20px; color: #000;">{{ __('landing.managing_committee_title') }}</h5>
                        <h2 class="text-lg mt-3" style="font-size: 30px;font-weight: 500; color: #000;">{{ __('landing.managing_committee_subtitle') }}</h2>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        @foreach($committees as $committee)
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="teacher-card text-center rounded" style="cursor:pointer;"
                                data-bs-toggle="modal" data-bs-target="#committeeModal"
                                data-name="{{ $committee->name }}"
                                data-designation="{{ $committee->designation }}"
                                data-photo="{{ asset($committee->photo_path) }}"
                                data-email="{{ $committee->email ?? 'N/A' }}"
                                data-phone="{{ $committee->phone ?? 'N/A' }}"
                                data-biography="{{ $committee->biography ?? 'N/A' }}"
                                data-join_date="{{ $committee->join_date ? \Carbon\Carbon::parse($committee->join_date)->format('d M Y') : 'N/A' }}">
                                <img src="{{ asset($committee->photo_path) }}" alt="{{ $committee->name }}"
                                    class="teacher-img" onerror="this.onerror=null; this.src='{{ asset('/public/assets/icons/user.png') }}'">
                                <div class="teacher-info mt-3">
                                    <h4>{{ $committee->name }}</h4>
                                    <p>{{ $committee->designation }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal fade" id="committeeModal" tabindex="-1" aria-labelledby="committeeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow rounded-3">

                            <!-- Modal Header -->
                            <div class="modal-header py-3 px-4 rounded-top">
                                <h5 class="modal-title fw-bold fs-4" id="committeeModalLabel">{{ __('header.governing_body') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body px-4 py-4">

                                <!-- Flex container: photo on left, info on right -->
                                <div
                                    class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4 mb-4">

                                    <!-- Committee Photo -->
                                    <img id="modalCommitteePhoto" src="" alt="Committee Photo"
                                        class="rounded shadow-sm flex-shrink-0"
                                        style="width: 140px; height: 140px; object-fit: cover;" />

                                    <!-- Info container -->
                                    <div class="text-center text-md-start">
                                        <h4 id="modalCommitteeName" class="fw-bold mb-2"></h4>
                                        <p id="modalCommitteeDesignation" class="mb-1"></p>
                                        <p id="modalCommitteeEmail" class="mb-1"></p>
                                        <p id="modalCommitteePhone" class="mb-1"></p>
                                        <p id="modalCommitteeJoinDate" class="mb-0"></p>
                                    </div>
                                </div>

                                <!-- Biography section -->
                                <section>
                                    <h6 class="fw-semibold mb-3">{{ __('landing.teacher_modal_biography') }}</h6>
                                    <p id="modalCommitteeBiography" class="mb-0"
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
        $('#committeeModal').on('show.bs.modal', function(event) {
            let trigger = $(event.relatedTarget);
            let name = trigger.data('name');
            let designation = trigger.data('designation');
            let photo = trigger.data('photo');
            let email = trigger.data('email');
            let phone = trigger.data('phone');
            let biography = trigger.data('biography');
            let joinDate = trigger.data('join_date');

            let modal = $(this);
            modal.find('#modalCommitteeName').text(name);
            modal.find('#modalCommitteeDesignation').text(designation ? designation : '');
            modal.find('#modalCommitteePhoto').attr('src', photo);
            modal.find('#modalCommitteeEmail').text(email && email !== 'N/A' ? "Email: " + email : '');
            modal.find('#modalCommitteePhone').text(phone && phone !== 'N/A' ? "Phone: " + phone : '');
            modal.find('#modalCommitteeJoinDate').text(joinDate && joinDate !== 'N/A' ? "Joined on: " + joinDate : '');
            modal.find('#modalCommitteeBiography').text(biography && biography !== 'N/A' ? biography : '');
        });
    });
</script>
@endsection

