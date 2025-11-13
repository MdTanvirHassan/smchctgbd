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
                                    <a href="#" class="notice-link"
                                        data-content="{{ $notice->description ? $notice->description : 'NA' }}">
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
                <div class="modal-body" id="modalNoticeContent">
                    <!-- Content will be added dynamically -->
                </div>
            </div>
        </div>
    </div>

@endsection