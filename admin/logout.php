<?php
require_once 'includes/auth.php';

// Logout user
AdminAuth::logout();

// Clear any output buffer to prevent header issues
if (ob_get_level()) {
    ob_end_clean();
}

// Redirect to login page
header('Location: index.php');
exit;
?>
