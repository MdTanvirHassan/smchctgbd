@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">নোটিশ</h1>
    </div>
</section>

<!-- ✅ Notice -->
<section class="notice-section">
    <div class="container shadow-sm my-5 p-4 bg-white rounded">
        <h2 class="text-center mb-4">নোটিশ</h2>
        <div style="font-size: 16px; line-height: 1.5em; color: #000;">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-info">
                    <tr>
                        <th scope="col">শুরুর তারিখ</th>
                        <th scope="col">নোটিশ শিরোনাম</th>
                        <th scope="col">শেষ তারিখ</th>
                        <th scope="col" style="width: 100px;">বিস্তারিত</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notices as $notice)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}</td>
                        <td>
                            <a href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#noticeModal"
                                data-title="{{ $notice->title }}"
                                data-date="{{ $notice->start_date }}"
                                data-description="{{ $notice->description }}"
                                onclick="showNoticeModal(this)">
                                {{ $notice->title }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}</td>
                        <td>
                            <button type="button"
                                class="btn btn-outline-dark btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#noticeModal"
                                data-title="{{ $notice->title }}"
                                data-date="{{ $notice->start_date }}"
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
    </div>

    <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel"
        aria-hidden="true">
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
</script>
@endsection