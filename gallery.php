<?php
include 'includes/header.php';

// Get gallery images from database
try {
    require_once 'admin/config/database.php';
    $galleryImages = getMultipleRecords(
        "SELECT * FROM gallery_images WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC"
    );
} catch (Exception $e) {
    $galleryImages = [];
}

// Group images by category
$imagesByCategory = [];
foreach ($galleryImages as $image) {
    $imagesByCategory[$image['category']][] = $image;
}

$hasCustomGallery = !empty($galleryImages);
?>

<!-- Page Header -->
<section class="page-header bg-warning text-dark py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Our Ambulance Fleet & Facilities</h1>
                <p class="lead">Take a look at our modern ambulances and professional team</p>
            </div>
            <div class="col-lg-4 text-end">
                <i class="fas fa-images display-1 opacity-25"></i>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Categories -->
<section class="gallery-categories py-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <button class="btn btn-outline-primary btn-sm gallery-filter active" data-filter="all">
                        All Images
                    </button>
                    <button class="btn btn-outline-primary btn-sm gallery-filter" data-filter="ambulances">
                        Ambulances
                    </button>
                    <button class="btn btn-outline-primary btn-sm gallery-filter" data-filter="equipment">
                        Equipment
                    </button>
                    <button class="btn btn-outline-primary btn-sm gallery-filter" data-filter="team">
                        Our Team
                    </button>
                    <button class="btn btn-outline-primary btn-sm gallery-filter" data-filter="facilities">
                        Facilities
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="gallery-grid py-5">
    <div class="container">
        <div class="row g-4" id="galleryContainer">
            <?php if ($hasCustomGallery): ?>
                <!-- Dynamic Gallery Images from Database -->
                <?php foreach ($galleryImages as $image): ?>
                <div class="col-lg-4 col-md-6 gallery-item" data-category="<?php echo htmlspecialchars($image['category']); ?>">
                    <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                        <div class="gallery-image" style="height: 250px; overflow: hidden;">
                            <img src="<?php echo htmlspecialchars($image['thumbnail_path'] ?: $image['image_path']); ?>"
                                 alt="<?php echo htmlspecialchars($image['title']); ?>"
                                 class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="gallery-info p-3">
                            <h6 class="fw-bold text-primary"><?php echo htmlspecialchars($image['title']); ?></h6>
                            <?php if ($image['description']): ?>
                                <p class="text-muted small mb-0"><?php echo htmlspecialchars($image['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default Gallery Items (Original Content) -->
                <!-- Ambulance Images -->
                <div class="col-lg-4 col-md-6 gallery-item" data-category="ambulances">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-ambulance text-primary" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">BLS Ambulance</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-primary">Basic Life Support Ambulance</h6>
                        <p class="text-muted small mb-0">Equipped with essential medical equipment for patient transport</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="ambulances">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-heartbeat text-danger" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">ALS Ambulance</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-danger">Advanced Life Support Ambulance</h6>
                        <p class="text-muted small mb-0">Advanced medical equipment for critical emergency situations</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="ambulances">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-hospital text-warning" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">ICU Ambulance</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-warning">Mobile ICU Ambulance</h6>
                        <p class="text-muted small mb-0">Complete ICU setup for critical patient transportation</p>
                    </div>
                </div>
            </div>
            
            <!-- Equipment Images -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="equipment">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-lungs text-info" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Oxygen Support</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-info">Oxygen Support System</h6>
                        <p class="text-muted small mb-0">High-quality oxygen cylinders and delivery systems</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="equipment">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-heartbeat text-danger" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Cardiac Monitor</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-danger">Cardiac Monitoring Equipment</h6>
                        <p class="text-muted small mb-0">Advanced cardiac monitors for patient vital signs</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="equipment">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-briefcase-medical text-success" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Medical Kit</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-success">Emergency Medical Kit</h6>
                        <p class="text-muted small mb-0">Comprehensive first aid and emergency medical supplies</p>
                    </div>
                </div>
            </div>
            
            <!-- Team Images -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="team">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-user-md text-primary" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Paramedic Team</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-primary">Professional Paramedics</h6>
                        <p class="text-muted small mb-0">Trained and certified paramedics ready for emergency response</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="team">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-users text-success" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Support Staff</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-success">Support Team</h6>
                        <p class="text-muted small mb-0">Compassionate support staff for patient care and assistance</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="team">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-user-tie text-info" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Management</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-info">Management Team</h6>
                        <p class="text-muted small mb-0">Experienced management ensuring quality service delivery</p>
                    </div>
                </div>
            </div>
            
            <!-- Facilities Images -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="facilities">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-building text-primary" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Our Office</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-primary">Main Office</h6>
                        <p class="text-muted small mb-0">Our main office near Ramkrishna Care Hospital</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="facilities">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-tools text-warning" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Maintenance</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-warning">Maintenance Facility</h6>
                        <p class="text-muted small mb-0">Well-equipped maintenance facility for ambulance upkeep</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 gallery-item" data-category="facilities">
                <div class="gallery-card h-100 border rounded overflow-hidden shadow-sm">
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <div class="text-center">
                            <i class="fas fa-phone text-danger" style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Control Room</p>
                        </div>
                    </div>
                    <div class="gallery-info p-3">
                        <h6 class="fw-bold text-danger">24x7 Control Room</h6>
                        <p class="text-muted small mb-0">Round-the-clock control room for emergency dispatch</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
