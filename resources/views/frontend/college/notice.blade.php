@extends('frontend.college.layouts.app')

@section('content')
@php
    $currentLocale = app()->getLocale();
@endphp
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('notice.title') }}</h1>
    </div>
</section>

<!-- ✅ Notice -->
<section class="notice-section my-5">
    <div class="container">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-bold">📢 {{ __('notice.title') }}</h2>

                <!-- 🔍 Search & Filter -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <input type="text" id="noticeSearch" class="form-control shadow-sm"
                            placeholder="🔍 {{ __('notice.search_placeholder') }}">
                    </div>
                    <div class="col-md-5">
                        <input type="date" id="noticeDateFilter" class="form-control shadow-sm">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary shadow-sm">
                            {{ __('notice.reset') }}
                        </button>
                    </div>
                </div>

                <!-- 📋 Notice Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center shadow-sm rounded-3 overflow-hidden" id="noticeTable"
                        style="border-collapse: separate; border-spacing: 0;">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3">{{ __('notice.start_date') }}</th>
                                <th class="py-3">{{ __('notice.notice_title') }}</th>
                                <th class="py-3">{{ __('notice.end_date') }}</th>
                                <th class="py-3" style="width: 180px;">{{ __('notice.details') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-light">
                            @foreach($notices as $notice)
                            <tr class="table-row"
                                data-start="{{ \Carbon\Carbon::parse($notice->start_date)->format('Y-m-d') }}"
                                data-end="{{ \Carbon\Carbon::parse($notice->end_date)->format('Y-m-d') }}">

                                <td class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}
                                </td>
                                <td class="text-start">
                                    <a href="#"
                                        class="fw-semibold text-decoration-none text-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#noticeModal"
                                        data-title="{{ $notice->title }}"
                                        data-date="{{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}"
                                        data-description="{{ $notice->description }}"
                                        data-image="{{ $notice->file_path ?? '' }}"
                                        onclick="showNoticeModal(this)">
                                        {{ $notice->title }}
                                    </a>
                                </td>
                                <td class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm px-3 rounded-pill"
                                            data-bs-toggle="modal"
                                            data-bs-target="#noticeModal"
                                            data-title="{{ $notice->title }}"
                                            data-date="{{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}"
                                            data-description="{{ $notice->description }}"
                                            data-image="{{ $notice->file_path ?? '' }}"
                                            onclick="showNoticeModal(this)">
                                            {{ __('notice.details') }}
                                        </button>
                                        @if($notice->file_path)
                                        @php
                                            $imagePath = $notice->file_path;
                                            $imageUrl = asset($imagePath);
                                        @endphp
                                        <button type="button"
                                            class="btn btn-outline-info btn-sm px-2 rounded-pill"
                                            onclick="viewNoticeImage('{{ $imageUrl }}')"
                                            title="{{ __('notice.view_image') }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-outline-success btn-sm px-2 rounded-pill"
                                            onclick="downloadNoticeImage('{{ $imageUrl }}')"
                                            title="{{ __('notice.download_image') }}">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <style>
                    /* ✅ Custom Table Styling */
                    #noticeTable thead tr {
                        background: linear-gradient(45deg, #0d6efd, #0dcaf0);
                    }

                    #noticeTable thead th {
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }

                    #noticeTable tbody tr {
                        transition: all 0.2s ease-in-out;
                    }

                    #noticeTable tbody tr:hover {
                        background-color: #f1f9ff !important;
                        transform: scale(1.01);
                    }

                    #noticeTable td,
                    #noticeTable th {
                        vertical-align: middle;
                    }
                </style>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="noticeModalLabel">{{ __('notice.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="modalNoticeTitle" class="fw-semibold mb-3"></h5>
                    <small id="modalNoticeDate" class="text-muted d-block mb-2"></small>
                    <p id="modalNoticeContent" class="mb-3"></p>
                    
                    <!-- Image Section -->
                    <div id="modalImageSection" style="display: none;">
                        <div class="mb-3">
                            <img id="modalNoticeImage" src="" alt="Notice Image" class="img-fluid rounded shadow-sm" style="max-width: 100%; max-height: 500px; object-fit: contain;">
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" id="viewImageBtn" class="btn btn-primary btn-sm" onclick="viewFullImage()">
                                <i class="fas fa-eye me-1"></i> {{ __('notice.view_image') }}
                            </button>
                            <button type="button" id="downloadImageBtn" class="btn btn-success btn-sm" onclick="downloadImage()">
                                <i class="fas fa-download me-1"></i> {{ __('notice.download_image') }}
                            </button>
                        </div>
                    </div>
                    <div id="noImageMessage" class="text-muted small" style="display: none;">
                        {{ __('notice.no_image') }}
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('notice.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    let currentImagePath = '';

    function showNoticeModal(element) {
        const title = element.getAttribute('data-title');
        const date = element.getAttribute('data-date');
        const description = element.getAttribute('data-description');
        const imagePath = element.getAttribute('data-image');

        document.getElementById('modalNoticeTitle').innerText = title;
        document.getElementById('modalNoticeDate').innerText = date;
        document.getElementById('modalNoticeContent').innerText = description;

        // Handle image
        const imageSection = document.getElementById('modalImageSection');
        const noImageMessage = document.getElementById('noImageMessage');
        const imageElement = document.getElementById('modalNoticeImage');
        const viewBtn = document.getElementById('viewImageBtn');
        const downloadBtn = document.getElementById('downloadImageBtn');

        if (imagePath && imagePath.trim() !== '') {
            // Normalize path - remove 'public/' prefix if present
            let normalizedPath = imagePath.replace(/^public\//, '');
            let imageUrl = '{{ asset("") }}' + normalizedPath;
            
            currentImagePath = normalizedPath;
            imageElement.src = imageUrl;
            imageSection.style.display = 'block';
            noImageMessage.style.display = 'none';
            viewBtn.setAttribute('data-image-url', imageUrl);
            downloadBtn.setAttribute('data-image-url', imageUrl);
        } else {
            imageSection.style.display = 'none';
            noImageMessage.style.display = 'block';
            currentImagePath = '';
        }
    }

    function viewFullImage() {
        const imageUrl = document.getElementById('viewImageBtn').getAttribute('data-image-url');
        if (imageUrl) {
            window.open(imageUrl, '_blank');
        }
    }

    function downloadImage() {
        const imageUrl = document.getElementById('downloadImageBtn').getAttribute('data-image-url');
        if (imageUrl) {
            // Create a temporary anchor element to trigger download
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = 'notice-image-' + Date.now() + '.jpg';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // View image from table button - opens in new tab
    function viewNoticeImage(imageUrl) {
        if (imageUrl) {
            window.open(imageUrl, '_blank');
        }
    }

    // Download image from table button
    function downloadNoticeImage(imageUrl) {
        if (imageUrl) {
            // Fetch the image and convert to blob for download
            fetch(imageUrl)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'notice-image-' + Date.now() + '.jpg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Download error:', error);
                    // Fallback: open in new tab if fetch fails
                    window.open(imageUrl, '_blank');
                });
        }
    }

    const searchInput = document.getElementById('noticeSearch');
    const dateInput = document.getElementById('noticeDateFilter');

    function filterNotices() {
        let searchValue = searchInput.value.toLowerCase();
        let selectedDate = dateInput.value; // YYYY-MM-DD
        let rows = document.querySelectorAll(".table-row");

        rows.forEach(row => {
            let title = row.cells[1].innerText.toLowerCase();
            let startDate = row.getAttribute("data-start");
            let endDate = row.getAttribute("data-end");

            let matchesSearch = title.includes(searchValue);

            let matchesDate = true;
            if (selectedDate) {
                matchesDate = (selectedDate >= startDate && selectedDate <= endDate);
            }

            row.style.display = (matchesSearch && matchesDate) ? "" : "none";
        });
    }

    // Event listeners
    searchInput.addEventListener('keyup', filterNotices);
    dateInput.addEventListener('change', filterNotices);

    // Reset button
    document.getElementById("resetFilters").addEventListener("click", function() {
        searchInput.value = "";
        dateInput.value = "";
        filterNotices();
    });
</script>
@endsection