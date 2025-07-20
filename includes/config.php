<?php
// Static Configuration File - Fallback for dynamic configuration
// This file provides default values when database configuration is not available

// Site Information
if (!defined('SITE_NAME')) define('SITE_NAME', 'Friends Ambulance Service');
if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', 'Raipur\'s Most Trusted Ambulance Service - 21+ Years');
if (!defined('SITE_URL')) define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));

if (!defined('META_DESCRIPTION')) define('META_DESCRIPTION', 'Friends Ambulance Service provides 24/7 emergency ambulance services in Raipur, Chhattisgarh. BLS and ALS ambulances available with trained medical staff.');
if (!defined('META_KEYWORDS')) define('META_KEYWORDS', 'ambulance service raipur, emergency ambulance, BLS ambulance, ALS ambulance, 24x7 ambulance, chhattisgarh ambulance, medical emergency, patient transport');

// Contact Information
if (!defined('PHONE_PRIMARY')) define('PHONE_PRIMARY', '93299 62163');
if (!defined('PHONE_SECONDARY')) define('PHONE_SECONDARY', '9893462863');
if (!defined('PHONE_TERTIARY')) define('PHONE_TERTIARY', '7869165263');
if (!defined('EMAIL')) define('EMAIL', 'info@friendsambulance.com');
if (!defined('EMAIL_SECONDARY')) define('EMAIL_SECONDARY', 'contact@friendsambulance.com');
if (!defined('WHATSAPP')) define('WHATSAPP', '919329962163');

// Address Information
if (!defined('ADDRESS')) define('ADDRESS', 'Ramkrishna care hospital, near by Ramkrishna care hospital, Pachpedi Naka, Raipur, Tikrapara, Chhattisgarh 492001');
if (!defined('CITY')) define('CITY', 'Raipur');
if (!defined('STATE')) define('STATE', 'Chhattisgarh');
if (!defined('PINCODE')) define('PINCODE', '492001');
if (!defined('COUNTRY')) define('COUNTRY', 'India');

// Social Media Links
if (!defined('FACEBOOK')) define('FACEBOOK', '#');
if (!defined('TWITTER')) define('TWITTER', '#');
if (!defined('INSTAGRAM')) define('INSTAGRAM', '#');
if (!defined('LINKEDIN')) define('LINKEDIN', '#');
if (!defined('YOUTUBE')) define('YOUTUBE', '#');

// Business Information
if (!defined('ESTABLISHED_YEAR')) define('ESTABLISHED_YEAR', '2003');
if (!defined('EXPERIENCE_YEARS')) define('EXPERIENCE_YEARS', '21+');
if (!defined('SERVICE_AREA')) define('SERVICE_AREA', 'Raipur and surrounding areas');
if (!defined('AVAILABILITY')) define('AVAILABILITY', '24/7');

// Service Information
if (!defined('SERVICES_OFFERED')) define('SERVICES_OFFERED', 'BLS Ambulance, ALS Ambulance, Emergency Response, Patient Transport, Medical Equipment');
if (!defined('RESPONSE_TIME')) define('RESPONSE_TIME', '10-15 minutes');
if (!defined('COVERAGE_AREA')) define('COVERAGE_AREA', 'Raipur, Durg, Bhilai, and nearby districts');

// Technical Configuration
if (!defined('SITE_TIMEZONE')) define('SITE_TIMEZONE', 'Asia/Kolkata');
if (!defined('DATE_FORMAT')) define('DATE_FORMAT', 'd/m/Y');
if (!defined('TIME_FORMAT')) define('TIME_FORMAT', 'H:i');
if (!defined('CURRENCY')) define('CURRENCY', 'INR');
if (!defined('LANGUAGE')) define('LANGUAGE', 'en');

// SEO Configuration
if (!defined('SITE_AUTHOR')) define('SITE_AUTHOR', 'Friends Ambulance Service');
if (!defined('SITE_COPYRIGHT')) define('SITE_COPYRIGHT', '© 2024 Friends Ambulance Service. All rights reserved.');
if (!defined('ROBOTS')) define('ROBOTS', 'index, follow');

// Helper Functions
if (!function_exists('formatPhone')) {
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
}

if (!function_exists('formatPhoneForCall')) {
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
}

if (!function_exists('getCurrentPage')) {
    function getCurrentPage() {
        return basename($_SERVER['PHP_SELF'], '.php');
    }
}

if (!function_exists('getPageTitle')) {
    function getPageTitle($page = null) {
        if (!$page) {
            $page = getCurrentPage();
        }
        
        $titles = [
            'index' => SITE_NAME . ' - ' . SITE_TAGLINE,
            'about' => 'About Us - ' . SITE_NAME,
            'services' => 'Our Services - ' . SITE_NAME,
            'contact' => 'Contact Us - ' . SITE_NAME,
            'gallery' => 'Gallery - ' . SITE_NAME,
            'blog' => 'Blog - ' . SITE_NAME,
            'privacy' => 'Privacy Policy - ' . SITE_NAME,
            'terms' => 'Terms of Service - ' . SITE_NAME
        ];
        
        return $titles[$page] ?? SITE_NAME;
    }
}

if (!function_exists('getMetaDescription')) {
    function getMetaDescription($page = null) {
        if (!$page) {
            $page = getCurrentPage();
        }
        
        $descriptions = [
            'index' => META_DESCRIPTION,
            'about' => 'Learn about Friends Ambulance Service, Raipur\'s most trusted ambulance service provider with 21+ years of experience in emergency medical services.',
            'services' => 'Comprehensive ambulance services including BLS, ALS, emergency response, and patient transport in Raipur, Chhattisgarh.',
            'contact' => 'Contact Friends Ambulance Service for emergency ambulance services in Raipur. Available 24/7 with quick response time.',
            'gallery' => 'View our fleet of modern ambulances and medical equipment. See why we are Raipur\'s most trusted ambulance service.',
        ];
        
        return $descriptions[$page] ?? META_DESCRIPTION;
    }
}

// Set timezone
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set(SITE_TIMEZONE);
}

// Global variables for backward compatibility
$SITE_SETTINGS = [
    'SITE_NAME' => SITE_NAME,
    'SITE_TAGLINE' => SITE_TAGLINE,
    'SITE_URL' => SITE_URL,
    'META_DESCRIPTION' => META_DESCRIPTION,
    'META_KEYWORDS' => META_KEYWORDS,
    'PHONE_PRIMARY' => PHONE_PRIMARY,
    'PHONE_SECONDARY' => PHONE_SECONDARY,
    'PHONE_TERTIARY' => PHONE_TERTIARY,
    'EMAIL' => EMAIL,
    'WHATSAPP' => WHATSAPP,
    'ADDRESS' => ADDRESS,
    'CITY' => CITY,
    'STATE' => STATE,
    'PINCODE' => PINCODE,
    'FACEBOOK' => FACEBOOK,
    'TWITTER' => TWITTER,
    'INSTAGRAM' => INSTAGRAM,
    'ESTABLISHED_YEAR' => ESTABLISHED_YEAR,
    'EXPERIENCE_YEARS' => EXPERIENCE_YEARS,
    'SERVICE_AREA' => SERVICE_AREA,
    'AVAILABILITY' => AVAILABILITY
];

// Helper functions for settings
if (!function_exists('getSetting')) {
    function getSetting($key, $default = '') {
        global $SITE_SETTINGS;
        return $SITE_SETTINGS[strtoupper($key)] ?? $default;
    }
}

if (!function_exists('hasSetting')) {
    function hasSetting($key) {
        global $SITE_SETTINGS;
        return isset($SITE_SETTINGS[strtoupper($key)]);
    }
}

if (!function_exists('getAllSettings')) {
    function getAllSettings() {
        global $SITE_SETTINGS;
        return $SITE_SETTINGS;
    }
}
?>
