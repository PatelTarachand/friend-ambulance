<?php
// Gallery Update - Process Edit Form
session_start();
require_once 'includes/database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['gallery_error'] = 'Invalid request method.';
    header('Location: gallery.php');
    exit;
}

// Get form data
$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$status = isset($_POST['status']) ? 1 : 0;

// Validate required fields
if (!$id) {
    $_SESSION['gallery_error'] = 'Gallery item ID is required.';
    header('Location: gallery.php');
    exit;
}

if (empty($name)) {
    $_SESSION['gallery_error'] = 'Image name is required.';
    header('Location: galleryEdit.php?id=' . $id);
    exit;
}

// Get existing item
$db = new GalleryDB();
$existingItem = $db->getById($id);

if (!$existingItem) {
    $_SESSION['gallery_error'] = 'Gallery item not found.';
    header('Location: gallery.php');
    exit;
}

$imagePath = $existingItem['image']; // Keep existing image by default

// Check if new image was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Process new image upload
    $uploadResult = uploadImage($_FILES['image']);
    
    if (!$uploadResult['success']) {
        $_SESSION['gallery_error'] = $uploadResult['message'];
        header('Location: galleryEdit.php?id=' . $id);
        exit;
    }
    
    // Delete old image file
    if (file_exists('../' . $existingItem['image'])) {
        unlink('../' . $existingItem['image']);
    }
    
    $imagePath = $uploadResult['path'];
}

// Update database
try {
    $success = $db->update($id, $name, $imagePath, $status);
    
    if ($success) {
        $_SESSION['gallery_message'] = "Gallery image '$name' updated successfully!";
        header('Location: gallery.php');
        exit;
    } else {
        $_SESSION['gallery_error'] = 'Failed to update gallery item.';
        header('Location: galleryEdit.php?id=' . $id);
        exit;
    }
} catch (Exception $e) {
    $_SESSION['gallery_error'] = 'Database error: ' . $e->getMessage();
    header('Location: galleryEdit.php?id=' . $id);
    exit;
}

// Image upload function
function uploadImage($file) {
    // Upload directory
    $uploadDir = '../uploads/gallery/';
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            return ['success' => false, 'message' => 'Failed to create upload directory.'];
        }
    }
    
    // Get file information
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG, and GIF files are allowed.'];
    }
    
    // Validate file size (5MB max)
    $maxSize = 5 * 1024 * 1024;
    if ($fileSize > $maxSize) {
        return ['success' => false, 'message' => 'File size must be less than 5MB.'];
    }
    
    // Validate image
    $imageInfo = getimagesize($fileTmp);
    if (!$imageInfo) {
        return ['success' => false, 'message' => 'Invalid image file.'];
    }
    
    // Check minimum dimensions
    if ($imageInfo[0] < 100 || $imageInfo[1] < 100) {
        return ['success' => false, 'message' => 'Image must be at least 100x100 pixels.'];
    }
    
    // Generate unique filename
    $newFileName = 'gallery_' . time() . '_' . uniqid() . '.' . $fileExt;
    $uploadPath = $uploadDir . $newFileName;
    $relativePath = 'uploads/gallery/' . $newFileName;
    
    // Move uploaded file
    if (move_uploaded_file($fileTmp, $uploadPath)) {
        return [
            'success' => true, 
            'path' => $relativePath,
            'filename' => $newFileName,
            'size' => $fileSize,
            'dimensions' => $imageInfo[0] . 'x' . $imageInfo[1]
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to upload file. Check directory permissions.'];
    }
}
?>
