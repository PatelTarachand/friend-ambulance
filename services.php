<?php
include 'includes/header.php';

// Add structured data for better SEO
$servicesStructuredData = [
    "@context" => "https://schema.org",
    "@type" => "MedicalBusiness",
    "name" => SITE_NAME,
    "description" => "Comprehensive ambulance and medical transportation services in Raipur, Chhattisgarh",
    "url" => SITE_URL . "/services",
    "telephone" => PHONE_PRIMARY,
    "areaServed" => [
        "@type" => "State",
        "name" => "Chhattisgarh"
    ],
    "hasOfferCatalog" => [
        "@type" => "OfferCatalog",
        "name" => "Ambulance Services",
        "itemListElement" => [
            [
                "@type" => "Offer",
                "itemOffered" => [
                    "@type" => "Service",
                    "name" => "BLS Ambulance Service",
                    "description" => "Basic Life Support ambulance with essential medical equipment"
                ]
            ],
            [
                "@type" => "Offer",
                "itemOffered" => [
                    "@type" => "Service",
                    "name" => "ALS Ambulance Service",
                    "description" => "Advanced Life Support ambulance for critical emergencies"
                ]
            ],
            [
                "@type" => "Offer",
                "itemOffered" => [
                    "@type" => "Service",
                    "name" => "ICU Ambulance Service",
                    "description" => "Mobile ICU with intensive care equipment"
                ]
            ]
        ]
    ]
];
?>
<!-- Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($servicesStructuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- Main Content -->
<main id="main-content" role="main">

<!-- Enhanced Page Header -->
<section class="premium-services-header bg-gradient-success text-white py-5 position-relative overflow-hidden"
         role="banner"
         aria-labelledby="services-main-heading">
    <div class="services-background-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="header-content" data-aos="fade-right">
                    <div class="header-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2" role="status">
                            <i class="fas fa-ambulance me-2" aria-hidden="true"></i>OUR SERVICES
                        </span>
                    </div>
                    <h1 id="services-main-heading"
                        class="display-5 fw-bold mb-3"
                        data-aos="fade-up"
                        data-aos-delay="200">Our Ambulance Services</h1>
                    <p class="lead"
                       data-aos="fade-up"
                       data-aos-delay="300">Comprehensive medical transportation solutions for all your needs</p>
                    <div class="header-stats mt-4"
                         data-aos="fade-up"
                         data-aos-delay="400"
                         role="region"
                         aria-label="Service statistics">
                        <div class="row">
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">3</span>
                                    <span class="text-warning">Service Types</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">50+</span>
                                    <span class="text-warning">Cities Covered</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">24x7</span>
                                    <span class="text-warning">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <div class="header-visual" data-aos="fade-left" data-aos-delay="500">
                    <div class="services-icon-showcase" role="img" aria-label="Ambulance services showcase">
                        <i class="fas fa-ambulance display-1" aria-hidden="true"></i>
                        <div class="showcase-rings" aria-hidden="true">
                            <div class="ring"></div>
                            <div class="ring"></div>
                            <div class="ring"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Emergency Services -->
<section class="emergency-services py-5 bg-white"
         role="region"
         aria-labelledby="emergency-services-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-danger fs-6 px-3 py-2" role="status">
                    <i class="fas fa-heartbeat me-2" aria-hidden="true"></i>EMERGENCY SERVICES
                </span>
            </div>
            <h2 id="emergency-services-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Emergency Ambulance Services</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">Immediate response for critical medical emergencies</p>
            <div class="emergency-stats mt-4"
                 data-aos="fade-up"
                 data-aos-delay="400"
                 role="region"
                 aria-label="Emergency response statistics">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="emergency-stat">
                            <span class="fw-bold fs-4 text-danger counter" data-target="5">0</span>
                            <span class="text-muted">Min Response</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="emergency-stat">
                            <span class="fw-bold fs-4 text-success counter" data-target="100">0</span>
                            <span class="text-muted">% Availability</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="premium-service-card h-100"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="article"
                     aria-labelledby="bls-heading">
                    <div class="service-header bg-gradient-primary text-white p-4 text-center">
                        <div class="service-icon-wrapper" data-aos="zoom-in" data-aos-delay="300">
                            <i class="fas fa-ambulance fs-1 mb-3" aria-hidden="true"></i>
                        </div>
                        <h4 id="bls-heading" class="fw-bold mb-1">BLS Ambulance</h4>
                        <small class="opacity-75">Basic Life Support</small>
                        <div class="service-badge mt-2">
                            <span class="badge bg-warning text-dark">Most Popular</span>
                        </div>
                    </div>
                    <div class="service-body p-4" data-aos="fade-up" data-aos-delay="400">
                        <p class="text-muted mb-4">
                            Equipped with essential medical equipment for stable patient transport
                            and basic emergency care during medical emergencies.
                        </p>
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-cogs me-2" aria-hidden="true"></i>Equipment & Features:
                        </h6>
                        <ul class="service-features-list" role="list" aria-label="BLS ambulance features">
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="500">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Oxygen Support System</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="600">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">First Aid Kit</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="700">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Stretcher & Wheelchair</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="800">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Trained Paramedic</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="900">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Emergency Medicines</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="1000">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Communication System</span>
                            </li>
                        </ul>
                        <div class="service-badges mt-4" data-aos="fade-up" data-aos-delay="1100">
                            <span class="badge bg-success">24x7 Available</span>
                            <span class="badge bg-info">Affordable Rates</span>
                        </div>
                        <div class="service-cta mt-4" data-aos="fade-up" data-aos-delay="1200">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-primary btn-sm w-100"
                               aria-label="Call for BLS ambulance service">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Book BLS Ambulance
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="premium-service-card h-100"
                     data-aos="fade-up"
                     data-aos-delay="300"
                     role="article"
                     aria-labelledby="als-heading">
                    <div class="service-header bg-gradient-danger text-white p-4 text-center">
                        <div class="service-icon-wrapper" data-aos="zoom-in" data-aos-delay="400">
                            <i class="fas fa-heartbeat fs-1 mb-3" aria-hidden="true"></i>
                        </div>
                        <h4 id="als-heading" class="fw-bold mb-1">ALS Ambulance</h4>
                        <small class="opacity-75">Advanced Life Support</small>
                        <div class="service-badge mt-2">
                            <span class="badge bg-warning text-dark">Critical Care</span>
                        </div>
                    </div>
                    <div class="service-body p-4" data-aos="fade-up" data-aos-delay="500">
                        <p class="text-muted mb-4">
                            Advanced medical equipment and trained personnel for critical
                            emergency situations requiring intensive care and monitoring.
                        </p>
                        <h6 class="fw-bold text-danger mb-3">
                            <i class="fas fa-stethoscope me-2" aria-hidden="true"></i>Equipment & Features:
                        </h6>
                        <ul class="service-features-list" role="list" aria-label="ALS ambulance features">
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="600">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Ventilator Support</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="700">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Cardiac Monitor</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="800">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Defibrillator</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="900">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">IV Fluids & Medications</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="1000">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Suction Unit</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="1100">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Trained Paramedic Team</span>
                            </li>
                        </ul>
                        <div class="service-badges mt-4" data-aos="fade-up" data-aos-delay="1200">
                            <span class="badge bg-success">24x7 Available</span>
                            <span class="badge bg-warning text-dark">Critical Care</span>
                        </div>
                        <div class="service-cta mt-4" data-aos="fade-up" data-aos-delay="1300">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-danger btn-sm w-100"
                               aria-label="Call for ALS ambulance service">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Book ALS Ambulance
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="premium-service-card h-100"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="article"
                     aria-labelledby="icu-heading">
                    <div class="service-header bg-gradient-warning p-4 text-center">
                        <div class="service-icon-wrapper" data-aos="zoom-in" data-aos-delay="500">
                            <i class="fas fa-hospital fs-1 mb-3 " aria-hidden="true"></i>
                        </div>
                        <h4 id="icu-heading" class="fw-bold mb-1">ICU Ambulance</h4>
                        <small class="opacity-75">Mobile Intensive Care Unit</small>
                        <div class="service-badge mt-2">
                            <span class="badge bg-danger text-white">Premium Care</span>
                        </div>
                    </div>
                    <div class="service-body p-4" data-aos="fade-up" data-aos-delay="600">
                        <p class="text-muted mb-4">
                            Mobile ICU with advanced life support systems for critical
                            patient transportation requiring intensive monitoring and care.
                        </p>
                        <h6 class="fw-bold text-warning mb-3">
                            <i class="fas fa-procedures me-2" aria-hidden="true"></i>Equipment & Features:
                        </h6>
                        <ul class="service-features-list" role="list" aria-label="ICU ambulance features">
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="700">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Complete ICU Setup</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="800">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Multi-Parameter Monitor</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="900">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Infusion Pumps</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="1000">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Specialist Doctor Available</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="1100">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Advanced Medications</span>
                            </li>
                            <li class="feature-item" role="listitem" data-aos="slide-right" data-aos-delay="1200">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Emergency Procedures</span>
                            </li>
                        </ul>
                        <div class="service-badges mt-4" data-aos="fade-up" data-aos-delay="1300">
                            <span class="badge bg-success">24x7 Available</span>
                            <span class="badge bg-danger">ICU Level Care</span>
                        </div>
                        <div class="service-cta mt-4" data-aos="fade-up" data-aos-delay="1400">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-warning btn-sm w-100"
                               aria-label="Call for ICU ambulance service">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Book ICU Ambulance
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Non-Emergency Services -->
<section class="non-emergency-services bg-light py-5"
         role="region"
         aria-labelledby="non-emergency-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-secondary fs-6 px-3 py-2" role="status">
                    <i class="fas fa-calendar-check me-2" aria-hidden="true"></i>NON-EMERGENCY
                </span>
            </div>
            <h2 id="non-emergency-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Non-Emergency Transport Services</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">Comfortable and safe medical transportation for planned procedures and appointments</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="premium-service-item"
                     data-aos="fade-right"
                     data-aos-delay="400"
                     role="article"
                     aria-labelledby="patient-transport-heading">
                    <div class="service-icon-container" data-aos="zoom-in" data-aos-delay="500">
                        <div class="service-icon me-4">
                            <i class="fas fa-wheelchair text-primary fs-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="service-content" data-aos="fade-up" data-aos-delay="600">
                        <h5 id="patient-transport-heading" class="fw-bold text-primary">Patient Transport</h5>
                        <p class="text-muted mb-3">
                            Safe and comfortable transportation for patients going to/from hospitals,
                            clinics, or medical appointments with professional care.
                        </p>
                        <ul class="service-features-list" role="list" aria-label="Patient transport features">
                            <li role="listitem" data-aos="slide-right" data-aos-delay="700">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Hospital to Home</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="800">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Inter-Hospital Transfer</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="900">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Medical Appointments</span>
                            </li>
                        </ul>
                        <div class="service-cta mt-3" data-aos="fade-up" data-aos-delay="1000">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-outline-primary btn-sm"
                               aria-label="Call for patient transport service">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Book Transport
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="premium-service-item"
                     data-aos="fade-left"
                     data-aos-delay="500"
                     role="article"
                     aria-labelledby="bed-to-bed-heading">
                    <div class="service-icon-container" data-aos="zoom-in" data-aos-delay="600">
                        <div class="service-icon me-4">
                            <i class="fas fa-bed text-success fs-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="service-content" data-aos="fade-up" data-aos-delay="700">
                        <h5 id="bed-to-bed-heading" class="fw-bold text-success">Bed-to-Bed Service</h5>
                        <p class="text-muted mb-3">
                            Complete bed-to-bed transfer service with trained staff to ensure
                            patient comfort and safety during transport with full assistance.
                        </p>
                        <ul class="service-features-list" role="list" aria-label="Bed-to-bed service features">
                            <li role="listitem" data-aos="slide-right" data-aos-delay="800">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Trained Attendants</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="900">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Comfortable Stretchers</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="1000">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Medical Supervision</span>
                            </li>
                        </ul>
                        <div class="service-cta mt-3" data-aos="fade-up" data-aos-delay="1100">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-outline-success btn-sm"
                               aria-label="Call for bed-to-bed service">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Book Service
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="premium-service-item"
                     data-aos="fade-right"
                     data-aos-delay="600"
                     role="article"
                     aria-labelledby="elderly-care-heading">
                    <div class="service-icon-container" data-aos="zoom-in" data-aos-delay="700">
                        <div class="service-icon me-4">
                            <i class="fas fa-user-injured text-warning fs-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="service-content" data-aos="fade-up" data-aos-delay="800">
                        <h5 id="elderly-care-heading" class="fw-bold text-warning">Elderly Care Transport</h5>
                        <p class="text-muted mb-3">
                            Specialized transportation for elderly patients with extra care
                            and attention to their specific needs and comfort requirements.
                        </p>
                        <ul class="service-features-list" role="list" aria-label="Elderly care transport features">
                            <li role="listitem" data-aos="slide-right" data-aos-delay="900">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Gentle Handling</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="1000">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Comfort Features</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="1100">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Family Accompaniment</span>
                            </li>
                        </ul>
                        <div class="service-cta mt-3" data-aos="fade-up" data-aos-delay="1200">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-outline-warning btn-sm"
                               aria-label="Call for elderly care transport">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Book Care Transport
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="premium-service-item"
                     data-aos="fade-left"
                     data-aos-delay="700"
                     role="article"
                     aria-labelledby="scheduled-appointments-heading">
                    <div class="service-icon-container" data-aos="zoom-in" data-aos-delay="800">
                        <div class="service-icon me-4">
                            <i class="fas fa-calendar-check text-info fs-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="service-content" data-aos="fade-up" data-aos-delay="900">
                        <h5 id="scheduled-appointments-heading" class="fw-bold text-info">Scheduled Appointments</h5>
                        <p class="text-muted mb-3">
                            Pre-planned medical transportation for regular treatments,
                            dialysis, chemotherapy, and routine check-ups with reliable scheduling.
                        </p>
                        <ul class="service-features-list" role="list" aria-label="Scheduled appointments features">
                            <li role="listitem" data-aos="slide-right" data-aos-delay="1000">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Advance Booking</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="1100">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Regular Schedules</span>
                            </li>
                            <li role="listitem" data-aos="slide-right" data-aos-delay="1200">
                                <i class="fas fa-check text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Reliable Service</span>
                            </li>
                        </ul>
                        <div class="service-cta mt-3" data-aos="fade-up" data-aos-delay="1300">
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                               class="btn btn-outline-info btn-sm"
                               aria-label="Call for scheduled appointment transport">
                                <i class="fas fa-phone me-2" aria-hidden="true"></i>Schedule Transport
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Service Areas -->
<section class="premium-service-areas py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge mb-3">
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="fas fa-map-marked-alt me-2"></i>COMPREHENSIVE COVERAGE
                </span>
            </div>
            <h2 class="fw-bold text-primary display-5">Our Service Areas</h2>
            <p class="lead text-muted">Extensive ambulance coverage across Chhattisgarh and neighboring states</p>
            <div class="coverage-highlights mt-4">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="highlight-stat">
                            <span class="fw-bold text-primary fs-4 counter" data-target="50">0</span>
                            <span class="text-muted">+ Cities</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="highlight-stat">
                            <span class="fw-bold text-success fs-4 counter" data-target="500">0</span>
                            <span class="text-muted">KM Radius</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="highlight-stat">
                            <span class="fw-bold text-warning fs-4">24x7</span>
                            <span class="text-muted">Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Coverage Map -->
        <div class="row g-4 mb-5">
            <!-- Primary Coverage -->
            <div class="col-lg-4">
                <div class="coverage-zone-card primary-coverage h-100">
                    <div class="zone-header">
                        <div class="zone-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Primary Coverage</h4>
                        <p class="mb-0 text-dark">Fastest response zones</p>
                        <div class="response-badge">
                            <span class="badge bg-success">5-15 Minutes</span>
                        </div>
                    </div>
                    <div class="zone-content">
                        <div class="area-grid">
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Raipur City Center</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Tikrapara</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Pachpedi Naka</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Shankar Nagar</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Pandri</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Tatibandh</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Mowa</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-success me-2"></i>
                                <span class="text-dark">Devendra Nagar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Coverage -->
            <div class="col-lg-4">
                <div class="coverage-zone-card secondary-coverage h-100">
                    <div class="zone-header">
                        <div class="zone-icon">
                            <i class="fas fa-industry"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Secondary Coverage</h4>
                        <p class="mb-0 text-dark">Industrial & nearby cities</p>
                        <div class="response-badge">
                            <span class="badge bg-info">15-30 Minutes</span>
                        </div>
                    </div>
                    <div class="zone-content">
                        <div class="area-grid">
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Durg</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Bhilai Steel City</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Bilaspur</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Korba</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Rajnandgaon</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Mahasamund</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Dhamtari</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-info me-2"></i>
                                <span class="text-dark">Baloda Bazar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extended Coverage -->
            <div class="col-lg-4">
                <div class="coverage-zone-card extended-coverage h-100">
                    <div class="zone-header">
                        <div class="zone-icon">
                            <i class="fas fa-route"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Extended Coverage</h4>
                        <p class="mb-0  text-dark">Long distance & inter-state</p>
                        <div class="response-badge">
                            <span class="badge bg-warning text-dark">30-60 Minutes</span>
                        </div>
                    </div>
                    <div class="zone-content">
                        <div class="area-grid">
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Jagdalpur</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Ambikapur</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Raigarh</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Kanker</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Jashpur</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Bastar</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Surguja</span>
                            </div>
                            <div class="area-item">
                                <i class="fas fa-dot-circle text-warning me-2"></i>
                                <span class="text-dark">Other States</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inter-State Services -->
        <div class="row">
            <div class="col-12">
                <div class="interstate-services-card bg-gradient-primary text-white rounded-4 p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-3">
                                <i class="fas fa-map me-3"></i>Inter-State Medical Transport
                            </h3>
                            <p class="lead mb-4">Specialized long-distance ambulance services to neighboring states with complete medical support and experienced staff.</p>
                            <div class="interstate-features">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-check-circle text-warning me-2"></i>
                                        <span>Madhya Pradesh</span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-check-circle text-warning me-2"></i>
                                        <span>Maharashtra</span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-check-circle text-warning me-2"></i>
                                        <span>Odisha</span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-check-circle text-warning me-2"></i>
                                        <span>Jharkhand</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center mt-4 mt-lg-0">
                            <div class="interstate-cta">
                                <h5 class="fw-bold mb-3">Need Long Distance?</h5>
                                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-warning btn-lg">
                                    <i class="fas fa-phone me-2"></i>Get Quote
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Information -->
<section class="pricing-info bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Transparent Pricing</h2>
            <p class="lead text-muted">Affordable rates with no hidden charges</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="pricing-card bg-white p-4 rounded shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold text-success mb-3">
                                <i class="fas fa-rupee-sign me-2"></i>Affordable & Transparent Rates
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-2 text-success"><i class="fas fa-check text-success me-2"></i> No hidden charges</li>
                                <li class="mb-2 text-success"><i class="fas fa-check text-success me-2"></i> Competitive pricing</li>
                                <li class="mb-2 text-success"><i class="fas fa-check text-success me-2"></i> Payment options available</li>
                                <li class="mb-2 text-success"><i class="fas fa-check text-success me-2"></i> Insurance accepted (where applicable)</li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="pricing-cta">
                                <p class="text-muted mb-2">Get Instant Quote</p>
                                <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-primary">
                                    <i class="fas fa-phone me-1"></i> Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Call to Action -->
<section class="cta-section bg-gradient-danger text-white py-5"
         role="region"
         aria-labelledby="cta-heading">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="cta-content" data-aos="fade-right">
                    <h3 id="cta-heading"
                        class="fw-bold mb-2"
                        data-aos="fade-up"
                        data-aos-delay="100">Need Ambulance Service Right Now?</h3>
                    <p class="mb-0"
                       data-aos="fade-up"
                       data-aos-delay="200">Our trained team is ready 24x7 for immediate response. Call us now for any emergency!</p>
                    <div class="emergency-info mt-3"
                         data-aos="fade-up"
                         data-aos-delay="300">
                        <div class="row">
                            <div class="col-auto">
                                <div class="emergency-stat">
                                    <i class="fas fa-clock text-warning me-2" aria-hidden="true"></i>
                                    <span>5-10 Min Response</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="emergency-stat">
                                    <i class="fas fa-phone text-warning me-2" aria-hidden="true"></i>
                                    <span>24x7 Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end"
                     data-aos="fade-left"
                     data-aos-delay="400"
                     role="group"
                     aria-label="Emergency contact options">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                       class="btn btn-warning btn-lg"
                       aria-label="Call emergency number <?php echo formatPhone(PHONE_PRIMARY); ?>">
                        <i class="fas fa-phone me-2" aria-hidden="true"></i> Emergency Call
                    </a>
                    <a href="https://wa.me/<?php echo WHATSAPP; ?>"
                       class="btn btn-success btn-lg"
                       target="_blank"
                       aria-label="Contact via WhatsApp">
                        <i class="fab fa-whatsapp me-2" aria-hidden="true"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php include 'includes/footer.php'; ?>
