<?php
// Get gallery and slider stats
require_once 'includes/database.php';
$db = new GalleryDB();
$sliderDb = new SliderDB();
$galleryStats = $db->getStats();
$sliderStats = $sliderDb->getStats();

$loginTime = $_SESSION['login_time'] ?? time();
$sessionDuration = time() - $loginTime;
// Include common admin header
include 'includes/header.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Friends Ambulance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
</head>
<body>
    <div class="container-fluid">
                <div class="main-content">
                   
                    <!-- Dashboard Content -->
                    <div class="container-fluid p-4">
                        <div class="row mb-4">
                            <div class="col">
                                <h2>
                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                    Dashboard Overview
                                </h2>
                                <p class="text-muted">Welcome to Friends Ambulance Service Admin Panel</p>
                            </div>
                        </div>
                        
                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-primary">
                                            <i class="fas fa-images"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0"><?php echo $galleryStats['total']; ?></h3>
                                            <p class="text-muted mb-0">Gallery Items</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-success">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0"><?php echo gmdate("H:i:s", $sessionDuration); ?></h3>
                                            <p class="text-muted mb-0">Session Time</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-warning">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0"><?php echo date('d'); ?></h3>
                                            <p class="text-muted mb-0"><?php echo date('M Y'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-info">
                                            <i class="fas fa-sliders-h"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0"><?php echo $sliderStats['total']; ?></h3>
                                            <p class="text-muted mb-0">Slider Items</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="gallery.php" class="btn btn-primary">
                                                <i class="fas fa-images me-2"></i>
                                                Manage Gallery
                                            </a>
                                            <a href="slider.php" class="btn btn-success">
                                                <i class="fas fa-sliders-h me-2"></i>
                                                Manage Slider
                                            </a>
                                            <a href="hero-backgrounds.php" class="btn btn-warning">
                                                <i class="fas fa-image me-2"></i>
                                                Hero Backgrounds
                                            </a>
                                            <a href="site-settings.php" class="btn btn-info">
                                                <i class="fas fa-cog me-2"></i>
                                                Site Settings
                                            </a>
                                            <a href="../index.php" target="_blank" class="btn btn-outline-info">
                                                <i class="fas fa-home me-2"></i>
                                                View Home Page
                                            </a>
                                            <a href="../" target="_blank" class="btn btn-outline-secondary">
                                                <i class="fas fa-home me-2"></i>
                                                View Website
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-info-circle me-2"></i>System Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li><strong>Login Time:</strong> <?php echo date('M j, Y g:i A', $loginTime); ?></li>
                                            <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
                                            <li><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></li>
                                            <li><strong>Upload Dir:</strong> <?php
                                                $uploadDir = __DIR__ . '/../uploads/';
                                                echo is_writable($uploadDir) ? 'Writable' : 'Not Writable';
                                            ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
