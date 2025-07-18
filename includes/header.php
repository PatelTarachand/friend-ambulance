<?php
// Define essential constants first (emergency fallback)
if (!defined('SITE_NAME')) define('SITE_NAME', 'Friends Ambulance Service');
if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', 'Raipur\'s Most Trusted Ambulance Service - 21+ Years');
if (!defined('META_DESCRIPTION')) define('META_DESCRIPTION', 'Friends Ambulance Service provides 24/7 emergency ambulance services in Raipur, Chhattisgarh.');
if (!defined('META_KEYWORDS')) define('META_KEYWORDS', 'ambulance service raipur, emergency ambulance, BLS ambulance, ALS ambulance');
if (!defined('PHONE_PRIMARY')) define('PHONE_PRIMARY', '93299 62163');
if (!defined('EMAIL')) define('EMAIL', 'info@friendsambulance.com');
if (!defined('ADDRESS')) define('ADDRESS', 'Raipur, Chhattisgarh');
if (!defined('WHATSAPP')) define('WHATSAPP', '919329962163');
if (!defined('FACEBOOK')) define('FACEBOOK', '#');
if (!defined('TWITTER')) define('TWITTER', '#');
if (!defined('INSTAGRAM')) define('INSTAGRAM', '#');

// Define getCurrentPage function if not already defined
if (!function_exists('getCurrentPage')) {
    function getCurrentPage() {
        return basename($_SERVER['PHP_SELF'], '.php');
    }
}

// Load configuration with comprehensive error handling
$configLoaded = false;

// First, try to load dynamic configuration from database
try {
    $dynamicConfigFile = __DIR__ . '/dynamic-config.php';
    if (file_exists($dynamicConfigFile)) {
        require_once $dynamicConfigFile;
        // Check if essential constants are defined
        if (defined('SITE_NAME') && defined('PHONE_PRIMARY') && defined('EMAIL')) {
            $configLoaded = true;
        }
    }
} catch (Exception $e) {
    $error_msg = "Dynamic config failed: " . $e->getMessage() .
                " in " . $e->getFile() . " on line " . $e->getLine();
    error_log("[HEADER] " . $error_msg);

    // Also log to custom file
    $custom_log = __DIR__ . '/../logs/php_errors.log';
    $log_dir = dirname($custom_log);
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }
    error_log("[" . date('Y-m-d H:i:s') . "] [HEADER] " . $error_msg . "\n", 3, $custom_log);
}

// Fallback to static config if dynamic config failed
if (!$configLoaded) {
    $staticConfigFile = __DIR__ . '/config.php';
    if (file_exists($staticConfigFile)) {
        require_once $staticConfigFile;
        $configLoaded = true;
    }
}

// Configuration loaded - constants are already defined above

$current_page = getCurrentPage();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current_page === 'home' ? SITE_NAME . ' - ' . SITE_TAGLINE : ucfirst(str_replace('-', ' ', $current_page)) . ' - ' . SITE_NAME; ?></title>
    
    <!-- Meta Tags -->
    <meta name="description" content="<?php echo META_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php echo META_KEYWORDS; ?>">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo META_DESCRIPTION; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/images/og-image.jpg">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo SITE_NAME; ?>">
    <meta name="twitter:description" content="<?php echo META_DESCRIPTION; ?>">
    <meta name="twitter:image" content="<?php echo SITE_URL; ?>/assets/images/og-image.jpg">

    <!-- Local Business Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "<?php echo SITE_NAME; ?>",
        "description": "<?php echo META_DESCRIPTION; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "telephone": "<?php echo PHONE_PRIMARY; ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo ADDRESS; ?>",
            "addressLocality": "Raipur",
            "addressRegion": "Chhattisgarh",
            "postalCode": "492001",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "21.2144",
            "longitude": "81.6516"
        },
        "openingHours": "Mo-Su 00:00-23:59",
        "priceRange": "$$",
        "serviceArea": {
            "@type": "GeoCircle",
            "geoMidpoint": {
                "@type": "GeoCoordinates",
                "latitude": "21.2144",
                "longitude": "81.6516"
            },
            "geoRadius": "50000"
        },
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Ambulance Services",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "BLS Ambulance Service",
                        "description": "Basic Life Support ambulance with essential medical equipment"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "ALS Ambulance Service",
                        "description": "Advanced Life Support ambulance for critical emergencies"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "ICU Ambulance Service",
                        "description": "Mobile ICU with intensive care equipment"
                    }
                }
            ]
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?php echo PHONE_PRIMARY; ?>",
            "contactType": "emergency",
            "availableLanguage": ["English", "Hindi"],
            "hoursAvailable": "Mo-Su 00:00-23:59"
        },
        "sameAs": [
            "<?php echo FACEBOOK; ?>",
            "<?php echo TWITTER; ?>",
            "<?php echo INSTAGRAM; ?>"
        ]
    }
    </script>
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"></noscript>

    <!-- Bootstrap CSS - Latest Version -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome - Latest Version -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- AOS (Animate On Scroll) Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">

    <!-- Critical CSS Inline -->
    <style>
        /* Critical above-the-fold styles */
        .hero-slider { min-height: 100vh; }
        .carousel-item { min-height: 100vh; }
        .hero-slide { min-height: 100vh; }
        .navbar { transition: all 0.3s ease; }
        .emergency-bar { background: linear-gradient(45deg, #bb2837, #e74c3c); }
    </style>

    <!-- PWA Manifest -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php echo SITE_NAME; ?>">
    <link rel="apple-touch-icon" href="assets/images/icons/icon-192x192.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
</head>
<body class="<?php echo $current_page; ?>-page">
    <!-- Emergency Top Bar -->
    <div class="emergency-bar bg-danger text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-ambulance me-2 blink"></i>
                        <span class="fw-bold">EMERGENCY? CALL NOW!</span>
                        <span class="ms-3">
                            <i class="fas fa-phone me-1"></i>
                            <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="text-white text-decoration-none fw-bold">
                                <?php echo formatPhone(PHONE_PRIMARY); ?>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-warning text-dark pulse">24x7 AVAILABLE</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo SITE_URL; ?>">
                <i class="fas fa-plus-circle text-danger me-2 fs-2"></i>
                <div>
                    <div class="fw-bold text-primary fs-4"><?php echo SITE_NAME; ?></div>
                    <small class="text-muted">21+ Years of Trust</small>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'home' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>" href="about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'services' ? 'active' : ''; ?>" href="services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'gallery' ? 'active' : ''; ?>" href="gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>" href="contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'faq' ? 'active' : ''; ?>" href="faq">FAQ</a>
                    </li>
                </ul>
                
                <div class="d-flex gap-2">
                    <a href="tel:<?php echo formatPhoneForCall(PHONE_PRIMARY); ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-phone me-1"></i> Call Now
                    </a>
                    <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-success btn-sm" target="_blank">
                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </nav>
