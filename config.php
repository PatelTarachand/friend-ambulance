<?php
// Configuration file for Friends Ambulance Service

// Site Information
define('SITE_NAME', 'Friends Ambulance Service');
define('SITE_TAGLINE', 'Raipur\'s Most Trusted Ambulance Service - 21+ Years');
define('SITE_URL', 'http://localhost/protc/Friend');

// Contact Information
define('PHONE_PRIMARY', '93299 62163');
define('PHONE_SECONDARY', '9893462863');
define('PHONE_TERTIARY', '7869165263');
define('EMAIL', 'info@friendsambulance.com');
define('WHATSAPP', '919329962163');

// Address
define('ADDRESS', 'Ramkrishna care hospital, near by Ramkrishna care hospital, Pachpedi Naka, Raipur, Tikrapara, Chhattisgarh 492001');

// Social Media (if any)
define('FACEBOOK', '#');
define('TWITTER', '#');
define('INSTAGRAM', '#');

// SEO Meta
define('META_DESCRIPTION', 'Friends Ambulance Service - Raipur\'s oldest and most trusted ambulance service with 21+ years of experience. 24x7 emergency response with BLS, ALS ambulances.');
define('META_KEYWORDS', 'ambulance service raipur, emergency ambulance, BLS ambulance, ALS ambulance, 24x7 ambulance, chhattisgarh ambulance');

// Google Maps Embed
define('GOOGLE_MAPS_EMBED', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.4429078742346!2d81.65156137610691!3d21.214278480481905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a28dd46decc38c5%3A0xf572bf456c2ba098!2sRaipur%20Friends%20ambulance%20Service!5e0!3m2!1sen!2sin!4v1752684039523!5m2!1sen!2sin');

// Function to get current page
function getCurrentPage() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page === 'index' ? 'home' : $page;
}

// Function to format phone number for display
function formatPhone($phone) {
    return preg_replace('/(\d{5})(\d{2})(\d{3})/', '$1 $2 $3', $phone);
}

// Function to format phone number for calling
function formatPhoneForCall($phone) {
    return preg_replace('/[^0-9]/', '', $phone);
}
?>
