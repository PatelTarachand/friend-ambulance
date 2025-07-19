<?php
// Enhanced Dashboard with Analytics
require_once 'includes/database.php';

// Initialize database connections
$sliderDb = new SliderDB();
$contactDb = new ContactFormDB();
$settingsDb = new SiteSettingsDB();

// Get comprehensive stats
$sliderStats = $sliderDb->getStats();
$contactStats = $contactDb->getSubmissionStats();

// Get recent activity
$recentContacts = $contactDb->getAllSubmissions('new', 5, 0);

// System information
$loginTime = $_SESSION['login_time'] ?? time();
$sessionDuration = time() - $loginTime;
$serverInfo = [
    'php_version' => PHP_VERSION,
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time')
];

// Calculate storage usage
$uploadDir = __DIR__ . '/../uploads/';
$storageUsed = 0;
if (is_dir($uploadDir)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadDir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $storageUsed += $file->getSize();
        }
    }
}
$storageUsedMB = round($storageUsed / 1024 / 1024, 2);

// Include common admin header
include 'includes/header.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Friends Ambulance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .activity-item {
            padding: 15px;
            border-left: 3px solid #e9ecef;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            border-left-color: #007bff;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .quick-action-card {
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .quick-action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
                <div class="main-content">
                   
                    <!-- Enhanced Dashboard Content -->
                    <div class="container-fluid p-4">
                        <!-- Welcome Header -->
                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center">
                                    <div class="dashboard-avatar me-3">
                                        <i class="fas fa-user-shield text-primary"></i>
                                    </div>
                                    <div>
                                        <h2 class="mb-1">
                                            <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                            Dashboard Overview
                                        </h2>
                                        <p class="text-muted mb-0">Welcome back! Here's what's happening with Friends Ambulance Service</p>
                                        <small class="text-success">
                                            <i class="fas fa-circle me-1"></i>
                                            System Status: Online
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-primary btn-sm" onclick="location.reload()">
                                        <i class="fas fa-sync-alt me-1"></i>Refresh
                                    </button>
                                    <a href="../" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i>View Site
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Statistics Cards -->
                        <div class="row mb-4">


                            <!-- Contact Messages Stats -->
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-gradient-warning">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h3 class="mb-0 fw-bold"><?php echo $contactStats['new_count']; ?></h3>
                                                        <p class="text-muted mb-0 small">New Messages</p>
                                                    </div>
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <?php echo $contactStats['total']; ?> Total
                                                    </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="contact-submissions.php" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-eye me-1"></i>View All
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Slider Stats -->
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-gradient-info">
                                                <i class="fas fa-sliders-h"></i>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h3 class="mb-0 fw-bold"><?php echo $sliderStats['total']; ?></h3>
                                                        <p class="text-muted mb-0 small">Hero Slides</p>
                                                    </div>
                                                    <span class="badge bg-info-subtle text-info">
                                                        <i class="fas fa-play me-1"></i>Active
                                                    </span>
                                                </div>
                                                <div class="progress mt-2" style="height: 4px;">
                                                    <div class="progress-bar bg-info" style="width: 60%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- System Performance -->
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card stat-card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-gradient-success">
                                                <i class="fas fa-server"></i>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h3 class="mb-0 fw-bold"><?php echo $storageUsedMB; ?>MB</h3>
                                                        <p class="text-muted mb-0 small">Storage Used</p>
                                                    </div>
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="fas fa-check me-1"></i>Healthy
                                                    </span>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        Session: <?php echo gmdate("H:i:s", $sessionDuration); ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Content Sections -->
                        <div class="row">
                            <!-- Quick Actions -->
                            <div class="col-lg-4 mb-4">
                                <div class="card quick-action-card border-0 shadow-sm h-100">
                                    <div class="card-header bg-gradient-primary text-white border-0">
                                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">

                                            <a href="hero-backgrounds.php" class="btn btn-outline-warning">
                                                <i class="fas fa-image me-2"></i>
                                                Hero Backgrounds
                                            </a>
                                            <a href="contact-submissions.php" class="btn btn-outline-info">
                                                <i class="fas fa-envelope me-2"></i>
                                                Contact Messages
                                            </a>
                                            <a href="site-settings.php" class="btn btn-outline-secondary">
                                                <i class="fas fa-cog me-2"></i>
                                                Site Settings
                                            </a>
                                        </div>
                                        <hr>
                                        <div class="d-grid gap-2">
                                            <a href="../" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                View Website
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="col-lg-4 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-gradient-info text-white border-0">
                                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Activity</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($recentContacts)): ?>
                                            <?php foreach (array_slice($recentContacts, 0, 3) as $contact): ?>
                                                <div class="activity-item">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="mb-1"><?php echo htmlspecialchars($contact['name'] ?? 'Unknown'); ?></h6>
                                                            <p class="mb-1 small text-muted"><?php echo htmlspecialchars(substr($contact['message'] ?? 'No message', 0, 50)) . '...'; ?></p>
                                                            <small class="text-muted"><?php echo isset($contact['created_at']) ? date('M j, g:i A', strtotime($contact['created_at'])) : 'Recent'; ?></small>
                                                        </div>
                                                        <span class="badge bg-warning">New</span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center text-muted py-3">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p>No recent activity</p>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-center mt-3">
                                            <a href="contact-submissions.php" class="btn btn-sm btn-outline-info">
                                                View All Activity
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced System Information -->
                            <div class="col-lg-4 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-gradient-success text-white border-0">
                                        <h5 class="mb-0"><i class="fas fa-server me-2"></i>System Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Login Time:</span>
                                                    <strong><?php echo date('M j, g:i A', $loginTime); ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">PHP Version:</span>
                                                    <strong><?php echo $serverInfo['php_version']; ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Memory Limit:</span>
                                                    <strong><?php echo $serverInfo['memory_limit']; ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Upload Max:</span>
                                                    <strong><?php echo $serverInfo['upload_max_filesize']; ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Storage Used:</span>
                                                    <strong><?php echo $storageUsedMB; ?> MB</strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Upload Directory:</span>
                                                    <span class="badge <?php echo is_writable($uploadDir) ? 'bg-success' : 'bg-danger'; ?>">
                                                        <?php echo is_writable($uploadDir) ? 'Writable' : 'Not Writable'; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-center">
                                            <a href="database-status.php" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-database me-1"></i>Database Status
                                            </a>
                                        </div>
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
