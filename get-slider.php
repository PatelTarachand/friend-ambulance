<?php
// API to get slider items for frontend display
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database
require_once 'admin/includes/database.php';

try {
    $db = new SliderDB();
    
    // Get only active slider items
    $activeSlides = $db->getActive();
    
    // Format for frontend
    $sliderData = [];
    foreach ($activeSlides as $slide) {
        $sliderData[] = [
            'id' => (int)$slide['id'],
            'title' => $slide['title'],
            'subtitle' => $slide['subtitle'],
            'image' => $slide['image'],
            'button_text' => $slide['button_text'],
            'button_link' => $slide['button_link'],
            'sort_order' => (int)$slide['sort_order'],
            'status' => (int)$slide['status'],
            'created_at' => $slide['created_at'],
            'updated_at' => $slide['updated_at']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $sliderData,
        'count' => count($sliderData),
        'message' => 'Slider data retrieved successfully'
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching slider data: ' . $e->getMessage(),
        'data' => [],
        'count' => 0
    ], JSON_PRETTY_PRINT);
}
?>
