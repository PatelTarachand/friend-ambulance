<?php
require_once 'includes/auth.php';

// Logout user
AdminAuth::logout();

// Redirect to login page
header('Location: login.php');
exit;
?>
