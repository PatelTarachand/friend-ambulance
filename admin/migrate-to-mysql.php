<?php
// Migration script from JSON to MySQL
session_start();

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require_once 'config/database.php';
require_once 'includes/database.php';

$message = '';
$error = '';
$migrated = 0;

if ($_POST && isset($_POST['migrate'])) {
    try {
        // Check if old JSON file exists
        $jsonFile = __DIR__ . '/data/gallery.json';
        
        if (!file_exists($jsonFile)) {
            $error = 'No JSON data file found to migrate.';
        } else {
            // Read JSON data
            $jsonData = file_get_contents($jsonFile);
            $items = json_decode($jsonData, true);
            
            if (!is_array($items)) {
                $error = 'Invalid JSON data format.';
            } else {
                // Initialize database
                $db = new GalleryDB();
                
                // Migrate each item
                foreach ($items as $item) {
                    $name = $item['name'] ?? $item['title'] ?? 'Untitled';
                    $image = $item['image'] ?? $item['image_path'] ?? '';
                    $status = isset($item['status']) ? (int)$item['status'] : 1;
                    
                    if (!empty($name) && !empty($image)) {
                        if ($db->create($name, $image, $status)) {
                            $migrated++;
                        }
                    }
                }
                
                if ($migrated > 0) {
                    $message = "Successfully migrated {$migrated} items from JSON to MySQL!";
                    
                    // Optionally backup and remove JSON file
                    if (isset($_POST['backup_json'])) {
                        $backupFile = $jsonFile . '.backup.' . date('Y-m-d-H-i-s');
                        copy($jsonFile, $backupFile);
                        unlink($jsonFile);
                        $message .= " JSON file backed up and removed.";
                    }
                } else {
                    $error = 'No valid items found to migrate.';
                }
            }
        }
        
    } catch (Exception $e) {
        $error = 'Migration failed: ' . $e->getMessage();
    }
}

// Check current status
$jsonExists = file_exists(__DIR__ . '/data/gallery.json');
$mysqlCount = 0;
$jsonCount = 0;

try {
    $db = new GalleryDB();
    $stats = $db->getStats();
    $mysqlCount = $stats['total'];
} catch (Exception $e) {
    // MySQL not available
}

if ($jsonExists) {
    $jsonData = file_get_contents(__DIR__ . '/data/gallery.json');
    $items = json_decode($jsonData, true);
    $jsonCount = is_array($items) ? count($items) : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrate to MySQL - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-database me-2"></i>Migrate from JSON to MySQL</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h5>Current Status:</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h3><?php echo $jsonCount; ?></h3>
                                        <p class="mb-0">Items in JSON</p>
                                        <small class="text-muted">
                                            <?php echo $jsonExists ? 'File exists' : 'No JSON file'; ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $mysqlCount; ?></h3>
                                        <p class="mb-0">Items in MySQL</p>
                                        <small>Database: friendsdb</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($jsonExists && $jsonCount > 0): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Migration Available:</strong> You have <?php echo $jsonCount; ?> items in JSON format that can be migrated to MySQL.
                            </div>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="backup_json" name="backup_json" checked>
                                        <label class="form-check-label" for="backup_json">
                                            Backup and remove JSON file after migration
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" name="migrate" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i>Migrate to MySQL
                                    </button>
                                    <a href="gallery.php" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Migration Complete:</strong> You are already using MySQL database.
                            </div>
                            
                            <a href="gallery.php" class="btn btn-primary">
                                <i class="fas fa-images me-2"></i>Go to Gallery Management
                            </a>
                        <?php endif; ?>
                        
                        <hr>
                        <h6>Migration Process:</h6>
                        <ol>
                            <li>Reads existing JSON data</li>
                            <li>Creates MySQL records for each item</li>
                            <li>Preserves names, images, and status</li>
                            <li>Optionally backs up and removes JSON file</li>
                        </ol>
                        
                        <div class="mt-3">
                            <a href="database-status.php" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-database me-1"></i>Database Status
                            </a>
                            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
