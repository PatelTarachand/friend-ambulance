<?php
require_once 'includes/database.php';

$db = new GalleryDB();
$message = '';
$error = '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle form submissions
if ($_POST) {
    $name = trim($_POST['name'] ?? '');
    $status = isset($_POST['status']) ? 1 : 0;

    if (empty($name)) {
        $error = 'Name is required.';
    } else {
        if ($action === 'create') {
            // Handle create
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleImageUpload($_FILES['image']);
                if ($uploadResult['success']) {
                    $newId = $db->create($name, $uploadResult['path'], $status);
                    if ($newId) {
                        $message = 'Gallery item created successfully!';
                        $action = 'list';
                    } else {
                        $error = 'Failed to save gallery item.';
                    }
                } else {
                    $error = $uploadResult['message'];
                }
            } else {
                $error = 'Please select an image file.';
            }
        } elseif ($action === 'edit' && $id) {
            // Handle edit
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleImageUpload($_FILES['image']);
                if ($uploadResult['success']) {
                    // Delete old image
                    $oldItem = $db->getById($id);
                    if ($oldItem && file_exists('../' . $oldItem['image'])) {
                        unlink('../' . $oldItem['image']);
                    }
                    $imagePath = $uploadResult['path'];
                } else {
                    $error = $uploadResult['message'];
                }
            }

            if (empty($error)) {
                if ($db->update($id, $name, $imagePath, $status)) {
                    $message = 'Gallery item updated successfully!';
                    $action = 'list';
                } else {
                    $error = 'Failed to update gallery item.';
                }
            }
        }
    }
}

// Handle delete
if ($action === 'delete' && $id) {
    if ($db->delete($id)) {
        $message = 'Gallery item deleted successfully!';
    } else {
        $error = 'Failed to delete gallery item.';
    }
    $action = 'list';
}

// Handle toggle status
if ($action === 'toggle' && $id) {
    $newStatus = $db->toggleStatus($id);
    if ($newStatus !== false) {
        $message = 'Status updated successfully!';
    } else {
        $error = 'Failed to update status.';
    }
    $action = 'list';
}

// Get data for different actions
$galleryItems = [];
$editItem = null;
$stats = $db->getStats();

if ($action === 'list') {
    $galleryItems = $db->getAll();
} elseif ($action === 'edit' && $id) {
    $editItem = $db->getById($id);
    if (!$editItem) {
        $error = 'Gallery item not found.';
        $action = 'list';
        $galleryItems = $db->getAll();
    }
}

// Image upload handler function
function handleImageUpload($file) {
    $uploadDir = '../assets/uploads/gallery/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate file
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG, and GIF files are allowed.'];
    }

    if ($fileSize > $maxSize) {
        return ['success' => false, 'message' => 'File size must be less than 5MB.'];
    }

    // Generate unique filename
    $newFileName = 'gallery_' . time() . '_' . uniqid() . '.' . $fileExt;
    $uploadPath = $uploadDir . $newFileName;
    $relativePath = 'assets/uploads/gallery/' . $newFileName;

    if (move_uploaded_file($fileTmp, $uploadPath)) {
        return ['success' => true, 'path' => $relativePath];
    } else {
        return ['success' => false, 'message' => 'Failed to upload file.'];
    }
}
// Include common admin header
include 'includes/header.php';
?>

<!-- Additional CSS for gallery page -->
<style>
    .image-card {
        transition: transform 0.3s;
    }
    .image-card:hover {
        transform: translateY(-5px);
    }
    .gallery-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
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
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['total']; ?></h3>
                                        <p class="mb-0">Total Items</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['active']; ?></h3>
                                        <p class="mb-0">Active Items</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['inactive']; ?></h3>
                                        <p class="mb-0">Inactive Items</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <a href="?action=create" class="btn btn-light btn-sm">
                                            <i class="fas fa-plus me-1"></i>Add New
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($action === 'create' || $action === 'edit'): ?>
                        <!-- Create/Edit Form -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>
                                    <i class="fas fa-<?php echo $action === 'create' ? 'plus' : 'edit'; ?> me-2"></i>
                                    <?php echo $action === 'create' ? 'Add New' : 'Edit'; ?> Gallery Item
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name *</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>"
                                                       placeholder="Enter gallery item name" required>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="status" name="status"
                                                           <?php echo ($editItem['status'] ?? 1) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="status">
                                                        Active Status
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image" class="form-label">
                                                    Image <?php echo $action === 'create' ? '*' : '(Leave empty to keep current)'; ?>
                                                </label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                       accept="image/*" <?php echo $action === 'create' ? 'required' : ''; ?>>
                                                <small class="text-muted">Max size: 5MB. Formats: JPG, PNG, GIF</small>
                                            </div>

                                            <?php if ($action === 'edit' && $editItem): ?>
                                            <div class="mb-3">
                                                <label class="form-label">Current Image</label>
                                                <div>
                                                    <img src="../<?php echo htmlspecialchars($editItem['image']); ?>"
                                                         alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            <?php echo $action === 'create' ? 'Create' : 'Update'; ?>
                                        </button>
                                        <a href="gallery.php" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($action === 'list'): ?>
                        <!-- Gallery Items List -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5><i class="fas fa-list me-2"></i>Gallery Items (<?php echo count($galleryItems); ?>)</h5>
                                <a href="?action=create" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Add New
                                </a>
                            </div>
                            <div class="card-body">
                                <?php if (empty($galleryItems)): ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No gallery items yet. Create your first item!</p>
                                        <a href="?action=create" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add First Item
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Updated</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($galleryItems as $item): ?>
                                                <tr>
                                                    <td>
                                                        <img src="../<?php echo htmlspecialchars($item['image']); ?>"
                                                             alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    </td>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php echo $item['status'] ? 'success' : 'secondary'; ?>">
                                                            <?php echo $item['status'] ? 'Active' : 'Inactive'; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php echo date('M j, Y', strtotime($item['created_at'])); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php echo date('M j, Y', strtotime($item['updated_at'])); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="../<?php echo htmlspecialchars($item['image']); ?>"
                                                               target="_blank" class="btn btn-outline-info" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="?action=edit&id=<?php echo $item['id']; ?>"
                                                               class="btn btn-outline-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="?action=toggle&id=<?php echo $item['id']; ?>"
                                                               class="btn btn-outline-warning" title="Toggle Status">
                                                                <i class="fas fa-toggle-<?php echo $item['status'] ? 'on' : 'off'; ?>"></i>
                                                            </a>
                                                            <a href="?action=delete&id=<?php echo $item['id']; ?>"
                                                               class="btn btn-outline-danger" title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this item?')">
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
                        <?php endif; ?>

<?php include 'includes/footer.php'; ?>
