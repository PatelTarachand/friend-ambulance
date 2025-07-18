<?php
// MySQL Database for Gallery CRUD

// Include database configuration
require_once __DIR__ . '/../config/database.php';

class GalleryDB {
    private $connection;

    public function __construct() {
        $this->initDatabase();
    }

    // Initialize database connection and create table
    private function initDatabase() {
        try {
            // Get connection from config
            $this->connection = getDBConnection();

            // Create gallery table if not exists
            $this->createTable();

        } catch (Exception $e) {
            die("Database initialization failed: " . $e->getMessage());
        }
    }

    // Create gallery and slider tables
    private function createTable() {
        // Gallery table
        $sql = "CREATE TABLE IF NOT EXISTS gallery (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            image VARCHAR(500) NOT NULL,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (!$this->connection->query($sql)) {
            throw new Exception("Error creating gallery table: " . $this->connection->error);
        }

        // Slider table
        $sql = "CREATE TABLE IF NOT EXISTS slider (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            subtitle TEXT,
            image VARCHAR(500) NOT NULL,
            button_text VARCHAR(100),
            button_link VARCHAR(500),
            sort_order INT DEFAULT 0,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (!$this->connection->query($sql)) {
            throw new Exception("Error creating slider table: " . $this->connection->error);
        }

        // Hero backgrounds table for home page
        $sql = "CREATE TABLE IF NOT EXISTS hero_backgrounds (
            id INT AUTO_INCREMENT PRIMARY KEY,
            slide_number INT NOT NULL UNIQUE,
            background_image VARCHAR(500),
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (!$this->connection->query($sql)) {
            throw new Exception("Error creating hero_backgrounds table: " . $this->connection->error);
        }

        // Insert default records for 4 slides if not exists
        for ($i = 1; $i <= 4; $i++) {
            $checkSql = "SELECT id FROM hero_backgrounds WHERE slide_number = ?";
            $checkStmt = $this->connection->prepare($checkSql);
            $checkStmt->bind_param("i", $i);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows == 0) {
                $insertSql = "INSERT INTO hero_backgrounds (slide_number, background_image, status) VALUES (?, NULL, 1)";
                $insertStmt = $this->connection->prepare($insertSql);
                $insertStmt->bind_param("i", $i);
                $insertStmt->execute();
            }
        }

        // Site settings table
        $sql = "CREATE TABLE IF NOT EXISTS site_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) NOT NULL UNIQUE,
            setting_value TEXT,
            setting_type ENUM('text', 'textarea', 'email', 'phone', 'url') DEFAULT 'text',
            setting_group VARCHAR(50) DEFAULT 'general',
            setting_label VARCHAR(255),
            setting_description TEXT,
            is_required TINYINT(1) DEFAULT 0,
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (!$this->connection->query($sql)) {
            throw new Exception("Error creating site_settings table: " . $this->connection->error);
        }

        // Insert default settings if not exists
        $defaultSettings = [
            // Site Information
            ['site_name', 'Friends Ambulance Service', 'text', 'site', 'Site Name', 'The name of your website', 1, 1],
            ['site_tagline', 'Raipur\'s Most Trusted Ambulance Service - 21+ Years', 'text', 'site', 'Site Tagline', 'Brief description or tagline', 1, 2],
            ['site_url', 'http://localhost/protc/Friend', 'url', 'site', 'Site URL', 'Full URL of your website', 1, 3],
            ['meta_keywords', 'ambulance service raipur, emergency ambulance, BLS ambulance, ALS ambulance, 24x7 ambulance, chhattisgarh ambulance', 'textarea', 'seo', 'Meta Keywords', 'SEO keywords for search engines', 0, 4],

            // Contact Information
            ['phone_primary', '93299 62163', 'phone', 'contact', 'Primary Phone', 'Main contact phone number', 1, 5],
            ['phone_secondary', '9893462863', 'phone', 'contact', 'Secondary Phone', 'Alternative phone number', 0, 6],
            ['phone_tertiary', '7869165263', 'phone', 'contact', 'Tertiary Phone', 'Third phone number', 0, 7],
            ['email', 'info@friendsambulance.com', 'email', 'contact', 'Email Address', 'Primary email address', 1, 8],
            ['whatsapp', '919329962163', 'phone', 'contact', 'WhatsApp Number', 'WhatsApp contact number', 1, 9],
            ['address', 'Ramkrishna care hospital, near by Ramkrishna care hospital, Pachpedi Naka, Raipur, Tikrapara, Chhattisgarh 492001', 'textarea', 'contact', 'Address', 'Complete business address', 1, 10],

            // Social Media
            ['facebook', '#', 'url', 'social', 'Facebook URL', 'Facebook page URL', 0, 11],
            ['twitter', '#', 'url', 'social', 'Twitter URL', 'Twitter profile URL', 0, 12],
            ['instagram', '#', 'url', 'social', 'Instagram URL', 'Instagram profile URL', 0, 13]
        ];

        foreach ($defaultSettings as $setting) {
            $checkSql = "SELECT id FROM site_settings WHERE setting_key = ?";
            $checkStmt = $this->connection->prepare($checkSql);
            $checkStmt->bind_param("s", $setting[0]);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows == 0) {
                $insertSql = "INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_group, setting_label, setting_description, is_required, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $this->connection->prepare($insertSql);
                $insertStmt->bind_param("ssssssii", $setting[0], $setting[1], $setting[2], $setting[3], $setting[4], $setting[5], $setting[6], $setting[7]);
                $insertStmt->execute();
            }
        }
    }

    // Get all gallery items
    public function getAll() {
        $sql = "SELECT * FROM gallery ORDER BY created_at DESC";
        $result = $this->connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get gallery item by ID
    public function getById($id) {
        $sql = "SELECT * FROM gallery WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Create new gallery item
    public function create($name, $image, $status = 1) {
        $sql = "INSERT INTO gallery (name, image, status) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssi", $name, $image, $status);

        if ($stmt->execute()) {
            return $this->connection->insert_id;
        }
        return false;
    }

    // Update gallery item
    public function update($id, $name, $image = null, $status = 1) {
        if ($image !== null) {
            // Update with new image
            $sql = "UPDATE gallery SET name = ?, image = ?, status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ssii", $name, $image, $status, $id);
        } else {
            // Update without changing image
            $sql = "UPDATE gallery SET name = ?, status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sii", $name, $status, $id);
        }

        return $stmt->execute();
    }

    // Delete gallery item
    public function delete($id) {
        // Get item to delete image file
        $item = $this->getById($id);

        if ($item) {
            // Delete image file if exists
            $imagePath = '../' . $item['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete from database
            $sql = "DELETE FROM gallery WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);

            return $stmt->execute();
        }
        return false;
    }

    // Get active gallery items
    public function getActive() {
        $sql = "SELECT * FROM gallery WHERE status = 1 ORDER BY created_at DESC";
        $result = $this->connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Toggle status
    public function toggleStatus($id) {
        // Get current status
        $item = $this->getById($id);
        if ($item) {
            $newStatus = $item['status'] == 1 ? 0 : 1;

            $sql = "UPDATE gallery SET status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ii", $newStatus, $id);

            if ($stmt->execute()) {
                return $newStatus;
            }
        }
        return false;
    }

    // Get statistics
    public function getStats() {
        $sql = "SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active,
                    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive
                FROM gallery";

        $result = $this->connection->query($sql);
        if ($result) {
            return $result->fetch_assoc();
        }

        return ['total' => 0, 'active' => 0, 'inactive' => 0];
    }

    // Close database connection
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Slider Database Class
class SliderDB {
    private $connection;

    public function __construct() {
        $this->initDatabase();
    }

    // Initialize database connection
    private function initDatabase() {
        try {
            // Get connection from config
            $this->connection = getDBConnection();
        } catch (Exception $e) {
            die("Slider database initialization failed: " . $e->getMessage());
        }
    }

    // Get all slider items
    public function getAll() {
        $sql = "SELECT * FROM slider ORDER BY sort_order ASC, created_at DESC";
        $result = $this->connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get active slider items
    public function getActive() {
        $sql = "SELECT * FROM slider WHERE status = 1 ORDER BY sort_order ASC, created_at DESC";
        $result = $this->connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get slider item by ID
    public function getById($id) {
        $sql = "SELECT * FROM slider WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Create new slider item
    public function create($title, $subtitle, $image, $buttonText = '', $buttonLink = '', $sortOrder = 0, $status = 1) {
        $sql = "INSERT INTO slider (title, subtitle, image, button_text, button_link, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssiii", $title, $subtitle, $image, $buttonText, $buttonLink, $sortOrder, $status);

        if ($stmt->execute()) {
            return $this->connection->insert_id;
        }
        return false;
    }

    // Update slider item
    public function update($id, $title, $subtitle, $image = null, $buttonText = '', $buttonLink = '', $sortOrder = 0, $status = 1) {
        if ($image !== null) {
            // Update with new image
            $sql = "UPDATE slider SET title = ?, subtitle = ?, image = ?, button_text = ?, button_link = ?, sort_order = ?, status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ssssiiis", $title, $subtitle, $image, $buttonText, $buttonLink, $sortOrder, $status, $id);
        } else {
            // Update without changing image
            $sql = "UPDATE slider SET title = ?, subtitle = ?, button_text = ?, button_link = ?, sort_order = ?, status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sssiiis", $title, $subtitle, $buttonText, $buttonLink, $sortOrder, $status, $id);
        }

        return $stmt->execute();
    }

    // Delete slider item
    public function delete($id) {
        // Get item to delete image file
        $item = $this->getById($id);

        if ($item) {
            // Delete image file if exists
            $imagePath = '../' . $item['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete from database
            $sql = "DELETE FROM slider WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);

            return $stmt->execute();
        }
        return false;
    }

    // Toggle status
    public function toggleStatus($id) {
        // Get current status
        $item = $this->getById($id);
        if ($item) {
            $newStatus = $item['status'] == 1 ? 0 : 1;

            $sql = "UPDATE slider SET status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ii", $newStatus, $id);

            if ($stmt->execute()) {
                return $newStatus;
            }
        }
        return false;
    }

    // Get statistics
    public function getStats() {
        $sql = "SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active,
                    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive
                FROM slider";

        $result = $this->connection->query($sql);
        if ($result) {
            return $result->fetch_assoc();
        }

        return ['total' => 0, 'active' => 0, 'inactive' => 0];
    }

    // Close database connection
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Hero Background Database Class
class HeroBackgroundDB {
    private $connection;

    public function __construct() {
        $this->initDatabase();
    }

    // Initialize database connection
    private function initDatabase() {
        try {
            // Get connection from config
            $this->connection = getDBConnection();
        } catch (Exception $e) {
            die("Hero background database initialization failed: " . $e->getMessage());
        }
    }

    // Get all hero backgrounds
    public function getAll() {
        $sql = "SELECT * FROM hero_backgrounds ORDER BY slide_number ASC";
        $result = $this->connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get hero background by slide number
    public function getBySlideNumber($slideNumber) {
        $sql = "SELECT * FROM hero_backgrounds WHERE slide_number = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $slideNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Update hero background image
    public function updateBackground($slideNumber, $backgroundImage) {
        $sql = "UPDATE hero_backgrounds SET background_image = ? WHERE slide_number = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("si", $backgroundImage, $slideNumber);

        return $stmt->execute();
    }

    // Remove background image (set to NULL)
    public function removeBackground($slideNumber) {
        // Get current background to delete file
        $current = $this->getBySlideNumber($slideNumber);
        if ($current && $current['background_image']) {
            $imagePath = '../' . $current['background_image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $sql = "UPDATE hero_backgrounds SET background_image = NULL WHERE slide_number = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $slideNumber);

        return $stmt->execute();
    }

    // Get statistics
    public function getStats() {
        $sql = "SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN background_image IS NOT NULL THEN 1 ELSE 0 END) as with_image,
                    SUM(CASE WHEN background_image IS NULL THEN 1 ELSE 0 END) as without_image
                FROM hero_backgrounds";

        $result = $this->connection->query($sql);
        if ($result) {
            return $result->fetch_assoc();
        }

        return ['total' => 0, 'with_image' => 0, 'without_image' => 0];
    }

    // Close database connection
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Site Settings Database Class
class SiteSettingsDB {
    private $connection;

    public function __construct() {
        $this->initDatabase();
    }

    // Initialize database connection
    private function initDatabase() {
        try {
            // Get connection from config
            $this->connection = getDBConnection();
        } catch (Exception $e) {
            die("Site settings database initialization failed: " . $e->getMessage());
        }
    }

    // Get all settings
    public function getAllSettings() {
        $sql = "SELECT * FROM site_settings ORDER BY setting_group, display_order";
        $result = $this->connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get settings by group
    public function getSettingsByGroup($group) {
        $sql = "SELECT * FROM site_settings WHERE setting_group = ? ORDER BY display_order";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $group);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get single setting value
    public function getSetting($key) {
        $sql = "SELECT setting_value FROM site_settings WHERE setting_key = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['setting_value'];
        }
        return null;
    }

    // Get settings as associative array (for config replacement)
    public function getSettingsArray() {
        $sql = "SELECT setting_key, setting_value FROM site_settings";
        $result = $this->connection->query($sql);

        $settings = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[strtoupper($row['setting_key'])] = $row['setting_value'];
            }
        }
        return $settings;
    }

    // Update setting value
    public function updateSetting($key, $value) {
        $sql = "UPDATE site_settings SET setting_value = ? WHERE setting_key = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $value, $key);

        return $stmt->execute();
    }

    // Update multiple settings
    public function updateMultipleSettings($settings) {
        $this->connection->begin_transaction();

        try {
            $sql = "UPDATE site_settings SET setting_value = ? WHERE setting_key = ?";
            $stmt = $this->connection->prepare($sql);

            foreach ($settings as $key => $value) {
                $stmt->bind_param("ss", $value, $key);
                $stmt->execute();
            }

            $this->connection->commit();
            return true;

        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    // Get statistics
    public function getStats() {
        $sql = "SELECT
                    COUNT(*) as total,
                    COUNT(CASE WHEN setting_value IS NOT NULL AND setting_value != '' THEN 1 END) as configured,
                    COUNT(CASE WHEN is_required = 1 THEN 1 END) as required,
                    COUNT(CASE WHEN is_required = 1 AND (setting_value IS NULL OR setting_value = '') THEN 1 END) as missing_required
                FROM site_settings";

        $result = $this->connection->query($sql);
        if ($result) {
            return $result->fetch_assoc();
        }

        return ['total' => 0, 'configured' => 0, 'required' => 0, 'missing_required' => 0];
    }

    // Close database connection
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
