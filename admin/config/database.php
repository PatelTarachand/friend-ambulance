<?php
// Database Configuration for Friends Ambulance Service

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'friendsdb');

// Create database connection
function getDBConnection() {
    try {
        $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);
        
        // Check connection
        if ($connection->connect_error) {
            throw new Exception("Connection failed: " . $connection->connect_error);
        }
        
        // Create database if not exists
        $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        if (!$connection->query($sql)) {
            throw new Exception("Error creating database: " . $connection->error);
        }
        
        // Select database
        $connection->select_db(DB_NAME);
        
        return $connection;
        
    } catch (Exception $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Test database connection
function testDBConnection() {
    try {
        $connection = getDBConnection();
        $connection->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
