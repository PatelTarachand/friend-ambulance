<?php
include 'includes/header.php';

// Handle form submission
$message_sent = false;
$error_message = '';

if ($_POST) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Basic validation
    if (empty($name) || empty($phone) || empty($message)) {
        $error_message = 'Please fill in all required fields.';
    } elseif (!preg_match('/^[0-9]{10}$/', preg_replace('/[^0-9]/', '', $phone))) {
        $error_message = 'Please enter a valid 10-digit phone number.';
    } else {
        // In a real application, you would send email or save to database
        // For now, we'll just show a success message
        $message_sent = true;
    }
}

// Add structured data for better SEO
$contactStructuredData = [
    "@context" => "https://schema.org",
    "@type" => "ContactPage",
    "mainEntity" => [
        "@type" => "MedicalBusiness",
        "name" => SITE_NAME,
        "description" => "Contact Friends Ambulance Service for emergency and non-emergency medical transportation",
        "url" => SITE_URL . "/contact",
        "telephone" => PHONE_PRIMARY,
        "email" => EMAIL,
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => ADDRESS,
            "addressLocality" => "Raipur",
            "addressRegion" => "Chhattisgarh",
            "addressCountry" => "IN"
        ],
        "openingHours" => "Mo-Su 00:00-23:59",
        "areaServed" => [
            "@type" => "State",
            "name" => "Chhattisgarh"
        ]
    ]
];
?>

<!-- Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($contactStructuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- Main Content -->
<main id="main-content" role="main">

<!-- Enhanced Page Header -->
<section class="premium-contact-header bg-gradient-info text-white py-5 position-relative overflow-hidden"
         role="banner"
         aria-labelledby="contact-main-heading">
    <div class="contact-background-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="header-content" data-aos="fade-right">
                    <div class="header-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                        <span class="badge bg-light text-dark fs-6 px-3 py-2" role="status">
                            <i class="fas fa-phone me-2" aria-hidden="true"></i>CONTACT US
                        </span>
                    </div>
                    <h1 id="contact-main-heading"
                        class="display-5 fw-bold mb-3"
                        data-aos="fade-up"
                        data-aos-delay="200">Contact Friends Ambulance</h1>
                    <p class="lead"
                       data-aos="fade-up"
                       data-aos-delay="300">Get in touch with us for emergency or non-emergency ambulance services</p>
                    <div class="header-stats mt-4"
                         data-aos="fade-up"
                         data-aos-delay="400"
                         role="region"
                         aria-label="Contact statistics">
                        <div class="row">
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">24x7</span>
                                    <span class="text-light">Available</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">5</span>
                                    <span class="text-light">Min Response</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">3</span>
                                    <span class="text-light">Contact Ways</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <div class="header-visual" data-aos="fade-left" data-aos-delay="500">
                    <div class="contact-icon-showcase" role="img" aria-label="Contact showcase">
                        <i class="fas fa-phone display-1" aria-hidden="true"></i>
                        <div class="contact-waves" aria-hidden="true">
                            <div class="wave"></div>
                            <div class="wave"></div>
                            <div class="wave"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Emergency Contact -->
<section class="premium-emergency-contact bg-gradient-danger text-white py-4"
         role="region"
         aria-labelledby="emergency-heading">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center" data-aos="fade-right">
                    <div class="emergency-icon-container me-4" data-aos="pulse" data-aos-delay="200">
                        <i class="fas fa-exclamation-triangle fs-1 emergency-blink" aria-hidden="true"></i>
                    </div>
                    <div class="emergency-content" data-aos="fade-up" data-aos-delay="300">
                        <h4 id="emergency-heading" class="fw-bold mb-1">MEDICAL EMERGENCY?</h4>
                        <p class="mb-0">Don't wait! Call us immediately for fastest response</p>
                        <div class="emergency-features mt-2">
                            <span class="feature-tag">
                                <i class="fas fa-clock me-1" aria-hidden="true"></i>5-10 Min Response
                            </span>
                            <span class="feature-tag">
                                <i class="fas fa-ambulance me-1" aria-hidden="true"></i>24x7 Ready
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="emergency-cta" data-aos="fade-left" data-aos-delay="400">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                       class="btn btn-warning btn-lg emergency-call-btn"
                       aria-label="Call emergency number <?php echo formatPhone(PHONE_PRIMARY); ?>">
                        <i class="fas fa-phone me-2" aria-hidden="true"></i><?php echo formatPhone(PHONE_PRIMARY); ?>
                    </a>
                    <div class="emergency-note mt-2">
                        <small class="text-light opacity-75">
                            <i class="fas fa-shield-alt me-1" aria-hidden="true"></i>Trusted by 10,000+ families
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Contact Information -->
<section class="premium-contact-info py-5 bg-white"
         role="region"
         aria-labelledby="contact-info-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-info fs-6 px-3 py-2" role="status">
                    <i class="fas fa-address-book me-2" aria-hidden="true"></i>CONTACT INFO
                </span>
            </div>
            <h2 id="contact-info-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Get In Touch With Us</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">Multiple ways to reach us for your convenience</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="premium-contact-card h-100"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="article"
                     aria-labelledby="phone-heading">
                    <div class="contact-card-header">
                        <div class="contact-icon-wrapper" data-aos="zoom-in" data-aos-delay="300">
                            <div class="contact-icon bg-gradient-primary">
                                <i class="fas fa-phone text-white fs-1" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 id="phone-heading" class="fw-bold text-primary mt-3">Phone Numbers</h5>
                        <p class="text-muted small">Call us anytime for immediate assistance</p>
                    </div>
                    <div class="contact-details" data-aos="fade-up" data-aos-delay="400">
                        <div class="contact-item">
                            <div class="contact-label">
                                <i class="fas fa-star text-warning me-2" aria-hidden="true"></i>
                                <strong class="text-dark">Primary:</strong>
                            </div>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="contact-link"
                               aria-label="Call primary number <?php echo formatPhone(PHONE_PRIMARY); ?>">
                                <?php echo formatPhone(PHONE_PRIMARY); ?>
                            </a>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">
                                <i class="fas fa-phone text-info me-2" aria-hidden="true"></i>
                                <strong class="text-dark">Secondary:</strong>
                            </div>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_SECONDARY); ?>"
                               class="contact-link"
                               aria-label="Call secondary number <?php echo formatPhone(PHONE_SECONDARY); ?>">
                                <?php echo formatPhone(PHONE_SECONDARY); ?>
                            </a>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">
                                <i class="fas fa-phone-alt text-secondary me-2" aria-hidden="true"></i>
                                <strong class="text-dark">Alternate:</strong>
                            </div>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_TERTIARY); ?>"
                               class="contact-link"
                               aria-label="Call alternate number <?php echo formatPhone(PHONE_TERTIARY); ?>">
                                <?php echo formatPhone(PHONE_TERTIARY); ?>
                            </a>
                        </div>
                    </div>
                    <div class="contact-badges mt-4" data-aos="fade-up" data-aos-delay="500">
                        <span class="badge bg-success">24x7 Available</span>
                        <span class="badge bg-primary">Instant Response</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="premium-contact-card h-100"
                     data-aos="fade-up"
                     data-aos-delay="300"
                     role="article"
                     aria-labelledby="location-heading">
                    <div class="contact-card-header">
                        <div class="contact-icon-wrapper" data-aos="zoom-in" data-aos-delay="400">
                            <div class="contact-icon bg-gradient-danger">
                                <i class="fas fa-map-marker-alt text-white fs-1" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 id="location-heading" class="fw-bold text-danger mt-3">Our Location</h5>
                        <p class="text-muted small">Visit us at our main office</p>
                    </div>
                    <div class="contact-details" data-aos="fade-up" data-aos-delay="500">
                        <div class="location-info">
                            <div class="address-text">
                                <i class="fas fa-building text-danger me-2" aria-hidden="true"></i>
                                <span class="text-dark"><?php echo ADDRESS; ?></span>
                            </div>
                            <div class="location-features mt-3">
                                <div class="location-feature">
                                    <i class="fas fa-hospital text-info me-2" aria-hidden="true"></i>
                                    <span class="text-dark">Near Ramkrishna Care Hospital</span>
                                </div>
                                <div class="location-feature">
                                    <i class="fas fa-parking text-success me-2" aria-hidden="true"></i>
                                    <span class="text-dark">Parking Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-badges mt-4" data-aos="fade-up" data-aos-delay="600">
                        <a href="https://maps.google.com/?q=<?php echo urlencode(ADDRESS); ?>"
                           class="btn btn-outline-danger btn-sm"
                           target="_blank"
                           aria-label="Get directions to our location">
                            <i class="fas fa-directions me-1" aria-hidden="true"></i> Get Directions
                        </a>
                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                           class="btn btn-danger btn-sm"
                           aria-label="Call for location assistance">
                            <i class="fas fa-phone me-1" aria-hidden="true"></i> Call
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="premium-contact-card h-100"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="article"
                     aria-labelledby="digital-heading">
                    <div class="contact-card-header">
                        <div class="contact-icon-wrapper" data-aos="zoom-in" data-aos-delay="500">
                            <div class="contact-icon bg-gradient-success">
                                <i class="fab fa-whatsapp text-white fs-1" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 id="digital-heading" class="fw-bold text-success mt-3">WhatsApp & Email</h5>
                        <p class="text-muted small">Digital communication channels</p>
                    </div>
                    <div class="contact-details" data-aos="fade-up" data-aos-delay="600">
                        <div class="contact-item">
                            <div class="contact-label">
                                <i class="fab fa-whatsapp text-success me-2" aria-hidden="true"></i>
                                <strong class="text-success">WhatsApp:</strong>
                            </div>
                            <a href="https://wa.me/<?php echo WHATSAPP; ?>"
                               class="contact-link"
                               target="_blank"
                               aria-label="Chat on WhatsApp <?php echo formatPhone(str_replace('91', '', WHATSAPP)); ?>">
                                <?php echo formatPhone(str_replace('91', '', WHATSAPP)); ?>
                            </a>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">
                                <i class="fas fa-envelope text-info me-2" aria-hidden="true"></i>
                                <strong class="text-info">Email:</strong>
                            </div>
                            <a href="mailto:<?php echo EMAIL; ?>"
                               class="contact-link"
                               aria-label="Send email to <?php echo EMAIL; ?>">
                                <?php echo EMAIL; ?>
                            </a>
                        </div>
                        <div class="digital-features mt-3">
                            <div class="digital-feature">
                                <i class="fas fa-clock text-warning me-2" aria-hidden="true"></i>
                                <span class="text-warning">Quick Response</span>
                            </div>
                            <div class="digital-feature">
                                <i class="fas fa-file-alt text-primary me-2" aria-hidden="true"></i>
                                <span class="text-primary">Document Sharing</span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-badges mt-4" data-aos="fade-up" data-aos-delay="700">
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>"
                           class="btn btn-success btn-sm"
                           target="_blank"
                           aria-label="Start WhatsApp chat">
                            <i class="fab fa-whatsapp me-1" aria-hidden="true"></i> Chat Now
                        </a>
                        <a href="mailto:<?php echo EMAIL; ?>"
                           class="btn btn-outline-success btn-sm"
                           aria-label="Send email">
                            <i class="fas fa-envelope me-1" aria-hidden="true"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Contact Form -->
<section class="premium-contact-form bg-light py-5"
         role="region"
         aria-labelledby="contact-form-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-primary fs-6 px-3 py-2" role="status">
                    <i class="fas fa-envelope me-2" aria-hidden="true"></i>CONTACT FORM
                </span>
            </div>
            <h2 id="contact-form-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Send Us a Message</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">For non-emergency inquiries, service bookings, or general questions</p>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="premium-form-container"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="form"
                     aria-labelledby="contact-form-heading">

                    <?php if ($message_sent): ?>
                        <div class="alert alert-success alert-dismissible fade show"
                             role="alert"
                             data-aos="fade-down">
                            <div class="alert-content">
                                <i class="fas fa-check-circle me-2" aria-hidden="true"></i>
                                <strong>Success!</strong> Thank you for your message! We will contact you soon.
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                        <div class="alert alert-danger alert-dismissible fade show"
                             role="alert"
                             data-aos="fade-down">
                            <div class="alert-content">
                                <i class="fas fa-exclamation-circle me-2" aria-hidden="true"></i>
                                <strong>Error!</strong> <?php echo $error_message; ?>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" class="premium-contact-form-inner" data-aos="fade-up" data-aos-delay="500">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group" data-aos="fade-right" data-aos-delay="600">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user text-primary me-2" aria-hidden="true"></i>Full Name *
                                    </label>
                                    <input type="text"
                                           class="form-control premium-form-control"
                                           id="name"
                                           name="name"
                                           value="<?php echo $_POST['name'] ?? ''; ?>"
                                           placeholder="Enter your full name"
                                           required
                                           aria-describedby="name-help">
                                    <div id="name-help" class="form-text">We'll use this to address you properly</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" data-aos="fade-left" data-aos-delay="600">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone text-success me-2" aria-hidden="true"></i>Phone Number *
                                    </label>
                                    <input type="tel"
                                           class="form-control premium-form-control"
                                           id="phone"
                                           name="phone"
                                           value="<?php echo $_POST['phone'] ?? ''; ?>"
                                           placeholder="Enter 10-digit mobile number"
                                           pattern="[0-9]{10}"
                                           required
                                           aria-describedby="phone-help">
                                    <div id="phone-help" class="form-text">We'll call you back on this number</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" data-aos="fade-right" data-aos-delay="700">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope text-info me-2" aria-hidden="true"></i>Email Address
                                    </label>
                                    <input type="email"
                                           class="form-control premium-form-control"
                                           id="email"
                                           name="email"
                                           value="<?php echo $_POST['email'] ?? ''; ?>"
                                           placeholder="Enter your email address"
                                           aria-describedby="email-help">
                                    <div id="email-help" class="form-text">Optional - for email updates</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" data-aos="fade-left" data-aos-delay="700">
                                    <label for="service" class="form-label">
                                        <i class="fas fa-ambulance text-warning me-2" aria-hidden="true"></i>Service Required
                                    </label>
                                    <select class="form-select premium-form-control"
                                            id="service"
                                            name="service"
                                            aria-describedby="service-help">
                                        <option value="">Select Service Type</option>
                                        <option value="BLS Ambulance" <?php echo ($_POST['service'] ?? '') === 'BLS Ambulance' ? 'selected' : ''; ?>>
                                            BLS Ambulance - Basic Life Support
                                        </option>
                                        <option value="ALS Ambulance" <?php echo ($_POST['service'] ?? '') === 'ALS Ambulance' ? 'selected' : ''; ?>>
                                            ALS Ambulance - Advanced Life Support
                                        </option>
                                        <option value="ICU Ambulance" <?php echo ($_POST['service'] ?? '') === 'ICU Ambulance' ? 'selected' : ''; ?>>
                                            ICU Ambulance - Mobile ICU
                                        </option>
                                        <option value="Patient Transport" <?php echo ($_POST['service'] ?? '') === 'Patient Transport' ? 'selected' : ''; ?>>
                                            Patient Transport - Non-Emergency
                                        </option>
                                        <option value="General Inquiry" <?php echo ($_POST['service'] ?? '') === 'General Inquiry' ? 'selected' : ''; ?>>
                                            General Inquiry - Information
                                        </option>
                                    </select>
                                    <div id="service-help" class="form-text">Choose the service you need</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group" data-aos="fade-up" data-aos-delay="800">
                                    <label for="message" class="form-label">
                                        <i class="fas fa-comment text-secondary me-2" aria-hidden="true"></i>Message *
                                    </label>
                                    <textarea class="form-control premium-form-control"
                                              id="message"
                                              name="message"
                                              rows="5"
                                              placeholder="Please describe your requirements, location, and any specific needs..."
                                              required
                                              aria-describedby="message-help"><?php echo $_POST['message'] ?? ''; ?></textarea>
                                    <div id="message-help" class="form-text">Provide details about your requirements</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-submit" data-aos="fade-up" data-aos-delay="900">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg premium-submit-btn">
                                            <i class="fas fa-paper-plane me-2" aria-hidden="true"></i>Send Message
                                            <span class="btn-loading d-none">
                                                <i class="fas fa-spinner fa-spin me-2" aria-hidden="true"></i>Sending...
                                            </span>
                                        </button>
                                    </div>
                                    <div class="form-note mt-3 text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-shield-alt text-success me-1" aria-hidden="true"></i>
                                            Your information is secure and will not be shared with third parties
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Google Maps -->
<section class="premium-google-maps py-5 bg-white"
         role="region"
         aria-labelledby="maps-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-danger fs-6 px-3 py-2" role="status">
                    <i class="fas fa-map-marked-alt me-2" aria-hidden="true"></i>LOCATION
                </span>
            </div>
            <h2 id="maps-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Find Us on Map</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">Located near Ramkrishna Care Hospital, Pachpedi Naka, Raipur</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="premium-map-container"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="application"
                     aria-label="Google Maps showing our location">
                    <div class="map-wrapper">
                        <iframe
                            src="<?php echo GOOGLE_MAPS_EMBED; ?>"
                            width="100%"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Friends Ambulance Service Location Map">
                        </iframe>
                        <div class="map-overlay">
                            <div class="map-info">
                                <h6 class="fw-bold text-white mb-2">
                                    <i class="fas fa-map-marker-alt me-2" aria-hidden="true"></i>Our Location
                                </h6>
                                <p class="text-light small mb-3"><?php echo ADDRESS; ?></p>
                                <div class="map-actions">
                                    <a href="https://maps.google.com/?q=<?php echo urlencode(ADDRESS); ?>"
                                       class="btn btn-light btn-sm"
                                       target="_blank"
                                       aria-label="Open in Google Maps">
                                        <i class="fas fa-external-link-alt me-1" aria-hidden="true"></i>Open in Maps
                                    </a>
                                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                                       class="btn btn-warning btn-sm"
                                       aria-label="Call for directions">
                                        <i class="fas fa-phone me-1" aria-hidden="true"></i>Call for Directions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Features -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="location-features-grid" data-aos="fade-up" data-aos-delay="500">
                    <div class="location-feature-item" data-aos="zoom-in" data-aos-delay="600">
                        <i class="fas fa-hospital text-info" aria-hidden="true"></i>
                        <span class="text-info">Near Hospital</span>
                    </div>
                    <div class="location-feature-item" data-aos="zoom-in" data-aos-delay="700">
                        <i class="fas fa-parking text-success" aria-hidden="true"></i>
                        <span class="text-success">Parking Available</span>
                    </div>
                    <div class="location-feature-item" data-aos="zoom-in" data-aos-delay="800">
                        <i class="fas fa-road text-primary" aria-hidden="true"></i>
                        <span class="text-primary">Main Road Access</span>
                    </div>
                    <div class="location-feature-item" data-aos="zoom-in" data-aos-delay="900">
                        <i class="fas fa-bus text-warning" aria-hidden="true"></i>
                        <span class="text-warning">Public Transport</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Contact CTA -->
<section class="premium-quick-contact-cta bg-gradient-primary text-white py-5"
         role="region"
         aria-labelledby="cta-heading">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="cta-content" data-aos="fade-right">
                    <h3 id="cta-heading"
                        class="fw-bold mb-2"
                        data-aos="fade-up"
                        data-aos-delay="100">Need Immediate Assistance?</h3>
                    <p class="mb-0"
                       data-aos="fade-up"
                       data-aos-delay="200">Our emergency response team is available 24x7. Don't hesitate to call!</p>
                    <div class="cta-features mt-3"
                         data-aos="fade-up"
                         data-aos-delay="300">
                        <div class="row">
                            <div class="col-auto">
                                <div class="cta-feature">
                                    <i class="fas fa-clock text-warning me-2" aria-hidden="true"></i>
                                    <span>24x7 Available</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="cta-feature">
                                    <i class="fas fa-bolt text-warning me-2" aria-hidden="true"></i>
                                    <span>Instant Response</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="cta-actions"
                     data-aos="fade-left"
                     data-aos-delay="400"
                     role="group"
                     aria-label="Contact options">
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                           class="btn btn-warning btn-lg cta-btn"
                           aria-label="Call emergency number <?php echo formatPhone(PHONE_PRIMARY); ?>">
                            <i class="fas fa-phone me-2" aria-hidden="true"></i> Call Now
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>"
                           class="btn btn-success btn-lg cta-btn"
                           target="_blank"
                           aria-label="Contact via WhatsApp">
                            <i class="fab fa-whatsapp me-2" aria-hidden="true"></i> WhatsApp
                        </a>
                    </div>
                    <div class="cta-note mt-3" data-aos="fade-up" data-aos-delay="500">
                        <small class="text-light opacity-75">
                            <i class="fas fa-shield-alt me-1" aria-hidden="true"></i>
                            Trusted by thousands of families across Chhattisgarh
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<!-- Contact Page JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form Enhancement
    const form = document.querySelector('.premium-contact-form-inner');
    const submitBtn = document.querySelector('.premium-submit-btn');
    const btnText = submitBtn.querySelector('span:not(.btn-loading)');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            submitBtn.disabled = true;

            // Re-enable after a delay (for demo purposes)
            setTimeout(() => {
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
                submitBtn.disabled = false;
            }, 2000);
        });
    }

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            e.target.value = value;
        });
    }

    // Form validation feedback
    const formInputs = document.querySelectorAll('.premium-form-control');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
    });

    // Map overlay toggle
    const mapContainer = document.querySelector('.premium-map-container');
    const mapOverlay = document.querySelector('.map-overlay');

    if (mapContainer && mapOverlay) {
        mapContainer.addEventListener('mouseenter', function() {
            mapOverlay.style.opacity = '1';
        });

        mapContainer.addEventListener('mouseleave', function() {
            mapOverlay.style.opacity = '0';
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
