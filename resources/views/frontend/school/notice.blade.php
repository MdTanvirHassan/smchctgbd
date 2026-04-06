@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Notice -->
    <section class="notice-section">
        <div class="container shadow-bg my-4">
            <h2 class="text-center">নোটিশ</h2>
            <div style="font-size: 16px; line-height: 1.5em; color: #000;">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-info">
                        <tr>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Notice</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($notices as $notice)
                            <tr>
                                <td>
                                    <div class="datenews">{{ $notice->start_date ? $notice->start_date : 'NA' }}</div>
                                </td>
                                <td>
                                    <div class="datenews">{{ $notice->end_date ? $notice->end_date : 'NA' }}</div>
                                </td>
                                <td>
                                    <a href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#noticeModal"
                                        data-title="{{ $notice->title ? $notice->title : 'NA' }}"
                                        data-date="{{ $notice->start_date ? $notice->start_date : 'NA' }}"
                                        data-description-html="{{ $notice->description ? htmlspecialchars($notice->description, ENT_QUOTES, 'UTF-8') : 'NA' }}"
                                        data-file="{{ $notice->file_path ?? '' }}"
                                        onclick="showNoticeModal(this)">
                                        {{ $notice->title ? $notice->title : 'NA' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noticeModalLabel">নোটিশ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="modalNoticeTitle" class="fw-semibold mb-2"></h5>
                    <small id="modalNoticeDate" class="text-muted d-block mb-2"></small>
                    <div class="summernote-content" id="modalNoticeContent" style="line-height: 1.8;"></div>
                    <div id="modalAttachmentSection" class="mt-3" style="display: none;">
                        <img id="modalNoticeImage" src="" alt="Notice image" class="img-fluid rounded" style="max-height: 400px; display: none;">
                        <embed id="modalNoticePdf" src="" type="application/pdf" style="width: 100%; height: 450px; border: 1px solid #dee2e6; display: none;">
                        <div class="mt-2 d-flex gap-2">
                            <a id="modalNoticeFileLink" href="#" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i> View File</a>
                            <a id="modalNoticeDownloadLink" href="#" download class="btn btn-sm btn-outline-success"><i class="fas fa-download me-1"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    /* Styles for Summernote rich text content */
    .notice-section .summernote-content,
    #modalNoticeContent {
        word-wrap: break-word;
    }
    
    #modalNoticeContent p {
        margin-bottom: 1rem;
    }
    
    #modalNoticeContent ul,
    #modalNoticeContent ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    #modalNoticeContent li {
        margin-bottom: 0.5rem;
    }
    
    #modalNoticeContent h1,
    #modalNoticeContent h2,
    #modalNoticeContent h3,
    #modalNoticeContent h4,
    #modalNoticeContent h5,
    #modalNoticeContent h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    #modalNoticeContent table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    
    #modalNoticeContent table td,
    #modalNoticeContent table th {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    #modalNoticeContent table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    #modalNoticeContent img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    #modalNoticeContent a {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    #modalNoticeContent a:hover {
        color: #0a58ca;
    }
</style>

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
        const title = element.getAttribute('data-title') || '';
        const date = element.getAttribute('data-date') || '';
        const descriptionHtml = element.getAttribute('data-description-html') || '';
        const filePath = element.getAttribute('data-file') || '';

        document.getElementById('modalNoticeTitle').innerText = title;
        document.getElementById('modalNoticeDate').innerText = date;

        if (descriptionHtml) {
            const tempTextarea = document.createElement('textarea');
            tempTextarea.innerHTML = descriptionHtml;
            document.getElementById('modalNoticeContent').innerHTML = tempTextarea.value;
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
@endsection