<?php
// Modern Notification System for Admin Panel

class AdminNotifications {
    private static $notifications = [];
    
    // Add notification to session
    public static function add($type, $title, $message, $icon = null) {
        if (!isset($_SESSION['admin_notifications'])) {
            $_SESSION['admin_notifications'] = [];
        }
        
        $notification = [
            'id' => uniqid(),
            'type' => $type, // success, error, warning, info
            'title' => $title,
            'message' => $message,
            'icon' => $icon ?: self::getDefaultIcon($type),
            'timestamp' => time()
        ];
        
        $_SESSION['admin_notifications'][] = $notification;
    }
    
    // Get all notifications and clear them
    public static function getAndClear() {
        $notifications = $_SESSION['admin_notifications'] ?? [];
        unset($_SESSION['admin_notifications']);
        return $notifications;
    }
    
    // Get default icon for notification type
    private static function getDefaultIcon($type) {
        $icons = [
            'success' => 'check-circle',
            'error' => 'exclamation-circle',
            'warning' => 'exclamation-triangle',
            'info' => 'info-circle'
        ];
        return $icons[$type] ?? 'bell';
    }
    
    // Render notifications HTML
    public static function render() {
        $notifications = self::getAndClear();
        if (empty($notifications)) return '';
        
        $html = '<div class="notification-container position-fixed" style="top: 20px; right: 20px; z-index: 9999;">';
        
        foreach ($notifications as $notification) {
            $html .= self::renderNotification($notification);
        }
        
        $html .= '</div>';
        
        // Add JavaScript for auto-dismiss and animations
        $html .= '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const notifications = document.querySelectorAll(".admin-notification");
                notifications.forEach((notification, index) => {
                    // Animate in
                    setTimeout(() => {
                        notification.style.transform = "translateX(0)";
                        notification.style.opacity = "1";
                    }, index * 150);
                    
                    // Auto dismiss after 5 seconds
                    setTimeout(() => {
                        notification.style.transform = "translateX(100%)";
                        notification.style.opacity = "0";
                        setTimeout(() => {
                            if (notification.parentNode) {
                                notification.parentNode.removeChild(notification);
                            }
                        }, 300);
                    }, 5000 + (index * 150));
                });
            });
        </script>';
        
        return $html;
    }
    
    // Render individual notification
    private static function renderNotification($notification) {
        $typeColors = [
            'success' => 'success',
            'error' => 'danger',
            'warning' => 'warning',
            'info' => 'info'
        ];
        
        $color = $typeColors[$notification['type']] ?? 'primary';
        
        return '
        <div class="admin-notification alert alert-' . $color . ' alert-dismissible fade show mb-3" 
             style="
                 min-width: 350px; 
                 max-width: 400px;
                 transform: translateX(100%);
                 opacity: 0;
                 transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                 border: none;
                 border-radius: 12px;
                 box-shadow: 0 8px 30px rgba(0,0,0,0.12);
                 backdrop-filter: blur(20px);
             ">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <i class="fas fa-' . $notification['icon'] . ' fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold mb-1">' . htmlspecialchars($notification['title']) . '</div>
                    <div class="small">' . htmlspecialchars($notification['message']) . '</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>';
    }
    
    // Convenience methods
    public static function success($title, $message) {
        self::add('success', $title, $message);
    }
    
    public static function error($title, $message) {
        self::add('error', $title, $message);
    }
    
    public static function warning($title, $message) {
        self::add('warning', $title, $message);
    }
    
    public static function info($title, $message) {
        self::add('info', $title, $message);
    }
}

// Helper functions for backward compatibility
function addSuccessNotification($title, $message) {
    AdminNotifications::success($title, $message);
}

function addErrorNotification($title, $message) {
    AdminNotifications::error($title, $message);
}

function addWarningNotification($title, $message) {
    AdminNotifications::warning($title, $message);
}

function addInfoNotification($title, $message) {
    AdminNotifications::info($title, $message);
}

// Auto-render notifications if they exist
function renderAdminNotifications() {
    return AdminNotifications::render();
}
?>
