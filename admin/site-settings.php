<?php
require_once 'includes/database.php';

$db = new SiteSettingsDB();
$message = '';
$error = '';

// Handle form submission
if ($_POST && isset($_POST['update_settings'])) {
    try {
        $settings = [];
        
        // Process all posted settings
        foreach ($_POST as $key => $value) {
            if ($key !== 'update_settings') {
                $settings[$key] = trim($value);
            }
        }
        
        if ($db->updateMultipleSettings($settings)) {
            $message = "Site settings updated successfully!";
        } else {
            throw new Exception('Failed to update settings');
        }
        
    } catch (Exception $e) {
        $error = 'Error updating settings: ' . $e->getMessage();
    }
}

// Get all settings grouped
$allSettings = $db->getAllSettings();
$settingGroups = [];
foreach ($allSettings as $setting) {
    $settingGroups[$setting['setting_group']][] = $setting;
}

// Get statistics
$stats = $db->getStats();

// Group labels
$groupLabels = [
    'site' => 'Site Information',
    'seo' => 'SEO Settings',
    'contact' => 'Contact Information',
    'social' => 'Social Media'
];
// Include common admin header
include 'includes/header.php';
?>
                        <?php if ($message): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['total']; ?></h3>
                                        <p class="mb-0">Total Settings</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['configured']; ?></h3>
                                        <p class="mb-0">Configured</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['required']; ?></h3>
                                        <p class="mb-0">Required</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h3><?php echo $stats['missing_required']; ?></h3>
                                        <p class="mb-0">Missing Required</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Form -->
                        <form method="POST">
                            <?php foreach ($settingGroups as $groupKey => $settings): ?>
                                <div class="setting-group">
                                    <h5 class="setting-group-header">
                                        <i class="fas fa-cog me-2"></i>
                                        <?php echo $groupLabels[$groupKey] ?? ucfirst($groupKey); ?>
                                    </h5>
                                    <div class="p-4">
                                        <div class="row">
                                            <?php foreach ($settings as $setting): ?>
                                                <div class="col-md-6 mb-3">
                                                    <label for="<?php echo $setting['setting_key']; ?>" class="form-label">
                                                        <?php echo htmlspecialchars($setting['setting_label']); ?>
                                                        <?php if ($setting['is_required']): ?>
                                                            <span class="text-danger">*</span>
                                                        <?php endif; ?>
                                                    </label>
                                                    
                                                    <?php if ($setting['setting_type'] == 'textarea'): ?>
                                                        <textarea class="form-control <?php echo $setting['is_required'] ? 'required-field' : ''; ?>" 
                                                                  id="<?php echo $setting['setting_key']; ?>"
                                                                  name="<?php echo $setting['setting_key']; ?>"
                                                                  rows="3"
                                                                  <?php echo $setting['is_required'] ? 'required' : ''; ?>><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                                                    <?php else: ?>
                                                        <input type="<?php echo $setting['setting_type']; ?>" 
                                                               class="form-control <?php echo $setting['is_required'] ? 'required-field' : ''; ?>" 
                                                               id="<?php echo $setting['setting_key']; ?>"
                                                               name="<?php echo $setting['setting_key']; ?>"
                                                               value="<?php echo htmlspecialchars($setting['setting_value']); ?>"
                                                               <?php echo $setting['is_required'] ? 'required' : ''; ?>>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($setting['setting_description']): ?>
                                                        <small class="text-muted"><?php echo htmlspecialchars($setting['setting_description']); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="text-center">
                                <button type="submit" name="update_settings" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Update All Settings
                                </button>
                                <a href="../debug-settings.php" target="_blank" class="btn btn-outline-info btn-lg ms-2">
                                    <i class="fas fa-bug me-2"></i>Debug Settings
                                </a>
                            </div>
                        </form>
                        
                        <!-- Info -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5><i class="fas fa-info-circle me-2"></i>How It Works</h5>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li><strong>Dynamic Configuration:</strong> All settings are loaded from database instead of static config.php</li>
                                    <li><strong>Real-time Updates:</strong> Changes appear immediately across the website</li>
                                    <li><strong>Grouped Settings:</strong> Organized by category for easy management</li>
                                    <li><strong>Required Fields:</strong> Red border indicates mandatory settings</li>
                                    <li><strong>Backward Compatibility:</strong> All existing code continues to work</li>
                                </ul>
                            </div>
                        </div>

<?php include 'includes/footer.php'; ?>
