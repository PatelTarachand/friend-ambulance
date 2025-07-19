<?php
require_once 'includes/database.php';

$db = new HeroBackgroundDB();
$message = '';
$error = '';

// Handle form submissions
if ($_POST) {
    try {
        if (isset($_POST['slide_number']) && isset($_FILES['background_image'])) {
            $slideNumber = (int)$_POST['slide_number'];
            
            // Handle file upload
            if ($_FILES['background_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/uploads/hero-backgrounds/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['background_image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    // Delete old background if exists
                    $current = $db->getBySlideNumber($slideNumber);
                    if ($current && $current['background_image']) {
                        $oldPath = '../' . $current['background_image'];
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    
                    $fileName = 'hero_bg_' . $slideNumber . '_' . time() . '.' . $fileExtension;
                    $targetPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['background_image']['tmp_name'], $targetPath)) {
                        $imagePath = 'assets/uploads/hero-backgrounds/' . $fileName;
                        
                        if ($db->updateBackground($slideNumber, $imagePath)) {
                            $message = "Hero background for slide {$slideNumber} updated successfully!";
                        } else {
                            throw new Exception('Failed to update database');
                        }
                    } else {
                        throw new Exception('Failed to upload image');
                    }
                } else {
                    throw new Exception('Invalid file type. Only JPG, PNG, and GIF are allowed.');
                }
            }
        }
        
        // Handle remove background
        if (isset($_POST['remove_background'])) {
            $slideNumber = (int)$_POST['slide_number'];
            if ($db->removeBackground($slideNumber)) {
                $message = "Background removed for slide {$slideNumber}!";
            } else {
                throw new Exception('Failed to remove background');
            }
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get all hero backgrounds
$heroBackgrounds = $db->getAll();
$stats = $db->getStats();

// Define slide names
$slideNames = [
    1 => 'Emergency Services',
    2 => 'Modern Fleet',
    3 => 'Professional Team',
    4 => 'Contact & Booking'
];

// Include common admin header
include 'includes/header.php';
?>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="main-content-inner">
                    
                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col">
                            <h2>
                                <i class="fas fa-image me-2 text-primary"></i>
                                Hero Backgrounds Management
                            </h2>
                            <p class="text-muted">Manage hero slider background images</p>
                        </div>
                    </div>

                    <!-- Messages -->
                    <?php if ($message): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3><?php echo $stats['total']; ?></h3>
                                    <p class="mb-0">Total Slides</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3><?php echo $stats['with_image']; ?></h3>
                                    <p class="mb-0">With Custom Background</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3><?php echo $stats['without_image']; ?></h3>
                                    <p class="mb-0">Default Background</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hero Slides -->
                    <div class="row">
                        <?php foreach ($heroBackgrounds as $bg): ?>
                            <div class="col-lg-6 mb-4">
                                <div class="card slide-card h-100">
                                    <div class="card-header">
                                        <h5>
                                            <i class="fas fa-image me-2"></i>
                                            Slide <?php echo $bg['slide_number']; ?>: <?php echo $slideNames[$bg['slide_number']]; ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($bg['background_image']): ?>
                                            <div class="mb-3">
                                                <img src="../<?php echo htmlspecialchars($bg['background_image']); ?>" 
                                                     alt="Hero background <?php echo $bg['slide_number']; ?>"
                                                     class="hero-preview img-fluid rounded" 
                                                     style="width: 100%; height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="d-flex gap-2 mb-3">
                                                <a href="../<?php echo htmlspecialchars($bg['background_image']); ?>" 
                                                   target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye me-1"></i>View Full
                                                </a>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="slide_number" value="<?php echo $bg['slide_number']; ?>">
                                                    <input type="submit" name="remove_background" class="btn btn-outline-danger btn-sm"
                                                           value="Remove" onclick="return confirm('Remove background image for this slide?')" />
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-3 text-center py-4 bg-light rounded">
                                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                <p class="text-muted">Using default background color</p>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Upload Form -->
                                        <form method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="slide_number" value="<?php echo $bg['slide_number']; ?>">
                                            <div class="mb-3">
                                                <label for="background_image_<?php echo $bg['slide_number']; ?>" class="form-label">
                                                    <?php echo $bg['background_image'] ? 'Replace' : 'Upload'; ?> Background Image
                                                </label>
                                                <input type="file" class="form-control" 
                                                       id="background_image_<?php echo $bg['slide_number']; ?>" 
                                                       name="background_image" accept="image/*" required>
                                                <small class="text-muted">Recommended: 1920x1080px. Max: 5MB. Formats: JPG, PNG, GIF</small>
                                            </div>
                                            <input type="submit" class="btn btn-primary" 
                                                   value="<?php echo $bg['background_image'] ? 'Replace' : 'Upload'; ?> Background" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Info -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle me-2"></i>How It Works</h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li><strong>Upload Background Images:</strong> Each slide can have a custom background image</li>
                                <li><strong>Default Fallback:</strong> If no image is uploaded, the slide uses its default background color</li>
                                <li><strong>Automatic Updates:</strong> Changes appear immediately on the home page</li>
                                <li><strong>Image Management:</strong> Old images are automatically deleted when replaced</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
