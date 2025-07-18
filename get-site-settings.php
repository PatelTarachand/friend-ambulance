<?php
// API to get site settings
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database
require_once 'admin/includes/database.php';

try {
    $db = new SiteSettingsDB();
    
    // Get all settings
    $allSettings = $db->getAllSettings();
    
    // Format for API response
    $settingsData = [];
    $settingsByGroup = [];
    
    foreach ($allSettings as $setting) {
        // Add to main array
        $settingsData[] = [
            'key' => $setting['setting_key'],
            'value' => $setting['setting_value'],
            'type' => $setting['setting_type'],
            'group' => $setting['setting_group'],
            'label' => $setting['setting_label'],
            'description' => $setting['setting_description'],
            'required' => (bool)$setting['is_required'],
            'order' => (int)$setting['display_order'],
            'created_at' => $setting['created_at'],
            'updated_at' => $setting['updated_at']
        ];
        
        // Group by category
        if (!isset($settingsByGroup[$setting['setting_group']])) {
            $settingsByGroup[$setting['setting_group']] = [];
        }
        $settingsByGroup[$setting['setting_group']][] = [
            'key' => $setting['setting_key'],
            'value' => $setting['setting_value'],
            'label' => $setting['setting_label'],
            'required' => (bool)$setting['is_required']
        ];
    }
    
    // Get settings as key-value pairs (like constants)
    $settingsArray = $db->getSettingsArray();
    
    // Get statistics
    $stats = $db->getStats();
    
    echo json_encode([
        'success' => true,
        'data' => $settingsData,
        'grouped' => $settingsByGroup,
        'constants' => $settingsArray,
        'count' => count($settingsData),
        'statistics' => [
            'total' => $stats['total'],
            'configured' => $stats['configured'],
            'required' => $stats['required'],
            'missing_required' => $stats['missing_required']
        ],
        'message' => 'Site settings retrieved successfully',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching site settings: ' . $e->getMessage(),
        'data' => [],
        'grouped' => [],
        'constants' => [],
        'count' => 0,
        'statistics' => [
            'total' => 0,
            'configured' => 0,
            'required' => 0,
            'missing_required' => 0
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT);
}
?>
