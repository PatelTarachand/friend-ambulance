<?php
require_once 'includes/header.php';

// Get statistics
$sliderCount = getSingleRecord("SELECT COUNT(*) as count FROM slider_images WHERE is_active = 1")['count'];
$galleryCount = getSingleRecord("SELECT COUNT(*) as count FROM gallery_images WHERE is_active = 1")['count'];
$totalSliders = getSingleRecord("SELECT COUNT(*) as count FROM slider_images")['count'];
$totalGallery = getSingleRecord("SELECT COUNT(*) as count FROM gallery_images")['count'];

// Get recent activity
$recentSliders = getMultipleRecords(
    "SELECT s.*, u.full_name as created_by_name 
     FROM slider_images s 
     LEFT JOIN admin_users u ON s.created_by = u.id 
     ORDER BY s.created_at DESC LIMIT 5"
);

$recentGallery = getMultipleRecords(
    "SELECT g.*, u.full_name as created_by_name 
     FROM gallery_images g 
     LEFT JOIN admin_users u ON g.created_by = u.id 
     ORDER BY g.created_at DESC LIMIT 5"
);
?>

<!-- Dashboard Stats -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?php echo $sliderCount; ?></h3>
                    <p class="mb-0">Active Sliders</p>
                </div>
                <div class="fs-1 opacity-75">
                    <i class="fas fa-images"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?php echo $galleryCount; ?></h3>
                    <p class="mb-0">Gallery Images</p>
                </div>
                <div class="fs-1 opacity-75">
                    <i class="fas fa-photo-video"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?php echo $totalSliders; ?></h3>
                    <p class="mb-0">Total Sliders</p>
                </div>
                <div class="fs-1 opacity-75">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?php echo $totalGallery; ?></h3>
                    <p class="mb-0">Total Gallery</p>
                </div>
                <div class="fs-1 opacity-75">
                    <i class="fas fa-images"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="slider-management.php?action=add" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Add Slider Image
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="gallery-management.php?action=add" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>Add Gallery Image
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="slider-management.php" class="btn btn-info w-100">
                            <i class="fas fa-edit me-2"></i>Manage Sliders
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="gallery-management.php" class="btn btn-warning w-100">
                            <i class="fas fa-edit me-2"></i>Manage Gallery
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-images me-2"></i>Recent Slider Images</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentSliders)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-images fs-1 text-muted mb-3"></i>
                        <p class="text-muted">No slider images yet</p>
                        <a href="slider-management.php?action=add" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Slider
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentSliders as $slider): ?>
                                <tr>
                                    <td>
                                        <img src="../<?php echo htmlspecialchars($slider['image_path']); ?>" 
                                             alt="Slider" class="rounded" style="width: 50px; height: 30px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($slider['title']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $slider['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $slider['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('M j, Y', strtotime($slider['created_at'])); ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="slider-management.php" class="btn btn-outline-primary">
                            View All Sliders <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-photo-video me-2"></i>Recent Gallery Images</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentGallery)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-photo-video fs-1 text-muted mb-3"></i>
                        <p class="text-muted">No gallery images yet</p>
                        <a href="gallery-management.php?action=add" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add First Image
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentGallery as $gallery): ?>
                                <tr>
                                    <td>
                                        <img src="../<?php echo htmlspecialchars($gallery['image_path']); ?>" 
                                             alt="Gallery" class="rounded" style="width: 50px; height: 30px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($gallery['title']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo ucfirst($gallery['category']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $gallery['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $gallery['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="gallery-management.php" class="btn btn-outline-success">
                            View All Gallery <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- System Info -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>System Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Last Login:</strong> <?php echo $currentUser['last_login'] ? date('M j, Y g:i A', strtotime($currentUser['last_login'])) : 'Never'; ?></p>
                        <p><strong>User Role:</strong> <?php echo ucfirst($currentUser['role']); ?></p>
                        <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Server Time:</strong> <?php echo date('M j, Y g:i A'); ?></p>
                        <p><strong>Upload Max Size:</strong> <?php echo ini_get('upload_max_filesize'); ?></p>
                        <p><strong>Memory Limit:</strong> <?php echo ini_get('memory_limit'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
