@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">ইভেন্ট</h1>
    </div>
</section>

<!-- ✅ Event -->
<section class="event-section">
    <div class="container shadow-sm my-5 p-4 bg-white rounded">
        <h2 class="text-center mb-4">ইভেন্ট</h2>
        <div style="font-size: 16px; line-height: 1.5em; color: #000;">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-info">
                    <tr>
                        <th scope="col">শুরুর তারিখ</th>
                        <th scope="col">ইভেন্ট শিরোনাম</th>
                        <th scope="col">শেষ তারিখ</th>
                        <th scope="col" style="width: 100px;">বিস্তারিত</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                        <td>
                            <a href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#eventModal"
                                data-title="{{ $event->title }}"
                                data-date="{{ $event->start_date }}"
                                data-description="{{ $event->description }}"
                                onclick="showEventModal(this)">
                                {{ $event->title }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                        <td>
                            <button type="button"
                                class="btn btn-outline-dark btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#eventModal"
                                data-title="{{ $event->title }}"
                                data-date="{{ $event->start_date }}"
                                data-description="{{ $event->description }}"
                                onclick="showEventModal(this)">
                                বিস্তারিত
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="eventModalLabel">ইভেন্ট</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="modalEventTitle" class="fw-semibold mb-3"></h5>
                    <small id="modalEventDate" class="text-muted d-block mb-2"></small>
                    <p id="modalEventContent" class="mb-0"></p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script>
    function showEventModal(element) {
        const title = element.getAttribute('data-title');
        const date = element.getAttribute('data-date');
        const description = element.getAttribute('data-description');

        document.getElementById('modalEventTitle').innerText = title;
        document.getElementById('modalEventDate').innerText = date;
        document.getElementById('modalEventContent').innerText = description;
    }
</script>
@endsection

