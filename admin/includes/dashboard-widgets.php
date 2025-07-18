<?php
// Dashboard Widgets - Modern UI Components for Admin Dashboard

// Quick Stats Widget
function renderQuickStatsWidget($stats) {
    $widgets = [
        [
            'title' => 'Gallery Items',
            'value' => $stats['gallery']['total'] ?? 0,
            'icon' => 'images',
            'color' => 'primary',
            'change' => '+' . ($stats['gallery']['active'] ?? 0) . ' active',
            'link' => 'gallery.php'
        ],
        [
            'title' => 'Slider Items',
            'value' => $stats['slider']['total'] ?? 0,
            'icon' => 'sliders-h',
            'color' => 'success',
            'change' => '+' . ($stats['slider']['active'] ?? 0) . ' active',
            'link' => 'slider.php'
        ],
        [
            'title' => 'Hero Backgrounds',
            'value' => '4',
            'icon' => 'image',
            'color' => 'warning',
            'change' => 'Customizable',
            'link' => 'hero-backgrounds.php'
        ],
        [
            'title' => 'Site Settings',
            'value' => $stats['settings']['configured'] ?? 0,
            'icon' => 'cog',
            'color' => 'danger',
            'change' => 'Configured',
            'link' => 'site-settings.php'
        ]
    ];

    echo '<div class="row mb-4">';
    foreach ($widgets as $widget) {
        echo '<div class="col-xl-3 col-md-6 mb-4">';
        echo '<div class="stat-card h-100">';
        echo '<div class="d-flex align-items-center">';
        echo '<div class="stat-icon ' . $widget['color'] . ' me-3">';
        echo '<i class="fas fa-' . $widget['icon'] . '"></i>';
        echo '</div>';
        echo '<div class="flex-grow-1">';
        echo '<div class="text-muted small text-uppercase fw-bold">' . $widget['title'] . '</div>';
        echo '<div class="h3 mb-0 fw-bold">' . $widget['value'] . '</div>';
        echo '<div class="text-muted small">' . $widget['change'] . '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="mt-3">';
        echo '<a href="' . $widget['link'] . '" class="btn btn-sm btn-outline-primary">Manage <i class="fas fa-arrow-right ms-1"></i></a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

// Recent Activity Widget
function renderRecentActivityWidget() {
    $activities = [
        [
            'icon' => 'plus-circle',
            'color' => 'success',
            'title' => 'New gallery item added',
            'time' => '2 hours ago',
            'description' => 'Ambulance fleet image uploaded'
        ],
        [
            'icon' => 'edit',
            'color' => 'primary',
            'title' => 'Site settings updated',
            'time' => '5 hours ago',
            'description' => 'Contact information modified'
        ],
        [
            'icon' => 'image',
            'color' => 'warning',
            'title' => 'Hero background changed',
            'time' => '1 day ago',
            'description' => 'Slide 2 background updated'
        ],
        [
            'icon' => 'sliders-h',
            'color' => 'info',
            'title' => 'Slider content modified',
            'time' => '2 days ago',
            'description' => 'Emergency services slider updated'
        ]
    ];

    echo '<div class="card h-100">';
    echo '<div class="card-header">';
    echo '<h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Activity</h5>';
    echo '</div>';
    echo '<div class="card-body p-0">';
    echo '<div class="list-group list-group-flush">';
    
    foreach ($activities as $activity) {
        echo '<div class="list-group-item border-0 py-3">';
        echo '<div class="d-flex align-items-start">';
        echo '<div class="stat-icon ' . $activity['color'] . ' me-3" style="width: 40px; height: 40px; font-size: 16px;">';
        echo '<i class="fas fa-' . $activity['icon'] . '"></i>';
        echo '</div>';
        echo '<div class="flex-grow-1">';
        echo '<div class="fw-semibold">' . $activity['title'] . '</div>';
        echo '<div class="text-muted small">' . $activity['description'] . '</div>';
        echo '<div class="text-muted small mt-1">' . $activity['time'] . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// Quick Actions Widget
function renderQuickActionsWidget() {
    $actions = [
        [
            'title' => 'Add Gallery Item',
            'icon' => 'plus',
            'color' => 'primary',
            'link' => 'gallery.php#add-new',
            'description' => 'Upload new images to gallery'
        ],
        [
            'title' => 'Create Slider',
            'icon' => 'plus-square',
            'color' => 'success',
            'link' => 'slider.php#add-new',
            'description' => 'Add new slider content'
        ],
        [
            'title' => 'Update Settings',
            'icon' => 'cog',
            'color' => 'warning',
            'link' => 'site-settings.php',
            'description' => 'Modify site configuration'
        ],
        [
            'title' => 'View Website',
            'icon' => 'external-link-alt',
            'color' => 'info',
            'link' => '../index.php',
            'description' => 'Preview live website'
        ]
    ];

    echo '<div class="card h-100">';
    echo '<div class="card-header">';
    echo '<h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<div class="row g-3">';
    
    foreach ($actions as $action) {
        echo '<div class="col-md-6">';
        echo '<a href="' . $action['link'] . '" class="text-decoration-none">';
        echo '<div class="p-3 rounded-3 border h-100 hover-lift" style="transition: all 0.3s ease;">';
        echo '<div class="d-flex align-items-center mb-2">';
        echo '<div class="stat-icon ' . $action['color'] . ' me-3" style="width: 35px; height: 35px; font-size: 14px;">';
        echo '<i class="fas fa-' . $action['icon'] . '"></i>';
        echo '</div>';
        echo '<div class="fw-semibold">' . $action['title'] . '</div>';
        echo '</div>';
        echo '<div class="text-muted small">' . $action['description'] . '</div>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// System Status Widget
function renderSystemStatusWidget($stats) {
    $status_items = [
        [
            'label' => 'Database Connection',
            'status' => 'healthy',
            'icon' => 'database',
            'color' => 'success'
        ],
        [
            'label' => 'File Uploads',
            'status' => 'operational',
            'icon' => 'upload',
            'color' => 'success'
        ],
        [
            'label' => 'Gallery Images',
            'status' => ($stats['gallery']['total'] ?? 0) . ' items',
            'icon' => 'images',
            'color' => 'primary'
        ],
        [
            'label' => 'Site Settings',
            'status' => 'configured',
            'icon' => 'check-circle',
            'color' => 'success'
        ]
    ];

    echo '<div class="card h-100">';
    echo '<div class="card-header">';
    echo '<h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>System Status</h5>';
    echo '</div>';
    echo '<div class="card-body">';
    
    foreach ($status_items as $item) {
        echo '<div class="d-flex align-items-center justify-content-between py-2">';
        echo '<div class="d-flex align-items-center">';
        echo '<i class="fas fa-' . $item['icon'] . ' text-' . $item['color'] . ' me-3"></i>';
        echo '<span>' . $item['label'] . '</span>';
        echo '</div>';
        echo '<span class="badge bg-' . $item['color'] . ' rounded-pill">' . $item['status'] . '</span>';
        echo '</div>';
        if ($item !== end($status_items)) {
            echo '<hr class="my-2">';
        }
    }
    
    echo '</div>';
    echo '</div>';
}

// Performance Metrics Widget
function renderPerformanceWidget() {
    echo '<div class="card h-100">';
    echo '<div class="card-header">';
    echo '<h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Performance</h5>';
    echo '</div>';
    echo '<div class="card-body">';
    
    $metrics = [
        ['label' => 'Page Load Time', 'value' => '1.2s', 'trend' => 'up', 'color' => 'success'],
        ['label' => 'Database Queries', 'value' => '15', 'trend' => 'stable', 'color' => 'primary'],
        ['label' => 'Memory Usage', 'value' => '64MB', 'trend' => 'down', 'color' => 'warning'],
        ['label' => 'Cache Hit Rate', 'value' => '94%', 'trend' => 'up', 'color' => 'success']
    ];
    
    foreach ($metrics as $metric) {
        echo '<div class="d-flex align-items-center justify-content-between py-2">';
        echo '<div>';
        echo '<div class="fw-semibold">' . $metric['label'] . '</div>';
        echo '<div class="text-muted small">Current value</div>';
        echo '</div>';
        echo '<div class="text-end">';
        echo '<div class="h5 mb-0 text-' . $metric['color'] . '">' . $metric['value'] . '</div>';
        echo '<div class="small text-' . $metric['color'] . '">';
        echo '<i class="fas fa-arrow-' . ($metric['trend'] === 'up' ? 'up' : ($metric['trend'] === 'down' ? 'down' : 'right')) . ' me-1"></i>';
        echo ucfirst($metric['trend']);
        echo '</div>';
        echo '</div>';
        echo '</div>';
        if ($metric !== end($metrics)) {
            echo '<hr class="my-2">';
        }
    }
    
    echo '</div>';
    echo '</div>';
}
?>
