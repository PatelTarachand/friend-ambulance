// Friends Ambulance Service - jQuery Version

$(document).ready(function() {
    console.log('🚑 Friends Ambulance Service - Initializing with jQuery...');

    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false,
            offset: 100
        });
    }

    // Initialize all modules
    initScrollToTop();
    initGalleryFilter();
    initFormValidation();
    initSmoothScrolling();
    initAnimations();
    initPhoneFormatting();
    initHeroSlider();
    initCounterAnimation();
    initEnhancedInteractions();
    initLazyLoading();
    initPerformanceOptimizations();
    initAccessibilityFeatures();
    initPWAFeatures();

    console.log('✅ Friends Ambulance Service - Initialized successfully with jQuery');
});
// Scroll to Top Button - jQuery Version
function initScrollToTop() {
    // Create scroll to top button
    var scrollBtn = $('<button class="scroll-to-top" aria-label="Scroll to top"><i class="fas fa-arrow-up"></i></button>');
    $('body').append(scrollBtn);

    // Show/hide scroll button
    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            scrollBtn.addClass('show');
        } else {
            scrollBtn.removeClass('show');
        }
    });

    // Scroll to top functionality
    scrollBtn.click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });
}
// Gallery Filter - jQuery Version
function initGalleryFilter() {
    $('.gallery-filter').click(function() {
        var filter = $(this).data('filter');

        // Update active button
        $('.gallery-filter').removeClass('active');
        $(this).addClass('active');

        // Filter gallery items
        $('.gallery-item').each(function() {
            var category = $(this).data('category');

            if (filter === 'all' || category === filter) {
                $(this).show().addClass('slide-in-up');
            } else {
                $(this).hide().removeClass('slide-in-up');
            }
        });
    });
}
// Form Validation - jQuery Version
function initFormValidation() {
    $('form').submit(function(e) {
        var form = $(this);
        var isValid = true;

        // Validate required fields
        form.find('[required]').each(function() {
            var field = $(this);
            if (!field.val().trim()) {
                isValid = false;
                field.addClass('is-invalid');

                // Remove invalid class on input
                field.on('input', function() {
                    $(this).removeClass('is-invalid');
                });
            }
        });

        // Phone number validation
        var phoneField = form.find('input[type="tel"]');
        if (phoneField.length && phoneField.val()) {
            var phoneRegex = /^[0-9]{10}$/;
            var cleanPhone = phoneField.val().replace(/[^0-9]/g, '');

            if (!phoneRegex.test(cleanPhone)) {
                isValid = false;
                phoneField.addClass('is-invalid');

                // Show error message
                var errorMsg = phoneField.parent().find('.invalid-feedback');
                if (errorMsg.length === 0) {
                    errorMsg = $('<div class="invalid-feedback"></div>');
                    phoneField.parent().append(errorMsg);
                }
                errorMsg.text('Please enter a valid 10-digit phone number');
            }
        }

        // Email validation
        var emailField = form.find('input[type="email"]');
        if (emailField.length && emailField.val()) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(emailField.val())) {
                isValid = false;
                emailField.addClass('is-invalid');

                var errorMsg = emailField.parent().find('.invalid-feedback');
                if (errorMsg.length === 0) {
                    errorMsg = $('<div class="invalid-feedback"></div>');
                    emailField.parent().append(errorMsg);
                }
                errorMsg.text('Please enter a valid email address');
            }
        }

        if (!isValid) {
            e.preventDefault();

            // Scroll to first invalid field
            var firstInvalid = form.find('.is-invalid').first();
            if (firstInvalid.length) {
                $('html, body').animate({
                    scrollTop: firstInvalid.offset().top - 100
                }, 500);
                firstInvalid.focus();
            }
        }
    });
}
// Smooth Scrolling for Anchor Links - jQuery Version
function initSmoothScrolling() {
    $('a[href^="#"]').click(function(e) {
        var href = $(this).attr('href');

        if (href !== '#' && href.length > 1) {
            var target = $(href);

            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        }
    });
}
// Animations on Scroll - jQuery Version
function initAnimations() {
    // Use jQuery to handle scroll animations
    $(window).scroll(function() {
        $('.service-card, .feature-item, .contact-card, .gallery-card').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('slide-in-up');
            }
        });
    });
}
// Phone Number Formatting - jQuery Version
function initPhoneFormatting() {
    $('input[type="tel"]').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, '');

        if (value.length <= 10) {
            // Format as: 12345 67890
            if (value.length > 5) {
                value = value.substring(0, 5) + ' ' + value.substring(5);
            }
            $(this).val(value);
        }
    });
}

// Hero Slider Functionality (Only for Index Page) - jQuery Version
function initHeroSlider() {
    var $heroCarousel = $('#heroCarousel');
    if ($heroCarousel.length === 0) return;

    // Double check we're on the home page (index page only)
    var isHomePage = $('body').hasClass('home-page');

    if (!isHomePage) {
        console.log('Hero slider skipped - not on home page');
        return;
    }

    // Initialize Bootstrap carousel
    var carousel = new bootstrap.Carousel($heroCarousel[0], {
        interval: 5000,
        wrap: true,
        pause: 'hover'
    });

    // Add slide change event listener
    $heroCarousel.on('slide.bs.carousel', function (event) {
        // Reset animations for incoming slide
        var $incomingSlide = $(event.relatedTarget);
        var $animatedElements = $incomingSlide.find('.slide-in-left, .slide-in-right');

        // Remove animation classes temporarily
        $animatedElements.each(function() {
            $(this).css('animation', 'none');
            this.offsetHeight; // Trigger reflow
            $(this).css('animation', '');
        });
    });

    // Pause carousel on focus (accessibility)
    $heroCarousel.on('focusin', function() {
        carousel.pause();
    });

    $heroCarousel.on('focusout', function() {
        carousel.cycle();
    });

    // Keyboard navigation
    $(document).on('keydown', function(e) {
        if ($heroCarousel.is(':hover') || $heroCarousel.has(document.activeElement).length) {
            if (e.key === 'ArrowLeft') {
                carousel.prev();
            } else if (e.key === 'ArrowRight') {
                carousel.next();
            }
        }
    });

    // Touch/swipe support for mobile
    var startX = 0;
    var endX = 0;

    $heroCarousel.on('touchstart', function(e) {
        startX = e.originalEvent.touches[0].clientX;
    });

    $heroCarousel.on('touchend', function(e) {
        endX = e.originalEvent.changedTouches[0].clientX;
        handleSwipe();
    });

    function handleSwipe() {
        var threshold = 50; // Minimum swipe distance
        var diff = startX - endX;

        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                // Swiped left - next slide
                carousel.next();
            } else {
                // Swiped right - previous slide
                carousel.prev();
            }
        }
    }

    // Auto-pause on reduced motion preference
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        carousel.pause();
    }

    // Performance optimization - pause when not visible
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    carousel.cycle();
                } else {
                    carousel.pause();
                }
            });
        }, { threshold: 0.5 });

        observer.observe($heroCarousel[0]);
    }
}

// Counter Animation - jQuery Version
function initCounterAnimation() {
    var $counters = $('.counter');

    // Use scroll event to trigger counter animation
    $(window).scroll(function() {
        $counters.each(function() {
            var $counter = $(this);

            if (!$counter.hasClass('counted')) {
                var elementTop = $counter.offset().top;
                var elementBottom = elementTop + $counter.outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();

                // Check if element is 70% visible
                if (elementBottom > viewportTop && elementTop < (viewportBottom - $(window).height() * 0.3)) {
                    $counter.addClass('counted');
                    animateCounter($counter[0]);
                }
            }
        });
    });

    function animateCounter(element) {
        var target = parseInt($(element).data('target'));
        var duration = 2000; // 2 seconds
        var increment = target / (duration / 16); // 60fps
        var current = 0;

        var timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            $(element).text(Math.floor(current));
        }, 16);
    }
}

// Enhanced Interactions - jQuery Version
function initEnhancedInteractions() {
    // Emergency button pulse effect
    $('.emergency-call').hover(
        function() {
            $(this).css('animation', 'pulse 0.5s ease-in-out');
        },
        function() {
            $(this).css('animation', 'pulse 2s infinite');
        }
    );

    // Smooth reveal animations for sections
    var $revealElements = $('.why-choose-card, .service-area-card, .trust-item');

    // Initialize reveal elements
    $revealElements.css({
        'opacity': '0',
        'transform': 'translateY(30px)',
        'transition': 'all 0.6s ease-out'
    });

    // Use scroll event for reveal animation
    $(window).scroll(function() {
        $revealElements.each(function() {
            var $element = $(this);
            var elementTop = $element.offset().top;
            var elementBottom = elementTop + $element.outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $element.css({
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
            }
        });
    });

    // Enhanced accordion behavior
    $('.accordion-button').click(function() {
        var $button = $(this);
        // Add a small delay for smooth icon rotation
        setTimeout(function() {
            var $icon = $button.find('i');
            if ($icon.length && !$button.hasClass('collapsed')) {
                $icon.css('transform', 'rotate(180deg)');
            } else if ($icon.length) {
                $icon.css('transform', 'rotate(0deg)');
            }
        }, 100);
    });

    // Testimonial card hover effects
    $('.testimonial-card').hover(
        function() {
            $(this).css('transform', 'translateY(-5px) scale(1.02)');
        },
        function() {
            $(this).css('transform', 'translateY(0) scale(1)');
        }
    );

    // Service area card interactions
    $('.service-area-card').hover(
        function() {
            var $badge = $(this).find('.badge');
            if ($badge.length) {
                $badge.css('transform', 'scale(1.1)');
            }
        },
        function() {
            var $badge = $(this).find('.badge');
            if ($badge.length) {
                $badge.css('transform', 'scale(1)');
            }
        }
    );

    // Why choose us card stagger animation
    var $whyChooseCards = $('.why-choose-card');

    $whyChooseCards.each(function(index) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(30px)',
            'transition': 'all 0.6s ease-out ' + (index * 0.1) + 's'
        });
    });

    // Use scroll event for stagger animation
    $(window).scroll(function() {
        $whyChooseCards.each(function(index) {
            var $card = $(this);
            var elementTop = $card.offset().top;
            var elementBottom = elementTop + $card.outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < (viewportBottom - $(window).height() * 0.2)) {
                setTimeout(function() {
                    $card.css({
                        'opacity': '1',
                        'transform': 'translateY(0)'
                    });
                }, index * 100);
            }
        });
    });
}

// Emergency Call Tracking (Optional Analytics) - jQuery Version
function trackEmergencyCall() {
    $('a[href^="tel:"]').click(function() {
        // You can add analytics tracking here
        console.log('Emergency call initiated');

        // Example: Google Analytics event tracking
        // gtag('event', 'emergency_call', {
        //     'event_category': 'engagement',
        //     'event_label': 'phone_call'
        // });
    });
}

// WhatsApp Link Tracking - jQuery Version
function trackWhatsAppClick() {
    $('a[href*="wa.me"]').click(function() {
        console.log('WhatsApp link clicked');

        // Example: Analytics tracking
        // gtag('event', 'whatsapp_click', {
        //     'event_category': 'engagement',
        //     'event_label': 'whatsapp_contact'
        // });
    });
}

// Initialize tracking
trackEmergencyCall();
trackWhatsAppClick();

// Loading Animation for Forms - jQuery Version
$('button[type="submit"]').click(function() {
    var $button = $(this);
    var $form = $button.closest('form');

    if ($form.length && $form[0].checkValidity()) {
        $button.html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');
        $button.prop('disabled', true);

        // Re-enable after 3 seconds (adjust based on actual form processing time)
        setTimeout(function() {
            $button.html('<i class="fas fa-paper-plane me-2"></i>Send Message');
            $button.prop('disabled', false);
        }, 3000);
    }
});

// Navbar Scroll Effect - jQuery Version
$(window).scroll(function() {
    var $navbar = $('.navbar');
    if ($navbar.length) {
        if ($(window).scrollTop() > 100) {
            $navbar.addClass('shadow');
        } else {
            $navbar.removeClass('shadow');
        }
    }
});

// Auto-hide alerts after 5 seconds - jQuery Version
$('.alert').each(function() {
    var $alert = $(this);
    setTimeout(function() {
        $alert.fadeOut(300, function() {
            $(this).remove();
        });
    }, 5000);
});

// Modern Lazy Loading - jQuery Version
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var $img = $(entry.target);
                    $img.attr('src', $img.data('src'));
                    $img.removeClass('lazy');
                    $img.addClass('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        $('img[data-src]').each(function() {
            imageObserver.observe(this);
        });
    }
}

// Performance Optimizations - jQuery Version
function initPerformanceOptimizations() {
    // Preload critical resources
    preloadCriticalResources();

    // Optimize scroll performance
    optimizeScrollPerformance();

    // Implement resource hints
    implementResourceHints();
}

function preloadCriticalResources() {
    var criticalResources = [
        '/assets/css/style.css',
        '/assets/js/script.js'
    ];

    $.each(criticalResources, function(index, resource) {
        var link = $('<link>');
        link.attr('rel', 'preload');
        link.attr('href', resource);
        link.attr('as', resource.endsWith('.css') ? 'style' : 'script');
        $('head').append(link);
    });
}

function optimizeScrollPerformance() {
    var ticking = false;

    function updateScrollElements() {
        // Update scroll-dependent elements
        var scrollY = $(window).scrollTop();

        // Update navbar
        var $navbar = $('.navbar');
        if ($navbar.length) {
            $navbar.css('transform', 'translateY(' + (scrollY > 100 ? '-100%' : '0') + ')');
        }

        ticking = false;
    }

    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateScrollElements);
            ticking = true;
        }
    }

    $(window).on('scroll', requestTick);
}

function implementResourceHints() {
    // DNS prefetch for external resources
    var externalDomains = [
        'fonts.googleapis.com',
        'fonts.gstatic.com',
        'cdn.jsdelivr.net',
        'cdnjs.cloudflare.com'
    ];

    $.each(externalDomains, function(index, domain) {
        var link = $('<link>');
        link.attr('rel', 'dns-prefetch');
        link.attr('href', '//' + domain);
        $('head').append(link);
    });
}

// Accessibility Features - jQuery Version
function initAccessibilityFeatures() {
    setupKeyboardNavigation();
    setupScreenReaderSupport();
    setupFocusManagement();
}

function setupKeyboardNavigation() {
    // Enhanced keyboard navigation
    $(document).on('keydown', function(e) {
        if (e.key === 'Tab') {
            $('body').addClass('keyboard-navigation');
        }
    });

    $(document).on('mousedown', function() {
        $('body').removeClass('keyboard-navigation');
    });

    // Skip to main content
    var skipLink = $('<a href="#main-content" class="skip-link">Skip to main content</a>');
    $('body').prepend(skipLink);
}

function setupScreenReaderSupport() {
    // Add ARIA labels to interactive elements
    $('button:not([aria-label])').each(function() {
        var $button = $(this);
        if (!$button.attr('aria-label')) {
            var text = $button.text().trim() || $button.attr('title') || 'Button';
            $button.attr('aria-label', text);
        }
    });

    // Add live region for dynamic content
    var liveRegion = $('<div aria-live="polite" aria-atomic="true" class="sr-only" id="live-region"></div>');
    $('body').append(liveRegion);
}

function setupFocusManagement() {
    // Trap focus in modals
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            var $modal = $('.modal.show');
            if ($modal.length) {
                var $closeButton = $modal.find('[data-bs-dismiss="modal"]');
                if ($closeButton.length) {
                    $closeButton.click();
                }
            }
        }
    });
}

// PWA Features - jQuery Version
function initPWAFeatures() {
    setupInstallPrompt();
    setupOfflineSupport();
    setupPushNotifications();
}

function setupInstallPrompt() {
    var deferredPrompt;

    $(window).on('beforeinstallprompt', function(e) {
        e.preventDefault();
        deferredPrompt = e.originalEvent;

        // Show install button
        var $installButton = $('<button class="btn btn-primary install-app-btn"><i class="fas fa-download me-2"></i>Install App</button>');
        $installButton.css({
            'position': 'fixed',
            'bottom': '20px',
            'right': '20px',
            'z-index': '1000'
        });

        $installButton.click(function() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(function(choiceResult) {
                    console.log('User response to the install prompt: ' + choiceResult.outcome);
                    deferredPrompt = null;
                    $installButton.remove();
                });
            }
        });

        $('body').append($installButton);
    });
}

function setupOfflineSupport() {
    $(window).on('online', function() {
        showNotification('Connection restored', 'success');
    });

    $(window).on('offline', function() {
        showNotification('You are offline. Some features may not work.', 'warning');
    });
}

function setupPushNotifications() {
    if ('Notification' in window && 'serviceWorker' in navigator) {
        // Request notification permission
        if (Notification.permission === 'default') {
            Notification.requestPermission().then(function(permission) {
                console.log('Notification permission:', permission);
            });
        }
    }
}

// Utility method for notifications - jQuery Version
function showNotification(message, type) {
    type = type || 'info';
    var $notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show position-fixed">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>');

    $notification.css({
        'top': '20px',
        'right': '20px',
        'z-index': '1060',
        'max-width': '300px'
    });

    $('body').append($notification);

    setTimeout(function() {
        $notification.remove();
    }, 5000);
}

// Utility Functions - jQuery Compatible
function formatPhoneNumber(phone) {
    var cleaned = phone.replace(/\D/g, '');
    var match = cleaned.match(/^(\d{5})(\d{2})(\d{3})$/);
    if (match) {
        return match[1] + ' ' + match[2] + ' ' + match[3];
    }
    return phone;
}

function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    var cleaned = phone.replace(/\D/g, '');
    return cleaned.length === 10;
}

// jQuery Ready - All functions initialized
console.log('✅ Friends Ambulance Service - All functions converted to jQuery successfully!');
