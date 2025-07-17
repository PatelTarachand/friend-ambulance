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
?>

<!-- Page Header -->
<section class="page-header bg-info text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Contact Friends Ambulance</h1>
                <p class="lead">Get in touch with us for emergency or non-emergency ambulance services</p>
            </div>
            <div class="col-lg-4 text-end">
                <i class="fas fa-phone display-1 opacity-25"></i>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Contact -->
<section class="emergency-contact bg-danger text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fs-1 me-3 blink"></i>
                    <div>
                        <h4 class="fw-bold mb-1">MEDICAL EMERGENCY?</h4>
                        <p class="mb-0">Don't wait! Call us immediately for fastest response</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg">
                    <i class="fas fa-phone me-2"></i><?php echo formatPhone(PHONE_PRIMARY); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="contact-info py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="contact-card h-100 text-center p-4 border rounded shadow-sm">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-phone text-primary fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-primary">Phone Numbers</h5>
                    <div class="contact-details">
                        <p class="mb-2">
                            <strong>Primary:</strong><br>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="text-decoration-none">
                                <?php echo formatPhone(PHONE_PRIMARY); ?>
                            </a>
                        </p>
                        <p class="mb-2">
                            <strong>Secondary:</strong><br>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_SECONDARY); ?>" class="text-decoration-none">
                                <?php echo formatPhone(PHONE_SECONDARY); ?>
                            </a>
                        </p>
                        <p class="mb-0">
                            <strong>Alternate:</strong><br>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_TERTIARY); ?>" class="text-decoration-none">
                                <?php echo formatPhone(PHONE_TERTIARY); ?>
                            </a>
                        </p>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">24x7 Available</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="contact-card h-100 text-center p-4 border rounded shadow-sm">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-map-marker-alt text-danger fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-danger">Our Location</h5>
                    <div class="contact-details">
                        <p class="text-muted"><?php echo ADDRESS; ?></p>
                        <div class="mt-3">
                            <a href="https://maps.google.com/?q=<?php echo urlencode(ADDRESS); ?>" 
                               class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fas fa-directions me-1"></i> Get Directions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="contact-card h-100 text-center p-4 border rounded shadow-sm">
                    <div class="contact-icon mb-3">
                        <i class="fab fa-whatsapp text-success fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-success">WhatsApp & Email</h5>
                    <div class="contact-details">
                        <p class="mb-3">
                            <strong>WhatsApp:</strong><br>
                            <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="text-decoration-none" target="_blank">
                                <?php echo formatPhone(str_replace('91', '', WHATSAPP)); ?>
                            </a>
                        </p>
                        <p class="mb-0">
                            <strong>Email:</strong><br>
                            <a href="mailto:<?php echo EMAIL; ?>" class="text-decoration-none">
                                <?php echo EMAIL; ?>
                            </a>
                        </p>
                    </div>
                    <div class="mt-3">
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-sm" target="_blank">
                            <i class="fab fa-whatsapp me-1"></i> Chat Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="contact-form bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="form-container bg-white p-5 rounded shadow">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Send Us a Message</h3>
                        <p class="text-muted">For non-emergency inquiries, service bookings, or general questions</p>
                    </div>
                    
                    <?php if ($message_sent): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Thank you for your message! We will contact you soon.
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo $_POST['name'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo $_POST['phone'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo $_POST['email'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="service" class="form-label">Service Required</label>
                                <select class="form-select" id="service" name="service">
                                    <option value="">Select Service</option>
                                    <option value="BLS Ambulance" <?php echo ($_POST['service'] ?? '') === 'BLS Ambulance' ? 'selected' : ''; ?>>BLS Ambulance</option>
                                    <option value="ALS Ambulance" <?php echo ($_POST['service'] ?? '') === 'ALS Ambulance' ? 'selected' : ''; ?>>ALS Ambulance</option>
                                    <option value="ICU Ambulance" <?php echo ($_POST['service'] ?? '') === 'ICU Ambulance' ? 'selected' : ''; ?>>ICU Ambulance</option>
                                    <option value="Patient Transport" <?php echo ($_POST['service'] ?? '') === 'Patient Transport' ? 'selected' : ''; ?>>Patient Transport</option>
                                    <option value="General Inquiry" <?php echo ($_POST['service'] ?? '') === 'General Inquiry' ? 'selected' : ''; ?>>General Inquiry</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" name="message" rows="4" 
                                          required><?php echo $_POST['message'] ?? ''; ?></textarea>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Google Maps -->
<section class="google-maps py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Find Us on Map</h3>
            <p class="text-muted">Located near Ramkrishna Care Hospital, Pachpedi Naka, Raipur</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="map-container rounded overflow-hidden shadow">
                    <iframe
                        src="<?php echo GOOGLE_MAPS_EMBED; ?>"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Contact CTA -->
<section class="quick-contact-cta bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Need Immediate Assistance?</h3>
                <p class="mb-0">Our emergency response team is available 24x7. Don't hesitate to call!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning">
                        <i class="fas fa-phone me-1"></i> Call Now
                    </a>
                    <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success" target="_blank">
                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
