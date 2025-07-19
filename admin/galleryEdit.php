<?php
// Gallery Edit Form
require_once 'includes/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: gallery.php');
    exit;
}

$db = new GalleryDB();
$item = $db->getById($id);

if (!$item) {
    session_start();
    $_SESSION['gallery_error'] = 'Gallery item not found.';
    header('Location: gallery.php');
    exit;
}

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
                                <i class="fas fa-edit me-2 text-primary"></i>
                                Edit Gallery Image
                            </h2>
                            <p class="text-muted">Update gallery image details</p>
                        </div>
                        <div class="col-lg-4 text-end">
                            <a href="gallery.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Gallery
                            </a>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-image me-2"></i>Edit Gallery Image Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="galleryUpdate.php" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">
                                                        <i class="fas fa-tag me-1"></i>Image Name *
                                                    </label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           value="<?php echo htmlspecialchars($item['name']); ?>"
                                                           placeholder="Enter descriptive name for the image" required>
                                                    <div class="form-text">
                                                        This will be used as the image title and alt text.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-toggle-on me-1"></i>Status
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="status" name="status" 
                                                               <?php echo $item['status'] ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="status">
                                                            <span class="status-text">
                                                                <?php echo $item['status'] ? 'Active (Visible on website)' : 'Inactive (Hidden from website)'; ?>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-text">
                                                        Toggle to make the image visible or hidden on the website.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-info-circle me-1"></i>Image Info
                                                    </label>
                                                    <div class="card bg-light">
                                                        <div class="card-body">
                                                            <small class="text-muted">
                                                                <strong>Created:</strong> <?php echo date('M j, Y g:i A', strtotime($item['created_at'])); ?><br>
                                                                <strong>Last Updated:</strong> <?php echo date('M j, Y g:i A', strtotime($item['updated_at'])); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Current Image -->
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-image me-1"></i>Current Image
                                                    </label>
                                                    <div class="border rounded p-3 text-center">
                                                        <img src="../<?php echo htmlspecialchars($item['image']); ?>" 
                                                             alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                             class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                </div>

                                                <!-- Replace Image -->
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">
                                                        <i class="fas fa-upload me-1"></i>Replace Image (Optional)
                                                    </label>
                                                    <input type="file" class="form-control" id="image" name="image"
                                                           accept="image/jpeg,image/jpg,image/png,image/gif">
                                                    <div class="form-text">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Leave empty to keep current image | Supported: JPG, PNG, GIF | Max: 5MB
                                                    </div>
                                                </div>

                                                <!-- New Image Preview -->
                                                <div class="mb-3">
                                                    <div id="imagePreview" class="border rounded p-3 text-center" style="display: none;">
                                                        <label class="form-label">New Image Preview</label>
                                                        <img id="previewImg" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <input type="submit" class="btn btn-primary btn-lg me-3" value="Update Gallery Image" name="submit" />
                                                  
                                                <a href="gallery.php" class="btn btn-secondary btn-lg">
                                                    <i class="fas fa-times me-2"></i>Cancel
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Image Preview -->
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        previewImg.src = '';
    }
});

// Status toggle text update
document.getElementById('status').addEventListener('change', function() {
    const statusText = document.querySelector('.status-text');
    if (this.checked) {
        statusText.textContent = 'Active (Visible on website)';
        statusText.className = 'status-text text-success';
    } else {
        statusText.textContent = 'Inactive (Hidden from website)';
        statusText.className = 'status-text text-muted';
    }
});
</script>

<?php include 'includes/footer.php'; ?>
