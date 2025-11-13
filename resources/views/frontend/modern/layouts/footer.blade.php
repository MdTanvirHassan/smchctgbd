<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Logo & About -->
            <div class="col-lg-4">
                <div class="mb-3">
                    <img src="{{ asset(get_setting('school_logo')) }}" alt="School Logo" class="me-3 mb-4" style="height: 60px;">
                    <h5 class="mb-0">{{ get_setting('school_name') }}</h5>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2">
                @php
                $quickLinksRaw = json_decode(get_setting('quick_links', '{}'), true) ?? [];
                $titles = $quickLinksRaw['title'] ?? [];
                $urls = $quickLinksRaw['url'] ?? [];
                @endphp


                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    @foreach ($titles as $index => $title)
                    @php
                    $url = $urls[$index] ?? null;
                    @endphp

                    @if ($title && $url)
                    <div class="mb-2">
                        <a href="{{ $url }}" class="text-white d-flex align-items-center text-decoration-none" target="_blank" rel="noopener noreferrer">
                            <i class="fa-solid fa-caret-right me-2"></i> {{ $title }}
                        </a>
                    </div>
                    @endif
                    @endforeach
                </ul>
            </div>

            <!-- Programs -->
            <div class="col-lg-3">
                <h6>Programs</h6>
                <ul class="list-unstyled">
                    @foreach(get_setting('footer_programs', []) as $program)
                    <li><a href="{{ $program['url'] }}" class="text-white-50">{{ $program['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3">
                <h6>Contact Info</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ get_setting('school_address') }}</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i>{{ get_setting('school_phone') }}</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i>{{ get_setting('school_email') }}</li>
                </ul>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} {{ get_setting('school_name') }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-end">
                <p class="mb-0">
                    Developed by
                    <a href="https://fouraxiz.com/" target="_blank" class="text-white fw-semibold mx-1">
                        4axiz IT Limited
                    </a>
                    &amp;
                    <a href="https://biddaniketon.com/" target="_blank" class="text-white fw-semibold ms-1">
                        BIDDANIKETON
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>