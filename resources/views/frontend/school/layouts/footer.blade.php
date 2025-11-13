<!-- ✅ Footer -->
<section class="footer">
    <div class="container">
        <div class="row text-white">
            <!-- Logo -->
            <div class="col-md-3">
                <div class="footer-logo">
                    <img src="{{ asset(get_setting('left_logo', 'left')) }}" alt="School Logo" class="img-fluid">
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold">যোগাযোগ</h5>
                <hr>
                {{-- Address - Click to search on Google Maps --}}
                <p class="mb-2">
                    <strong>ঠিকানা:</strong>
                    <a href="https://www.google.com/maps/search/{{ urlencode(get_setting('school_address')) }}"
                        target="_blank" class="text-white text-decoration-none" style="font-size: 15px;">
                        {{ get_setting('school_address') }}
                    </a>
                </p>

                {{-- Phone - Click to Call --}}
                <p class="mb-2">
                    <strong>ফোন:</strong>
                    <a href="tel:{{ get_setting('school_phone') }}" class="text-white text-decoration-none"
                        style="font-size: 15px;">
                        {{ get_setting('school_phone') }}
                    </a>
                </p>

                {{-- Email --}}
                <p>
                    <strong>ইমেইল:</strong>
                    <a href="mailto:{{ get_setting('school_email') }}" class="text-white text-decoration-none"
                        style="font-size: 15px;">
                        {{ get_setting('school_email') }}
                    </a>
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold">দ্রুত লিঙ্ক</h5>
                <hr>
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
                            <a href="{{ $url }}" class="text-white d-flex align-items-center text-decoration-none"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fa-solid fa-caret-right me-2"></i> {{ $title }}
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>



            <!-- Social Links -->
            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold">সোশ্যাল মিডিয়া</h5>
                <hr>
                <div class="mb-2">
                    <a href="{{ get_setting('facebook_link') }}" class="text-white text-decoration-none"
                        target="_blank">
                        <i class="fab fa-facebook-f me-2"></i> Facebook
                    </a>
                </div>

                <div class="mb-2">
                    <a href="{{ get_setting('instagram_link') }}" class="text-white text-decoration-none"
                        target="_blank">
                        <i class="fab fa-instagram me-2"></i> Instagram
                    </a>
                </div>

                <div>
                    <a href="{{ get_setting('youtube_link') }}" class="text-white text-decoration-none" target="_blank">
                        <i class="fab fa-youtube me-2"></i> YouTube
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="row mt-4">
            <div class="col-12 text-center pt-3">
                <hr>
                <p class="mb-0" style="font-size: 18px; color: #bbb;">
                    &copy; {{ get_setting('school_name') }} |
                    Developed by
                    <a href="https://fouraxiz.com/" target="_blank" class="text-white fw-semibold mx-1"
                        style="font-size: 20px;">
                        4axiz IT Limited
                    </a>
                    &amp;
                    <a href="https://biddaniketon.com/" target="_blank" class="text-white fw-semibold ms-1"
                        style="font-size: 20px;">
                        BIDDANIKETON
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>