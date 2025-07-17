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
            $button_text = trim($_POST['button_text'] ?? '');
            $button_link = trim($_POST['button_link'] ?? '');
            $background_color = $_POST['background_color'] ?? '#0d6efd';
            $text_color = $_POST['text_color'] ?? '#ffffff';
            $slide_order = intval($_POST['slide_order'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            if (empty($title)) {
                $error = 'Title is required.';
            } else {
                if ($action === 'add') {
                    // Handle new slider
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $upload = new ImageUpload();
                        $result = $upload->uploadImage($_FILES['image'], 'slider');
                        
                        if ($result['success']) {
                            $sliders = readJsonFile(SLIDERS_FILE);
                            $sliders[] = [
                                'id' => generateId(),
                                'title' => $title,
                                'description' => $description,
                                'image_path' => $result['path'],
                                'slide_order' => $slide_order,
                                'is_active' => $is_active,
                                'button_text' => $button_text,
                                'button_link' => $button_link,
                                'background_color' => $background_color,
                                'text_color' => $text_color,
                                'created_by' => $_SESSION['admin_user_id'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                            writeJsonFile(SLIDERS_FILE, $sliders);
                            $message = 'Slider image added successfully!';
                            $action = 'list';
                        } else {
                            $error = $result['message'];
                        }
                    } else {
                        $error = 'Please select an image file.';
                    }
                } else {
                    // Handle edit slider
                    $sliders = readJsonFile(SLIDERS_FILE);
                    $sliderIndex = -1;

                    foreach ($sliders as $index => $slider) {
                        if ($slider['id'] === $id) {
                            $sliderIndex = $index;
                            break;
                        }
                    }

                    if ($sliderIndex !== -1) {
                        // Handle image update if new image uploaded
                        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                            $upload = new ImageUpload();
                            $result = $upload->uploadImage($_FILES['image'], 'slider');

                            if ($result['success']) {
                                // Delete old image
                                $upload->deleteImage($sliders[$sliderIndex]['image_path']);
                                $sliders[$sliderIndex]['image_path'] = $result['path'];
                            } else {
                                $error = $result['message'];
                            }
                        }

                        if (empty($error)) {
                            $sliders[$sliderIndex]['title'] = $title;
                            $sliders[$sliderIndex]['description'] = $description;
                            $sliders[$sliderIndex]['slide_order'] = $slide_order;
                            $sliders[$sliderIndex]['is_active'] = $is_active;
                            $sliders[$sliderIndex]['button_text'] = $button_text;
                            $sliders[$sliderIndex]['button_link'] = $button_link;
                            $sliders[$sliderIndex]['background_color'] = $background_color;
                            $sliders[$sliderIndex]['text_color'] = $text_color;
                            $sliders[$sliderIndex]['updated_at'] = date('Y-m-d H:i:s');

                            writeJsonFile(SLIDERS_FILE, $sliders);
                            $message = 'Slider image updated successfully!';
                            $action = 'list';
                        }
                    }
                }
            }
        } elseif ($action === 'delete') {
            $sliders = readJsonFile(SLIDERS_FILE);
            $sliderIndex = -1;

            foreach ($sliders as $index => $slider) {
                if ($slider['id'] === $id) {
                    $sliderIndex = $index;
                    break;
                }
            }

            if ($sliderIndex !== -1) {
                $upload = new ImageUpload();
                $upload->deleteImage($sliders[$sliderIndex]['image_path']);
                array_splice($sliders, $sliderIndex, 1);
                writeJsonFile(SLIDERS_FILE, $sliders);
                $message = 'Slider image deleted successfully!';
            }
            $action = 'list';
        }
    }
}

// Get slider data for edit
$sliderData = null;
if ($action === 'edit' && $id) {
    $sliders = readJsonFile(SLIDERS_FILE);
    foreach ($sliders as $slider) {
        if ($slider['id'] === $id) {
            $sliderData = $slider;
            break;
        }
    }
    if (!$sliderData) {
        $error = 'Slider not found.';
        $action = 'list';
    }
}

// Get all sliders for list view
$sliders = [];
if ($action === 'list') {
    $sliders = readJsonFile(SLIDERS_FILE);
    $users = readJsonFile(USERS_FILE);

    // Add creator names
    foreach ($sliders as &$slider) {
        $slider['created_by_name'] = 'Unknown';
        foreach ($users as $user) {
            if ($user['id'] === $slider['created_by']) {
                $slider['created_by_name'] = $user['full_name'];
                break;
            }
        }
    }

    // Sort by slide order and creation date
    usort($sliders, function($a, $b) {
        if ($a['slide_order'] == $b['slide_order']) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        }
        return $a['slide_order'] - $b['slide_order'];
    });
}
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
    <!-- Slider List -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-images me-2"></i>Slider Images</h4>
        <a href="?action=add" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Slider
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (empty($sliders)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-images fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No slider images found</h5>
                    <p class="text-muted">Add your first slider image to get started.</p>
                    <a href="?action=add" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Slider
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sliders as $slider): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary"><?php echo $slider['slide_order']; ?></span>
                                </td>
                                <td>
                                    <img src="../<?php echo htmlspecialchars($slider['image_path']); ?>" 
                                         alt="Slider" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($slider['title']); ?></strong>
                                    <?php if ($slider['description']): ?>
                                        <br><small class="text-muted"><?php echo htmlspecialchars(substr($slider['description'], 0, 50)) . '...'; ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo $slider['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $slider['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($slider['created_by_name'] ?? 'Unknown'); ?></td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo date('M j, Y', strtotime($slider['created_at'])); ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="?action=edit&id=<?php echo $slider['id']; ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=delete&id=<?php echo $slider['id']; ?>" 
                                           class="btn btn-outline-danger btn-delete"
                                           onclick="return confirm('Are you sure you want to delete this slider?')">
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

<?php elseif ($action === 'add' || $action === 'edit'): ?>
    <!-- Add/Edit Form -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>
            <i class="fas fa-<?php echo $action === 'add' ? 'plus' : 'edit'; ?> me-2"></i>
            <?php echo $action === 'add' ? 'Add New' : 'Edit'; ?> Slider Image
        </h4>
        <a href="?action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
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
                                   value="<?php echo htmlspecialchars($sliderData['title'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($sliderData['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" class="form-control" id="button_text" name="button_text" 
                                           value="<?php echo htmlspecialchars($sliderData['button_text'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="url" class="form-control" id="button_link" name="button_link" 
                                           value="<?php echo htmlspecialchars($sliderData['button_link'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                Slider Image <?php echo $action === 'add' ? '*' : '(Leave empty to keep current)'; ?>
                            </label>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/*" <?php echo $action === 'add' ? 'required' : ''; ?>
                                   onchange="previewImage(this, 'imagePreview')">
                            <small class="text-muted">Max size: 5MB. Recommended: 1920x1080px</small>
                        </div>
                        
                        <?php if ($action === 'edit' && $sliderData): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <img src="../<?php echo htmlspecialchars($sliderData['image_path']); ?>" 
                                     class="img-fluid rounded" alt="Current slider">
                            </div>
                        <?php endif; ?>
                        
                        <img id="imagePreview" class="img-fluid rounded mb-3" style="display: none;" alt="Preview">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="slide_order" class="form-label">Order</label>
                            <input type="number" class="form-control" id="slide_order" name="slide_order" 
                                   value="<?php echo $sliderData['slide_order'] ?? 0; ?>" min="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="background_color" class="form-label">Background Color</label>
                            <input type="color" class="form-control form-control-color" id="background_color" name="background_color" 
                                   value="<?php echo $sliderData['background_color'] ?? '#0d6efd'; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="text_color" class="form-label">Text Color</label>
                            <input type="color" class="form-control form-control-color" id="text_color" name="text_color" 
                                   value="<?php echo $sliderData['text_color'] ?? '#ffffff'; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       <?php echo ($sliderData['is_active'] ?? 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        <?php echo $action === 'add' ? 'Add' : 'Update'; ?> Slider
                    </button>
                    <a href="?action=list" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
