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
                                        data-content="{{ $event->description ? $event->description : 'NA' }}">
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


@endsection