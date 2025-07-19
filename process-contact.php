<?php
// Process Contact Form Submission
session_start();
require_once 'admin/includes/database.php';

// Set JSON response header
header('Content-Type: application/json');

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'errors' => [],
    'debug' => []
];

try {
    // Debug information
    $response['debug']['request_method'] = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
    $response['debug']['post_data'] = $_POST;
    $response['debug']['content_type'] = $_SERVER['CONTENT_TYPE'] ?? 'UNKNOWN';

    // Check if form was submitted via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['debug']['error'] = 'Request method is: ' . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN');
        throw new Exception('Invalid request method: ' . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN'));
    }
    
    // Get and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validation
    $errors = [];
    
    // Required fields validation
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters';
    } elseif (strlen($name) > 100) {
        $errors['name'] = 'Name must be less than 100 characters';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Message must be at least 10 characters';
    } elseif (strlen($message) > 2000) {
        $errors['message'] = 'Message must be less than 2000 characters';
    }
    
    // Optional fields validation
    if (!empty($phone)) {
        // Basic phone validation - allow various formats
        $phone_clean = preg_replace('/[^\d+\-\s\(\)]/', '', $phone);
        if (strlen($phone_clean) < 12) {
            $errors['phone'] = 'Please enter a valid phone number';
        }
    }
    
    if (!empty($subject) && strlen($subject) > 200) {
        $errors['subject'] = 'Subject must be less than 200 characters';
    }
    
    // Check for spam (simple honeypot and rate limiting)
    if (isset($_POST['website']) && !empty($_POST['website'])) {
        // Honeypot field filled - likely spam
        throw new Exception('Spam detected');
    }
    
    // Rate limiting - check if same IP submitted recently
    if (isset($_SESSION['last_contact_submission'])) {
        $time_diff = time() - $_SESSION['last_contact_submission'];
        if ($time_diff < 60) { // 1 minute cooldown
            $errors['general'] = 'Please wait before submitting another message';
        }
    }
    
    // If there are validation errors, return them
    if (!empty($errors)) {
        $response['errors'] = $errors;
        $response['message'] = 'Please correct the errors below';
        echo json_encode($response);
        exit;
    }
    
    // Prepare data for database
    $formData = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message
    ];
    
    // Save to database
    $contactDB = new ContactFormDB();
    $submissionId = $contactDB->submitForm($formData);
    
    if ($submissionId) {
        // Success - set session to prevent rapid resubmission
        $_SESSION['last_contact_submission'] = time();
        
        $response['success'] = true;
        $response['message'] = 'Thank you for your message! We will get back to you soon.';
        $response['submission_id'] = $submissionId;
        
        // Optional: Send email notification to admin
        // You can implement email notification here if needed
        
    } else {
        throw new Exception('Failed to save your message. Please try again.');
    }
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    // Log error for debugging
    error_log("Contact form error: " . $e->getMessage());
}

// Return JSON response
echo json_encode($response);
exit;
?>
