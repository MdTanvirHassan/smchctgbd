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
                                data-description-html="{{ htmlspecialchars($notice->description, ENT_QUOTES, 'UTF-8') }}"
                                data-file="{{ $notice->file_path ?? '' }}"
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
                                data-description-html="{{ htmlspecialchars($notice->description, ENT_QUOTES, 'UTF-8') }}"
                                data-file="{{ $notice->file_path ?? '' }}"
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
                    <div id="modalNoticeContent" class="summernote-content mb-0" style="line-height: 1.8;"></div>
                    <div id="modalAttachmentSection" class="mt-3" style="display: none;">
                        <img id="modalNoticeImage" src="" alt="Notice image" class="img-fluid rounded" style="max-height: 400px; display: none;">
                        <embed id="modalNoticePdf" src="" type="application/pdf" style="width: 100%; height: 450px; border: 1px solid #dee2e6; display: none;">
                        <div class="mt-2 d-flex gap-2">
                            <a id="modalNoticeFileLink" href="#" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i> View File</a>
                            <a id="modalNoticeDownloadLink" href="#" download class="btn btn-sm btn-outline-success"><i class="fas fa-download me-1"></i> Download</a>
                        </div>
                    </div>
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
    function isPdfFile(filePath) {
        return filePath.toLowerCase().endsWith('.pdf');
    }

    function getFileUrl(filePath) {
        let normalizedPath = (filePath || '').trim().replace(/\\/g, '/');

        if (/^https?:\/\//i.test(normalizedPath)) {
            return normalizedPath;
        }

        normalizedPath = normalizedPath.replace(/^.*\/public\//i, 'public/').replace(/^\/+/, '');
        if (!normalizedPath.startsWith('public/')) {
            normalizedPath = 'public/' + normalizedPath;
        }

        return '{{ asset("") }}' + normalizedPath;
    }

    function showNoticeModal(element) {
        const title = element.getAttribute('data-title');
        const date = element.getAttribute('data-date');
        const descriptionHtml = element.getAttribute('data-description-html');
        const filePath = element.getAttribute('data-file');

        document.getElementById('modalNoticeTitle').innerText = title;
        document.getElementById('modalNoticeDate').innerText = date;
        
        // Decode HTML entities and render as HTML
        if (descriptionHtml) {
            const tempTextarea = document.createElement('textarea');
            tempTextarea.innerHTML = descriptionHtml;
            const decodedHtml = tempTextarea.value;
            document.getElementById('modalNoticeContent').innerHTML = decodedHtml;
        } else {
            document.getElementById('modalNoticeContent').innerHTML = '';
        }

        const attachmentSection = document.getElementById('modalAttachmentSection');
        const imageElement = document.getElementById('modalNoticeImage');
        const pdfElement = document.getElementById('modalNoticePdf');
        const fileLink = document.getElementById('modalNoticeFileLink');
        const downloadLink = document.getElementById('modalNoticeDownloadLink');

        if (filePath && filePath.trim() !== '') {
            const fileUrl = getFileUrl(filePath);
            fileLink.href = fileUrl;
            downloadLink.href = fileUrl;
            attachmentSection.style.display = 'block';

            if (isPdfFile(filePath)) {
                imageElement.style.display = 'none';
                imageElement.src = '';
                pdfElement.src = fileUrl;
                pdfElement.style.display = 'block';
            } else {
                pdfElement.style.display = 'none';
                pdfElement.src = '';
                imageElement.src = fileUrl;
                imageElement.style.display = 'block';
            }
        } else {
            attachmentSection.style.display = 'none';
            imageElement.style.display = 'none';
            imageElement.src = '';
            pdfElement.style.display = 'none';
            pdfElement.src = '';
            fileLink.href = '#';
            downloadLink.href = '#';
        }
    }
</script>

<style>
    /* Styles for Summernote rich text content */
    .notice-section .summernote-content {
        word-wrap: break-word;
    }
    
    .notice-section .summernote-content p {
        margin-bottom: 1rem;
    }
    
    .notice-section .summernote-content ul,
    .notice-section .summernote-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .notice-section .summernote-content li {
        margin-bottom: 0.5rem;
    }
    
    .notice-section .summernote-content h1,
    .notice-section .summernote-content h2,
    .notice-section .summernote-content h3,
    .notice-section .summernote-content h4,
    .notice-section .summernote-content h5,
    .notice-section .summernote-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .notice-section .summernote-content table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    
    .notice-section .summernote-content table td,
    .notice-section .summernote-content table th {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .notice-section .summernote-content table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .notice-section .summernote-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    .notice-section .summernote-content a {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    .notice-section .summernote-content a:hover {
        color: #0a58ca;
    }
</style>
@endsection