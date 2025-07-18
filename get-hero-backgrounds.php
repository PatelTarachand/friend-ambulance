<?php
// API to get hero background images
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database
require_once 'admin/includes/database.php';

try {
    $db = new HeroBackgroundDB();
    
    // Get all hero backgrounds
    $backgrounds = $db->getAll();
    
    // Format for frontend
    $heroData = [];
    foreach ($backgrounds as $bg) {
        $heroData[] = [
            'slide_number' => (int)$bg['slide_number'],
            'background_image' => $bg['background_image'],
            'has_image' => !empty($bg['background_image']),
            'status' => (int)$bg['status'],
            'created_at' => $bg['created_at'],
            'updated_at' => $bg['updated_at']
        ];
    }
    
    // Get statistics
    $stats = $db->getStats();
    
    echo json_encode([
        'success' => true,
        'data' => $heroData,
        'count' => count($heroData),
        'statistics' => [
            'total_slides' => $stats['total'],
            'with_image' => $stats['with_image'],
            'without_image' => $stats['without_image']
        ],
        'message' => 'Hero backgrounds retrieved successfully',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching hero backgrounds: ' . $e->getMessage(),
        'data' => [],
        'count' => 0,
        'statistics' => [
            'total_slides' => 0,
            'with_image' => 0,
            'without_image' => 0
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT);
}
?>
