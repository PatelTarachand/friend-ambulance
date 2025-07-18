    <!-- Premium Footer -->
    <footer class="premium-footer bg-dark text-white position-relative overflow-hidden">
        <div class="footer-background-pattern"></div>

        <!-- Emergency Contact Strip -->
        <div class="emergency-footer-strip bg-danger py-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="emergency-pulse-icon me-3">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">MEDICAL EMERGENCY?</h6>
                                <small class="opacity-75">Call now for immediate ambulance dispatch</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <div class="emergency-contacts">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg me-2 emergency-call-btn">
                                <i class="fas fa-phone me-1"></i><?php echo formatPhone(PHONE_PRIMARY); ?>
                            </a>
                            <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Content -->
        <div class="footer-main py-5">
            <div class="container position-relative">
                <div class="row">
                    <!-- Company Info -->
                    <div class="col-lg-4 mb-4">
                        <div class="footer-brand mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="brand-icon me-3">
                                    <i class="fas fa-plus-circle text-danger fs-2"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold"><?php echo SITE_NAME; ?></h4>
                                    <div class="brand-tagline">
                                        <span class="badge bg-warning text-dark">Since 2003</span>
                                        <span class="text-muted ms-2">21+ Years of Trust</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="footer-description mb-4">Raipur's oldest and most trusted ambulance service, providing 24x7 emergency and non-emergency medical transportation with professional care and compassion.</p>

                        <!-- Trust Badges -->
                        <div class="trust-badges mb-4">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="trust-badge-item">
                                        <i class="fas fa-certificate text-primary me-2"></i>
                                        <span class="small">Licensed Service</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="trust-badge-item">
                                        <i class="fas fa-shield-alt text-success me-2"></i>
                                        <span class="small">Insured Fleet</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="trust-badge-item">
                                        <i class="fas fa-user-md text-info me-2"></i>
                                        <span class="small">Trained Staff</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="trust-badge-item">
                                        <i class="fas fa-clock text-warning me-2"></i>
                                        <span class="small">24x7 Available</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social-media">
                            <h6 class="fw-bold mb-3">Follow Us</h6>
                            <div class="social-links">
                                <a href="<?php echo FACEBOOK; ?>" class="social-link facebook" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="<?php echo TWITTER; ?>" class="social-link twitter" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="<?php echo INSTAGRAM; ?>" class="social-link instagram" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="social-link whatsapp" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                
                    <!-- Quick Links -->
                    <div class="col-lg-2 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-heading">
                                <i class="fas fa-link text-danger me-2"></i>Quick Links
                            </h5>
                            <ul class="footer-links">
                                <li><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home me-2"></i>Home</a></li>
                                <li><a href="about"><i class="fas fa-info-circle me-2"></i>About Us</a></li>
                                <li><a href="services"><i class="fas fa-ambulance me-2"></i>Services</a></li>
                                <li><a href="gallery"><i class="fas fa-images me-2"></i>Gallery</a></li>
                                <li><a href="contact"><i class="fas fa-envelope me-2"></i>Contact</a></li>
                                <li><a href="faq"><i class="fas fa-question-circle me-2"></i>FAQ</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="col-lg-3 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-heading">
                                <i class="fas fa-medical-kit text-danger me-2"></i>Our Services
                            </h5>
                            <div class="services-grid">
                                <div class="service-item">
                                    <div class="service-icon bg-success">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <div class="service-info">
                                        <h6 class="service-name">BLS Ambulance</h6>
                                        <p class="service-desc">Basic Life Support</p>
                                    </div>
                                </div>
                                <div class="service-item">
                                    <div class="service-icon bg-warning">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                    <div class="service-info">
                                        <h6 class="service-name">ALS Ambulance</h6>
                                        <p class="service-desc">Advanced Life Support</p>
                                    </div>
                                </div>
                                <div class="service-item">
                                    <div class="service-icon bg-danger">
                                        <i class="fas fa-procedures"></i>
                                    </div>
                                    <div class="service-info">
                                        <h6 class="service-name">ICU Ambulance</h6>
                                        <p class="service-desc">Intensive Care Unit</p>
                                    </div>
                                </div>
                                <div class="service-item">
                                    <div class="service-icon bg-info">
                                        <i class="fas fa-wheelchair"></i>
                                    </div>
                                    <div class="service-info">
                                        <h6 class="service-name">Patient Transport</h6>
                                        <p class="service-desc">Non-Emergency</p>
                                    </div>
                                </div>
                            </div>
                            <div class="service-highlight mt-3">
                                <div class="highlight-badge">
                                    <i class="fas fa-clock text-warning me-2"></i>
                                    <span class="fw-bold">24x7 Emergency Service</span>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Contact Information -->
                    <div class="col-lg-3 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-heading">
                                <i class="fas fa-phone text-danger me-2"></i>Contact Info
                            </h5>

                            <!-- Primary Emergency Contact -->
                            <div class="contact-section mb-3">
                                <div class="emergency-highlight-box">
                                    <div class="emergency-header">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        <span class="fw-bold text-warning">EMERGENCY HOTLINE</span>
                                    </div>
                                    <div class="emergency-number">
                                        <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="emergency-link">
                                            <i class="fas fa-phone me-2"></i><?php echo formatPhone(PHONE_PRIMARY); ?>
                                        </a>
                                         <a href="tel:<?php echo formatPhoneForCall(PHONE_SECONDARY); ?>" class="emergency-link">
                                                <i class="fas fa-phone me-2"></i><?php echo formatPhone(PHONE_SECONDARY); ?>
                                        </a>
                                        <a href="tel:<?php echo formatPhoneForCall(PHONE_TERTIARY); ?>" class="emergency-link">
                                                <i class="fas fa-phone me-2"></i><?php echo formatPhone(PHONE_TERTIARY); ?>
                                        </a>
                                        <div class="availability-badge">
                                            <i class="fas fa-clock me-1"></i>24x7 Available
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Address -->
                            <div class="contact-section">
                                <h6 class="contact-category mb-3">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>Our Location
                                </h6>
                                <div class="address-info">
                                    <div class="address-content">
                                        <i class="fas fa-building text-muted me-2"></i>
                                        <span class="address-text"><?php echo ADDRESS; ?></span>
                                    </div>
                                    <div class="location-features mt-2">
                                        <div class="location-feature">
                                            <i class="fas fa-hospital text-info me-1"></i>
                                            <small>Near Ramkrishna Care Hospital</small>
                                        </div>
                                        <div class="location-feature">
                                            <i class="fas fa-parking text-success me-1"></i>
                                            <small>Parking Available</small>
                                        </div>
                                    </div>
                                    <div class="location-actions mt-3">
                                        <a href="https://maps.google.com/?q=<?php echo urlencode(ADDRESS); ?>"
                                           class="btn btn-outline-light btn-sm me-2"
                                           target="_blank">
                                            <i class="fas fa-directions me-1"></i>Directions
                                        </a>
                                        <a href="contact" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-info-circle me-1"></i>More Info
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Newsletter & Updates -->
                <div class="row mt-5 d-none">
                    <div class="col-lg-8">
                        <div class="newsletter-section">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-bell text-warning me-2"></i>Stay Updated
                            </h5>
                            <p class="text-muted mb-3">Get important updates about our services, health tips, and emergency preparedness.</p>
                            <div class="newsletter-form">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Enter your email address">
                                    <button class="btn btn-danger" type="button">
                                        <i class="fas fa-paper-plane me-1"></i>Subscribe
                                    </button>
                                </div>
                                <small class="text-muted mt-2 d-block">We respect your privacy. Unsubscribe anytime.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer-stats">
                            <h6 class="fw-bold mb-3">Our Impact</h6>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <span class="stat-number">10,000+</span>
                                    <span class="stat-label">Lives Saved</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">21+</span>
                                    <span class="stat-label">Years Service</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">50+</span>
                                    <span class="stat-label">Cities Covered</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">24x7</span>
                                    <span class="stat-label">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom bg-darker py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="copyright-info">
                            <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                            <div class="legal-links mt-1">
                                <a href="privacy-policy" class="legal-link">Privacy Policy</a>
                                <span class="separator">•</span>
                                <a href="terms-of-service" class="legal-link">Terms of Service</a>
                                <span class="separator">•</span>
                                <a href="disclaimer" class="legal-link">Disclaimer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="footer-actions">
                            <div class="action-buttons">
                                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-danger btn-lg emergency-footer-btn">
                                    <i class="fas fa-phone me-2"></i>Emergency Call
                                </a>
                                <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg ms-2" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                </a>
                            </div>
                            <div class="back-to-top mt-2">
                                <button class="btn btn-outline-light btn-sm" id="backToTop">
                                    <i class="fas fa-arrow-up me-1"></i>Back to Top
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery - Latest Version -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap JS - Latest Version -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- AOS (Animate On Scroll) Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Intersection Observer Polyfill for older browsers -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>"></script>

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed');
                    });
            });
        }
    </script>

    <!-- Performance Monitoring -->
    <script>
        // Web Vitals monitoring
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.entryType === 'largest-contentful-paint') {
                        console.log('LCP:', entry.startTime);
                    }
                    if (entry.entryType === 'first-input') {
                        console.log('FID:', entry.processingStart - entry.startTime);
                    }
                }
            });
            observer.observe({entryTypes: ['largest-contentful-paint', 'first-input']});
        }
    </script>

   
</body>
</html>
