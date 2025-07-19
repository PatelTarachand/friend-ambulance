<?php
// Gallery Delete - Process Delete Request
session_start();
require_once 'includes/database.php';

// Get ID from URL
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['gallery_error'] = 'Gallery item ID is required.';
    header('Location: gallery.php');
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

// Store name for success message
$itemName = $existingItem['name'];

try {
    // Delete from database
    $success = $db->delete($id);
    
    if ($success) {
        // Delete image file
        if (file_exists('../' . $existingItem['image'])) {
            unlink('../' . $existingItem['image']);
        }
        
        $_SESSION['gallery_message'] = "Gallery image '$itemName' deleted successfully!";
    } else {
        $_SESSION['gallery_error'] = 'Failed to delete gallery item from database.';
    }
} catch (Exception $e) {
    $_SESSION['gallery_error'] = 'Database error: ' . $e->getMessage();
}

// Redirect back to gallery list
header('Location: gallery.php');
exit;
?>
