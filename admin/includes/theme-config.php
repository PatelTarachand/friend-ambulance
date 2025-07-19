<?php
// Modern Admin Theme Configuration

class AdminTheme {
    // Theme colors and gradients
    public static $colors = [
        'primary' => '#ea6666ff',
        'secondary' => '#f093fb',
        'success' => '#4facfe',
        'warning' => '#43e97b',
        'danger' => '#fa709a',
        'info' => '#17a2b8',
        'dark' => '#2d3748',
        'light' => '#f7fafc'
    ];
    
    public static $gradients = [
        'primary' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'secondary' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
        'success' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
        'warning' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
        'danger' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
        'info' => 'linear-gradient(135deg, #17a2b8 0%, #20c997 100%)'
    ];
    
    // Get theme configuration
    public static function getConfig() {
        return [
            'name' => 'Friends Ambulance Admin',
            'version' => '2.0',
            'author' => 'Admin Panel',
            'colors' => self::$colors,
            'gradients' => self::$gradients,
            'features' => [
                'dark_mode' => false,
                'animations' => true,
                'notifications' => true,
                'auto_save' => true,
                'mobile_responsive' => true
            ]
        ];
    }
    
    // Generate CSS custom properties
    public static function getCSSVariables() {
        $css = ':root {';
        
        // Colors
        foreach (self::$colors as $name => $color) {
            $css .= "--{$name}-color: {$color};";
        }
        
        // Gradients
        foreach (self::$gradients as $name => $gradient) {
            $css .= "--{$name}-gradient: {$gradient};";
        }
        
        // Additional variables
        $css .= '
            --border-radius: 12px;
            --shadow: 0 4px 20px rgba(0,0,0,0.1);
            --shadow-hover: 0 8px 30px rgba(0,0,0,0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        ';
        
        $css .= '}';
        
        return $css;
    }
    
    // Get icon for page
    public static function getPageIcon($page) {
        $icons = [
            'dashboard' => 'tachometer-alt',
            'gallery' => 'images',
            'slider' => 'sliders-h',
            'hero-backgrounds' => 'image',
            'site-settings' => 'cog',
            'database-status' => 'database',
            'test-hero-backgrounds' => 'vial'
        ];
        return $icons[$page] ?? 'file-alt';
    }
    
    // Get color class for stat cards
    public static function getStatCardColor($index) {
        $colors = ['primary', 'success', 'warning', 'danger'];
        return $colors[$index % count($colors)];
    }
    
    // Generate button classes
    public static function getButtonClass($type = 'primary', $size = 'md') {
        $sizeClasses = [
            'sm' => 'btn-sm',
            'md' => '',
            'lg' => 'btn-lg'
        ];
        
        return 'btn btn-' . $type . ' ' . ($sizeClasses[$size] ?? '');
    }
    
    // Generate card classes
    public static function getCardClass($type = 'default') {
        $baseClass = 'card';
        
        switch ($type) {
            case 'stat':
                return $baseClass . ' stat-card';
            case 'widget':
                return $baseClass . ' widget-card';
            case 'form':
                return $baseClass . ' form-card';
            default:
                return $baseClass;
        }
    }
    
    // Generate alert classes
    public static function getAlertClass($type = 'info') {
        return 'alert alert-' . $type . ' alert-dismissible fade show';
    }
    
    // Get navigation items
    public static function getNavigationItems() {
        return [
            [
                'id' => 'dashboard',
                'title' => 'Dashboard',
                'icon' => 'tachometer-alt',
                'url' => 'dashboard.php',
                'badge' => null
            ],
            [
                'id' => 'gallery',
                'title' => 'Gallery',
                'icon' => 'images',
                'url' => 'gallery.php',
                'badge' => null
            ],
            [
                'id' => 'slider',
                'title' => 'Slider',
                'icon' => 'sliders-h',
                'url' => 'slider.php',
                'badge' => null
            ],
            [
                'id' => 'hero-backgrounds',
                'title' => 'Hero Backgrounds',
                'icon' => 'image',
                'url' => 'hero-backgrounds.php',
                'badge' => null
            ],
            [
                'id' => 'site-settings',
                'title' => 'Site Settings',
                'icon' => 'cog',
                'url' => 'site-settings.php',
                'badge' => null
            ],
            [
                'id' => 'contact-submissions',
                'title' => 'Contact Forms',
                'icon' => 'envelope',
                'url' => 'contact-submissions.php',
                'badge' => null
            ],
            [
                'id' => 'database-status',
                'title' => 'Database',
                'icon' => 'database',
                'url' => 'database-status.php',
                'badge' => null
            ]
        ];
    }
    
    // Render navigation
    public static function renderNavigation($currentPage) {
        $items = self::getNavigationItems();
        $html = '';
        
        foreach ($items as $item) {
            $isActive = $currentPage === $item['id'];
            $activeClass = $isActive ? 'active' : '';
            
            $html .= '<a class="nav-link ' . $activeClass . '" href="' . $item['url'] . '">';
            $html .= '<i class="fas fa-' . $item['icon'] . '"></i>';
            $html .= $item['title'];
            
            if ($item['badge']) {
                $html .= '<span class="badge bg-light text-dark ms-auto">' . $item['badge'] . '</span>';
            }
            
            $html .= '</a>';
        }
        
        return $html;
    }
    
    // Generate breadcrumb
    public static function getBreadcrumb($currentPage) {
        $breadcrumbs = [
            'dashboard' => [['title' => 'Dashboard', 'url' => null]],
            'gallery' => [
                ['title' => 'Dashboard', 'url' => 'dashboard.php'],
                ['title' => 'Gallery Management', 'url' => null]
            ],
            'slider' => [
                ['title' => 'Dashboard', 'url' => 'dashboard.php'],
                ['title' => 'Slider Management', 'url' => null]
            ],
            'hero-backgrounds' => [
                ['title' => 'Dashboard', 'url' => 'dashboard.php'],
                ['title' => 'Hero Backgrounds', 'url' => null]
            ],
            'site-settings' => [
                ['title' => 'Dashboard', 'url' => 'dashboard.php'],
                ['title' => 'Site Settings', 'url' => null]
            ],
            'database-status' => [
                ['title' => 'Dashboard', 'url' => 'dashboard.php'],
                ['title' => 'Database Status', 'url' => null]
            ]
        ];
        
        return $breadcrumbs[$currentPage] ?? [['title' => 'Admin Panel', 'url' => null]];
    }
    
    // Render breadcrumb HTML
    public static function renderBreadcrumb($currentPage) {
        $breadcrumbs = self::getBreadcrumb($currentPage);
        
        if (count($breadcrumbs) <= 1) {
            return '';
        }
        
        $html = '<nav aria-label="breadcrumb" class="mb-3">';
        $html .= '<ol class="breadcrumb">';
        
        foreach ($breadcrumbs as $index => $crumb) {
            $isLast = $index === count($breadcrumbs) - 1;
            
            if ($isLast) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . $crumb['title'] . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item">';
                if ($crumb['url']) {
                    $html .= '<a href="' . $crumb['url'] . '">' . $crumb['title'] . '</a>';
                } else {
                    $html .= $crumb['title'];
                }
                $html .= '</li>';
            }
        }
        
        $html .= '</ol>';
        $html .= '</nav>';
        
        return $html;
    }
}
?>
