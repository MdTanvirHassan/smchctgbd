<!-- <script>
    // Custom JavaScript
    $(document).ready(function() {
        // Initialize tooltips and popovers
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Counter Animation
        function animateCounters() {
            $('.counter').each(function() {
                var $this = $(this);
                var countTo = $this.attr('data-count');

                $({
                    countNum: $this.text()
                }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                        // Add % sign for pass rate
                        if ($this.parent().find('.stat-label').text() === 'Pass Rate %') {
                            $this.text(this.countNum + '%');
                        }
                    }
                });
            });
        }

        // Trigger counter animation when section comes into view
        function checkCountersInView() {
            var countersSection = $('.counter').first().closest('.section-block');
            var windowTop = $(window).scrollTop();
            var windowBottom = windowTop + $(window).height();
            var elementTop = countersSection.offset().top;
            var elementBottom = elementTop + countersSection.height();

            if ((elementTop <= windowBottom) && (elementBottom >= windowTop) && !countersSection.hasClass('animated')) {
                countersSection.addClass('animated');
                animateCounters();
            }
        }

        // Check on scroll
        $(window).scroll(function() {
            checkCountersInView();
        });

        // Check on page load
        checkCountersInView();

        // Smooth scrolling for navigation links
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 70
                }, 1000);
            }
        });

        // Add active class to navigation links based on scroll position
        $(window).scroll(function() {
            var scrollPos = $(window).scrollTop() + 100;

            $('.nav-link').each(function() {
                var currLink = $(this);
                var refElement = $(currLink.attr("href"));

                if (refElement.length > 0) {
                    if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                        $('.nav-link').removeClass("active");
                        currLink.addClass("active");
                    } else {
                        currLink.removeClass("active");
                    }
                }
            });
        });

        // Auto-play carousels with custom intervals
        $('#heroCarousel').carousel({
            interval: 5000,
            pause: 'hover'
        });

        $('#teacherCarousel').carousel({
            interval: 4000,
            pause: 'hover'
        });

        // Add fade-in animation to sections when they come into view
        function checkFadeInElements() {
            $('.section-block').each(function() {
                var element = $(this);
                var windowTop = $(window).scrollTop();
                var windowBottom = windowTop + $(window).height();
                var elementTop = element.offset().top;
                var elementBottom = elementTop + element.height();

                if ((elementTop <= windowBottom) && (elementBottom >= windowTop) && !element.hasClass('fade-in-up')) {
                    element.addClass('fade-in-up');
                }
            });
        }

        // Check on scroll and load
        $(window).scroll(checkFadeInElements);
        checkFadeInElements();

        // Gallery lightbox functionality
        window.openLightbox = function(imageSrc) {
            $('#lightboxImage').attr('src', imageSrc);
        };

        // Add hover effects to cards
        $('.card').hover(
            function() {
                $(this).addClass('shadow-lg');
            },
            function() {
                $(this).removeClass('shadow-lg');
            }
        );

        // Mobile menu close on link click
        $('.navbar-nav .nav-link').on('click', function() {
            if ($(window).width() < 992) {
                $('.navbar-collapse').collapse('hide');
            }
        });
    
        // Add loading animation
        $(window).on('load', function() {
            $('body').addClass('loaded');
        });

        // Back to top button (optional)
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#backToTop').fadeIn();
            } else {
                $('#backToTop').fadeOut();
            }
        });

        // Add back to top button to body
        $('body').append('<button id="backToTop" class="btn btn-primary position-fixed" style="bottom: 20px; right: 20px; z-index: 1000; display: none; border-radius: 50%; width: 50px; height: 50px;"><i class="fas fa-arrow-up"></i></button>');

        $('#backToTop').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
            return false;
        });

        // Add typing effect to hero text (optional enhancement)
        function typeWriter(element, text, speed) {
            var i = 0;
            element.innerHTML = '';

            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Enhanced mobile navigation
        $('.navbar-toggler').click(function() {
            $(this).toggleClass('active');
        });

        // Form validation and enhancement (if forms are added later)
        $('form').on('submit', function(e) {
            // Add form validation logic here
        });

        // Accessibility enhancements
        $('a, button').on('focus', function() {
            $(this).addClass('focus-visible');
        }).on('blur', function() {
            $(this).removeClass('focus-visible');
        });

        // Performance optimization - lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        console.log('School website initialized successfully!');
    });

    // Additional utility functions
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this,
                args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Throttled scroll handler for better performance
    var throttledScroll = debounce(function() {
        checkCountersInView();
        checkFadeInElements();
    }, 100);

    $(window).scroll(throttledScroll);
</script> -->