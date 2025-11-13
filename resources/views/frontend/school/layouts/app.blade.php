<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>{{ get_setting('meta_title', get_setting('site_title', 'Biddaniketon Edu | 4axiz')) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="{{ get_setting('meta_description', 'Default description here') }}">
    <meta name="keywords" content="{{ get_setting('meta_keywords', 'education, school, learning') }}">
    <meta name="author" content="{{ get_setting('meta_author', 'Biddaniketon Edu') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="{{ get_setting('og_title', get_setting('site_title', 'Biddaniketon Edu | 4axiz')) }}">
    <meta property="og:description" content="{{ get_setting('og_description', 'Default OG description here') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset(get_setting('og_image', get_setting('school_logo', ''))) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ get_setting('twitter_title', get_setting('site_title', 'Biddaniketon Edu | 4axiz')) }}">
    <meta name="twitter:description" content="{{ get_setting('twitter_description', 'Default Twitter description here') }}">
    <meta name="twitter:image" content="{{ asset(get_setting('twitter_image', get_setting('school_logo', ''))) }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(get_setting('school_logo', 'favicon.ico')) }}" type="image/x-icon">
    <link rel="icon" href="{{ asset(get_setting('school_logo', 'favicon.ico')) }}" type="image/x-icon">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font (for Bengali) -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali&display=swap" rel="stylesheet">

    <!-- Font Awesome 4 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/school.css') }}">


</head>

<body>
    @include('frontend.school.layouts.header')

    @yield('content')

    @include('frontend.school.layouts.footer')


    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery and Slick JS/CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Slick Carousel Initialization -->
    <script>
        $(document).ready(function() {
            $('.testimonial-clients').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1000,
                arrows: true,
                dots: false,
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });

        function showNewsModal(element) {
            const content = element.getAttribute('data-content');
            document.getElementById('modalContent').textContent = content;
        }

        $(document).ready(function() {
            $('.notice-link').on('click', function(e) {
                e.preventDefault();
                const content = $(this).data('content');
                $('#modalNoticeContent').text(content);
                const myModal = new bootstrap.Modal(document.getElementById('noticeModal'));
                myModal.show();
            });
        });
    </script>
</body>

</html>