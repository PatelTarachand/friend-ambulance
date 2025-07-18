<?php
include 'includes/header.php';

// Get gallery images from database
try {
    require_once 'admin/config/database.php';

    // Get active gallery images
    $galleryImages = getMultipleRecords(
        "SELECT * FROM gallery_images WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC"
    );

    // Get featured images
    $featuredImages = getMultipleRecords(
        "SELECT * FROM gallery_images WHERE is_active = 1 AND is_featured = 1 ORDER BY sort_order ASC"
    );

} catch (Exception $e) {
    $galleryImages = [];
    $featuredImages = [];
}

// Group images by category
$imagesByCategory = [];
foreach ($galleryImages as $image) {
    $imagesByCategory[$image['category']][] = $image;
}

$hasCustomGallery = !empty($galleryImages);
$totalImages = count($galleryImages);

// Add structured data for better SEO
$galleryStructuredData = [
    "@context" => "https://schema.org",
    "@type" => "ImageGallery",
    "name" => "Friends Ambulance Service Gallery",
    "description" => "Gallery showcasing our ambulance fleet, medical equipment, professional team, and facilities",
    "url" => SITE_URL . "/gallery",
    "publisher" => [
        "@type" => "Organization",
        "name" => SITE_NAME,
        "url" => SITE_URL
    ],
    "about" => [
        "@type" => "MedicalBusiness",
        "name" => SITE_NAME,
        "description" => "Professional ambulance and medical transportation services"
    ]
];
?>

<!-- Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($galleryStructuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- Main Content -->
<main id="main-content" role="main">

<!-- Enhanced Page Header -->
<section class="premium-gallery-header bg-gradient-warning text-dark py-5 position-relative overflow-hidden"
         role="banner"
         aria-labelledby="gallery-main-heading">
    <div class="gallery-background-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="header-content" data-aos="fade-right">
                    <div class="header-badge mb-3" data-aos="fade-up" data-aos-delay="100">
                        <span class="badge bg-dark fs-6 px-3 py-2" role="status">
                            <i class="fas fa-images me-2" aria-hidden="true"></i>GALLERY
                        </span>
                    </div>
                    <h1 id="gallery-main-heading"
                        class="display-5 fw-bold mb-3"
                        data-aos="fade-up"
                        data-aos-delay="200">Our Ambulance Fleet & Facilities</h1>
                    <p class="lead"
                       data-aos="fade-up"
                       data-aos-delay="300">Take a look at our modern ambulances, advanced equipment, and professional team</p>
                    <div class="header-stats mt-4"
                         data-aos="fade-up"
                         data-aos-delay="400"
                         role="region"
                         aria-label="Gallery statistics">
                        <div class="row">
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4 counter" data-target="<?php echo $hasCustomGallery ? count($galleryImages) : 12; ?>">0</span>
                                    <span class="text-dark">Images</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">4</span>
                                    <span class="text-dark">Categories</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">HD</span>
                                    <span class="text-dark">Quality</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <div class="header-visual" data-aos="fade-left" data-aos-delay="500">
                    <div class="gallery-icon-showcase" role="img" aria-label="Gallery showcase">
                        <i class="fas fa-images display-1" aria-hidden="true"></i>
                        <div class="showcase-sparkles" aria-hidden="true">
                            <div class="sparkle"></div>
                            <div class="sparkle"></div>
                            <div class="sparkle"></div>
                            <div class="sparkle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Search -->
<section class="gallery-search-section py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-3">
                    <h2 class="h5 fw-bold text-primary mb-2">Search Gallery</h2>
                    <p class="text-muted small">Find images by title or description</p>
                </div>
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           id="gallerySearch"
                           placeholder="Search images by title, description..."
                           aria-label="Search gallery images">
                    <button class="btn btn-outline-primary" type="button" id="searchButton">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Gallery Grid -->
<section class="premium-gallery-grid py-5 bg-white"
         role="region"
         aria-labelledby="gallery-grid-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 id="gallery-grid-heading" class="fw-bold text-primary display-6">Our Visual Gallery</h2>
            <p class="lead text-muted">Explore our comprehensive collection of ambulances, equipment, and facilities</p>
        </div>
        <div class="row g-4" id="galleryContainer" role="grid" aria-label="Image gallery">
            <?php if ($hasCustomGallery): ?>
                <!-- Dynamic Gallery Images from Database -->
                <?php $imageIndex = 0; foreach ($galleryImages as $image): $imageIndex++; ?>
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="<?php echo ($imageIndex % 6) * 100; ?>"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="image-<?php echo $imageIndex; ?>">
                        <div class="gallery-image-container">
                            <div class="gallery-image" style="height: 280px; overflow: hidden;">
                                <?php
                                $imageSrc = $image['thumbnail_path'] ?: $image['image_path'];
                                $fullImageSrc = $image['image_path'];
                                $imageExists = file_exists($imageSrc);
                                ?>

                                <?php if ($imageExists): ?>
                                    <img src="<?php echo htmlspecialchars($imageSrc); ?>"
                                         alt="<?php echo htmlspecialchars($image['alt_text'] ?: $image['title']); ?>"
                                         class="w-100 h-100"
                                         style="object-fit: cover;"
                                         loading="lazy"
                                         onerror="this.src='assets/images/placeholder-gallery.jpg'">
                                <?php else: ?>
                                    <!-- Fallback placeholder -->
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <i class="fas fa-image text-muted fs-1 mb-2"></i>
                                            <p class="text-muted small">Image not found</p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="image-overlay">
                                    <div class="overlay-content">
                                        <button class="btn btn-light btn-sm image-zoom"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-image="<?php echo htmlspecialchars($fullImageSrc); ?>"
                                                data-title="<?php echo htmlspecialchars($image['title']); ?>"
                                                data-description="<?php echo htmlspecialchars($image['description']); ?>"
                                                aria-label="View larger image">
                                            <i class="fas fa-expand" aria-hidden="true"></i>
                                        </button>
                                        <?php if ($image['is_featured']): ?>
                                            <div class="featured-badge">
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="image-<?php echo $imageIndex; ?>" class="fw-bold text-primary mb-2">
                                <?php echo htmlspecialchars($image['title']); ?>
                            </h6>
                            <?php if ($image['description']): ?>
                                <p class="text-muted small mb-2"><?php echo htmlspecialchars(substr($image['description'], 0, 100)) . (strlen($image['description']) > 100 ? '...' : ''); ?></p>
                            <?php endif; ?>
                            <div class="gallery-meta mt-2">
                                <span class="badge text-white"
                                      style="background-color: <?php echo htmlspecialchars($image['category_color'] ?: '#007bff'); ?>">
                                    <i class="<?php echo htmlspecialchars($image['category_icon'] ?: 'fas fa-image'); ?> me-1"></i>
                                    <?php echo htmlspecialchars($image['category_name'] ?: ucfirst($image['category'])); ?>
                                </span>
                                <?php if ($image['is_featured']): ?>
                                    <span class="badge bg-warning text-dark ms-1">
                                        <i class="fas fa-star me-1"></i>Featured
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Enhanced Default Gallery Items -->
                <!-- Ambulance Images -->
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="100"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="bls-ambulance">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-ambulance text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">BLS Ambulance</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Oxygen Support</span>
                                        <span class="feature-badge">First Aid Kit</span>
                                        <span class="feature-badge">Trained Paramedic</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="bls-ambulance" class="fw-bold text-primary mb-2">Basic Life Support Ambulance</h6>
                            <p class="text-muted small mb-2">Equipped with essential medical equipment for stable patient transport and basic emergency care</p>
                            <div class="gallery-meta">
                                <span class="badge bg-primary">Ambulances</span>
                                <span class="badge bg-success">24x7 Available</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="als-ambulance">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-heartbeat text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">ALS Ambulance</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Ventilator</span>
                                        <span class="feature-badge">Cardiac Monitor</span>
                                        <span class="feature-badge">Defibrillator</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="als-ambulance" class="fw-bold text-danger mb-2">Advanced Life Support Ambulance</h6>
                            <p class="text-muted small mb-2">Advanced medical equipment and trained personnel for critical emergency situations</p>
                            <div class="gallery-meta">
                                <span class="badge bg-primary">Ambulances</span>
                                <span class="badge bg-warning text-dark">Critical Care</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="300"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="icu-ambulance">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-hospital text-dark" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">ICU Ambulance</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Complete ICU</span>
                                        <span class="feature-badge">Multi-Monitor</span>
                                        <span class="feature-badge">Specialist Doctor</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="icu-ambulance" class="fw-bold text-warning mb-2">Mobile ICU Ambulance</h6>
                            <p class="text-muted small mb-2">Complete ICU setup for critical patient transportation requiring intensive monitoring</p>
                            <div class="gallery-meta">
                                <span class="badge bg-primary">Ambulances</span>
                                <span class="badge bg-danger">ICU Level Care</span>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Equipment Images -->
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="oxygen-system">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-lungs text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Oxygen Support</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">High Flow</span>
                                        <span class="feature-badge">Portable</span>
                                        <span class="feature-badge">Emergency Ready</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="oxygen-system" class="fw-bold text-info mb-2">Oxygen Support System</h6>
                            <p class="text-muted small mb-2">High-quality oxygen cylinders and delivery systems for patient respiratory support</p>
                            <div class="gallery-meta">
                                <span class="badge bg-info">Equipment</span>
                                <span class="badge bg-success">Life Support</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="500"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="cardiac-monitor">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-heartbeat text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Cardiac Monitor</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Real-time</span>
                                        <span class="feature-badge">Multi-parameter</span>
                                        <span class="feature-badge">Alert System</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="cardiac-monitor" class="fw-bold text-danger mb-2">Cardiac Monitoring Equipment</h6>
                            <p class="text-muted small mb-2">Advanced cardiac monitors for continuous patient vital signs monitoring</p>
                            <div class="gallery-meta">
                                <span class="badge bg-info">Equipment</span>
                                <span class="badge bg-danger">Critical Care</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="600"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="medical-kit">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-briefcase-medical text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Medical Kit</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Complete Kit</span>
                                        <span class="feature-badge">Sterile</span>
                                        <span class="feature-badge">Emergency Ready</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="medical-kit" class="fw-bold text-success mb-2">Emergency Medical Kit</h6>
                            <p class="text-muted small mb-2">Comprehensive first aid and emergency medical supplies for immediate care</p>
                            <div class="gallery-meta">
                                <span class="badge bg-info">Equipment</span>
                                <span class="badge bg-warning text-dark">First Aid</span>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Team Images -->
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="100"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="paramedic-team">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-user-md text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Paramedic Team</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Certified</span>
                                        <span class="feature-badge">Experienced</span>
                                        <span class="feature-badge">24x7 Ready</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="paramedic-team" class="fw-bold text-primary mb-2">Professional Paramedics</h6>
                            <p class="text-muted small mb-2">Trained and certified paramedics ready for emergency response and patient care</p>
                            <div class="gallery-meta">
                                <span class="badge bg-secondary">Team</span>
                                <span class="badge bg-success">Certified</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="200"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="support-team">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-users text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Support Staff</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Compassionate</span>
                                        <span class="feature-badge">Helpful</span>
                                        <span class="feature-badge">Professional</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="support-team" class="fw-bold text-success mb-2">Support Team</h6>
                            <p class="text-muted small mb-2">Compassionate support staff for patient care and family assistance during emergencies</p>
                            <div class="gallery-meta">
                                <span class="badge bg-secondary">Team</span>
                                <span class="badge bg-info">Support</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="300"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="management-team">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-user-tie text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Management</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Experienced</span>
                                        <span class="feature-badge">Leadership</span>
                                        <span class="feature-badge">Quality Focus</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="management-team" class="fw-bold text-info mb-2">Management Team</h6>
                            <p class="text-muted small mb-2">Experienced management ensuring quality service delivery and operational excellence</p>
                            <div class="gallery-meta">
                                <span class="badge bg-secondary">Team</span>
                                <span class="badge bg-warning text-dark">Leadership</span>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Facilities Images -->
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="400"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="main-office">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-building text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Our Office</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Central Location</span>
                                        <span class="feature-badge">Modern</span>
                                        <span class="feature-badge">Accessible</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="main-office" class="fw-bold text-primary mb-2">Main Office</h6>
                            <p class="text-muted small mb-2">Our main office near Ramkrishna Care Hospital, centrally located for quick response</p>
                            <div class="gallery-meta">
                                <span class="badge bg-dark">Facilities</span>
                                <span class="badge bg-primary">Headquarters</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="500"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="maintenance-facility">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-tools text-dark" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Maintenance</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Well-equipped</span>
                                        <span class="feature-badge">Regular Service</span>
                                        <span class="feature-badge">Quality Care</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="maintenance-facility" class="fw-bold text-warning mb-2">Maintenance Facility</h6>
                            <p class="text-muted small mb-2">Well-equipped maintenance facility for ambulance upkeep and regular servicing</p>
                            <div class="gallery-meta">
                                <span class="badge bg-dark">Facilities</span>
                                <span class="badge bg-warning text-dark">Maintenance</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="600"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="control-room">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-phone text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Control Room</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">24x7 Active</span>
                                        <span class="feature-badge">Quick Dispatch</span>
                                        <span class="feature-badge">GPS Tracking</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="control-room" class="fw-bold text-danger mb-2">24x7 Control Room</h6>
                            <p class="text-muted small mb-2">Round-the-clock control room for emergency dispatch and ambulance coordination</p>
                            <div class="gallery-meta">
                                <span class="badge bg-dark">Facilities</span>
                                <span class="badge bg-danger">Emergency</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="800">
            <button class="btn btn-outline-primary btn-lg" id="loadMoreBtn" style="display: none;">
                <i class="fas fa-plus me-2" aria-hidden="true"></i>Load More Images
            </button>
        </div>
    </div>
</section>

<!-- Enhanced Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-lg-8">
                        <div class="image-container">
                            <img src="" alt="" class="w-100" id="modalImage" style="max-height: 70vh; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="image-details p-4">
                            <h6 class="fw-bold text-primary mb-3" id="modalImageTitle">Image Title</h6>
                            <div class="image-info">
                                <div class="info-item mb-3" id="modalImageDescription">
                                    <label class="fw-semibold text-muted small">Description:</label>
                                    <p class="mb-0" id="modalDescriptionText">No description available</p>
                                </div>
                                <div class="info-item mb-3" id="modalImageCategory">
                                    <label class="fw-semibold text-muted small">Category:</label>
                                    <div id="modalCategoryBadge"></div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="fw-semibold text-muted small">Actions:</label>
                                    <div class="d-flex gap-2 mt-2">
                                        <button class="btn btn-outline-primary btn-sm" onclick="downloadImage()">
                                            <i class="fas fa-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="shareImage()">
                                            <i class="fas fa-share me-1"></i>Share
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

</main>

<!-- Gallery JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Search Functionality
    const galleryItems = document.querySelectorAll('.gallery-item');
    const galleryContainer = document.getElementById('galleryContainer');
    const searchInput = document.getElementById('gallerySearch');
    const searchButton = document.getElementById('searchButton');
    const clearSearchButton = document.getElementById('clearSearch');

    let isSearchMode = false;

    // Search functionality
    if (searchInput && searchButton) {
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        clearSearchButton.addEventListener('click', clearSearch);
    }

    function performSearch() {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            alert('Please enter at least 2 characters to search');
            return;
        }

        isSearchMode = true;
        searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        clearSearchButton.style.display = 'inline-block';

        // Simple client-side search for now
        const searchResults = [];
        galleryItems.forEach(item => {
            const title = item.querySelector('h6').textContent.toLowerCase();
            const description = item.querySelector('p') ? item.querySelector('p').textContent.toLowerCase() : '';

            if (title.includes(query.toLowerCase()) || description.includes(query.toLowerCase())) {
                searchResults.push(item);
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.5s ease-in-out';
            } else {
                item.style.display = 'none';
            }
        });

        searchButton.innerHTML = '<i class="fas fa-search"></i>';

        // Show results count
        const resultsCount = searchResults.length;
        showSearchResults(resultsCount, query);
    }

    function clearSearch() {
        isSearchMode = false;
        searchInput.value = '';
        clearSearchButton.style.display = 'none';

        // Show all gallery items
        galleryItems.forEach(item => {
            item.style.display = 'block';
            item.style.animation = 'fadeIn 0.5s ease-in-out';
        });

        // Hide search results message
        const searchMessage = document.getElementById('searchResultsMessage');
        if (searchMessage) {
            searchMessage.remove();
        }
    }

    function showSearchResults(count, query) {
        // Remove existing message
        const existingMessage = document.getElementById('searchResultsMessage');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create new message
        const message = document.createElement('div');
        message.id = 'searchResultsMessage';
        message.className = 'alert alert-info text-center mt-3';
        message.innerHTML = `
            <i class="fas fa-search me-2"></i>
            Found <strong>${count}</strong> result${count !== 1 ? 's' : ''} for "<strong>${query}</strong>"
            <button type="button" class="btn-close ms-2" onclick="document.getElementById('clearSearch').click()"></button>
        `;

        galleryContainer.parentNode.insertBefore(message, galleryContainer);
    }

    // Enhanced Image Modal Functionality
    const imageZoomButtons = document.querySelectorAll('.image-zoom');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');
    const modalImageTitle = document.getElementById('modalImageTitle');
    const modalDescriptionText = document.getElementById('modalDescriptionText');
    const modalCategoryBadge = document.getElementById('modalCategoryBadge');
    const modalImageDescription = document.getElementById('modalImageDescription');

    let currentImageSrc = '';

    imageZoomButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            const imageTitle = this.getAttribute('data-title');
            const imageDescription = this.getAttribute('data-description');
            const categoryElement = this.closest('.gallery-item').querySelector('.gallery-meta .badge');

            currentImageSrc = imageSrc;

            // Update modal content
            modalImage.src = imageSrc;
            modalImage.alt = imageTitle;
            modalTitle.textContent = imageTitle;
            modalImageTitle.textContent = imageTitle;

            // Update description
            if (imageDescription && imageDescription.trim() !== '') {
                modalDescriptionText.textContent = imageDescription;
                modalImageDescription.style.display = 'block';
            } else {
                modalImageDescription.style.display = 'none';
            }

            // Update category badge
            if (categoryElement) {
                modalCategoryBadge.innerHTML = categoryElement.outerHTML;
            }
        });
    });

    // Download image function
    window.downloadImage = function() {
        if (currentImageSrc) {
            const link = document.createElement('a');
            link.href = currentImageSrc;
            link.download = currentImageSrc.split('/').pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    };

    // Share image function
    window.shareImage = function() {
        if (navigator.share && currentImageSrc) {
            navigator.share({
                title: modalImageTitle.textContent,
                text: modalDescriptionText.textContent,
                url: window.location.origin + '/' + currentImageSrc
            }).catch(console.error);
        } else {
            // Fallback: copy to clipboard
            const url = window.location.origin + '/' + currentImageSrc;
            navigator.clipboard.writeText(url).then(() => {
                alert('Image URL copied to clipboard!');
            }).catch(() => {
                alert('Image URL: ' + url);
            });
        }
    };

    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;

        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        updateCounter();
    };

    // Intersection Observer for counters
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
});

// CSS Animation Keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

<?php include 'includes/footer.php'; ?>
