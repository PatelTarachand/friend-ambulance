<?php
// Dynamic Configuration - Loads settings from database
// This replaces the static config.php with database-driven configuration

// Global settings array
$SITE_SETTINGS = [];

// Load settings from database
function loadSiteSettings() {
    global $SITE_SETTINGS;

    try {
        // Check if database file exists
        $dbFile = __DIR__ . '/../admin/includes/database.php';
        if (!file_exists($dbFile)) {
            throw new Exception("Database file not found: " . $dbFile);
        }

        // Include database classes
        require_once $dbFile;

        // Check if database classes are available
        if (!class_exists('SiteSettingsDB')) {
            throw new Exception("SiteSettingsDB class not found");
        }

        $settingsDB = new SiteSettingsDB();
        $SITE_SETTINGS = $settingsDB->getSettingsArray();
echo 1;
        // Validate that we got some settings
        if (empty($SITE_SETTINGS)) {
            throw new Exception("No settings loaded from database");
        }

        // Define constants for backward compatibility
        defineSettingConstants();

    } catch (Exception $e) {
        echo 3;
        // Fallback to default values if database fails
        $error_msg = "Failed to load site settings from database: " . $e->getMessage() .
                    " in " . $e->getFile() . " on line " . $e->getLine();
        error_log("[DYNAMIC-CONFIG] " . $error_msg);

        // Also log to custom file for easier debugging
        $custom_log = __DIR__ . '/../logs/php_errors.log';
        $log_dir = dirname($custom_log);
        if (!is_dir($log_dir)) {
            @mkdir($log_dir, 0755, true);
        }
        error_log("[" . date('Y-m-d H:i:s') . "] [DYNAMIC-CONFIG] " . $error_msg . "\n", 3, $custom_log);

        loadFallbackSettings();
    }
}
loadSiteSettings();


// Define constants from database settings
function defineSettingConstants() {
    global $SITE_SETTINGS;
    
    // Site Information
    if (!defined('SITE_NAME')) define('SITE_NAME', $SITE_SETTINGS['SITE_NAME'] ?? 'Friends Ambulance Service');
    if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', $SITE_SETTINGS['SITE_TAGLINE'] ?? 'Raipur\'s Most Trusted Ambulance Service - 21+ Years');
    if (!defined('SITE_URL')) define('SITE_URL', $SITE_SETTINGS['SITE_URL'] ?? 'http://localhost/protc/Friend');
    if (!defined('META_KEYWORDS')) define('META_KEYWORDS', $SITE_SETTINGS['META_KEYWORDS'] ?? 'ambulance service raipur, emergency ambulance, BLS ambulance, ALS ambulance, 24x7 ambulance, chhattisgarh ambulance');
    
    // Contact Information
    if (!defined('PHONE_PRIMARY')) define('PHONE_PRIMARY', $SITE_SETTINGS['PHONE_PRIMARY'] ?? '93299 62163');
    if (!defined('PHONE_SECONDARY')) define('PHONE_SECONDARY', $SITE_SETTINGS['PHONE_SECONDARY'] ?? '9893462863');
    if (!defined('PHONE_TERTIARY')) define('PHONE_TERTIARY', $SITE_SETTINGS['PHONE_TERTIARY'] ?? '7869165263');
    if (!defined('EMAIL')) define('EMAIL', $SITE_SETTINGS['EMAIL'] ?? 'info@friendsambulance.com');
    if (!defined('WHATSAPP')) define('WHATSAPP', $SITE_SETTINGS['WHATSAPP'] ?? '919329962163');
    if (!defined('ADDRESS')) define('ADDRESS', $SITE_SETTINGS['ADDRESS'] ?? 'Ramkrishna care hospital, near by Ramkrishna care hospital, Pachpedi Naka, Raipur, Tikrapara, Chhattisgarh 492001');
    
    // Social Media
    if (!defined('FACEBOOK')) define('FACEBOOK', $SITE_SETTINGS['FACEBOOK'] ?? '#');
    if (!defined('TWITTER')) define('TWITTER', $SITE_SETTINGS['TWITTER'] ?? '#');
    if (!defined('INSTAGRAM')) define('INSTAGRAM', $SITE_SETTINGS['INSTAGRAM'] ?? '#');
}

// Fallback settings if database is not available
function loadFallbackSettings() {
    global $SITE_SETTINGS;
    
    $SITE_SETTINGS = [
        'SITE_NAME' => 'Friends Ambulance Service',
        'SITE_TAGLINE' => 'Raipur\'s Most Trusted Ambulance Service - 21+ Years',
        'SITE_URL' => 'http://localhost/protc/Friend',
        'META_KEYWORDS' => 'ambulance service raipur, emergency ambulance, BLS ambulance, ALS ambulance, 24x7 ambulance, chhattisgarh ambulance',
        'PHONE_PRIMARY' => '93299 62163',
        'PHONE_SECONDARY' => '9893462863',
        'PHONE_TERTIARY' => '7869165263',
        'EMAIL' => 'info@friendsambulance.com',
        'WHATSAPP' => '919329962163',
        'ADDRESS' => 'Ramkrishna care hospital, near by Ramkrishna care hospital, Pachpedi Naka, Raipur, Tikrapara, Chhattisgarh 492001',
        'FACEBOOK' => '#',
        'TWITTER' => '#',
        'INSTAGRAM' => '#'
    ];
    
    defineSettingConstants();
}

// Get setting value by key
function getSetting($key, $default = '') {
    global $SITE_SETTINGS;
    return $SITE_SETTINGS[strtoupper($key)] ?? $default;
}

// Check if setting exists
function hasSetting($key) {
    global $SITE_SETTINGS;
    return isset($SITE_SETTINGS[strtoupper($key)]);
}

// Get all settings
function getAllSettings() {
    global $SITE_SETTINGS;
    return $SITE_SETTINGS;
}

// Refresh settings from database
function refreshSettings() {
    loadSiteSettings();
}

// Helper functions for phone formatting (from original config)
function formatPhone($phone) {
    // Remove any non-digit characters except +
    $phone = preg_replace('/[^\d+]/', '', $phone);
    
    // Format Indian phone numbers
    if (strlen($phone) == 10) {
        return substr($phone, 0, 5) . ' ' . substr($phone, 5);
    } elseif (strlen($phone) == 12 && substr($phone, 0, 2) == '91') {
        return '+91 ' . substr($phone, 2, 5) . ' ' . substr($phone, 7);
    } elseif (strlen($phone) == 13 && substr($phone, 0, 3) == '+91') {
        return '+91 ' . substr($phone, 3, 5) . ' ' . substr($phone, 8);
    }
    
    return $phone;
}

function formatPhoneForCall($phone) {
    // Remove any non-digit characters except +
    $phone = preg_replace('/[^\d+]/', '', $phone);
    
    // Ensure proper format for tel: links
    if (strlen($phone) == 10) {
        return '+91' . $phone;
    } elseif (strlen($phone) == 12 && substr($phone, 0, 2) == '91') {
        return '+' . $phone;
    } elseif (strlen($phone) == 13 && substr($phone, 0, 3) == '+91') {
        return $phone;
    }
    
    return $phone;
}
echo $SITE_SETTINGS['PHONE_PRIMARY'];
// Initialize settings when this file is included
loadSiteSettings();


?>
