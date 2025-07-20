<?php
// Database Setup Script for Friends Ambulance Service

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Setup - Friends Ambulance</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    <style>
        body { background: #f8f9fa; padding: 20px; }
        .setup-card { max-width: 800px; margin: 0 auto; }
        .status-success { color: #28a745; }
        .status-error { color: #dc3545; }
        .status-info { color: #17a2b8; }
    </style>
</head>
<body>
<div class='container'>
    <div class='setup-card'>
        <div class='card'>
            <div class='card-header bg-primary text-white'>
                <h3><i class='fas fa-database me-2'></i>Database Setup - Friends Ambulance Service</h3>
            </div>
            <div class='card-body'>";

try {
    // Test connection
    echo "<p class='status-info'><i class='fas fa-spinner fa-spin me-2'></i>Testing database connection...</p>";
    $connection = getDBConnection();
    echo "<p class='status-success'><i class='fas fa-check-circle me-2'></i>Database connection successful!</p>";

    // Create gallery table
    echo "<p class='status-info'><i class='fas fa-spinner fa-spin me-2'></i>Creating gallery table...</p>";
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        image_path VARCHAR(500) NOT NULL,
        alt_text VARCHAR(255),
        category VARCHAR(100) DEFAULT 'general',
        display_order INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        is_featured BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($connection->query($sql)) {
        echo "<p class='status-success'><i class='fas fa-check-circle me-2'></i>Gallery table created successfully!</p>";
    } else {
        throw new Exception("Error creating gallery table: " . $connection->error);
    }

    // Create admin users table
    echo "<p class='status-info'><i class='fas fa-spinner fa-spin me-2'></i>Creating admin users table...</p>";
    $adminSQL = "CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255),
        full_name VARCHAR(255),
        role ENUM('admin', 'moderator') DEFAULT 'admin',
        is_active BOOLEAN DEFAULT TRUE,
        last_login TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($connection->query($adminSQL)) {
        echo "<p class='status-success'><i class='fas fa-check-circle me-2'></i>Admin Users table created successfully!</p>";

        // Insert default admin user if not exists
        $checkAdmin = $connection->query("SELECT id FROM admin_users WHERE username = 'admin'");
        if ($checkAdmin->num_rows == 0) {
            $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $insertAdmin = $connection->prepare("INSERT INTO admin_users (username, password, email, full_name, role) VALUES (?, ?, ?, ?, ?)");
            $username = 'admin';
            $email = 'admin@friendsambulance.com';
            $fullName = 'System Administrator';
            $role = 'admin';
            $insertAdmin->bind_param("sssss", $username, $defaultPassword, $email, $fullName, $role);

            if ($insertAdmin->execute()) {
                echo "<p class='status-success'><i class='fas fa-user-plus me-2'></i>Default admin user created (admin/admin123)</p>";
            } else {
                echo "<p class='status-error'><i class='fas fa-exclamation-triangle me-2'></i>Could not create default admin user: " . $connection->error . "</p>";
            }
        } else {
            echo "<p class='status-info'><i class='fas fa-info-circle me-2'></i>Admin user already exists</p>";
        }
    } else {
        throw new Exception("Error creating admin_users table: " . $connection->error);
    }

    // Create slider table
    echo "<p>Creating slider table...</p>";
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

    if ($connection->query($sql)) {
        echo "<p style='color: green;'>✓ Slider table created successfully!</p>";
    } else {
        throw new Exception("Error creating slider table: " . $connection->error);
    }
    
    // Check if table exists and show structure
    $result = $connection->query("DESCRIBE gallery");
    if ($result) {
        echo "<h3>Gallery Table Structure:</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Show current data count
    $countResult = $connection->query("SELECT COUNT(*) as count FROM gallery");
    if ($countResult) {
        $count = $countResult->fetch_assoc()['count'];
        echo "<p><strong>Current gallery items:</strong> " . $count . "</p>";
    }
    
    echo "<h3>Database Setup Complete!</h3>";
    echo "<p style='color: green;'>Your database is ready to use.</p>";
    echo "<p><a href='gallery.php'>Go to Gallery Management</a> | <a href='dashboard.php'>Go to Dashboard</a></p>";
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<h3>Setup Failed!</h3>";
    echo "<p>Please check your database configuration and try again.</p>";
}

echo "<hr>";
echo "<h3>Database Configuration:</h3>";
echo "<ul>";
echo "<li><strong>Host:</strong> " . DB_HOST . "</li>";
echo "<li><strong>Database:</strong> " . DB_NAME . "</li>";
echo "<li><strong>Username:</strong> " . DB_USERNAME . "</li>";
echo "</ul>";

echo "<h3>Requirements:</h3>";
echo "<ul>";
echo "<li>MySQL server running</li>";
echo "<li>Database user with CREATE privileges</li>";
echo "<li>PHP mysqli extension enabled</li>";
echo "</ul>";
?>
