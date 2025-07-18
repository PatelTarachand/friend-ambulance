<?php
// Database Setup Script for Friends Ambulance Service

require_once 'config/database.php';

echo "<h2>Database Setup for Friends Ambulance Service</h2>";

try {
    // Test connection
    echo "<p>Testing database connection...</p>";
    $connection = getDBConnection();
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Create gallery table
    echo "<p>Creating gallery table...</p>";
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        image VARCHAR(500) NOT NULL,
        status TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($connection->query($sql)) {
        echo "<p style='color: green;'>✓ Gallery table created successfully!</p>";
    } else {
        throw new Exception("Error creating gallery table: " . $connection->error);
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
