@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">নোটিশ</h1>
    </div>
</section>

<!-- ✅ Notice -->
<section class="notice-section my-5">
    <div class="container">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-bold">📢 নোটিশ</h2>

                <!-- 🔍 Search & Filter -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <input type="text" id="noticeSearch" class="form-control shadow-sm"
                            placeholder="🔍 শিরোনাম দ্বারা খুঁজুন...">
                    </div>
                    <div class="col-md-5">
                        <input type="date" id="noticeDateFilter" class="form-control shadow-sm">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary shadow-sm">
                            Reset
                        </button>
                    </div>
                </div>

                <!-- 📋 Notice Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center shadow-sm rounded-3 overflow-hidden" id="noticeTable"
                        style="border-collapse: separate; border-spacing: 0;">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3">শুরুর তারিখ</th>
                                <th class="py-3">নোটিশ শিরোনাম</th>
                                <th class="py-3">শেষ তারিখ</th>
                                <th class="py-3" style="width: 120px;">বিস্তারিত</th>
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
                                        onclick="showNoticeModal(this)">
                                        {{ $notice->title }}
                                    </a>
                                </td>
                                <td class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn btn-outline-primary btn-sm px-3 rounded-pill"
                                        data-bs-toggle="modal"
                                        data-bs-target="#noticeModal"
                                        data-title="{{ $notice->title }}"
                                        data-date="{{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}"
                                        data-description="{{ $notice->description }}"
                                        onclick="showNoticeModal(this)">
                                        বিস্তারিত
                                    </button>
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
                    <h5 class="modal-title fw-bold" id="noticeModalLabel">নোটিশ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="modalNoticeTitle" class="fw-semibold mb-3"></h5>
                    <small id="modalNoticeDate" class="text-muted d-block mb-2"></small>
                    <p id="modalNoticeContent" class="mb-0"></p>
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
    function showNoticeModal(element) {
        const title = element.getAttribute('data-title');
        const date = element.getAttribute('data-date');
        const description = element.getAttribute('data-description');

        document.getElementById('modalNoticeTitle').innerText = title;
        document.getElementById('modalNoticeDate').innerText = date;
        document.getElementById('modalNoticeContent').innerText = description;
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