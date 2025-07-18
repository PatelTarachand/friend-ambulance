<?php
session_start();

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once 'config/database.php';
require_once 'includes/database.php';

$dbStatus = [];
$error = '';

try {
    // Test database connection
    $connection = getDBConnection();
    $dbStatus['connection'] = 'Connected';
    $dbStatus['host'] = DB_HOST;
    $dbStatus['database'] = DB_NAME;
    $dbStatus['username'] = DB_USERNAME;
    
    // Get MySQL version
    $result = $connection->query("SELECT VERSION() as version");
    if ($result) {
        $dbStatus['mysql_version'] = $result->fetch_assoc()['version'];
    }
    
    // Check if gallery table exists
    $result = $connection->query("SHOW TABLES LIKE 'gallery'");
    $dbStatus['gallery_table'] = $result->num_rows > 0 ? 'Exists' : 'Not Found';
    
    // Get gallery statistics
    if ($result->num_rows > 0) {
        $db = new GalleryDB();
        $stats = $db->getStats();
        $dbStatus['gallery_stats'] = $stats;
    }

    // Check if slider table exists
    $result = $connection->query("SHOW TABLES LIKE 'slider'");
    $dbStatus['slider_table'] = $result->num_rows > 0 ? 'Exists' : 'Not Found';

    // Get slider statistics
    if ($result->num_rows > 0) {
        $sliderDb = new SliderDB();
        $sliderStats = $sliderDb->getStats();
        $dbStatus['slider_stats'] = $sliderStats;
    }
    
    $connection->close();
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $dbStatus['connection'] = 'Failed';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Status - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 0;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .status-good { color: #28a745; }
        .status-bad { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="p-3">
                        <h5 class="text-center mb-4">
                            <i class="fas fa-plus-circle me-2"></i>
                            Admin Panel
                        </h5>
                        
                        <nav class="nav flex-column">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                            <a class="nav-link" href="gallery.php">
                                <i class="fas fa-images me-2"></i>
                                Gallery Management
                            </a>
                            <a class="nav-link" href="slider.php">
                                <i class="fas fa-sliders-h me-2"></i>
                                Slider Management
                            </a>
                            <a class="nav-link active" href="database-status.php">
                                <i class="fas fa-database me-2"></i>
                                Database Status
                            </a>
                            <a class="nav-link" href="../" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>
                                View Website
                            </a>
                            <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Top Navigation -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                        <div class="container-fluid">
                            <span class="navbar-brand">Database Status</span>
                            <div class="navbar-nav ms-auto">
                                <span class="nav-item nav-link">
                                    <i class="fas fa-user me-2"></i>
                                    <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                                </span>
                            </div>
                        </div>
                    </nav>
                    
                    <!-- Database Status Content -->
                    <div class="container-fluid p-4">
                        <div class="row mb-4">
                            <div class="col">
                                <h2>
                                    <i class="fas fa-database me-2 text-primary"></i>
                                    Database Status
                                </h2>
                                <p class="text-muted">MySQL Database Connection and Table Status</p>
                            </div>
                        </div>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Database Error:</strong> <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Database Information -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-info-circle me-2"></i>Connection Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    <span class="<?php echo $dbStatus['connection'] === 'Connected' ? 'status-good' : 'status-bad'; ?>">
                                                        <i class="fas fa-<?php echo $dbStatus['connection'] === 'Connected' ? 'check-circle' : 'times-circle'; ?> me-1"></i>
                                                        <?php echo $dbStatus['connection']; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Host:</strong></td>
                                                <td><?php echo $dbStatus['host'] ?? 'N/A'; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Database:</strong></td>
                                                <td><?php echo $dbStatus['database'] ?? 'N/A'; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td><?php echo $dbStatus['username'] ?? 'N/A'; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>MySQL Version:</strong></td>
                                                <td><?php echo $dbStatus['mysql_version'] ?? 'N/A'; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-table me-2"></i>Gallery Table Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Table Status:</strong></td>
                                                <td>
                                                    <span class="<?php echo ($dbStatus['gallery_table'] ?? '') === 'Exists' ? 'status-good' : 'status-bad'; ?>">
                                                        <i class="fas fa-<?php echo ($dbStatus['gallery_table'] ?? '') === 'Exists' ? 'check-circle' : 'times-circle'; ?> me-1"></i>
                                                        <?php echo $dbStatus['gallery_table'] ?? 'Unknown'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php if (isset($dbStatus['gallery_stats'])): ?>
                                                <tr>
                                                    <td><strong>Total Items:</strong></td>
                                                    <td><?php echo $dbStatus['gallery_stats']['total']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Active Items:</strong></td>
                                                    <td><?php echo $dbStatus['gallery_stats']['active']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Inactive Items:</strong></td>
                                                    <td><?php echo $dbStatus['gallery_stats']['inactive']; ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-sliders-h me-2"></i>Slider Table Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Table Status:</strong></td>
                                                <td>
                                                    <span class="<?php echo ($dbStatus['slider_table'] ?? '') === 'Exists' ? 'status-good' : 'status-bad'; ?>">
                                                        <i class="fas fa-<?php echo ($dbStatus['slider_table'] ?? '') === 'Exists' ? 'check-circle' : 'times-circle'; ?> me-1"></i>
                                                        <?php echo $dbStatus['slider_table'] ?? 'Unknown'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php if (isset($dbStatus['slider_stats'])): ?>
                                                <tr>
                                                    <td><strong>Total Slides:</strong></td>
                                                    <td><?php echo $dbStatus['slider_stats']['total']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Active Slides:</strong></td>
                                                    <td><?php echo $dbStatus['slider_stats']['active']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Inactive Slides:</strong></td>
                                                    <td><?php echo $dbStatus['slider_stats']['inactive']; ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h5><i class="fas fa-info-circle me-2"></i>Quick Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="gallery.php" class="btn btn-primary btn-sm">
                                                <i class="fas fa-images me-2"></i>Manage Gallery
                                            </a>
                                            <a href="slider.php" class="btn btn-success btn-sm">
                                                <i class="fas fa-sliders-h me-2"></i>Manage Slider
                                            </a>
                                            <a href="setup-database.php" class="btn btn-info btn-sm">
                                                <i class="fas fa-cog me-2"></i>Setup Database
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-tools me-2"></i>Database Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    <a href="setup-database.php" class="btn btn-primary">
                                        <i class="fas fa-cog me-2"></i>Setup Database
                                    </a>
                                    <a href="gallery.php" class="btn btn-success">
                                        <i class="fas fa-images me-2"></i>Manage Gallery
                                    </a>
                                    <a href="get-gallery.php" target="_blank" class="btn btn-info">
                                        <i class="fas fa-api me-2"></i>Test API
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
