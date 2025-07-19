<?php
// Gallery List - Show all gallery items
require_once 'includes/database.php';

$db = new GalleryDB();
$galleryItems = $db->getAll();
$stats = $db->getStats();

// Handle messages from session
session_start();
$message = $_SESSION['gallery_message'] ?? '';
$error = $_SESSION['gallery_error'] ?? '';
unset($_SESSION['gallery_message'], $_SESSION['gallery_error']);

include 'includes/header.php';
?>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="main-content-inner">
                    
                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <h2>
                                <i class="fas fa-images me-2 text-primary"></i>
                                Gallery Management
                            </h2>
                            <p class="text-muted">Manage your gallery images</p>
                        </div>
                        <div class="col-lg-4 text-end">
                            <a href="galleryCreate.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Add New Image
                            </a>
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
                                    <p class="mb-0">Total Images</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3><?php echo $stats['active']; ?></h3>
                                    <p class="mb-0">Active Images</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3><?php echo $stats['inactive']; ?></h3>
                                    <p class="mb-0">Inactive Images</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Items -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Gallery Items
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($galleryItems)): ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                    <h4>No Gallery Items Found</h4>
                                    <p class="text-muted">Start by adding your first gallery image.</p>
                                    <a href="galleryCreate.php" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add First Image
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($galleryItems as $item): ?>
                                                <tr>
                                                    <td><?php echo $item['id']; ?></td>
                                                    <td>
                                                        <img src="../<?php echo htmlspecialchars($item['image']); ?>" 
                                                             alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                    </td>
                                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $item['status'] ? 'bg-success' : 'bg-secondary'; ?>">
                                                            <?php echo $item['status'] ? 'Active' : 'Inactive'; ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo date('M j, Y', strtotime($item['created_at'])); ?></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="galleryEdit.php?id=<?php echo $item['id']; ?>" 
                                                               class="btn btn-outline-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="galleryDelete.php?id=<?php echo $item['id']; ?>" 
                                                               class="btn btn-outline-danger" title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
