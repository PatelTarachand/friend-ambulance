<?php
require_once 'includes/header.php';
require_once 'includes/upload.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$message = '';
$error = '';

// Handle form submissions
if ($_POST) {
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!AdminAuth::verifyCSRFToken($csrf_token)) {
        $error = 'Invalid security token. Please try again.';
    } else {
        if ($action === 'add' || $action === 'edit') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $sort_order = intval($_POST['sort_order'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            if (empty($title)) {
                $error = 'Title is required.';
            } else {
                if ($action === 'add') {
                    // Handle new gallery image
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $upload = new ImageUpload();
                        $result = $upload->uploadImage($_FILES['image'], 'gallery');

                        if ($result['success']) {
                            $success = executeQuery(
                                "INSERT INTO gallery_images (title, description, image_path, thumbnail_path, is_active, sort_order, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)",
                                [$title, $description, $result['path'], $result['thumbnail'], $is_active, $sort_order, $_SESSION['admin_user_id']]
                            );

                            if ($success) {
                                $message = 'Gallery image added successfully!';
                                $action = 'list';
                            } else {
                                $error = 'Failed to save image data.';
                            }
                        } else {
                            $error = $result['message'];
                        }
                    } else {
                        $uploadError = $_FILES['image']['error'] ?? 'No file selected';
                        $error = 'Please select an image file. Upload error: ' . $uploadError;
                    }
                } else {
                    // Handle edit gallery image
                    $updateQuery = "UPDATE gallery_images SET title = ?, description = ?, is_active = ?, sort_order = ?, updated_at = ? WHERE id = ?";
                    $updateParams = [$title, $description, $is_active, $sort_order, date('Y-m-d H:i:s'), $id];
                    
                    // Handle image update if new image uploaded
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $upload = new ImageUpload();
                        $result = $upload->uploadImage($_FILES['image'], 'gallery');
                        
                        if ($result['success']) {
                            // Delete old images
                            $oldGallery = getSingleRecord("SELECT image_path, thumbnail_path FROM gallery_images WHERE id = ?", [$id]);
                            if ($oldGallery) {
                                $upload->deleteImage($oldGallery['image_path'], $oldGallery['thumbnail_path']);
                            }
                            
                            $updateQuery = "UPDATE gallery_images SET title = ?, description = ?, image_path = ?, thumbnail_path = ?, is_active = ?, sort_order = ?, updated_at = ? WHERE id = ?";
                            $updateParams = [$title, $description, $result['path'], $result['thumbnail'], $is_active, $sort_order, date('Y-m-d H:i:s'), $id];
                        } else {
                            $error = $result['message'];
                        }
                    }
                    
                    if (empty($error)) {
                        executeQuery($updateQuery, $updateParams);
                        $message = 'Gallery image updated successfully!';
                        $action = 'list';
                    }
                }
            }
        } elseif ($action === 'delete') {
            $gallery = getSingleRecord("SELECT image_path, thumbnail_path FROM gallery_images WHERE id = ?", [$id]);
            if ($gallery) {
                $upload = new ImageUpload();
                $upload->deleteImage($gallery['image_path'], $gallery['thumbnail_path']);
                executeQuery("DELETE FROM gallery_images WHERE id = ?", [$id]);
                $message = 'Gallery image deleted successfully!';
            }
            $action = 'list';
        }
    }
}

// Get gallery data for edit
$galleryData = null;
if ($action === 'edit' && $id) {
    $galleryData = getSingleRecord("SELECT * FROM gallery_images WHERE id = ?", [$id]);
    if (!$galleryData) {
        $error = 'Gallery image not found.';
        $action = 'list';
    }
}

// Get gallery images for list view
$galleryImages = [];
if ($action === 'list') {
    $galleryImages = getMultipleRecords(
        "SELECT g.*, u.full_name as created_by_name
         FROM gallery_images g
         LEFT JOIN admin_users u ON g.created_by = u.id
         ORDER BY g.sort_order ASC, g.created_at DESC"
    );
}

// Get total count
$totalImages = getSingleRecord("SELECT COUNT(*) as count FROM gallery_images")['count'];
?>

<?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <!-- Gallery List -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-photo-video me-2"></i>Gallery Management</h4>
        <a href="?action=add" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Image
        </a>
    </div>
    
    <!-- Gallery Stats -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="fas fa-images text-primary me-2"></i>
                <span>Total Images: <strong><?php echo $totalImages; ?></strong></span>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (empty($galleryImages)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-photo-video fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No gallery images found</h5>
                    <p class="text-muted">Add your first gallery image to get started.</p>
                    <a href="?action=add" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add First Image
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($galleryImages as $gallery): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="../<?php echo htmlspecialchars($gallery['thumbnail_path'] ?: $gallery['image_path']); ?>" 
                                     class="card-img-top" style="height: 200px; object-fit: cover;" 
                                     alt="<?php echo htmlspecialchars($gallery['title']); ?>">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge <?php echo $gallery['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $gallery['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </div>

                            </div>
                            <div class="card-body">
                                <h6 class="card-title"><?php echo htmlspecialchars($gallery['title']); ?></h6>
                                <?php if ($gallery['description']): ?>
                                    <p class="card-text text-muted small">
                                        <?php echo htmlspecialchars(substr($gallery['description'], 0, 80)) . '...'; ?>
                                    </p>
                                <?php endif; ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Order: <?php echo $gallery['sort_order']; ?>
                                    </small>
                                    <div class="btn-group btn-group-sm">
                                        <a href="?action=edit&id=<?php echo $gallery['id']; ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=delete&id=<?php echo $gallery['id']; ?>" 
                                           class="btn btn-outline-danger btn-delete"
                                           onclick="return confirm('Are you sure you want to delete this image?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    By <?php echo htmlspecialchars($gallery['created_by_name'] ?? 'Unknown'); ?> • 
                                    <?php echo date('M j, Y', strtotime($gallery['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php elseif ($action === 'add' || $action === 'edit'): ?>
    <!-- Add/Edit Form -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>
            <i class="fas fa-<?php echo $action === 'add' ? 'plus' : 'edit'; ?> me-2"></i>
            <?php echo $action === 'add' ? 'Add New' : 'Edit'; ?> Gallery Image
        </h4>
        <a href="?action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Gallery
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo AdminAuth::generateCSRFToken(); ?>">
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($galleryData['title'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($galleryData['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order"
                                           value="<?php echo $galleryData['sort_order'] ?? 0; ?>" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                Gallery Image <?php echo $action === 'add' ? '*' : '(Leave empty to keep current)'; ?>
                            </label>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/*" <?php echo $action === 'add' ? 'required' : ''; ?>
                                   onchange="previewImage(this, 'imagePreview')">
                            <small class="text-muted">Max size: 5MB. Recommended: 800x600px</small>
                        </div>
                        
                        <?php if ($action === 'edit' && $galleryData): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <img src="../<?php echo htmlspecialchars($galleryData['image_path']); ?>" 
                                     class="img-fluid rounded" alt="Current image">
                            </div>
                        <?php endif; ?>
                        
                        <img id="imagePreview" class="img-fluid rounded mb-3" style="display: none;" alt="Preview">
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   <?php echo ($galleryData['is_active'] ?? 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>
                        <?php echo $action === 'add' ? 'Add' : 'Update'; ?> Image
                    </button>
                    <a href="?action=list" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
