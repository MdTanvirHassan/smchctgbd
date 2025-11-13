<div class="footer-top-wave">
    <svg viewBox="0 0 1440 220" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <!-- Back Layer (lighter, multiple dips) -->
        <path fill="#006a857a" fill-opacity="0.6" d="
      M0,90 
      C240,130 360,20 600,60 
      C840,100 960,20 1200,60 
      C1320,90 1440,60 1440,60 
      L1440,220 L0,220 Z">
        </path>

        <!-- Middle Layer (medium tone, opposite dips) -->
        <path fill="#005460" fill-opacity="0.8" d="
      M0,120 
      C240,170 480,80 720,120 
      C960,160 1200,80 1440,130 
      L1440,220 L0,220 Z">
        </path>

        <!-- Front Layer (main footer color, smooth waves) -->
        <path fill="#00465b" d="
      M0,150 
      C180,190 360,120 540,160 
      C720,200 900,130 1080,170 
      C1260,210 1440,140 1440,140 
      L1440,220 L0,220 Z">
        </path>
    </svg>
</div>


<section class="footer text-white pt-5 pb-3">
    <div class="container">
        <div class="row gy-4 align-items-start">
            <!-- Logo -->
            <div class="col-md-3 d-flex justify-content-center justify-content-md-start">
                <img src="{{ asset(get_setting('school_logo')) }}" alt="{{ __('footer.school_logo_alt') }}" class="img-fluid"
                    style="max-height: 130px; width: auto;">
            </div>

            <!-- Contact Info -->
            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold">{{ __('footer.contact') }}</h5>
                <hr>
                {{-- Address - Click to search on Google Maps --}}
                <p class="mb-2">
                    <strong>{{ __('footer.address') }}:</strong>
                    <a href="https://www.google.com/maps/search/{{ urlencode(get_setting('school_address')) }}"
                        target="_blank" class="text-white text-decoration-none" style="font-size: 15px;">
                        {{ get_setting('school_address') }}
                    </a>
                </p>

                {{-- Phone - Click to Call --}}
                <p class="mb-2">
                    <strong>{{ __('footer.phone') }}:</strong>
                    <a href="tel:{{ get_setting('school_phone') }}" class="text-white text-decoration-none"
                        style="font-size: 15px;">
                        {{ get_setting('school_phone') }}
                    </a>
                </p>

                {{-- Email --}}
                <p>
                    <strong>{{ __('footer.email') }}:</strong>
                    <a href="mailto:{{ get_setting('school_email') }}" class="text-white text-decoration-none"
                        style="font-size: 15px;">
                        {{ get_setting('school_email') }}
                    </a>
                </p>
            </div>


            <!-- Quick Links -->
            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold">{{ __('footer.quick_links') }}</h5>
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
                <h5 class="fw-semibold">{{ __('footer.social_media') }}</h5>
                <hr>
                <div class="mb-2">
                    <a href="{{ get_setting('facebook_link') }}" class="text-white text-decoration-none"
                        target="_blank">
                        <i class="fab fa-facebook-f me-2"></i> {{ __('footer.facebook') }}
                    </a>
                </div>

                <div class="mb-2">
                    <a href="{{ get_setting('instagram_link') }}" class="text-white text-decoration-none"
                        target="_blank">
                        <i class="fab fa-instagram me-2"></i> {{ __('footer.instagram') }}
                    </a>
                </div>

                <div>
                    <a href="{{ get_setting('youtube_link') }}" class="text-white text-decoration-none" target="_blank">
                        <i class="fab fa-youtube me-2"></i> {{ __('footer.youtube') }}
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
                    {{ __('footer.developed_by') }}
                    <a href="https://fouraxiz.com/" target="_blank" class="text-white fw-semibold mx-1"
                        style="font-size: 20px;">
                        4axiz IT Limited
                    </a>
                    {{ __('footer.and') }}
                    <a href="https://biddaniketon.com/" target="_blank" class="text-white fw-semibold ms-1"
                        style="font-size: 20px;">
                        BIDDANIKETON
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>