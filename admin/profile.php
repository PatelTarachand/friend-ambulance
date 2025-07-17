<?php
require_once 'includes/header.php';

$message = '';
$error = '';

// Handle form submissions
if ($_POST) {
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!AdminAuth::verifyCSRFToken($csrf_token)) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'update_profile') {
            $full_name = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            if (empty($full_name) || empty($email)) {
                $error = 'Full name and email are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                // Check if email is already taken by another user
                $existingUser = getSingleRecord(
                    "SELECT id FROM admin_users WHERE email = ? AND id != ?",
                    [$email, $_SESSION['admin_user_id']]
                );
                
                if ($existingUser) {
                    $error = 'This email address is already in use.';
                } else {
                    if (AdminAuth::updateProfile($_SESSION['admin_user_id'], $full_name, $email)) {
                        $message = 'Profile updated successfully!';
                    } else {
                        $error = 'Failed to update profile. Please try again.';
                    }
                }
            }
        } elseif ($action === 'change_password') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $error = 'All password fields are required.';
            } elseif ($new_password !== $confirm_password) {
                $error = 'New passwords do not match.';
            } elseif (strlen($new_password) < 6) {
                $error = 'New password must be at least 6 characters long.';
            } else {
                if (AdminAuth::changePassword($_SESSION['admin_user_id'], $current_password, $new_password)) {
                    $message = 'Password changed successfully!';
                } else {
                    $error = 'Current password is incorrect.';
                }
            }
        }
    }
}

// Get current user data
$currentUser = AdminAuth::getCurrentUser();
?>

<?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card">
            <div class="card-body text-center">
                <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    <?php echo strtoupper(substr($currentUser['full_name'], 0, 1)); ?>
                </div>
                <h5 class="mb-1"><?php echo htmlspecialchars($currentUser['full_name']); ?></h5>
                <p class="text-muted mb-2"><?php echo htmlspecialchars($currentUser['email']); ?></p>
                <span class="badge bg-primary"><?php echo ucfirst($currentUser['role']); ?></span>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <h6 class="mb-0">Last Login</h6>
                        <small class="text-muted">
                            <?php echo $currentUser['last_login'] ? date('M j, Y', strtotime($currentUser['last_login'])) : 'Never'; ?>
                        </small>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-0">Member Since</h6>
                        <small class="text-muted">
                            <?php echo date('M Y', strtotime($currentUser['created_at'] ?? 'now')); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Your Activity</h6>
            </div>
            <div class="card-body">
                <?php
                $userSliders = getSingleRecord("SELECT COUNT(*) as count FROM slider_images WHERE created_by = ?", [$currentUser['id']])['count'];
                $userGallery = getSingleRecord("SELECT COUNT(*) as count FROM gallery_images WHERE created_by = ?", [$currentUser['id']])['count'];
                ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Slider Images</span>
                    <span class="badge bg-primary"><?php echo $userSliders; ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Gallery Images</span>
                    <span class="badge bg-success"><?php echo $userGallery; ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Update Profile -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Update Profile</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo AdminAuth::generateCSRFToken(); ?>">
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?php echo htmlspecialchars($currentUser['full_name']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" 
                                       value="<?php echo htmlspecialchars($currentUser['username']); ?>" readonly>
                                <small class="text-muted">Username cannot be changed</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role" 
                                       value="<?php echo ucfirst($currentUser['role']); ?>" readonly>
                                <small class="text-muted">Role is managed by system administrator</small>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Change Password -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo AdminAuth::generateCSRFToken(); ?>">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password *</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" 
                                       minlength="6" required>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password *</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                       minlength="6" required>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-2"></i>Change Password
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Account Security -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Account Security</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Security Tips</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Use a strong password</li>
                            <li><i class="fas fa-check text-success me-2"></i>Don't share your login credentials</li>
                            <li><i class="fas fa-check text-success me-2"></i>Log out when finished</li>
                            <li><i class="fas fa-check text-success me-2"></i>Keep your browser updated</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Session Information</h6>
                        <p><strong>IP Address:</strong> <?php echo $_SERVER['REMOTE_ADDR'] ?? 'Unknown'; ?></p>
                        <p><strong>Browser:</strong> <?php echo substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 50) . '...'; ?></p>
                        <p><strong>Login Time:</strong> <?php echo date('M j, Y g:i A'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('new_password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
