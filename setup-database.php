<?php
// Setup Database for Contact Form
echo "<h1>Database Setup for Contact Form</h1>";

try {
    // Step 1: Connect to MySQL
    echo "<h2>Step 1: Connecting to MySQL</h2>";
    $conn = new mysqli('localhost', 'root', '', 'friendsdb');
    
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    echo "✅ Connected to MySQL successfully<br>";
    
    // Step 2: Create table if not exists
    echo "<h2>Step 2: Creating contact_submissions table</h2>";
    $createTable = "CREATE TABLE IF NOT EXISTS contact_submissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20),
        subject VARCHAR(200),
        message TEXT NOT NULL,
        ip_address VARCHAR(45),
        user_agent TEXT,
        status ENUM('new', 'read', 'replied') DEFAULT 'new',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($createTable)) {
        echo "✅ Table 'contact_submissions' created/verified<br>";
    } else {
        throw new Exception('Failed to create table: ' . $conn->error);
    }
    
    // Step 3: Test insert
    echo "<h2>Step 3: Testing data insertion</h2>";
    $testName = 'Test User';
    $testEmail = 'test@example.com';
    $testMessage = 'This is a test message';
    
    $sql = "INSERT INTO contact_submissions (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $testName, $testEmail, $testMessage);
    
    if ($stmt->execute()) {
        $insertId = $conn->insert_id;
        echo "✅ Test data inserted successfully! ID: $insertId<br>";
    } else {
        throw new Exception('Failed to insert test data: ' . $stmt->error);
    }
    
    // Step 4: Show existing data
    echo "<h2>Step 4: Current data in table</h2>";
    $result = $conn->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Subject</th><th>Message</th><th>Created</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
            echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($row['message'], 0, 50)) . "...</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found in table.<br>";
    }
    
    $conn->close();
    
    echo "<h2>✅ Database Setup Complete!</h2>";
    echo "<p><strong>Next step:</strong> Test the contact form</p>";
    
} catch (Exception $e) {
    echo "<h2>❌ Error</h2>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Contact Form Process Explanation</h2>";
echo "<ol>";
echo "<li><strong>User fills form</strong> → Name, Email, Message</li>";
echo "<li><strong>Form submits via POST</strong> → contact.php processes it</li>";
echo "<li><strong>PHP validates data</strong> → Check required fields</li>";
echo "<li><strong>PHP connects to database</strong> → friendsdb.contact_submissions</li>";
echo "<li><strong>PHP inserts data</strong> → INSERT INTO contact_submissions</li>";
echo "<li><strong>Success message shown</strong> → User sees confirmation</li>";
echo "</ol>";

echo "<p><a href='contact.php' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Test Contact Form</a></p>";
?>
