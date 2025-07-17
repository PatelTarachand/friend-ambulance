<?php
include 'includes/header.php';

// Add structured data for better SEO
$aboutStructuredData = [
    "@context" => "https://schema.org",
    "@type" => "AboutPage",
    "mainEntity" => [
        "@type" => "MedicalBusiness",
        "name" => SITE_NAME,
        "description" => "Raipur's most trusted emergency medical service provider since 2003",
        "foundingDate" => "2003",
        "founder" => [
            "@type" => "Person",
            "name" => "Founder of Friends Ambulance Service"
        ],
        "address" => [
            "@type" => "PostalAddress",
            "addressLocality" => "Raipur",
            "addressRegion" => "Chhattisgarh",
            "addressCountry" => "IN"
        ],
        "areaServed" => [
            "@type" => "State",
            "name" => "Chhattisgarh"
        ]
    ]
];
?>

<!-- Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($aboutStructuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- Main Content -->
<main id="main-content" role="main">

<!-- Enhanced Page Header -->
<section class="premium-page-header bg-gradient-primary text-white py-5 position-relative overflow-hidden"
         role="banner"
         aria-labelledby="about-heading">
    <div class="header-background-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="header-content" data-aos="fade-right">
                    <div class="header-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2" role="status">
                            <i class="fas fa-info-circle me-2" aria-hidden="true"></i>ABOUT US
                        </span>
                    </div>
                    <h1 id="about-heading"
                        class="display-4 fw-bold mb-3"
                        data-aos="fade-up"
                        data-aos-delay="200">Friends Ambulance Service</h1>
                    <p class="lead mb-4"
                       data-aos="fade-up"
                       data-aos-delay="300">Raipur's most trusted emergency medical service provider since 2003</p>
                    <div class="header-stats"
                         data-aos="fade-up"
                         data-aos-delay="400"
                         role="region"
                         aria-label="Key statistics">
                        <div class="row">
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4 counter"
                                          data-target="21"
                                          aria-label="21 years of experience">0</span>
                                    <span class="text-warning">+ Years</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4 counter"
                                          data-target="10000"
                                          aria-label="Over 10000 lives saved">0</span>
                                    <span class="text-warning">+ Lives</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4"
                                          aria-label="24 hours 7 days service">24x7</span>
                                    <span class="text-warning">Service</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="header-visual" data-aos="fade-left" data-aos-delay="500">
                    <div class="ambulance-icon-circle" role="img" aria-label="Ambulance service icon">
                        <i class="fas fa-ambulance display-1" aria-hidden="true"></i>
                    </div>
                    <div class="pulse-rings" aria-hidden="true">
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced About Content -->
<section class="premium-about-content py-5 bg-white"
         role="region"
         aria-labelledby="story-heading">
    <div class="container">
        <!-- Our Story Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="story-content" data-aos="fade-right">
                    <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                        <span class="badge bg-primary fs-6 px-3 py-2" role="status">
                            <i class="fas fa-book-open me-2" aria-hidden="true"></i>OUR STORY
                        </span>
                    </div>
                    <h2 id="story-heading"
                        class="fw-bold text-primary display-6 mb-4"
                        data-aos="fade-up"
                        data-aos-delay="200">21+ Years of Saving Lives</h2>
                    <p class="lead text-muted mb-4"
                       data-aos="fade-up"
                       data-aos-delay="300">
                        Founded in 2003, Friends Ambulance Service began with a simple yet powerful mission:
                        to provide reliable, professional, and compassionate medical transportation services
                        to the people of Raipur and Chhattisgarh.
                    </p>
                    <p class="mb-4"
                       data-aos="fade-up"
                       data-aos-delay="400">
                        What started as a small initiative has grown into the region's most trusted ambulance
                        service. Over two decades, we've responded to thousands of emergencies, transported
                        countless patients, and built lasting relationships with hospitals, healthcare providers,
                        and families across the state.
                    </p>

                    <!-- Enhanced Journey Timeline -->
                    <div class="journey-timeline mb-4"
                         data-aos="fade-up"
                         data-aos-delay="500"
                         role="region"
                         aria-label="Company timeline">
                        <div class="timeline-item" data-aos="fade-right" data-aos-delay="600">
                            <div class="timeline-year" role="heading" aria-level="3">2003</div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Founded</h6>
                                <p class="small text-muted">Started with basic ambulance services in Raipur</p>
                            </div>
                        </div>
                        <div class="timeline-item" data-aos="fade-right" data-aos-delay="700">
                            <div class="timeline-year" role="heading" aria-level="3">2010</div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Expansion</h6>
                                <p class="small text-muted">Extended services to Durg, Bhilai, and Bilaspur</p>
                            </div>
                        </div>
                        <div class="timeline-item" data-aos="fade-right" data-aos-delay="800">
                            <div class="timeline-year" role="heading" aria-level="3">2018</div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Advanced Fleet</h6>
                                <p class="small text-muted">Introduced ICU ambulances with latest equipment</p>
                            </div>
                        </div>
                        <div class="timeline-item" data-aos="fade-right" data-aos-delay="900">
                            <div class="timeline-year" role="heading" aria-level="3">2024</div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Digital Era</h6>
                                <p class="small text-muted">GPS tracking and online booking systems</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="story-visual" data-aos="fade-left" data-aos-delay="600">
                    <div class="premium-image-card">
                        <div class="image-content">
                            <div class="ambulance-showcase" role="img" aria-label="Ambulance service showcase">
                                <div class="ambulance-icon-large">
                                    <i class="fas fa-ambulance" aria-hidden="true"></i>
                                </div>
                                <div class="showcase-stats" role="region" aria-label="Service statistics">
                                    <div class="stat-circle" data-aos="zoom-in" data-aos-delay="700">
                                        <span class="stat-number counter"
                                              data-target="21"
                                              aria-label="21 years">0</span>
                                        <span class="stat-label">Years</span>
                                    </div>
                                    <div class="stat-circle" data-aos="zoom-in" data-aos-delay="800">
                                        <span class="stat-number counter"
                                              data-target="10"
                                              aria-label="10 thousand plus lives">0</span>
                                        <span class="stat-label">K+ Lives</span>
                                    </div>
                                    <div class="stat-circle" data-aos="zoom-in" data-aos-delay="900">
                                        <span class="stat-number"
                                              aria-label="24 hours 7 days">24x7</span>
                                        <span class="stat-label">Service</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="image-caption" data-aos="fade-up" data-aos-delay="1000">
                            <h6 class="fw-bold text-primary">Modern Fleet</h6>
                            <p class="text-muted small">State-of-the-art ambulances with advanced medical equipment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Founder's Message -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="founders-message-card"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="region"
                     aria-labelledby="founder-message-heading">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="message-content" data-aos="fade-right" data-aos-delay="300">
                                <div class="quote-icon" aria-hidden="true">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                <h4 id="founder-message-heading"
                                    class="fw-bold text-primary mb-3"
                                    data-aos="fade-up"
                                    data-aos-delay="400">Founder's Message</h4>
                                <blockquote class="lead text-muted mb-4"
                                           data-aos="fade-up"
                                           data-aos-delay="500">
                                    "When we started Friends Ambulance Service in 2003, our vision was simple:
                                    to ensure that no one in our community would have to wait for emergency medical
                                    help. Today, after 21+ years, that vision continues to drive us every day."
                                </blockquote>
                                <blockquote class="text-muted mb-4"
                                           data-aos="fade-up"
                                           data-aos-delay="600">
                                    "Every life we save, every family we help during their most difficult moments,
                                    reminds us why we do what we do. We're not just an ambulance service – we're
                                    your neighbors, your friends, ready to help when you need us most."
                                </blockquote>
                                <div class="founder-signature"
                                     data-aos="fade-up"
                                     data-aos-delay="700">
                                    <h6 class="fw-bold text-primary">- Founder, Friends Ambulance Service</h6>
                                    <p class="text-muted small">Serving Raipur since 2003</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="founder-visual" data-aos="fade-left" data-aos-delay="800">
                                <div class="founder-icon-circle" role="img" aria-label="Founder representation">
                                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                                </div>
                                <div class="trust-indicators mt-3" data-aos="fade-up" data-aos-delay="900">
                                    <div class="trust-badge">
                                        <i class="fas fa-award text-warning me-2" aria-hidden="true"></i>
                                        <span class="text-dark">21+ Years Leadership</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Mission & Vision -->
<section class="premium-mission-vision bg-light py-5 position-relative overflow-hidden"
         role="region"
         aria-labelledby="mission-vision-heading">
    <div class="mission-background-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-success fs-6 px-3 py-2" role="status">
                    <i class="fas fa-compass me-2" aria-hidden="true"></i>MISSION & VISION
                </span>
            </div>
            <h2 id="mission-vision-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Our Purpose & Direction</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">Guiding principles that drive our commitment to excellence</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="premium-mission-card h-100"
                     data-aos="fade-right"
                     data-aos-delay="400"
                     role="article"
                     aria-labelledby="mission-heading">
                    <div class="card-header" data-aos="fade-up" data-aos-delay="500">
                        <div class="mission-icon" role="img" aria-label="Mission target icon">
                            <i class="fas fa-bullseye" aria-hidden="true"></i>
                        </div>
                        <h3 id="mission-heading" class="fw-bold text-primary">Our Mission</h3>
                        <p class="card-subtitle">What drives us every day</p>
                    </div>
                    <div class="card-content" data-aos="fade-up" data-aos-delay="600">
                        <p class="mission-text text-dark">
                            To provide immediate, professional, and compassionate emergency medical services
                            to the people of Raipur and surrounding areas. We are committed to saving lives
                            through rapid response times, state-of-the-art medical equipment, and highly
                            trained healthcare professionals.
                        </p>

                        <div class="mission-pillars" data-aos="fade-up" data-aos-delay="700">
                            <h6 class="fw-bold text-primary mb-3">Our Core Commitments:</h6>
                            <div class="pillars-grid" role="list" aria-label="Core commitments">
                                <div class="pillar-item"
                                     role="listitem"
                                     data-aos="zoom-in"
                                     data-aos-delay="800">
                                    <div class="pillar-icon bg-success" role="img" aria-label="Rapid response icon">
                                        <i class="fas fa-bolt" aria-hidden="true"></i>
                                    </div>
                                    <div class="pillar-content">
                                        <h6 class="pillar-title text-dark">Rapid Response</h6>
                                        <p class="pillar-desc">5-10 minute emergency response time</p>
                                    </div>
                                </div>
                                <div class="pillar-item"
                                     role="listitem"
                                     data-aos="zoom-in"
                                     data-aos-delay="900">
                                    <div class="pillar-icon bg-primary" role="img" aria-label="Professional care icon">
                                        <i class="fas fa-user-md" aria-hidden="true"></i>
                                    </div>
                                    <div class="pillar-content">
                                        <h6 class="pillar-title text-dark">Professional Care</h6>
                                        <p class="pillar-desc">Certified medical professionals</p>
                                    </div>
                                </div>
                                <div class="pillar-item"
                                     role="listitem"
                                     data-aos="zoom-in"
                                     data-aos-delay="1000">
                                    <div class="pillar-icon bg-warning" role="img" aria-label="Compassionate service icon">
                                        <i class="fas fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <div class="pillar-content">
                                        <h6 class="pillar-title text-dark">Compassionate Service</h6>
                                        <p class="pillar-desc">Caring for patients and families</p>
                                    </div>
                                </div>
                                <div class="pillar-item"
                                     role="listitem"
                                     data-aos="zoom-in"
                                     data-aos-delay="1100">
                                    <div class="pillar-icon bg-info" role="img" aria-label="Community focus icon">
                                        <i class="fas fa-users" aria-hidden="true"></i>
                                    </div>
                                    <div class="pillar-content">
                                        <h6 class="pillar-title text-dark">Community Focus</h6>
                                        <p class="pillar-desc">Serving our local community</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="premium-vision-card h-100"
                     data-aos="fade-left"
                     data-aos-delay="400"
                     role="article"
                     aria-labelledby="vision-heading">
                    <div class="card-header" data-aos="fade-up" data-aos-delay="500">
                        <div class="vision-icon" role="img" aria-label="Vision eye icon">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </div>
                        <h3 id="vision-heading" class="fw-bold text-danger">Our Vision</h3>
                        <p class="card-subtitle">Where we're heading</p>
                    </div>
                    <div class="card-content" data-aos="fade-up" data-aos-delay="600">
                        <p class="vision-text text-dark">
                            To be the most trusted and reliable ambulance service in Chhattisgarh, setting
                            the gold standard for emergency medical transportation through continuous innovation,
                            operational excellence, and unwavering commitment to patient care and community health.
                        </p>

                        <div class="vision-goals" data-aos="fade-up" data-aos-delay="700">
                            <h6 class="fw-bold text-danger mb-3">Our Future Goals:</h6>
                            <div class="goals-list" role="list" aria-label="Future goals">
                                <div class="goal-item"
                                     role="listitem"
                                     data-aos="slide-right"
                                     data-aos-delay="800">
                                    <div class="goal-number" aria-hidden="true">01</div>
                                    <div class="goal-content">
                                        <h6 class="goal-title text-dark">Regional Leadership</h6>
                                        <p class="goal-desc">Leading ambulance service across Chhattisgarh</p>
                                    </div>
                                </div>
                                <div class="goal-item"
                                     role="listitem"
                                     data-aos="slide-right"
                                     data-aos-delay="900">
                                    <div class="goal-number" aria-hidden="true">02</div>
                                    <div class="goal-content">
                                        <h6 class="goal-title text-dark">Technology Integration</h6>
                                        <p class="goal-desc">Advanced medical technology and GPS systems</p>
                                    </div>
                                </div>
                                <div class="goal-item"
                                     role="listitem"
                                     data-aos="slide-right"
                                     data-aos-delay="1000">
                                    <div class="goal-number" aria-hidden="true">03</div>
                                    <div class="goal-content">
                                        <h6 class="goal-title text-dark">Service Excellence</h6>
                                        <p class="goal-desc">Continuous improvement in care quality</p>
                                    </div>
                                </div>
                                <div class="goal-item"
                                     role="listitem"
                                     data-aos="slide-right"
                                     data-aos-delay="1100">
                                    <div class="goal-number" aria-hidden="true">04</div>
                                    <div class="goal-content">
                                        <h6 class="goal-title text-dark">Community Health</h6>
                                        <p class="goal-desc">Advancing overall community wellness</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Values Section -->
        <div class="row">
            <div class="col-12">
                <div class="values-section"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="region"
                     aria-labelledby="values-heading">
                    <div class="text-center mb-4" data-aos="fade-up" data-aos-delay="300">
                        <h3 id="values-heading" class="fw-bold text-primary">Our Core Values</h3>
                        <p class="text-muted">The principles that guide every decision we make</p>
                    </div>
                    <div class="row g-3" role="list" aria-label="Core values">
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="value-item"
                                 role="listitem"
                                 data-aos="zoom-in"
                                 data-aos-delay="400">
                                <div class="value-icon" role="img" aria-label="Trust shield icon">
                                    <i class="fas fa-shield-alt text-primary" aria-hidden="true"></i>
                                </div>
                                <h6 class="value-name text-dark">Trust</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="value-item"
                                 role="listitem"
                                 data-aos="zoom-in"
                                 data-aos-delay="500">
                                <div class="value-icon" role="img" aria-label="Excellence star icon">
                                    <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                </div>
                                <h6 class="value-name text-dark">Excellence</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="value-item"
                                 role="listitem"
                                 data-aos="zoom-in"
                                 data-aos-delay="600">
                                <div class="value-icon" role="img" aria-label="Compassion heart icon">
                                    <i class="fas fa-heart text-danger" aria-hidden="true"></i>
                                </div>
                                <h6 class="value-name text-dark">Compassion</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="value-item"
                                 role="listitem"
                                 data-aos="zoom-in"
                                 data-aos-delay="700">
                                <div class="value-icon" role="img" aria-label="Integrity handshake icon">
                                    <i class="fas fa-handshake text-success" aria-hidden="true"></i>
                                </div>
                                <h6 class="value-name text-dark">Integrity</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="value-item"
                                 role="listitem"
                                 data-aos="zoom-in"
                                 data-aos-delay="800">
                                <div class="value-icon" role="img" aria-label="Innovation lightbulb icon">
                                    <i class="fas fa-lightbulb text-info" aria-hidden="true"></i>
                                </div>
                                <h6 class="value-name text-dark">Innovation</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="value-item"
                                 role="listitem"
                                 data-aos="zoom-in"
                                 data-aos-delay="900">
                                <div class="value-icon" role="img" aria-label="Community users icon">
                                    <i class="fas fa-users text-secondary" aria-hidden="true"></i>
                                </div>
                                <h6 class="value-name text-dark">Community</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Why Trust Us -->
<section class="premium-why-trust py-5 bg-gradient-light"
         role="region"
         aria-labelledby="trust-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-warning text-dark fs-6 px-3 py-2" role="status">
                    <i class="fas fa-shield-check me-2" aria-hidden="true"></i>TRUST & RELIABILITY
                </span>
            </div>
            <h2 id="trust-heading"
                class="fw-bold text-primary display-6"
                data-aos="fade-up"
                data-aos-delay="200">Why Families Trust Us</h2>
            <p class="lead text-muted"
               data-aos="fade-up"
               data-aos-delay="300">Over two decades of proven excellence in emergency medical services</p>
            <div class="trust-stats mt-4"
                 data-aos="fade-up"
                 data-aos-delay="400"
                 role="region"
                 aria-label="Trust statistics">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="trust-stat" data-aos="zoom-in" data-aos-delay="500">
                            <span class="fw-bold fs-4 text-success counter"
                                  data-target="98"
                                  aria-label="98 percent satisfaction">0</span>
                            <span class="text-muted">% Satisfaction</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="trust-stat" data-aos="zoom-in" data-aos-delay="600">
                            <span class="fw-bold fs-4 text-primary counter"
                                  data-target="500"
                                  aria-label="Over 500 reviews">0</span>
                            <span class="text-muted">+ Reviews</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-item h-100"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="article"
                     aria-labelledby="legacy-heading">
                    <div class="trust-item-header" data-aos="zoom-in" data-aos-delay="300">
                        <div class="trust-item-icon bg-gradient-warning" role="img" aria-label="Trophy icon">
                            <i class="fas fa-trophy" aria-hidden="true"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-warning text-dark">Since 2003</span>
                        </div>
                    </div>
                    <div class="trust-item-content" data-aos="fade-up" data-aos-delay="400">
                        <h5 id="legacy-heading" class="fw-bold text-warning">21+ Years Legacy</h5>
                        <p class="text-muted mb-3">
                            More than two decades of continuous service, making us Raipur's most
                            experienced and trusted ambulance service provider.
                        </p>
                        <div class="trust-features" role="list" aria-label="Legacy features">
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Established 2003</span>
                            </div>
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Proven Track Record</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-item h-100"
                     data-aos="fade-up"
                     data-aos-delay="300"
                     role="article"
                     aria-labelledby="team-heading">
                    <div class="trust-item-header" data-aos="zoom-in" data-aos-delay="400">
                        <div class="trust-item-icon bg-gradient-primary" role="img" aria-label="Medical doctor icon">
                            <i class="fas fa-user-md" aria-hidden="true"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-primary">Certified</span>
                        </div>
                    </div>
                    <div class="trust-item-content" data-aos="fade-up" data-aos-delay="500">
                        <h5 id="team-heading" class="fw-bold text-primary">Expert Medical Team</h5>
                        <p class="text-muted mb-3">
                            Our team consists of certified paramedics, experienced drivers, and
                            compassionate staff who understand medical emergency protocols.
                        </p>
                        <div class="trust-features" role="list" aria-label="Team features">
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Certified Paramedics</span>
                            </div>
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Continuous Training</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-item h-100"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="article"
                     aria-labelledby="availability-heading">
                    <div class="trust-item-header" data-aos="zoom-in" data-aos-delay="500">
                        <div class="trust-item-icon bg-gradient-success" role="img" aria-label="Clock icon">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-success">24x7</span>
                        </div>
                    </div>
                    <div class="trust-item-content" data-aos="fade-up" data-aos-delay="600">
                        <h5 id="availability-heading" class="fw-bold text-success">Always Available</h5>
                        <p class="text-muted mb-3">
                            Round-the-clock availability ensures that help is always just a phone call away,
                            365 days a year including holidays.
                        </p>
                        <div class="trust-features" role="list" aria-label="Availability features">
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">24-Hour Dispatch</span>
                            </div>
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Holiday Coverage</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="premium-trust-item h-100"
                     data-aos="fade-up"
                     data-aos-delay="500"
                     role="article"
                     aria-labelledby="transparency-heading">
                    <div class="trust-item-header" data-aos="zoom-in" data-aos-delay="600">
                        <div class="trust-item-icon bg-gradient-danger" role="img" aria-label="Heart in hand icon">
                            <i class="fas fa-hand-holding-heart" aria-hidden="true"></i>
                        </div>
                        <div class="trust-badge">
                            <span class="badge bg-danger">Transparent</span>
                        </div>
                    </div>
                    <div class="trust-item-content" data-aos="fade-up" data-aos-delay="700">
                        <h5 id="transparency-heading" class="fw-bold text-danger">Fair & Transparent</h5>
                        <p class="text-muted mb-3">
                            Honest pricing with complete transparency - no hidden charges or surprise fees.
                            Quality emergency care accessible to all families.
                        </p>
                        <div class="trust-features" role="list" aria-label="Transparency features">
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">No Hidden Charges</span>
                            </div>
                            <div class="feature-point" role="listitem">
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                <span class="text-dark">Upfront Pricing</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Trust Testimonial -->
        <div class="row">
            <div class="col-12">
                <div class="trust-testimonial-card"
                     data-aos="fade-up"
                     data-aos-delay="600"
                     role="region"
                     aria-labelledby="testimonial-heading">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="testimonial-content" data-aos="fade-right" data-aos-delay="700">
                                <div class="testimonial-quote-large" aria-hidden="true">
                                    <i class="fas fa-quote-left text-primary"></i>
                                </div>
                                <blockquote class="lead text-muted mb-3"
                                           data-aos="fade-up"
                                           data-aos-delay="800">
                                    "Friends Ambulance has been our family's trusted partner for over 15 years.
                                    From routine medical transports to critical emergencies, they've always been
                                    there when we needed them most. Their professionalism and care give us complete peace of mind."
                                </blockquote>
                                <div class="testimonial-author"
                                     data-aos="fade-up"
                                     data-aos-delay="900">
                                    <h6 class="fw-bold text-primary">Dr. Rajesh Sharma</h6>
                                    <p class="text-muted small">Long-term Client • Raipur</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="testimonial-visual" data-aos="fade-left" data-aos-delay="1000">
                                <div class="testimonial-rating">
                                    <div class="stars mb-2"
                                         role="img"
                                         aria-label="5 star rating">
                                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                                    </div>
                                    <p class="fw-bold text-primary">4.9 Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Call to Action -->
<section class="cta-section bg-danger text-white py-5"
         role="region"
         aria-labelledby="cta-heading">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="cta-content" data-aos="fade-right">
                    <h3 id="cta-heading"
                        class="fw-bold mb-2"
                        data-aos="fade-up"
                        data-aos-delay="100">Need Emergency Ambulance Service?</h3>
                    <p class="mb-0"
                       data-aos="fade-up"
                       data-aos-delay="200">Our team is ready 24x7 to provide immediate medical transportation assistance.</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end"
                     data-aos="fade-left"
                     data-aos-delay="300"
                     role="group"
                     aria-label="Contact options">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>"
                       class="btn btn-warning"
                       aria-label="Call emergency number <?php echo formatPhone(PHONE_PRIMARY); ?>">
                        <i class="fas fa-phone me-1" aria-hidden="true"></i> Call Now
                    </a>
                    <a href="contact"
                       class="btn btn-outline-light"
                       aria-label="Go to contact page">
                        <i class="fas fa-envelope me-1" aria-hidden="true"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php include 'includes/footer.php'; ?>
