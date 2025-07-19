<?php
require_once 'includes/database.php';

$db = new SiteSettingsDB();
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    try {
        $settings = [];

        // Process all posted settings
        foreach ($_POST as $key => $value) {
            if ($key !== 'update_settings') {
                $settings[$key] = is_array($value) ? $value : trim($value);
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

<!-- Custom CSS for better tab visibility -->
<style>
    .nav-tabs .nav-link {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
        margin-right: 2px;
        border-radius: 0.375rem 0.375rem 0 0;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6 #dee2e6 #fff;
        color: #0d6efd;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
        color: #0d6efd;
        font-weight: 600;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 0;
    }

    .tab-content {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
        padding: 1.5rem;
    }

    .card-header-tabs {
        margin-bottom: -1px;
    }

    .required-field {
        border-color: #dc3545;
    }

    .setting-group-icon {
        width: 20px;
        text-align: center;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="main-content-inner">

                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <h2>
                                <i class="fas fa-cog me-2 text-primary"></i>
                                Site Settings
                            </h2>
                            <p class="text-muted">Configure your website settings</p>
                        </div>
                        <div class="col-lg-4 text-end">
                            <a href="../debug-settings.php" target="_blank" class="btn btn-outline-info">
                                <i class="fas fa-bug me-2"></i>Debug Settings
                            </a>
                        </div>
                    </div>

                    <!-- Messages -->
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
                        
                    <!-- Settings Tabs -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                                <?php
                                $first = true;
                                $tabIcons = [
                                    'site' => 'globe',
                                    'seo' => 'search',
                                    'contact' => 'envelope',
                                    'social' => 'share-alt'
                                ];
                                foreach ($settingGroups as $groupKey => $settings):
                                ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo $first ? 'active' : ''; ?>"
                                                id="<?php echo $groupKey; ?>-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#<?php echo $groupKey; ?>-pane"
                                                type="button" role="tab"
                                                aria-controls="<?php echo $groupKey; ?>-pane"
                                                aria-selected="<?php echo $first ? 'true' : 'false'; ?>">
                                            <i class="fas fa-<?php echo $tabIcons[$groupKey] ?? 'cog'; ?> setting-group-icon me-2"></i>
                                            <span><?php echo $groupLabels[$groupKey] ?? ucfirst($groupKey); ?></span>
                                        </button>
                                    </li>
                                <?php $first = false; endforeach; ?>
                            </ul>
                        </div>

                        <div class="card-body p-0">
                            <form method="POST">
                                <div class="tab-content" id="settingsTabContent">
                                    <?php $first = true; foreach ($settingGroups as $groupKey => $settings): ?>
                                        <div class="tab-pane fade <?php echo $first ? 'show active' : ''; ?>"
                                             id="<?php echo $groupKey; ?>-pane"
                                             role="tabpanel"
                                             aria-labelledby="<?php echo $groupKey; ?>-tab">

                                            <div class="p-4">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-<?php echo $tabIcons[$groupKey] ?? 'cog'; ?> me-2 text-primary"></i>
                                                    <?php echo $groupLabels[$groupKey] ?? ucfirst($groupKey); ?> Settings
                                                </h5>

                                                <div class="row">
                                                    <?php foreach ($settings as $setting): ?>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="<?php echo $setting['setting_key']; ?>" class="form-label fw-semibold">
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
                                                                          placeholder="Enter <?php echo strtolower($setting['setting_label']); ?>..."
                                                                          <?php echo $setting['is_required'] ? 'required' : ''; ?>><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                                                            <?php else: ?>
                                                                <input type="<?php echo $setting['setting_type']; ?>"
                                                                       class="form-control <?php echo $setting['is_required'] ? 'required-field' : ''; ?>"
                                                                       id="<?php echo $setting['setting_key']; ?>"
                                                                       name="<?php echo $setting['setting_key']; ?>"
                                                                       value="<?php echo htmlspecialchars($setting['setting_value']); ?>"
                                                                       placeholder="Enter <?php echo strtolower($setting['setting_label']); ?>..."
                                                                       <?php echo $setting['is_required'] ? 'required' : ''; ?>>
                                                            <?php endif; ?>

                                                            <?php if ($setting['setting_description']): ?>
                                                                <small class="form-text text-muted">
                                                                    <i class="fas fa-info-circle me-1"></i>
                                                                    <?php echo htmlspecialchars($setting['setting_description']); ?>
                                                                </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $first = false; endforeach; ?>
                                </div>

                                <div class="bg-light p-4 border-top">
                                    <div class="text-center">
                                        <input type="submit" name="update_settings" value="💾 Update All Settings" class="btn btn-primary btn-lg me-3" />
                                        <a href="dashboard.php" class="btn btn-outline-secondary btn-lg">
                                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                        </a>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Changes will be applied immediately across the website
                                        </small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Information Card -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>Settings Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-cogs me-2"></i>How It Works</h6>
                                    <ul class="mb-3">
                                        <li><strong>Dynamic Configuration:</strong> Settings loaded from database</li>
                                        <li><strong>Real-time Updates:</strong> Changes appear immediately</li>
                                        <li><strong>Organized Tabs:</strong> Settings grouped by category</li>
                                        <li><strong>Required Fields:</strong> Marked with red asterisk (*)</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notes</h6>
                                    <ul class="mb-0">
                                        <li><strong>Backup:</strong> Always backup before major changes</li>
                                        <li><strong>Testing:</strong> Test changes on staging first</li>
                                        <li><strong>SEO Impact:</strong> Some changes affect search rankings</li>
                                        <li><strong>Cache:</strong> Clear cache after updates if needed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
