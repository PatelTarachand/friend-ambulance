<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../admin/config/database.php';

try {
    $action = $_GET['action'] ?? 'get_images';
    
    switch ($action) {
        case 'get_images':
            echo json_encode(getGalleryImages());
            break;
            
        case 'get_categories':
            echo json_encode(getGalleryCategories());
            break;
            
        case 'get_featured':
            echo json_encode(getFeaturedImages());
            break;
            
        case 'search':
            $query = $_GET['q'] ?? '';
            echo json_encode(searchGalleryImages($query));
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function getGalleryImages() {
    try {
        $category = $_GET['category'] ?? '';
        $limit = intval($_GET['limit'] ?? 50);
        $offset = intval($_GET['offset'] ?? 0);
        
        $sql = "SELECT gi.*, gc.name as category_name, gc.icon as category_icon, gc.color as category_color 
                FROM gallery_images gi 
                LEFT JOIN gallery_categories gc ON gi.category = gc.slug 
                WHERE gi.is_active = 1";
        
        $params = [];
        
        if ($category && $category !== 'all') {
            $sql .= " AND gi.category = ?";
            $params[] = $category;
        }
        
        $sql .= " ORDER BY gi.sort_order ASC, gi.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $images = getMultipleRecords($sql, $params);
        
        // Check if images exist and add file status
        foreach ($images as &$image) {
            $image['thumbnail_exists'] = file_exists('../' . $image['thumbnail_path']);
            $image['image_exists'] = file_exists('../' . $image['image_path']);
            $image['display_src'] = $image['thumbnail_exists'] ? $image['thumbnail_path'] : 
                                   ($image['image_exists'] ? $image['image_path'] : 'assets/images/placeholder-gallery.jpg');
        }
        
        return [
            'success' => true,
            'data' => $images,
            'total' => getTotalImageCount($category),
            'has_more' => (count($images) === $limit)
        ];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function getGalleryCategories() {
    try {
        $categories = getMultipleRecords(
            "SELECT gc.*, COUNT(gi.id) as image_count 
             FROM gallery_categories gc 
             LEFT JOIN gallery_images gi ON gc.slug = gi.category AND gi.is_active = 1 
             WHERE gc.is_active = 1 
             GROUP BY gc.id 
             ORDER BY gc.sort_order ASC"
        );
        
        return [
            'success' => true,
            'data' => $categories
        ];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function getFeaturedImages() {
    try {
        $images = getMultipleRecords(
            "SELECT gi.*, gc.name as category_name, gc.icon as category_icon, gc.color as category_color 
             FROM gallery_images gi 
             LEFT JOIN gallery_categories gc ON gi.category = gc.slug 
             WHERE gi.is_active = 1 AND gi.is_featured = 1 
             ORDER BY gi.sort_order ASC 
             LIMIT 6"
        );
        
        // Check if images exist
        foreach ($images as &$image) {
            $image['thumbnail_exists'] = file_exists('../' . $image['thumbnail_path']);
            $image['image_exists'] = file_exists('../' . $image['image_path']);
            $image['display_src'] = $image['thumbnail_exists'] ? $image['thumbnail_path'] : 
                                   ($image['image_exists'] ? $image['image_path'] : 'assets/images/placeholder-gallery.jpg');
        }
        
        return [
            'success' => true,
            'data' => $images
        ];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function searchGalleryImages($query) {
    try {
        if (empty($query)) {
            return ['success' => true, 'data' => []];
        }
        
        $sql = "SELECT gi.*, gc.name as category_name, gc.icon as category_icon, gc.color as category_color 
                FROM gallery_images gi 
                LEFT JOIN gallery_categories gc ON gi.category = gc.slug 
                WHERE gi.is_active = 1 
                AND (gi.title LIKE ? OR gi.description LIKE ? OR gi.alt_text LIKE ?) 
                ORDER BY gi.sort_order ASC, gi.created_at DESC 
                LIMIT 20";
        
        $searchTerm = '%' . $query . '%';
        $images = getMultipleRecords($sql, [$searchTerm, $searchTerm, $searchTerm]);
        
        // Check if images exist
        foreach ($images as &$image) {
            $image['thumbnail_exists'] = file_exists('../' . $image['thumbnail_path']);
            $image['image_exists'] = file_exists('../' . $image['image_path']);
            $image['display_src'] = $image['thumbnail_exists'] ? $image['thumbnail_path'] : 
                                   ($image['image_exists'] ? $image['image_path'] : 'assets/images/placeholder-gallery.jpg');
        }
        
        return [
            'success' => true,
            'data' => $images,
            'query' => $query
        ];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function getTotalImageCount($category = '') {
    try {
        $sql = "SELECT COUNT(*) as count FROM gallery_images WHERE is_active = 1";
        $params = [];
        
        if ($category && $category !== 'all') {
            $sql .= " AND category = ?";
            $params[] = $category;
        }
        
        $result = getSingleRecord($sql, $params);
        return $result ? intval($result['count']) : 0;
        
    } catch (Exception $e) {
        return 0;
    }
}
?>
