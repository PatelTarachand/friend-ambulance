<?php
// API to get gallery items for frontend display
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database
require_once 'admin/includes/database.php';

try {
    $db = new GalleryDB();

    // Get only active gallery items
    $activeItems = $db->getActive();

    // Format for frontend
    $galleryData = [];
    foreach ($activeItems as $item) {
        $galleryData[] = [
            'id' => (int)$item['id'],
            'name' => $item['name'],
            'image' => $item['image'],
            'status' => (int)$item['status'],
            'created_at' => $item['created_at'],
            'updated_at' => $item['updated_at']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $galleryData,
        'count' => count($galleryData),
        'message' => 'Gallery data retrieved successfully'
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching gallery data: ' . $e->getMessage(),
        'data' => [],
        'count' => 0
    ], JSON_PRETTY_PRINT);
}
?>
