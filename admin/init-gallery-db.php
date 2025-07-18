<?php
/**
 * Gallery Database Initialization Script
 * Run this once to set up the gallery tables and sample data
 */

require_once 'config/database.php';

try {
    echo "<h2>Initializing Gallery Database...</h2>";
    
    // Create gallery_categories table
    $categoriesTable = "
    CREATE TABLE IF NOT EXISTS `gallery_categories` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `slug` varchar(100) NOT NULL UNIQUE,
      `description` text DEFAULT NULL,
      `icon` varchar(100) DEFAULT NULL,
      `color` varchar(7) DEFAULT '#007bff',
      `sort_order` int(11) DEFAULT 0,
      `is_active` tinyint(1) DEFAULT 1,
      `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `slug` (`slug`),
      KEY `idx_active` (`is_active`),
      KEY `idx_sort_order` (`sort_order`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    executeQuery($categoriesTable);
    echo "<p>✓ Gallery categories table created/verified</p>";
    
    // Create gallery_images table
    $imagesTable = "
    CREATE TABLE IF NOT EXISTS `gallery_images` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text DEFAULT NULL,
      `image_path` varchar(500) NOT NULL,
      `thumbnail_path` varchar(500) DEFAULT NULL,
      `category` enum('ambulances','equipment','team','facilities') NOT NULL DEFAULT 'ambulances',
      `alt_text` varchar(255) DEFAULT NULL,
      `sort_order` int(11) DEFAULT 0,
      `is_active` tinyint(1) DEFAULT 1,
      `is_featured` tinyint(1) DEFAULT 0,
      `file_size` int(11) DEFAULT NULL,
      `image_width` int(11) DEFAULT NULL,
      `image_height` int(11) DEFAULT NULL,
      `upload_date` timestamp DEFAULT CURRENT_TIMESTAMP,
      `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_category` (`category`),
      KEY `idx_active` (`is_active`),
      KEY `idx_featured` (`is_featured`),
      KEY `idx_sort_order` (`sort_order`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    executeQuery($imagesTable);
    echo "<p>✓ Gallery images table created/verified</p>";
    
    // Check if categories exist, if not insert default ones
    $existingCategories = getMultipleRecords("SELECT COUNT(*) as count FROM gallery_categories");
    if ($existingCategories[0]['count'] == 0) {
        $defaultCategories = [
            ['Ambulances', 'ambulances', 'Our fleet of BLS, ALS, and ICU ambulances', 'fas fa-ambulance', '#007bff', 1],
            ['Equipment', 'equipment', 'Medical equipment and life support systems', 'fas fa-stethoscope', '#28a745', 2],
            ['Our Team', 'team', 'Professional paramedics and support staff', 'fas fa-users', '#ffc107', 3],
            ['Facilities', 'facilities', 'Our office, maintenance, and control room facilities', 'fas fa-building', '#dc3545', 4]
        ];
        
        foreach ($defaultCategories as $category) {
            executeQuery(
                "INSERT INTO gallery_categories (name, slug, description, icon, color, sort_order) VALUES (?, ?, ?, ?, ?, ?)",
                $category
            );
        }
        echo "<p>✓ Default categories inserted</p>";
    } else {
        echo "<p>✓ Categories already exist</p>";
    }
    
    // Check if sample images exist, if not insert placeholders
    $existingImages = getMultipleRecords("SELECT COUNT(*) as count FROM gallery_images");
    if ($existingImages[0]['count'] == 0) {
        $sampleImages = [
            [
                'BLS Ambulance - Front View',
                'Our Basic Life Support ambulance equipped with essential medical equipment for emergency response',
                'assets/images/gallery/bls-ambulance-1.jpg',
                'assets/images/gallery/thumbs/bls-ambulance-1.jpg',
                'ambulances',
                'BLS Ambulance front view showing emergency lights and medical cross',
                1, 1, 1
            ],
            [
                'ALS Ambulance - Interior',
                'Advanced Life Support ambulance interior with cardiac monitor, ventilator, and advanced medical equipment',
                'assets/images/gallery/als-ambulance-interior.jpg',
                'assets/images/gallery/thumbs/als-ambulance-interior.jpg',
                'ambulances',
                'ALS Ambulance interior showing advanced medical equipment',
                2, 1, 1
            ],
            [
                'ICU Ambulance - Mobile ICU Setup',
                'Mobile ICU ambulance with complete intensive care unit setup for critical patient transport',
                'assets/images/gallery/icu-ambulance-setup.jpg',
                'assets/images/gallery/thumbs/icu-ambulance-setup.jpg',
                'ambulances',
                'ICU Ambulance showing mobile intensive care unit equipment',
                3, 1, 1
            ],
            [
                'Oxygen Support System',
                'High-flow oxygen delivery system with portable cylinders and various delivery masks',
                'assets/images/gallery/oxygen-system.jpg',
                'assets/images/gallery/thumbs/oxygen-system.jpg',
                'equipment',
                'Oxygen support system with cylinders and delivery masks',
                4, 1, 0
            ],
            [
                'Cardiac Monitor',
                'Multi-parameter cardiac monitor for continuous vital signs monitoring during transport',
                'assets/images/gallery/cardiac-monitor.jpg',
                'assets/images/gallery/thumbs/cardiac-monitor.jpg',
                'equipment',
                'Cardiac monitor displaying patient vital signs',
                5, 1, 0
            ],
            [
                'Emergency Medical Kit',
                'Comprehensive emergency medical kit with first aid supplies and emergency medications',
                'assets/images/gallery/medical-kit.jpg',
                'assets/images/gallery/thumbs/medical-kit.jpg',
                'equipment',
                'Emergency medical kit with various medical supplies',
                6, 1, 0
            ],
            [
                'Paramedic Team',
                'Our certified paramedic team ready for emergency response with professional training',
                'assets/images/gallery/paramedic-team.jpg',
                'assets/images/gallery/thumbs/paramedic-team.jpg',
                'team',
                'Professional paramedic team in uniform',
                7, 1, 1
            ],
            [
                'Support Staff',
                'Compassionate support staff providing patient care assistance and family support',
                'assets/images/gallery/support-staff.jpg',
                'assets/images/gallery/thumbs/support-staff.jpg',
                'team',
                'Support staff helping with patient care',
                8, 1, 0
            ],
            [
                'Management Team',
                'Experienced management team ensuring quality service delivery and operational excellence',
                'assets/images/gallery/management-team.jpg',
                'assets/images/gallery/thumbs/management-team.jpg',
                'team',
                'Management team in office setting',
                9, 1, 0
            ],
            [
                'Main Office',
                'Our main office located near Ramkrishna Care Hospital, Pachpedi Naka, Raipur',
                'assets/images/gallery/main-office.jpg',
                'assets/images/gallery/thumbs/main-office.jpg',
                'facilities',
                'Main office building exterior view',
                10, 1, 0
            ],
            [
                'Maintenance Facility',
                'Well-equipped maintenance facility for regular ambulance servicing and repairs',
                'assets/images/gallery/maintenance-facility.jpg',
                'assets/images/gallery/thumbs/maintenance-facility.jpg',
                'facilities',
                'Maintenance facility with ambulance being serviced',
                11, 1, 0
            ],
            [
                '24x7 Control Room',
                'Our 24x7 control room for emergency dispatch and coordination with GPS tracking',
                'assets/images/gallery/control-room.jpg',
                'assets/images/gallery/thumbs/control-room.jpg',
                'facilities',
                'Control room with dispatch equipment and monitors',
                12, 1, 0
            ]
        ];
        
        foreach ($sampleImages as $image) {
            executeQuery(
                "INSERT INTO gallery_images (title, description, image_path, thumbnail_path, category, alt_text, sort_order, is_active, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                $image
            );
        }
        echo "<p>✓ Sample gallery images inserted</p>";
    } else {
        echo "<p>✓ Gallery images already exist</p>";
    }
    
    // Create directories if they don't exist
    $directories = [
        '../assets/images/gallery',
        '../assets/images/gallery/thumbs'
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            echo "<p>✓ Created directory: $dir</p>";
        } else {
            echo "<p>✓ Directory exists: $dir</p>";
        }
    }
    
    echo "<h3 style='color: green;'>✓ Gallery database initialization completed successfully!</h3>";
    echo "<p><a href='gallery-management.php'>Go to Gallery Management</a></p>";
    echo "<p><a href='../gallery.php'>View Gallery Page</a></p>";
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>✗ Error: " . $e->getMessage() . "</h3>";
}
?>
