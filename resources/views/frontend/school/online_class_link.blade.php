@extends('frontend.school.layouts.app')

@section('content')
    @php
        $quickLinksRaw = json_decode(get_setting('quick_links', '{}'), true) ?? [];
        $titles = $quickLinksRaw['title'] ?? [];
        $urls = $quickLinksRaw['url'] ?? [];
    @endphp

    @foreach ($titles as $index => $title)
        @php
            $url = $urls[$index] ?? null;
        @endphp

        @if ($title && $url)
            <div class="mb-2">
                <a href="{{ $url }}" class="text-white d-flex align-items-center text-decoration-none" target="_blank"
                    rel="noopener noreferrer">
                    <i class="fa-solid fa-caret-right me-2"></i> {{ $title }}
                </a>
            </div>
        @endif
    @endforeach

@endsection