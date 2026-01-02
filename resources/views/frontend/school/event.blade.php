@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Events -->
    <section class="notice-section">
        <div class="container shadow-bg my-4">
            <h2 class="text-center">{{ __('event.page_title') }}</h2>
            <div style="font-size: 16px; line-height: 1.5em; color: #000;">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-info">
                        <tr>
                            <th scope="col">{{ __('event.start_date') }}</th>
                            <th scope="col">{{ __('event.end_date') }}</th>
                            <th scope="col">{{ __('event.event_title') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($events as $event)
                            <tr>
                                <td>
                                    <div class="datenews">{{ $event->start_date ? $event->start_date : 'NA' }}</div>
                                </td>
                                <td>
                                    <div class="datenews">{{ $event->end_date ? $event->end_date : 'NA' }}</div>
                                </td>
                                <td>
                                    <a href="#" class="notice-link"
                                        data-content-html="{{ $event->description ? htmlspecialchars($event->description, ENT_QUOTES, 'UTF-8') : 'NA' }}">
                                        {{ $event->title ? $event->title : 'NA' }}
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
                    <h5 class="modal-title" id="noticeModalLabel">{{ __('event.modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('event.close') }}"></button>
                </div>
                <div class="modal-body" id="modalNoticeContent">
                    <!-- Content will be added dynamically -->
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