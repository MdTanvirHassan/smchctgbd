@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('event.page_title') }}</h1>
    </div>
</section>

<!-- ✅ Event -->
<section class="event-section">
    <div class="container shadow-sm my-5 p-4 bg-white rounded">
        <h2 class="text-center mb-4">{{ __('event.section_title') }}</h2>

        <!-- 🔍 Search & Filter -->
        <div class="row mb-3">
            <div class="col-md-5">
                <input type="text" id="eventSearch" class="form-control shadow-sm"
                    placeholder="{{ __('event.search_placeholder') }}">
            </div>
            <div class="col-md-5">
                <input type="date" id="eventDateFilter" class="form-control shadow-sm">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" id="resetEventFilters" class="btn btn-outline-secondary shadow-sm">
                    {{ __('event.reset') }}
                </button>
            </div>
        </div>

        <div style="font-size: 16px; line-height: 1.5em; color: #000;">
            <table class="table table-bordered table-striped table-hover" id="eventTable">
                <thead class="table-info">
                    <tr>
                        <th scope="col">{{ __('event.start_date') }}</th>
                        <th scope="col">{{ __('event.event_title') }}</th>
                        <th scope="col">{{ __('event.end_date') }}</th>
                        <th scope="col" style="width: 100px;">{{ __('event.details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr data-start="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}"
                        data-end="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}">

                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                        <td>
                            <a href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#eventModal"
                                data-title="{{ $event->title }}"
                                data-date="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}"
                                data-description-html="{{ htmlspecialchars($event->description, ENT_QUOTES, 'UTF-8') }}"
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
                                data-date="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}"
                                data-description-html="{{ htmlspecialchars($event->description, ENT_QUOTES, 'UTF-8') }}"
                                onclick="showEventModal(this)">
                                {{ __('event.details') }}
                            </button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="eventModalLabel">{{ __('event.modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('event.close') }}"></button>
                </div>
                <div class="modal-body">
                    <h5 id="modalEventTitle" class="fw-semibold mb-3"></h5>
                    <small id="modalEventDate" class="text-muted d-block mb-2"></small>
                    <div id="modalEventContent" class="summernote-content mb-0" style="line-height: 1.8;"></div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('event.close') }}</button>
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
        const descriptionHtml = element.getAttribute('data-description-html');

        document.getElementById('modalEventTitle').innerText = title;
        document.getElementById('modalEventDate').innerText = date;
        
        // Decode HTML entities and render as HTML
        if (descriptionHtml) {
            const tempTextarea = document.createElement('textarea');
            tempTextarea.innerHTML = descriptionHtml;
            const decodedHtml = tempTextarea.value;
            document.getElementById('modalEventContent').innerHTML = decodedHtml;
        } else {
            document.getElementById('modalEventContent').innerHTML = '';
        }
    }

    // ✅ Filter Events
    function filterEvents() {
        const searchValue = document.getElementById("eventSearch").value.toLowerCase();
        const filterDate = document.getElementById("eventDateFilter").value; // YYYY-MM-DD
        const rows = document.querySelectorAll("#eventTable tbody tr");

        rows.forEach(row => {
            const title = row.querySelector("td:nth-child(2)").innerText.toLowerCase();
            const startDate = row.getAttribute("data-start");
            const endDate = row.getAttribute("data-end");

            const matchSearch = title.includes(searchValue);

            let matchDate = true;
            if (filterDate) {
                matchDate = (filterDate >= startDate && filterDate <= endDate);
            }

            row.style.display = (matchSearch && matchDate) ? "" : "none";
        });
    }


    // Event listeners
    document.getElementById("eventSearch").addEventListener("keyup", filterEvents);
    document.getElementById("eventDateFilter").addEventListener("change", filterEvents);
    document.getElementById("resetEventFilters").addEventListener("click", function() {
        document.getElementById("eventSearch").value = "";
        document.getElementById("eventDateFilter").value = "";
        filterEvents();
    });
</script>

<style>
    /* Styles for Summernote rich text content */
    .event-section .summernote-content {
        word-wrap: break-word;
    }
    
    .event-section .summernote-content p {
        margin-bottom: 1rem;
    }
    
    .event-section .summernote-content ul,
    .event-section .summernote-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .event-section .summernote-content li {
        margin-bottom: 0.5rem;
    }
    
    .event-section .summernote-content h1,
    .event-section .summernote-content h2,
    .event-section .summernote-content h3,
    .event-section .summernote-content h4,
    .event-section .summernote-content h5,
    .event-section .summernote-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .event-section .summernote-content table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    
    .event-section .summernote-content table td,
    .event-section .summernote-content table th {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .event-section .summernote-content table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .event-section .summernote-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    .event-section .summernote-content a {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    .event-section .summernote-content a:hover {
        color: #0a58ca;
    }
</style>
@endsection