<?php
include 'includes/header.php';

// Get hero background images from database
$heroBackgrounds = [];
try {
    require_once 'admin/includes/database.php';
    $heroBgDb = new HeroBackgroundDB();
    $heroBackgrounds = $heroBgDb->getAll();
} catch (Exception $e) {
    // Fallback to empty array if database fails
    $heroBackgrounds = [];
    error_log("Hero background database error: " . $e->getMessage());
}

// Convert to associative array for easy access
$bgImages = [];
foreach ($heroBackgrounds as $bg) {
    $bgImages[$bg['slide_number']] = $bg['background_image'];
}

// Since admin panel is removed, we'll use default slides
$sliderImages = [];
$hasCustomSliders = false;

// Add structured data for better SEO
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "MedicalBusiness",
    "name" => SITE_NAME,
    "description" => META_DESCRIPTION,
    "url" => SITE_URL,
    "telephone" => PHONE_PRIMARY,
    "priceRange" => "$$",
    "paymentAccepted" => "Cash, Card, UPI",
    "currenciesAccepted" => "INR",
    "availableService" => [
        [
            "@type" => "MedicalService",
            "name" => "Emergency Ambulance Service",
            "description" => "24x7 emergency medical transportation"
        ],
        [
            "@type" => "MedicalService",
            "name" => "BLS Ambulance",
            "description" => "Basic Life Support ambulance service"
        ],
        [
            "@type" => "MedicalService",
            "name" => "ALS Ambulance",
            "description" => "Advanced Life Support ambulance service"
        ]
    ]
];
?>

<!-- Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- Hero Background Styles -->
<style>
.hero-slide {
    position: relative;
    overflow: hidden;
    min-height: 100vh;
}

.hero-bg-image,
.hero-bg-overlay,
.hero-bg-gradient {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.hero-bg-image {
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-attachment: scroll;
    opacity: 1 !important;
    visibility: visible !important;
}

.hero-bg-overlay {
    /* Theme color overlay will be applied inline */
}

.hero-slide .container {
    position: relative;
    z-index: 100;
}

.hero-slide .row {
    position: relative;
    z-index: 100;
}

/* Ensure text is always visible with better contrast */
.hero-slide h1,
.hero-slide p,
.hero-slide .btn,
.hero-slide .badge {
    position: relative;
    z-index: 100;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.8);
}

.hero-slide .btn {
    text-shadow: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.hero-slide .badge {
    background-color: rgba(255,255,255,0.9) !important;
    color: #333 !important;
    text-shadow: none;
}

/* Ensure background images are visible */
.hero-slide {
    background-color: transparent !important;
}

.hero-bg-image {
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
}

.hero-bg-overlay {
    display: block !important;
}

/* Fix any conflicting background colors */
.carousel-item {
    background-color: transparent !important;
}

#heroCarousel {
    background-color: transparent !important;
}

/* Mobile optimization */
@media (max-width: 768px) {
    .hero-bg-image {
        background-attachment: scroll;
    }

    .hero-slide h1 {
        font-size: 2.5rem !important;
    }
}
</style>

<!-- Main Content -->
<main id="main-content" role="main">

<!-- Hero Slider Section - Enhanced -->
<section class="hero-slider" role="banner" aria-label="Main hero slider">
    <div id="heroCarousel" class="carousel slide carousel-fade"
         data-bs-ride="carousel"
         data-bs-interval="6000"
         data-bs-pause="hover"
         data-bs-keyboard="true"
         data-bs-touch="true"
         aria-label="Emergency ambulance service slideshow">
        <!-- Carousel Indicators - Enhanced Accessibility -->
        <div class="carousel-indicators" role="tablist" aria-label="Slide indicators">
            <?php if ($hasCustomSliders): ?>
                <?php foreach ($sliderImages as $index => $slider): ?>
                    <button type="button"
                            data-bs-target="#heroCarousel"
                            data-bs-slide-to="<?php echo $index; ?>"
                            <?php echo $index === 0 ? 'class="active" aria-current="true"' : ''; ?>
                            role="tab"
                            aria-controls="slide-<?php echo $index; ?>"
                            aria-label="Slide <?php echo $index + 1; ?>: <?php echo htmlspecialchars($slider['title']); ?>">
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0"
                        class="active" aria-current="true" role="tab"
                        aria-controls="slide-0" aria-label="Slide 1: Emergency Response"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"
                        role="tab" aria-controls="slide-1" aria-label="Slide 2: 21+ Years Experience"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"
                        role="tab" aria-controls="slide-2" aria-label="Slide 3: Advanced Equipment"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"
                        role="tab" aria-controls="slide-3" aria-label="Slide 4: Contact & Booking"></button>
            <?php endif; ?>
        </div>

        <!-- Carousel Inner - Enhanced -->
        <div class="carousel-inner" role="tabpanel">

                <!-- Default Slides (Enhanced) -->
                <!-- Slide 1 - Emergency Response -->
                <div class="carousel-item active"
                     id="slide-0"
                     role="tabpanel"
                     aria-labelledby="slide-0-tab"
                     data-aos="fade-in"
                     data-aos-duration="1000">
                <div class="hero-slide d-flex align-items-center min-vh-100 position-relative">
                    <?php if (isset($bgImages[1]) && $bgImages[1]): ?>
                        <div class="hero-bg-image"
                             style="background-image: url('<?php echo htmlspecialchars($bgImages[1]); ?>'); z-index: 1;"></div>
                    <?php else: ?>
                        <div class="hero-bg-gradient"
                             style="background: linear-gradient(135deg, #dc3545, #c82333); z-index: 1;"></div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content text-white" data-aos="fade-right" data-aos-delay="200">
                                    <div class="badge bg-warning text-dark mb-3 pulse fs-6"
                                         role="status"
                                         aria-label="Emergency ready status">
                                        <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i> EMERGENCY READY
                                    </div>
                                    <h1 class="display-3 fw-bold mb-4"
                                        data-aos="fade-up"
                                        data-aos-delay="300"
                                        role="heading"
                                        aria-level="1">
                                        <span class="text-warning">Emergency</span><br>
                                        Ambulance Service
                                    </h1>
                                    <p class="lead mb-4"
                                       data-aos="fade-up"
                                       data-aos-delay="400">
                                        Immediate response within 5-10 minutes. Our trained paramedics are ready
                                        24x7 with fully equipped ambulances for any medical emergency.
                                    </p>
                                    <div class="d-flex flex-wrap gap-3"
                                         data-aos="fade-up"
                                         data-aos-delay="500"
                                         role="group"
                                         aria-label="Emergency contact options">
                                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                                           class="btn btn-warning btn-lg"
                                           aria-label="Call emergency number <?php echo formatPhone(PHONE_PRIMARY); ?>">
                                            <i class="fas fa-phone me-2" aria-hidden="true"></i>
                                            CALL NOW: <?php echo formatPhone(PHONE_PRIMARY); ?>
                                        </a>
                                        <a href="https://wa.me/<?php echo WHATSAPP; ?>"
                                           class="btn btn-success btn-lg"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           aria-label="Contact us on WhatsApp">
                                            <i class="fab fa-whatsapp me-2" aria-hidden="true"></i> WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center" data-aos="fade-left" data-aos-delay="600">
                                    <div class="ambulance-icon-large" role="img" aria-label="Emergency ambulance icon">
                                        <i class="fas fa-ambulance text-warning blink"
                                           style="font-size: 8rem;"
                                           aria-hidden="true"></i>
                                    </div>
                                    <div class="emergency-pulse mt-4" aria-hidden="true">
                                        <div class="pulse-ring"></div>
                                        <div class="pulse-ring"></div>
                                        <div class="pulse-ring"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 - 21+ Years Experience -->
            <div class="carousel-item">
                <div class="hero-slide d-flex align-items-center min-vh-100 position-relative">
                    <?php if (isset($bgImages[2]) && $bgImages[2]): ?>
                        <div class="hero-bg-image"
                             style="background-image: url('<?php echo htmlspecialchars($bgImages[2]); ?>'); z-index: 1;"></div>
                    <?php else: ?>
                        <div class="hero-bg-gradient"
                             style="background: linear-gradient(135deg, #0d6efd, #0b5ed7); z-index: 1;"></div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content text-white">
                                    <div class="badge bg-success mb-3 fs-6">
                                        <i class="fas fa-award me-1"></i> TRUSTED SINCE 2003
                                    </div>
                                    <h1 class="display-3 fw-bold mb-4 slide-in-left">
                                        <span class="text-warning">21+ Years</span><br>
                                        of Trust & Service
                                    </h1>
                                    <p class="lead mb-4 slide-in-left" style="animation-delay: 0.2s;">
                                        Raipur's oldest and most experienced ambulance service provider.
                                        Thousands of families have trusted us during their critical moments.
                                    </p>
                                    <div class="row text-center mb-4 slide-in-left" style="animation-delay: 0.3s;">
                                        <div class="col-4">
                                            <h2 class="fw-bold text-warning">21+</h2>
                                            <small>Years Experience</small>
                                        </div>
                                        <div class="col-4">
                                            <h2 class="fw-bold text-warning">1000+</h2>
                                            <small>Lives Saved</small>
                                        </div>
                                        <div class="col-4">
                                            <h2 class="fw-bold text-warning">24x7</h2>
                                            <small>Available</small>
                                        </div>
                                    </div>
                                    <div class="slide-in-left" style="animation-delay: 0.4s;">
                                        <a href="about" class="btn btn-warning btn-lg me-3">
                                            <i class="fas fa-info-circle me-2"></i> Learn More
                                        </a>
                                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-outline-light btn-lg">
                                            <i class="fas fa-phone me-2"></i> Call Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center slide-in-right">
                                    <div class="experience-badge">
                                        <div class="badge-circle bg-warning text-dark">
                                            <div class="badge-content">
                                                <h1 class="fw-bold mb-0">21+</h1>
                                                <small>YEARS</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="trust-icons mt-4">
                                        <i class="fas fa-shield-alt text-success fs-1 me-3"></i>
                                        <i class="fas fa-heart text-danger fs-1 me-3"></i>
                                        <i class="fas fa-star text-warning fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 - Advanced Equipment -->
            <div class="carousel-item">
                <div class="hero-slide d-flex align-items-center min-vh-100 position-relative">
                    <?php if (isset($bgImages[3]) && $bgImages[3]): ?>
                        <div class="hero-bg-image"
                             style="background-image: url('<?php echo htmlspecialchars($bgImages[3]); ?>'); z-index: 1;"></div>
                    <?php else: ?>
                        <div class="hero-bg-gradient"
                             style="background: linear-gradient(135deg, #198754, #157347); z-index: 1;"></div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content text-white">
                                    <div class="badge bg-info mb-3 fs-6">
                                        <i class="fas fa-medical-kit me-1"></i> ADVANCED EQUIPMENT
                                    </div>
                                    <h1 class="display-3 fw-bold mb-4 slide-in-left">
                                        <span class="text-warning">Modern</span><br>
                                        Medical Equipment
                                    </h1>
                                    <p class="lead mb-4 slide-in-left" style="animation-delay: 0.2s;">
                                        State-of-the-art BLS, ALS, and ICU ambulances equipped with latest
                                        medical technology and life support systems.
                                    </p>
                                    <div class="equipment-list slide-in-left" style="animation-delay: 0.3s;">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="equipment-item mb-2">
                                                    <i class="fas fa-check-circle text-warning me-2"></i>
                                                    <span>Ventilator Support</span>
                                                </div>
                                                <div class="equipment-item mb-2">
                                                    <i class="fas fa-check-circle text-warning me-2"></i>
                                                    <span>Cardiac Monitor</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="equipment-item mb-2">
                                                    <i class="fas fa-check-circle text-warning me-2"></i>
                                                    <span>Oxygen Support</span>
                                                </div>
                                                <div class="equipment-item mb-2">
                                                    <i class="fas fa-check-circle text-warning me-2"></i>
                                                    <span>Emergency Medicines</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-in-left" style="animation-delay: 0.4s;">
                                        <a href="services" class="btn btn-warning btn-lg me-3">
                                            <i class="fas fa-ambulance me-2"></i> Our Services
                                        </a>
                                        <a href="gallery" class="btn btn-outline-light btn-lg">
                                            <i class="fas fa-images me-2"></i> View Gallery
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center slide-in-right">
                                    <div class="equipment-showcase">
                                        <div class="equipment-grid">
                                            <div class="equipment-icon">
                                                <i class="fas fa-heartbeat text-danger fs-1"></i>
                                            </div>
                                            <div class="equipment-icon">
                                                <i class="fas fa-lungs text-info fs-1"></i>
                                            </div>
                                            <div class="equipment-icon">
                                                <i class="fas fa-syringe text-warning fs-1"></i>
                                            </div>
                                            <div class="equipment-icon">
                                                <i class="fas fa-stethoscope text-success fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 4 - Contact & Booking -->
            <div class="carousel-item">
                <div class="hero-slide d-flex align-items-center min-vh-100 position-relative">
                    <?php if (isset($bgImages[4]) && $bgImages[4]): ?>
                        <div class="hero-bg-image"
                             style="background-image: url('<?php echo htmlspecialchars($bgImages[4]); ?>'); z-index: 1;"></div>
                    <?php else: ?>
                        <div class="hero-bg-gradient"
                             style="background: linear-gradient(135deg, #0dcaf0, #31d2f2); z-index: 1;"></div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content text-white">
                                    <div class="badge bg-danger mb-3 fs-6">
                                        <i class="fas fa-phone me-1"></i> INSTANT BOOKING
                                    </div>
                                    <h1 class="display-3 fw-bold mb-4 slide-in-left">
                                        <span class="text-warning">Book</span><br>
                                        Ambulance Now
                                    </h1>
                                    <p class="lead mb-4 slide-in-left" style="animation-delay: 0.2s;">
                                        Multiple ways to reach us - Phone call, WhatsApp, or online form.
                                        Emergency or scheduled bookings available 24x7.
                                    </p>
                                    <div class="contact-methods slide-in-left" style="animation-delay: 0.3s;">
                                        <div class="contact-item mb-3">
                                            <i class="fas fa-phone text-warning me-3 fs-4"></i>
                                            <div>
                                                <strong>Primary:</strong> <?php echo formatPhone(PHONE_PRIMARY); ?><br>
                                                <strong>Secondary:</strong> <?php echo formatPhone(PHONE_SECONDARY); ?>
                                            </div>
                                        </div>
                                        <div class="contact-item mb-3">
                                            <i class="fab fa-whatsapp text-success me-3 fs-4"></i>
                                            <div>
                                                <strong>WhatsApp:</strong> <?php echo formatPhone(str_replace('91', '', WHATSAPP)); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-in-left" style="animation-delay: 0.4s;">
                                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg me-3">
                                            <i class="fas fa-phone me-2"></i> Call Now
                                        </a>
                                        <a href="contact" class="btn btn-outline-light btn-lg">
                                            <i class="fas fa-envelope me-2"></i> Contact Form
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center slide-in-right">
                                    <div class="contact-visual">
                                        <div class="phone-ring">
                                            <i class="fas fa-phone text-warning fs-1"></i>
                                        </div>
                                        <div class="contact-options mt-4">
                                            <div class="contact-option">
                                                <i class="fab fa-whatsapp text-success fs-2"></i>
                                            </div>
                                            <div class="contact-option">
                                                <i class="fas fa-envelope text-info fs-2"></i>
                                            </div>
                                            <div class="contact-option">
                                                <i class="fas fa-map-marker-alt text-danger fs-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Carousel Controls - Enhanced Accessibility -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#heroCarousel"
                data-bs-slide="prev"
                aria-label="Previous slide"
                title="Go to previous slide">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous slide</span>
        </button>
        <button class="carousel-control-next"
                type="button"
                data-bs-target="#heroCarousel"
                data-bs-slide="next"
                aria-label="Next slide"
                title="Go to next slide">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next slide</span>
        </button>
    </div>
</section>

<!-- Quick Stats Bar - Enhanced -->
<section class="quick-stats bg-primary text-white py-3"
         role="region"
         aria-label="Key statistics">
    <div class="container">
        <div class="row text-center">
            <div class="col-6 col-md-3 mb-2 mb-md-0">
                <div class="stat-item"
                     data-aos="fade-up"
                     data-aos-delay="100">
                    <h4 class="fw-bold mb-0 counter"
                        data-target="21"
                        aria-label="21 years of experience">0</h4>
                    <small>Years Experience</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-2 mb-md-0">
                <div class="stat-item"
                     data-aos="fade-up"
                     data-aos-delay="200">
                    <h4 class="fw-bold mb-0 counter"
                        data-target="1000"
                        aria-label="Over 1000 lives saved">0</h4>
                    <small>Lives Saved</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item"
                     data-aos="fade-up"
                     data-aos-delay="300">
                    <h4 class="fw-bold mb-0"
                        aria-label="Available 24 hours 7 days a week">24x7</h4>
                    <small>Available</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item"
                     data-aos="fade-up"
                     data-aos-delay="400">
                    <h4 class="fw-bold mb-0 counter"
                        data-target="5"
                        aria-label="5 minute response time">0</h4>
                    <small>Min Response</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Contact Banner -->
<section class="emergency-contact-banner bg-danger text-white py-3 d-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="emergency-icon me-3">
                        <i class="fas fa-ambulance blink fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">MEDICAL EMERGENCY?</h5>
                        <p class="mb-0">Don't wait! Our emergency response team is ready 24x7</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="emergency-buttons">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg me-2 emergency-call">
                        <i class="fas fa-phone me-1"></i> <?php echo formatPhone(PHONE_PRIMARY); ?>
                    </a>
                    <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                        <i class="fab fa-whatsapp me-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="hero-section bg-gradient-danger text-white py-5 d-none">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <div class="hero-content">
                    <div class="badge bg-warning text-dark mb-3 pulse">
                        <i class="fas fa-clock me-1"></i> 24x7 AVAILABLE
                    </div>
                    <h1 class="display-4 fw-bold mb-3">
                        Raipur's Most <span class="text-warning">Trusted</span> Ambulance Service
                    </h1>
                    <p class="lead mb-4">
                        21+ years of dedicated service providing emergency and non-emergency medical transportation. 
                        Professional, compassionate, and always ready to serve.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg">
                            <i class="fas fa-phone me-2"></i> Call Now: <?php echo formatPhone(PHONE_PRIMARY); ?>
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp
                        </a>
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="fw-bold text-warning">21+</h3>
                                <small>Years Experience</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="fw-bold text-warning">24x7</h3>
                                <small>Available</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="fw-bold text-warning">100%</h3>
                                <small>Trusted</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <div class="ambulance-animation">
                        <i class="fas fa-ambulance display-1 text-warning blink"></i>
                    </div>
                    <div class="emergency-badge mt-4">
                        <div class="badge bg-danger fs-6 pulse">
                            <i class="fas fa-heartbeat me-1"></i> EMERGENCY READY
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview - Enhanced -->
<section class="services-overview py-5 bg-white"
         role="region"
         aria-labelledby="services-heading">
    <div class="container">
        <div class="text-center mb-5">
            <h2 id="services-heading"
                class="fw-bold text-primary"
                data-aos="fade-up">Our Ambulance Services</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="100">Professional medical transportation with state-of-the-art equipment</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-icon">
                        <i class="fas fa-ambulance text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-primary">BLS Ambulance</h4>
                    <p class="text-muted">Basic Life Support ambulances equipped with essential medical equipment for stable patient transport.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i> Oxygen Support</li>
                        <li><i class="fas fa-check text-success me-2"></i> First Aid Kit</li>
                        <li><i class="fas fa-check text-success me-2"></i> Trained Paramedic</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-icon">
                        <i class="fas fa-heartbeat text-danger fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-danger">ALS Ambulance</h4>
                    <p class="text-muted">Advanced Life Support ambulances with critical care equipment for emergency situations.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i> Ventilator Support</li>
                        <li><i class="fas fa-check text-success me-2"></i> Cardiac Monitor</li>
                        <li><i class="fas fa-check text-success me-2"></i> Emergency Medicines</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-icon">
                        <i class="fas fa-hospital text-warning fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-warning">ICU Ambulance</h4>
                    <p class="text-muted">Mobile ICU with advanced life support systems for critical patient transportation.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i> ICU Equipment</li>
                        <li><i class="fas fa-check text-success me-2"></i> Specialist Doctor</li>
                        <li><i class="fas fa-check text-success me-2"></i> 24x7 Availability</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="services" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-right me-2"></i> View All Services
            </a>
        </div>
    </div>
</section>



<!-- Why Choose Friends Ambulance - Premium Section -->
<section class="why-choose-premium py-5 bg-light position-relative">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge mb-3">
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="fas fa-star me-2"></i>RAIPUR'S #1 CHOICE
                </span>
            </div>
            <h2 class="fw-bold text-primary display-5">Why Choose Friends Ambulance?</h2>
            <p class="lead text-muted">The most trusted name in emergency medical services since 2003</p>
            <div class="trust-indicators mt-4">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="trust-stat">
                            <span class="fw-bold text-primary fs-4 counter" data-target="21">0</span>
                            <span class="text-muted">+ Years</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-stat">
                            <span class="fw-bold text-success fs-4 counter" data-target="10000">0</span>
                            <span class="text-muted">+ Patients</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-stat">
                            <span class="fw-bold text-warning fs-4">4.9</span>
                            <span class="text-muted">/5 Rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Lightning Fast Response -->
            <div class="col-lg-4 col-md-6">
                <div class="premium-feature-card h-100 text-center p-4 bg-white rounded-4 shadow-lg position-relative">
                    <div class="feature-number">01</div>
                    <div class="icon-wrapper mb-4">
                        <div class="premium-icon-circle bg-gradient-primary text-white mx-auto">
                            <i class="fas fa-bolt fs-2"></i>
                        </div>
                        <div class="icon-pulse"></div>
                    </div>
                    <h5 class="fw-bold text-primary mb-3">Lightning Fast Response</h5>
                    <p class="text-muted mb-4">Industry-leading 5-10 minute response time within Raipur. Our GPS-tracked fleet and strategic positioning ensure we reach you faster than anyone else.</p>
                    <div class="feature-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-primary">5-10</span>
                                    <small class="d-block text-muted">Minutes</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-success">24x7</span>
                                    <small class="d-block text-muted">Available</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature-highlight mt-3">
                        <span class="badge bg-primary px-3 py-2">
                            <i class="fas fa-stopwatch me-1"></i>Fastest in City
                        </span>
                    </div>
                </div>
            </div>

            <!-- Expert Medical Team -->
            <div class="col-lg-4 col-md-6">
                <div class="premium-feature-card h-100 text-center p-4 bg-white rounded-4 shadow-lg position-relative">
                    <div class="feature-number">02</div>
                    <div class="icon-wrapper mb-4">
                        <div class="premium-icon-circle bg-gradient-success text-white mx-auto">
                            <i class="fas fa-user-md fs-2"></i>
                        </div>
                        <div class="icon-pulse"></div>
                    </div>
                    <h5 class="fw-bold text-success mb-3">Expert Medical Team</h5>
                    <p class="text-muted mb-4">Highly trained paramedics, certified EMTs, and experienced medical professionals. Our team undergoes continuous training to handle all emergency situations.</p>
                    <div class="feature-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-success">100%</span>
                                    <small class="d-block text-muted">Certified</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-info">15+</span>
                                    <small class="d-block text-muted">Avg Experience</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature-highlight mt-3">
                        <span class="badge bg-success px-3 py-2">
                            <i class="fas fa-certificate me-1"></i>Licensed Professionals
                        </span>
                    </div>
                </div>
            </div>

            <!-- Proven Track Record -->
            <div class="col-lg-4 col-md-6">
                <div class="premium-feature-card h-100 text-center p-4 bg-white rounded-4 shadow-lg position-relative">
                    <div class="feature-number">03</div>
                    <div class="icon-wrapper mb-4">
                        <div class="premium-icon-circle bg-gradient-warning text-dark mx-auto">
                            <i class="fas fa-trophy fs-2"></i>
                        </div>
                        <div class="icon-pulse"></div>
                    </div>
                    <h5 class="fw-bold text-warning mb-3">Proven Track Record</h5>
                    <p class="text-muted mb-4">21+ years of excellence with over 10,000 successful emergency responses. Raipur's most trusted ambulance service with an unmatched safety record.</p>
                    <div class="feature-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-warning">21+</span>
                                    <small class="d-block text-muted">Years</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-danger">10K+</span>
                                    <small class="d-block text-muted">Lives Saved</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature-highlight mt-3">
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="fas fa-medal me-1"></i>Since 2003
                        </span>
                    </div>
                </div>
            </div>

            <!-- Advanced Life Support -->
            <div class="col-lg-4 col-md-6">
                <div class="premium-feature-card h-100 text-center p-4 bg-white rounded-4 shadow-lg position-relative">
                    <div class="feature-number">04</div>
                    <div class="icon-wrapper mb-4">
                        <div class="premium-icon-circle bg-gradient-info text-white mx-auto">
                            <i class="fas fa-heartbeat fs-2"></i>
                        </div>
                        <div class="icon-pulse"></div>
                    </div>
                    <h5 class="fw-bold text-info mb-3">Advanced Life Support</h5>
                    <p class="text-muted mb-4">State-of-the-art medical equipment including ventilators, defibrillators, cardiac monitors, and complete emergency medicine inventory.</p>
                    <div class="feature-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-info">BLS</span>
                                    <small class="d-block text-muted">ALS & ICU</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-primary">GPS</span>
                                    <small class="d-block text-muted">Tracked</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature-highlight mt-3">
                        <span class="badge bg-info px-3 py-2">
                            <i class="fas fa-microchip me-1"></i>Latest Technology
                        </span>
                    </div>
                </div>
            </div>

            <!-- Transparent Pricing -->
            <div class="col-lg-4 col-md-6">
                <div class="premium-feature-card h-100 text-center p-4 bg-white rounded-4 shadow-lg position-relative">
                    <div class="feature-number">05</div>
                    <div class="icon-wrapper mb-4">
                        <div class="premium-icon-circle bg-gradient-danger text-white mx-auto">
                            <i class="fas fa-hand-holding-heart fs-2"></i>
                        </div>
                        <div class="icon-pulse"></div>
                    </div>
                    <h5 class="fw-bold text-danger mb-3">Transparent Pricing</h5>
                    <p class="text-muted mb-4">Honest, upfront pricing with no hidden charges. Quality emergency care that's accessible to all families, with flexible payment options.</p>
                    <div class="feature-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-danger">0%</span>
                                    <small class="d-block text-muted">Hidden Fees</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-success">100%</span>
                                    <small class="d-block text-muted">Transparent</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature-highlight mt-3">
                        <span class="badge bg-danger px-3 py-2">
                            <i class="fas fa-receipt me-1"></i>Fair Pricing
                        </span>
                    </div>
                </div>
            </div>

            <!-- Complete Coverage -->
            <div class="col-lg-4 col-md-6">
                <div class="premium-feature-card h-100 text-center p-4 bg-white rounded-4 shadow-lg position-relative">
                    <div class="feature-number">06</div>
                    <div class="icon-wrapper mb-4">
                        <div class="premium-icon-circle bg-gradient-secondary text-white mx-auto">
                            <i class="fas fa-globe-asia fs-2"></i>
                        </div>
                        <div class="icon-pulse"></div>
                    </div>
                    <h5 class="fw-bold text-secondary mb-3">Complete Coverage</h5>
                    <p class="text-muted mb-4">Comprehensive service across Chhattisgarh and neighboring states. From local emergencies to long-distance medical transfers.</p>
                    <div class="feature-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-secondary">50+</span>
                                    <small class="d-block text-muted">Cities</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <span class="fw-bold text-primary">500</span>
                                    <small class="d-block text-muted">KM Radius</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feature-highlight mt-3">
                        <span class="badge bg-secondary px-3 py-2">
                            <i class="fas fa-map-marked-alt me-1"></i>Pan-State Service
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom CTA Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="premium-cta-card bg-gradient-primary text-white p-5 rounded-4 text-center">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-3">Ready to Experience the Difference?</h3>
                            <p class="lead mb-0">Join thousands of families who trust Friends Ambulance for their emergency medical needs. Available 24x7, 365 days a year.</p>
                        </div>
                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <div class="d-grid gap-2">
                                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg">
                                    <i class="fas fa-phone me-2"></i><?php echo formatPhone(PHONE_PRIMARY); ?>
                                </a>
                                <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Service Areas Section -->
<section class="premium-service-areas py-5 bg-primary text-white position-relative overflow-hidden">
    <div class="area-background-pattern"></div>
    <div class="container position-relative">
        <div class="text-center mb-5">
            <div class="section-badge mb-3">
                <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                    <i class="fas fa-map-marked-alt me-2"></i>WIDE COVERAGE
                </span>
            </div>
            <h2 class="fw-bold display-5">Our Service Areas</h2>
            <p class="lead mb-4">Comprehensive ambulance coverage across Chhattisgarh and beyond</p>
            <div class="coverage-highlights">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="highlight-stat">
                            <span class="fw-bold fs-4 counter" data-target="50">0</span>
                            <span class="text-warning">+ Cities</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="highlight-stat">
                            <span class="fw-bold fs-4 counter" data-target="500">0</span>
                            <span class="text-warning">KM Radius</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="highlight-stat">
                            <span class="fw-bold fs-4">24x7</span>
                            <span class="text-warning">Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactive Service Areas Map -->
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="premium-area-card bg-white text-dark rounded-4 shadow-lg overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="header-icon me-3">
                                <i class="fas fa-map-marker-alt fs-2"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Primary Coverage Areas</h4>
                                <p class="mb-0 opacity-75">Fastest response zones with dedicated ambulances</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="area-zone primary-zone">
                                    <div class="zone-header">
                                        <i class="fas fa-building text-primary me-2"></i>
                                        <strong>Raipur Metro</strong>
                                    </div>
                                    <ul class="zone-list">
                                        <li><i class="fas fa-dot-circle text-success me-2"></i>Raipur City Center</li>
                                        <li><i class="fas fa-dot-circle text-success me-2"></i>Tikrapara</li>
                                        <li><i class="fas fa-dot-circle text-success me-2"></i>Pachpedi Naka</li>
                                        <li><i class="fas fa-dot-circle text-success me-2"></i>Shankar Nagar</li>
                                        <li><i class="fas fa-dot-circle text-success me-2"></i>Pandri</li>
                                    </ul>
                                    <div class="zone-badge">
                                        <span class="badge bg-success">5-10 Min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="area-zone secondary-zone">
                                    <div class="zone-header">
                                        <i class="fas fa-industry text-info me-2"></i>
                                        <strong>Industrial Belt</strong>
                                    </div>
                                    <ul class="zone-list">
                                        <li><i class="fas fa-dot-circle text-info me-2"></i>Durg</li>
                                        <li><i class="fas fa-dot-circle text-info me-2"></i>Bhilai Steel City</li>
                                        <li><i class="fas fa-dot-circle text-info me-2"></i>Rajnandgaon</li>
                                        <li><i class="fas fa-dot-circle text-info me-2"></i>Korba</li>
                                        <li><i class="fas fa-dot-circle text-info me-2"></i>Bilaspur</li>
                                    </ul>
                                    <div class="zone-badge">
                                        <span class="badge bg-info">10-20 Min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="area-zone extended-zone">
                                    <div class="zone-header">
                                        <i class="fas fa-mountain text-warning me-2"></i>
                                        <strong>Extended Areas</strong>
                                    </div>
                                    <ul class="zone-list">
                                        <li><i class="fas fa-dot-circle text-warning me-2"></i>Mahasamund</li>
                                        <li><i class="fas fa-dot-circle text-warning me-2"></i>Jagdalpur</li>
                                        <li><i class="fas fa-dot-circle text-warning me-2"></i>Ambikapur</li>
                                        <li><i class="fas fa-dot-circle text-warning me-2"></i>Raigarh</li>
                                        <li><i class="fas fa-dot-circle text-warning me-2"></i>Kanker</li>
                                    </ul>
                                    <div class="zone-badge">
                                        <span class="badge bg-warning text-dark">20-45 Min</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="premium-stats-card bg-white text-dark rounded-4 shadow-lg p-4 h-100">
                    <div class="stats-header text-center mb-4">
                        <div class="stats-icon">
                            <i class="fas fa-chart-line text-success fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-success mt-3">Coverage Statistics</h4>
                    </div>
                    <div class="stats-grid">
                        <div class="stat-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="stat-label">Total Cities</span>
                                <span class="stat-value fw-bold text-primary counter" data-target="50">0</span>
                            </div>
                            <div class="stat-bar">
                                <div class="stat-progress bg-primary" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="stat-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="stat-label">Coverage Radius</span>
                                <span class="stat-value fw-bold text-info">500 KM</span>
                            </div>
                            <div class="stat-bar">
                                <div class="stat-progress bg-info" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="stat-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="stat-label">Avg Response</span>
                                <span class="stat-value fw-bold text-success">12 Min</span>
                            </div>
                            <div class="stat-bar">
                                <div class="stat-progress bg-success" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="stat-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="stat-label">Availability</span>
                                <span class="stat-value fw-bold text-danger">24x7</span>
                            </div>
                            <div class="stat-bar">
                                <div class="stat-progress bg-danger" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="stats-footer mt-4 text-center">
                        <div class="badge bg-success px-3 py-2">
                            <i class="fas fa-shield-alt me-1"></i>Guaranteed Service
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inter-State Services -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="interstate-card bg-gradient-warning text-dark rounded-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center">
                                <div class="interstate-icon me-4">
                                    <i class="fas fa-route fs-1"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-2">Inter-State Medical Transport</h4>
                                    <p class="mb-2">Specialized long-distance ambulance services to neighboring states including Madhya Pradesh, Maharashtra, Odisha, and Jharkhand.</p>
                                    <div class="interstate-features">
                                        <span class="badge bg-dark me-2"><i class="fas fa-bed me-1"></i>ICU Equipped</span>
                                        <span class="badge bg-dark me-2"><i class="fas fa-user-md me-1"></i>Medical Attendant</span>
                                        <span class="badge bg-dark me-2"><i class="fas fa-gas-pump me-1"></i>Fuel Included</span>
                                        <span class="badge bg-dark"><i class="fas fa-phone me-1"></i>24x7 Support</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center mt-3 mt-lg-0">
                            <div class="interstate-cta">
                                <p class="fw-bold mb-2">Need Long Distance Transport?</p>
                                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-dark btn-lg">
                                    <i class="fas fa-phone me-2"></i>Call for Quote
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Contact for Areas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="area-contact-card bg-white rounded-4 shadow-lg p-4 text-center">
                    <h5 class="fw-bold text-primary mb-3">Not Sure If We Cover Your Area?</h5>
                    <p class="text-muted mb-4">Call us now to check availability and get instant response time estimates for your location.</p>
                    <div class="contact-buttons">
                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-phone me-2"></i><?php echo formatPhone(PHONE_PRIMARY); ?>
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp Location
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Booking Section -->
<section class="emergency-booking py-5 bg-gradient-danger text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="booking-content">
                    <h2 class="fw-bold mb-3">Need Ambulance Right Now?</h2>
                    <p class="lead mb-4">Don't wait in medical emergencies. Our dispatch team will connect you with the nearest available ambulance within minutes.</p>
                    <div class="booking-features">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-check-circle text-warning me-2"></i>
                                <span>Instant dispatch system</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-check-circle text-warning me-2"></i>
                                <span>GPS tracking available</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-check-circle text-warning me-2"></i>
                                <span>Trained medical staff</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-check-circle text-warning me-2"></i>
                                <span>All payment methods accepted</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="booking-action">
                    <div class="emergency-pulse mb-4">
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring"></div>
                        <i class="fas fa-ambulance fs-1 text-warning"></i>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg">
                            <i class="fas fa-phone me-2"></i>EMERGENCY CALL
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp Booking
                        </a>
                        <a href="contact" class="btn btn-outline-light">
                            <i class="fas fa-calendar me-2"></i>Schedule Transport
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Testimonials -->
<section class="premium-testimonials py-5 bg-light position-relative overflow-hidden">
    <div class="testimonials-background-pattern"></div>
    <div class="container position-relative">
        <div class="text-center mb-5">
            <div class="section-badge mb-3">
                <span class="badge bg-success fs-6 px-3 py-2">
                    <i class="fas fa-heart me-2"></i>PATIENT STORIES
                </span>
            </div>
            <h2 class="fw-bold text-primary display-5">What Our Patients Say</h2>
            <p class="lead text-muted">Real experiences from thousands of families we've served with care and compassion</p>

            <!-- Enhanced Rating Display -->
            <div class="premium-rating-card mt-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-auto">
                        <div class="rating-display">
                            <div class="rating-stars mb-2">
                                <i class="fas fa-star text-warning fs-4"></i>
                                <i class="fas fa-star text-warning fs-4"></i>
                                <i class="fas fa-star text-warning fs-4"></i>
                                <i class="fas fa-star text-warning fs-4"></i>
                                <i class="fas fa-star text-warning fs-4"></i>
                            </div>
                            <div class="rating-text">
                                <span class="fw-bold fs-3 text-primary">4.9</span>
                                <span class="text-muted">/5 Rating</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="rating-divider"></div>
                    </div>
                    <div class="col-auto">
                        <div class="review-stats">
                            <div class="stat-item">
                                <span class="fw-bold fs-4 text-success counter" data-target="500">0</span>
                                <span class="text-muted">+ Reviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="rating-divider"></div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-badge">
                            <div class="stat-item">
                                <span class="fw-bold fs-4 text-warning">98%</span>
                                <span class="text-muted">Satisfaction</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Testimonial Cards -->
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="premium-testimonial-card h-100 position-relative">
                    <div class="testimonial-quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="testimonial-header mb-3">
                        <div class="testimonial-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="testimonial-badge">
                            <span class="badge bg-success">Emergency Response</span>
                        </div>
                    </div>
                    <div class="testimonial-content mb-4">
                        <p class="testimonial-text">"Friends Ambulance saved my father's life! They arrived in just 4 minutes during his heart attack. The paramedic was incredibly skilled and the ambulance had all necessary equipment. Professional, caring, and efficient - exactly what you need in an emergency."</p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="author-info d-flex align-items-center">
                            <div class="author-avatar bg-gradient-primary">
                                <span class="author-initial">R</span>
                            </div>
                            <div class="author-details">
                                <h6 class="author-name">Rajesh Kumar</h6>
                                <div class="author-meta">
                                    <span class="location"><i class="fas fa-map-marker-alt me-1"></i>Raipur</span>
                                    <span class="date">2 weeks ago</span>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-verified">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Verified Patient</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="premium-testimonial-card h-100 position-relative">
                    <div class="testimonial-quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="testimonial-header mb-3">
                        <div class="testimonial-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="testimonial-badge">
                            <span class="badge bg-warning text-dark">Long-term Trust</span>
                        </div>
                    </div>
                    <div class="testimonial-content mb-4">
                        <p class="testimonial-text">"Our family has trusted Friends Ambulance for over 15 years. From my grandmother's regular dialysis trips to emergency situations, they've always been there. Affordable, reliable, and the staff treats patients like family. True to their name - real friends in need!"</p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="author-info d-flex align-items-center">
                            <div class="author-avatar bg-gradient-success">
                                <span class="author-initial">P</span>
                            </div>
                            <div class="author-details">
                                <h6 class="author-name">Priya Sharma</h6>
                                <div class="author-meta">
                                    <span class="location"><i class="fas fa-map-marker-alt me-1"></i>Tikrapara</span>
                                    <span class="date">1 month ago</span>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-verified">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Verified Patient</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="premium-testimonial-card h-100 position-relative">
                    <div class="testimonial-quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="testimonial-header mb-3">
                        <div class="testimonial-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="testimonial-badge">
                            <span class="badge bg-danger">Life Saver</span>
                        </div>
                    </div>
                    <div class="testimonial-content mb-4">
                        <p class="testimonial-text">"When my mother had a cardiac arrest at 2 AM, Friends Ambulance reached us in 6 minutes with full ICU setup. The paramedic's quick action and advanced equipment literally saved her life. Best ambulance service in Chhattisgarh - no doubt about it!"</p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="author-info d-flex align-items-center">
                            <div class="author-avatar bg-gradient-danger">
                                <span class="author-initial">A</span>
                            </div>
                            <div class="author-details">
                                <h6 class="author-name">Amit Patel</h6>
                                <div class="author-meta">
                                    <span class="location"><i class="fas fa-map-marker-alt me-1"></i>Durg</span>
                                    <span class="date">3 days ago</span>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-verified">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Verified Patient</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Testimonials Row -->
        <div class="row g-4 mt-2">
            <div class="col-lg-6">
                <div class="premium-testimonial-card horizontal-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="testimonial-content">
                                <div class="testimonial-stars mb-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="testimonial-text">"Inter-state transport from Raipur to Nagpur was seamless. Professional driver, medical attendant, and all facilities. Worth every penny!"</p>
                                <div class="author-info-inline">
                                    <strong>Dr. Sunita Verma</strong> • <span class="text-muted">Bilaspur</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="testimonial-badge-large">
                                <span class="badge bg-info">Inter-State</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="premium-testimonial-card horizontal-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="testimonial-content">
                                <div class="testimonial-stars mb-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="testimonial-text">"Transparent pricing, no hidden charges. They explained everything upfront. Honest service that you can trust completely."</p>
                                <div class="author-info-inline">
                                    <strong>Ramesh Gupta</strong> • <span class="text-muted">Korba</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="testimonial-badge-large">
                                <span class="badge bg-success">Transparent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials CTA -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="testimonials-cta-card text-center">
                    <h4 class="fw-bold text-primary mb-3">Share Your Experience</h4>
                    <p class="text-muted mb-4">Help others by sharing your experience with Friends Ambulance Service</p>
                    <div class="cta-buttons">
                        <a href="https://g.page/r/friends-ambulance-reviews" class="btn btn-primary btn-lg me-3" target="_blank">
                            <i class="fas fa-star me-2"></i>Write a Review
                        </a>
                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>Share Feedback
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium FAQ Section -->
<section class="premium-faq-section py-5 bg-gradient-light">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge mb-3">
                <span class="badge bg-info fs-6 px-3 py-2">
                    <i class="fas fa-question-circle me-2"></i>COMMON QUESTIONS
                </span>
            </div>
            <h2 class="fw-bold text-primary display-5">Frequently Asked Questions</h2>
            <p class="lead text-muted">Everything you need to know about our emergency ambulance services</p>
            <div class="faq-stats mt-4">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="stat-highlight">
                            <span class="fw-bold text-primary fs-4 counter" data-target="50">0</span>
                            <span class="text-muted">+ FAQs</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-highlight">
                            <span class="fw-bold text-success fs-4">24x7</span>
                            <span class="text-muted">Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Featured FAQ -->
                <div class="featured-faq-card mb-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="featured-content">
                                <h4 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-bolt text-warning me-2"></i>
                                    Emergency Response Time
                                </h4>
                                <p class="lead text-muted mb-3">Our average response time is <strong class="text-success">5-10 minutes</strong> within Raipur city limits. We maintain strategically positioned ambulances across the city for fastest possible emergency response.</p>
                                <div class="response-features">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="feature-item">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <span>GPS-tracked fleet</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="feature-item">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <span>24x7 dispatch center</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="response-time-visual">
                                <div class="time-circle">
                                    <span class="time-number">5-10</span>
                                    <span class="time-unit">Minutes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Accordion -->
                <div class="premium-accordion" id="premiumFAQ">
                    <div class="premium-accordion-item">
                        <div class="accordion-header">
                            <button class="premium-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <div class="question-icon">
                                    <i class="fas fa-rupee-sign"></i>
                                </div>
                                <div class="question-content">
                                    <h5 class="question-title">What are your charges and payment options?</h5>
                                    <p class="question-subtitle">Transparent pricing with flexible payment methods</p>
                                </div>
                                <div class="accordion-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </button>
                        </div>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#premiumFAQ">
                            <div class="premium-accordion-body">
                                <div class="answer-content">
                                    <p class="mb-3">Our pricing is completely transparent with no hidden charges. Costs depend on:</p>
                                    <div class="pricing-factors">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="factor-item">
                                                    <i class="fas fa-route text-primary me-2"></i>
                                                    <span>Distance traveled</span>
                                                </div>
                                                <div class="factor-item">
                                                    <i class="fas fa-ambulance text-success me-2"></i>
                                                    <span>Type of ambulance (BLS/ALS/ICU)</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="factor-item">
                                                    <i class="fas fa-clock text-warning me-2"></i>
                                                    <span>Duration of service</span>
                                                </div>
                                                <div class="factor-item">
                                                    <i class="fas fa-user-md text-info me-2"></i>
                                                    <span>Medical staff required</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-options mt-4">
                                        <h6 class="fw-bold mb-2">Payment Methods:</h6>
                                        <div class="payment-badges">
                                            <span class="badge bg-primary me-2">Cash</span>
                                            <span class="badge bg-success me-2">UPI</span>
                                            <span class="badge bg-info me-2">Card</span>
                                            <span class="badge bg-warning text-dark">Insurance</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="premium-accordion-item">
                        <div class="accordion-header">
                            <button class="premium-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <div class="question-icon">
                                    <i class="fas fa-ambulance"></i>
                                </div>
                                <div class="question-content">
                                    <h5 class="question-title">What types of ambulances do you have?</h5>
                                    <p class="question-subtitle">Complete range from basic to advanced life support</p>
                                </div>
                                <div class="accordion-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </button>
                        </div>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#premiumFAQ">
                            <div class="premium-accordion-body">
                                <div class="answer-content">
                                    <div class="ambulance-types">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="ambulance-type-card">
                                                    <div class="type-icon bg-success">
                                                        <i class="fas fa-plus"></i>
                                                    </div>
                                                    <h6 class="fw-bold">BLS Ambulance</h6>
                                                    <p class="small text-muted">Basic Life Support with essential medical equipment</p>
                                                    <ul class="feature-list">
                                                        <li>Oxygen support</li>
                                                        <li>First aid equipment</li>
                                                        <li>Trained EMT</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="ambulance-type-card">
                                                    <div class="type-icon bg-warning">
                                                        <i class="fas fa-heartbeat"></i>
                                                    </div>
                                                    <h6 class="fw-bold">ALS Ambulance</h6>
                                                    <p class="small text-muted">Advanced Life Support with cardiac monitoring</p>
                                                    <ul class="feature-list">
                                                        <li>Cardiac monitor</li>
                                                        <li>Defibrillator</li>
                                                        <li>Paramedic staff</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="ambulance-type-card">
                                                    <div class="type-icon bg-danger">
                                                        <i class="fas fa-procedures"></i>
                                                    </div>
                                                    <h6 class="fw-bold">ICU Ambulance</h6>
                                                    <p class="small text-muted">Mobile ICU with ventilator support</p>
                                                    <ul class="feature-list">
                                                        <li>Ventilator</li>
                                                        <li>Infusion pumps</li>
                                                        <li>Critical care team</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="premium-accordion-item">
                        <div class="accordion-header">
                            <button class="premium-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <div class="question-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="question-content">
                                    <h5 class="question-title">Are you available 24x7?</h5>
                                    <p class="question-subtitle">Round-the-clock emergency services</p>
                                </div>
                                <div class="accordion-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </button>
                        </div>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#premiumFAQ">
                            <div class="premium-accordion-body">
                                <div class="answer-content">
                                    <div class="availability-info">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <p class="mb-3">Yes! We provide <strong class="text-success">24x7 emergency ambulance services</strong> every day of the year including weekends and holidays.</p>
                                                <div class="availability-features">
                                                    <div class="feature-item mb-2">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span>24-hour dispatch center</span>
                                                    </div>
                                                    <div class="feature-item mb-2">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span>Always-ready ambulance fleet</span>
                                                    </div>
                                                    <div class="feature-item mb-2">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span>On-call medical staff</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <div class="availability-badge">
                                                    <div class="badge-circle bg-success">
                                                        <span class="badge-text">24x7</span>
                                                        <small>Available</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="premium-accordion-item">
                        <div class="accordion-header">
                            <button class="premium-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <div class="question-icon">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div class="question-content">
                                    <h5 class="question-title">Which areas do you cover?</h5>
                                    <p class="question-subtitle">Comprehensive coverage across Chhattisgarh</p>
                                </div>
                                <div class="accordion-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </button>
                        </div>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#premiumFAQ">
                            <div class="premium-accordion-body">
                                <div class="answer-content">
                                    <div class="coverage-info">
                                        <p class="mb-3">We provide comprehensive ambulance services across <strong>50+ cities</strong> in Chhattisgarh and neighboring states.</p>
                                        <div class="coverage-zones">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="zone-info">
                                                        <h6 class="fw-bold text-success">Primary Zone</h6>
                                                        <p class="small">5-15 minutes response</p>
                                                        <ul class="zone-list">
                                                            <li>Raipur City</li>
                                                            <li>Tikrapara</li>
                                                            <li>Pachpedi Naka</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="zone-info">
                                                        <h6 class="fw-bold text-info">Secondary Zone</h6>
                                                        <p class="small">15-30 minutes response</p>
                                                        <ul class="zone-list">
                                                            <li>Durg & Bhilai</li>
                                                            <li>Bilaspur</li>
                                                            <li>Korba</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="zone-info">
                                                        <h6 class="fw-bold text-warning">Extended Zone</h6>
                                                        <p class="small">30-60 minutes response</p>
                                                        <ul class="zone-list">
                                                            <li>Jagdalpur</li>
                                                            <li>Ambikapur</li>
                                                            <li>Other States</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ CTA Section -->
                <div class="faq-cta-section mt-5">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cta-content">
                                <h4 class="fw-bold text-primary mb-3">Still have questions?</h4>
                                <p class="text-muted mb-4">Our customer support team is available 24x7 to answer all your queries about our ambulance services.</p>
                                <div class="cta-buttons">
                                    <a href="faq" class="btn btn-primary btn-lg me-3">
                                        <i class="fas fa-question-circle me-2"></i>View All FAQs
                                    </a>
                                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-phone me-2"></i>Call Support
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="support-visual">
                                <div class="support-icon">
                                    <i class="fas fa-headset fs-1 text-primary"></i>
                                </div>
                                <p class="fw-bold text-primary mt-2">24x7 Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Trust Indicators -->
<section class="premium-trust-section py-5 bg-light position-relative overflow-hidden">
    <div class="trust-background-pattern"></div>
    <div class="container position-relative">
        <div class="text-center mb-5">
            <div class="section-badge mb-3">
                <span class="badge bg-success fs-6 px-3 py-2">
                    <i class="fas fa-shield-check me-2"></i>TRUSTED EXCELLENCE
                </span>
            </div>
            <h2 class="fw-bold text-primary display-5">Trusted by Thousands</h2>
            <p class="lead text-muted">The reasons why families across Chhattisgarh choose Friends Ambulance Service</p>

            <!-- Trust Statistics -->
            <div class="trust-stats-card mt-4">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="trust-stat-item">
                            <span class="fw-bold fs-3 text-primary counter" data-target="10000">0</span>
                            <span class="text-muted">+ Patients Served</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-divider"></div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-stat-item">
                            <span class="fw-bold fs-3 text-success">4.9</span>
                            <span class="text-muted">/5 Rating</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-divider"></div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-stat-item">
                            <span class="fw-bold fs-3 text-warning counter" data-target="98">0</span>
                            <span class="text-muted">% Satisfaction</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Trust Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-card h-100">
                    <div class="trust-card-header">
                        <div class="trust-icon-premium bg-gradient-primary">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-primary">Licensed</span>
                        </div>
                    </div>
                    <div class="trust-card-body">
                        <h5 class="fw-bold text-primary">Government Certified</h5>
                        <p class="text-muted">Licensed and certified ambulance service provider with all necessary permits and registrations.</p>
                        <div class="trust-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Valid License</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Insurance Coverage</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-card h-100">
                    <div class="trust-card-header">
                        <div class="trust-icon-premium bg-gradient-warning">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-warning text-dark">Since 2003</span>
                        </div>
                    </div>
                    <div class="trust-card-body">
                        <h5 class="fw-bold text-warning">21+ Years Legacy</h5>
                        <p class="text-muted">Over two decades of dedicated service, making us Raipur's most experienced ambulance provider.</p>
                        <div class="trust-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Established 2003</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Proven Track Record</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-card h-100">
                    <div class="trust-card-header">
                        <div class="trust-icon-premium bg-gradient-success">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-success">Certified</span>
                        </div>
                    </div>
                    <div class="trust-card-body">
                        <h5 class="fw-bold text-success">Expert Medical Team</h5>
                        <p class="text-muted">Highly trained paramedics, EMTs, and medical professionals with continuous skill development.</p>
                        <div class="trust-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Certified Paramedics</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Regular Training</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-card h-100">
                    <div class="trust-card-header">
                        <div class="trust-icon-premium bg-gradient-info">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-info">Guaranteed</span>
                        </div>
                    </div>
                    <div class="trust-card-body">
                        <h5 class="fw-bold text-info">Safety & Reliability</h5>
                        <p class="text-muted">Highest safety standards with well-maintained ambulances and strict quality protocols.</p>
                        <div class="trust-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Safety Protocols</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Quality Assurance</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Testimonials Slider -->
        <div class="row">
            <div class="col-12">
                <div class="trust-testimonials-section">
                    <h4 class="fw-bold text-center text-primary mb-4">What Makes Us Trustworthy</h4>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="mini-testimonial-card">
                                <div class="testimonial-quote">
                                    <i class="fas fa-quote-left text-primary"></i>
                                </div>
                                <p class="testimonial-text">"21 years of service speaks for itself. They've been our family's trusted partner for all medical emergencies."</p>
                                <div class="testimonial-author">
                                    <strong>Dr. Sharma</strong> • <span class="text-muted">Regular Client</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mini-testimonial-card">
                                <div class="testimonial-quote">
                                    <i class="fas fa-quote-left text-success"></i>
                                </div>
                                <p class="testimonial-text">"Professional, reliable, and always available. Their transparency in pricing builds complete trust."</p>
                                <div class="testimonial-author">
                                    <strong>Meera Patel</strong> • <span class="text-muted">Satisfied Customer</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mini-testimonial-card">
                                <div class="testimonial-quote">
                                    <i class="fas fa-quote-left text-warning"></i>
                                </div>
                                <p class="testimonial-text">"The best ambulance service in Chhattisgarh. Their quick response and expert care saved my father's life."</p>
                                <div class="testimonial-author">
                                    <strong>Rohit Gupta</strong> • <span class="text-muted">Grateful Family</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section bg-danger text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Need Emergency Ambulance Service?</h3>
                <p class="mb-0">Our trained team is ready 24x7 for immediate response. Don't wait in emergencies!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg">
                        <i class="fas fa-phone me-2"></i> Call Now
                    </a>
                    <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<!-- Performance Optimization Script -->
<script>
    // Preload next page resources
    const preloadLinks = [
        '/services',
        '/about',
        '/contact',
        '/gallery'
    ];

    preloadLinks.forEach(link => {
        const linkElement = document.createElement('link');
        linkElement.rel = 'prefetch';
        linkElement.href = link;
        document.head.appendChild(linkElement);
    });

    // Critical resource hints
    const criticalResources = [
        'https://fonts.gstatic.com',
        'https://cdn.jsdelivr.net'
    ];

    criticalResources.forEach(resource => {
        const linkElement = document.createElement('link');
        linkElement.rel = 'dns-prefetch';
        linkElement.href = resource;
        document.head.appendChild(linkElement);
    });
</script>

<?php include 'includes/footer.php'; ?>
