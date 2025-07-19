<?php
// Process contact form submission
$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Debug: Show that form was submitted
        error_log("Contact form submitted with data: " . print_r($_POST, true));

        // Get form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $msg = trim($_POST['message'] ?? '');

        // Debug: Show processed data
        error_log("Processed data - Name: $name, Email: $email, Message: $msg");

        // Basic validation
        if (empty($name) || empty($email) || empty($msg)) {
            throw new Exception('Name, email, and message are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }

        // Use existing database classes
        require_once 'admin/includes/database.php';

        // Prepare form data
        $formData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $msg
        ];

        // Save to database using existing ContactFormDB class
        $contactDB = new ContactFormDB();
        $submissionId = $contactDB->submitForm($formData);

        if ($submissionId) {
            $success = true;
            $message = "Thank you! Your message has been sent successfully. Submission ID: $submissionId";
            // Clear form data
            $_POST = [];
        } else {
            throw new Exception('Failed to save message');
        }

    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
}

// Error handling for contact page
error_reporting(E_ALL);
ini_set('display_errors', 1); // Show errors for debugging




// Try to include header, but handle errors gracefully
try {
    include 'includes/header.php';
} catch (Exception $e) {
    // Fallback constants if header fails
    if (!defined('SITE_NAME')) define('SITE_NAME', 'Friends Ambulance Service');
    if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', 'Raipur\'s Most Trusted Ambulance Service - 21+ Years');
    if (!defined('PHONE_PRIMARY')) define('PHONE_PRIMARY', '9329962163');
    if (!defined('PHONE_SECONDARY')) define('PHONE_SECONDARY', '8845987877');
    if (!defined('PHONE_TERTIARY')) define('PHONE_TERTIARY', '7000562163');
    if (!defined('EMAIL')) define('EMAIL', 'info@friendsambulance.com');
    if (!defined('ADDRESS')) define('ADDRESS', 'Near Gurudwara, Shankar Nagar, Raipur, Chhattisgarh 492007');
    if (!defined('WHATSAPP')) define('WHATSAPP', '919329962163');

    // Simple header fallback
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact - <?php echo SITE_NAME; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand text-danger fw-bold" href="index.php">
                    <i class="fas fa-ambulance me-2"></i><?php echo SITE_NAME; ?>
                </a>
                <div class="ms-auto">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-danger">
                        <i class="fas fa-phone me-1"></i> Call Now
                    </a>
                </div>
            </div>
        </nav>
    <?php
}

// Add structured data for better SEO
$contactStructuredData = [
    "@context" => "https://schema.org",
    "@type" => "ContactPage",
    "mainEntity" => [
        "@type" => "MedicalBusiness",
        "name" => SITE_NAME,
        "description" => "Contact Friends Ambulance Service for emergency and non-emergency medical transportation",
        "url" => (defined('SITE_URL') ? SITE_URL : 'http://localhost/protc/Friend') . "/contact.php",
        "telephone" => PHONE_PRIMARY,
        "email" => EMAIL,
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => ADDRESS,
            "addressLocality" => defined('CITY') ? CITY : "Raipur",
            "addressRegion" => defined('STATE') ? STATE : "Chhattisgarh",
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

<!-- Contact Page Styles -->
<style>
.premium-contact-header {
    min-height: 400px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.contact-background-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="20" cy="80" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.premium-contact-card {
    background: #fff;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.premium-contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.contact-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.contact-link {
    color: #007bff;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
}

.contact-link:hover {
    color: #0056b3;
    text-decoration: underline;
}

.premium-contact-form {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 3rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.premium-form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.premium-form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.premium-submit-btn {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    border-radius: 10px;
    padding: 15px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.premium-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,123,255,0.3);
}

.stat-highlight {
    text-align: center;
    padding: 0 1rem;
}

.emergency-blink {
    animation: blink 1.5s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.5; }
}

.contact-waves {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.wave {
    position: absolute;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    animation: wave 2s infinite;
}

.wave:nth-child(1) { width: 100px; height: 100px; animation-delay: 0s; }
.wave:nth-child(2) { width: 150px; height: 150px; animation-delay: 0.5s; }
.wave:nth-child(3) { width: 200px; height: 200px; animation-delay: 1s; }

@keyframes wave {
    0% { transform: translate(-50%, -50%) scale(0); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 0; }
}

.contact-icon-showcase {
    position: relative;
    display: inline-block;
}

.premium-map-container {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.map-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,123,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
</style>

<!-- Main Content -->
<main id="main-content" role="main">

<!-- Enhanced Page Header -->
<section class="premium-contact-header bg-primary text-white py-5 position-relative overflow-hidden"
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
<section class="premium-emergency-contact bg-danger text-white py-4"
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

                    <!-- Contact Form Alert Container -->
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?> alert-dismissible fade show mb-4">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="premium-contact-form-inner" data-aos="fade-up" data-aos-delay="500">
                        <!-- Honeypot field for spam protection -->
                        <input type="text" name="website" style="display: none;" tabindex="-1" autocomplete="off">
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
                                           value="<?php echo htmlspecialchars(($_POST['name'] ?? '') ?: ''); ?>"
                                           placeholder="Enter your full name"
                                           required
                                           aria-describedby="name-help">
                                    <div id="name-help" class="form-text">We'll use this to address you properly</div>
                                    <div class="invalid-feedback"></div>
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
                                           value="<?php echo htmlspecialchars(($_POST['phone'] ?? '') ?: ''); ?>"
                                           placeholder="Enter your phone number"
                                           aria-describedby="phone-help">
                                    <div id="phone-help" class="form-text">Optional - for urgent follow-up</div>
                                    <div class="invalid-feedback"></div>
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
                                           value="<?php echo htmlspecialchars(($_POST['email'] ?? '') ?: ''); ?>"
                                           placeholder="Enter your email address"
                                           required
                                           aria-describedby="email-help">
                                    <div id="email-help" class="form-text">We'll send you a confirmation</div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" data-aos="fade-left" data-aos-delay="700">
                                    <label for="subject" class="form-label">
                                        <i class="fas fa-ambulance text-primary me-2" aria-hidden="true"></i>Subject
                                    </label>
                                    <select class="form-select premium-form-control"
                                            id="subject"
                                            name="subject"
                                            aria-describedby="subject-help">
                                        <option value="">Select inquiry type</option>
                                        <option value="Emergency Ambulance" <?php echo (($_POST['subject'] ?? '') === 'Emergency Ambulance') ? 'selected' : ''; ?>>Emergency Ambulance</option>
                                        <option value="BLS Ambulance" <?php echo (($_POST['subject'] ?? '') === 'BLS Ambulance') ? 'selected' : ''; ?>>BLS Ambulance</option>
                                        <option value="ALS Ambulance" <?php echo (($_POST['subject'] ?? '') === 'ALS Ambulance') ? 'selected' : ''; ?>>ALS Ambulance</option>
                                        <option value="Patient Transport" <?php echo (($_POST['subject'] ?? '') === 'Patient Transport') ? 'selected' : ''; ?>>Patient Transport</option>
                                        <option value="Event Standby" <?php echo (($_POST['subject'] ?? '') === 'Event Standby') ? 'selected' : ''; ?>>Event Standby</option>
                                        <option value="General Inquiry" <?php echo (($_POST['subject'] ?? '') === 'General Inquiry') ? 'selected' : ''; ?>>General Inquiry</option>
                                        <option value="Other" <?php echo (($_POST['subject'] ?? '') === 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                    <div id="subject-help" class="form-text">Help us route your inquiry</div>
                                    <div class="invalid-feedback"></div>
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
                                              placeholder="Please provide details about your requirement, location, urgency level, and any special medical needs..."
                                              required
                                              aria-describedby="message-help"><?php echo htmlspecialchars(($_POST['message'] ?? '') ?: ''); ?></textarea>
                                    <div id="message-help" class="form-text">Include pickup location, destination, patient condition, and urgency</div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-center" data-aos="fade-up" data-aos-delay="900">
                                    <input type="submit" class="btn btn-primary btn-lg premium-submit-btn" value="Send Message" name="submit" />
                                        
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-shield-alt me-1" aria-hidden="true"></i>
                                            Your information is secure and will only be used to contact you about your ambulance service request.
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
// Simple form enhancement
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>


<?php include 'includes/footer.php'; ?>
