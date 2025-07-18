<?php
// Admin Header - Common header for all admin pages
// This file should be included at the top of every admin page

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Get current page name for active navigation
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Page titles mapping
$page_titles = [
    'dashboard' => 'Dashboard',
    'gallery' => 'Gallery Management',
    'slider' => 'Slider Management',
    'hero-backgrounds' => 'Hero Backgrounds',
    'site-settings' => 'Site Settings',
    'database-status' => 'Database Status',
    'test-hero-backgrounds' => 'Test Hero Backgrounds'
];

$page_title = $page_titles[$current_page] ?? 'Admin Panel';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #667eea;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-color: #f093fb;
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-color: #4facfe;
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-color: #43e97b;
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-color: #fa709a;
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --border-radius: 12px;
            --shadow: 0 4px 20px rgba(0,0,0,0.1);
            --shadow-hover: 0 8px 30px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: var(--primary-gradient);
            min-height: 100vh;
            color: white;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="20" cy="80" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .sidebar .admin-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar .admin-brand h5 {
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .sidebar .admin-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            backdrop-filter: blur(10px);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-radius: 0;
            margin: 2px 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            border-radius: var(--border-radius);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }

        .sidebar .nav-divider {
            margin: 20px 20px;
            border-color: rgba(255,255,255,0.2);
        }

        .main-content {
            background: transparent;
            min-height: 100vh;
        }

        .top-navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: none;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            border-radius: 0 0 20px 20px;
            margin-bottom: 20px;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--dark-color) !important;
        }

        .user-info {
            background: var(--primary-gradient);
            color: white !important;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 500;
            box-shadow: var(--shadow);
        }

        .content-container {
            padding: 0 20px 20px 20px;
        }

        .stat-card {
            background: rgba(255,255,255,0.95);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin-bottom: 15px;
        }

        .stat-icon.primary { background: var(--primary-gradient); }
        .stat-icon.success { background: var(--success-gradient); }
        .stat-icon.warning { background: var(--warning-gradient); }
        .stat-icon.danger { background: var(--danger-gradient); }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 20px 25px;
            font-weight: 600;
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-success {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-warning {
            background: var(--warning-gradient);
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
        }

        .btn-danger {
            background: var(--danger-gradient);
            box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.8);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 16px 20px;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(67, 233, 123, 0.1), rgba(56, 249, 215, 0.1));
            color: #065f46;
            border-left: 4px solid var(--warning-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(250, 112, 154, 0.1), rgba(254, 225, 64, 0.1));
            color: #7f1d1d;
            border-left: 4px solid var(--danger-color);
        }

        .table {
            background: rgba(255,255,255,0.95);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            border-color: #f1f5f9;
        }

        .slide-card, .gallery-item, .setting-group {
            background: rgba(255,255,255,0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(20px);
        }

        .slide-card:hover, .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .hero-preview, .gallery-image {
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .hero-preview:hover, .gallery-image:hover {
            transform: scale(1.02);
        }

        .required-field {
            border-left: 4px solid var(--danger-color);
        }

        .badge {
            border-radius: 20px;
            padding: 6px 12px;
            font-weight: 500;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="admin-brand">
                        <h5>
                            <div class="brand-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            Admin Panel
                        </h5>
                    </div>

                    <nav class="nav flex-column py-3">
                        <a class="nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <a class="nav-link <?php echo $current_page === 'gallery' ? 'active' : ''; ?>" href="gallery.php">
                            <i class="fas fa-images"></i>
                            Gallery
                        </a>
                       
                        <a class="nav-link <?php echo $current_page === 'hero-backgrounds' ? 'active' : ''; ?>" href="hero-backgrounds.php">
                            <i class="fas fa-image"></i>
                            Slider Image
                        </a>
                        <a class="nav-link <?php echo $current_page === 'site-settings' ? 'active' : ''; ?>" href="site-settings.php">
                            <i class="fas fa-cog"></i>
                            Site Settings
                        </a>
                      

                        <hr class="nav-divider">

                        <a class="nav-link" href="../" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            View Website
                        </a>
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Top Navigation -->
                    <nav class="navbar navbar-expand-lg top-navbar">
                        <div class="container-fluid">
                            <span class="navbar-brand">
                                <i class="fas fa-<?php echo getPageIcon($current_page); ?> me-2"></i>
                                <?php echo $page_title; ?>
                            </span>
                            <div class="navbar-nav ms-auto">
                                <span class="nav-item user-info">
                                    <i class="fas fa-user me-2"></i>
                                    <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                                </span>
                            </div>
                        </div>
                    </nav>

                    <!-- Page Content Container -->
                    <div class="content-container">

<?php
// Helper function to get page icons
function getPageIcon($page) {
    $icons = [
        'dashboard' => 'tachometer-alt',
        'gallery' => 'images',
        'slider' => 'sliders-h',
        'hero-backgrounds' => 'image',
        'site-settings' => 'cog',
        'database-status' => 'database'
    ];
    return $icons[$page] ?? 'file-alt';
}
?>
