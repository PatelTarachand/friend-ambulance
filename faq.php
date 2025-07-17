<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="page-header bg-info text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Frequently Asked Questions</h1>
                <p class="lead">Common questions about our ambulance services</p>
            </div>
            <div class="col-lg-4 text-end">
                <i class="fas fa-question-circle display-1 opacity-25"></i>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="faq-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    
                    <!-- FAQ 1 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                <i class="fas fa-clock text-primary me-2"></i>
                                How quickly can you respond to an emergency call?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>We pride ourselves on rapid response times. In most cases within Raipur city, our ambulances can reach you within 5-10 minutes of your call. For areas outside the city, response time may vary from 15-30 minutes depending on location and traffic conditions.</p>
                                <p class="mb-0"><strong>Emergency Hotline:</strong> <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="text-decoration-none"><?php echo formatPhone(PHONE_PRIMARY); ?></a></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                <i class="fas fa-rupee-sign text-success me-2"></i>
                                What are your charges for ambulance services?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Our charges are transparent and affordable with no hidden fees. Pricing depends on:</p>
                                <ul>
                                    <li>Type of ambulance (BLS, ALS, or ICU)</li>
                                    <li>Distance traveled</li>
                                    <li>Duration of service</li>
                                    <li>Additional medical equipment required</li>
                                </ul>
                                <p class="mb-0">For exact pricing, please call us at <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="text-decoration-none"><?php echo formatPhone(PHONE_PRIMARY); ?></a>. We provide instant quotes over the phone.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                <i class="fas fa-ambulance text-danger me-2"></i>
                                What types of ambulances do you have?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>We have a comprehensive fleet of modern ambulances:</p>
                                <ul>
                                    <li><strong>BLS Ambulance:</strong> Basic Life Support with oxygen, first aid, and trained paramedic</li>
                                    <li><strong>ALS Ambulance:</strong> Advanced Life Support with ventilator, cardiac monitor, and emergency medicines</li>
                                    <li><strong>ICU Ambulance:</strong> Mobile ICU with complete intensive care setup and specialist doctor</li>
                                    <li><strong>Patient Transport:</strong> Comfortable vehicles for non-emergency medical transportation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                Which areas do you serve?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>We primarily serve Raipur and surrounding areas including:</p>
                                <ul>
                                    <li>Raipur City</li>
                                    <li>Tikrapara</li>
                                    <li>Pachpedi Naka</li>
                                    <li>Durg</li>
                                    <li>Bhilai</li>
                                    <li>Bilaspur</li>
                                </ul>
                                <p class="mb-0">We also provide inter-city and inter-state ambulance services. Contact us for availability and special arrangements.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 5 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                <i class="fas fa-user-md text-info me-2"></i>
                                Are your staff trained and certified?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Yes, absolutely! Our team consists of:</p>
                                <ul>
                                    <li><strong>Certified Paramedics:</strong> Trained in emergency medical procedures and life support</li>
                                    <li><strong>Experienced Drivers:</strong> Skilled in emergency driving and familiar with all routes</li>
                                    <li><strong>Medical Attendants:</strong> Compassionate staff trained in patient care</li>
                                    <li><strong>Specialist Doctors:</strong> Available for ICU ambulance services when required</li>
                                </ul>
                                <p class="mb-0">All our staff undergo regular training and certification updates to maintain the highest standards of care.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 6 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                Can I book an ambulance in advance?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Yes, you can book our ambulance services in advance for:</p>
                                <ul>
                                    <li>Scheduled medical appointments</li>
                                    <li>Hospital discharge transportation</li>
                                    <li>Inter-hospital transfers</li>
                                    <li>Regular dialysis or chemotherapy sessions</li>
                                    <li>Elderly care transportation</li>
                                </ul>
                                <p class="mb-0">For advance bookings, call us at <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="text-decoration-none"><?php echo formatPhone(PHONE_PRIMARY); ?></a> or WhatsApp at <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="text-decoration-none" target="_blank"><?php echo formatPhone(str_replace('91', '', WHATSAPP)); ?></a></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 7 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                                <i class="fas fa-shield-alt text-success me-2"></i>
                                Do you accept insurance?
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>We work with various insurance providers and can assist with insurance claims where applicable. However, coverage depends on your specific insurance policy.</p>
                                <p>We recommend:</p>
                                <ul>
                                    <li>Check with your insurance provider about ambulance coverage</li>
                                    <li>Keep all receipts and documentation</li>
                                    <li>Inform us about your insurance during booking</li>
                                </ul>
                                <p class="mb-0">Our staff can help you with the necessary documentation for insurance claims.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 8 -->
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="faq8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                                <i class="fas fa-phone text-danger me-2"></i>
                                What information should I provide when calling for emergency?
                            </button>
                        </h2>
                        <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>When calling for emergency ambulance service, please provide:</p>
                                <ul>
                                    <li><strong>Your exact location:</strong> Address, landmarks, or GPS coordinates</li>
                                    <li><strong>Patient's condition:</strong> Brief description of the medical emergency</li>
                                    <li><strong>Contact number:</strong> Your phone number for follow-up</li>
                                    <li><strong>Special requirements:</strong> If you need specific type of ambulance (ALS/ICU)</li>
                                    <li><strong>Access information:</strong> Floor number, building details, parking availability</li>
                                </ul>
                                <p class="mb-0">Stay calm and speak clearly. Our dispatcher will guide you through any additional questions.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Still Have Questions -->
<section class="still-questions bg-light py-5">
    <div class="container">
        <div class="text-center">
            <h3 class="fw-bold text-primary mb-3">Still Have Questions?</h3>
            <p class="lead text-muted mb-4">Our team is available 24x7 to answer your queries and provide assistance</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-phone me-2"></i> Call Us Now
                </a>
                <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-lg" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i> WhatsApp Chat
                </a>
                <a href="contact" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-envelope me-2"></i> Send Message
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
