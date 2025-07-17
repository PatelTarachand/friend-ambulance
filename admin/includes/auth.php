<?php
// Admin Authentication System

session_start();
require_once __DIR__ . '/../config/database.php';

class AdminAuth {
    
    // Login user
    public static function login($username, $password) {
        try {
            $users = readJsonFile(USERS_FILE);
            $user = null;

            foreach ($users as $u) {
                if (($u['username'] === $username || $u['email'] === $username) && $u['is_active'] == 1) {
                    $user = $u;
                    break;
                }
            }

            if ($user && password_verify($password, $user['password'])) {
                // Create session
                self::createSession($user);

                // Update last login
                foreach ($users as &$u) {
                    if ($u['id'] === $user['id']) {
                        $u['last_login'] = date('Y-m-d H:i:s');
                        break;
                    }
                }
                writeJsonFile(USERS_FILE, $users);

                return true;
            }

            return false;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
    
    // Create user session
    private static function createSession($user) {
        // Generate secure session ID
        $sessionId = bin2hex(random_bytes(32));

        // Store session in file
        $sessions = readJsonFile(SESSIONS_FILE);
        $sessions[] = [
            'id' => $sessionId,
            'user_id' => $user['id'],
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', time() + (24 * 60 * 60))
        ];
        writeJsonFile(SESSIONS_FILE, $sessions);
        
        // Set session variables
        $_SESSION['admin_session_id'] = $sessionId;
        $_SESSION['admin_user_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_full_name'] = $user['full_name'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['admin_logged_in'] = true;
        
        // Set secure cookie
        setcookie('admin_session', $sessionId, [
            'expires' => time() + (24 * 60 * 60),
            'path' => '/admin/',
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
    
    // Check if user is logged in
    public static function isLoggedIn() {
        if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
            return false;
        }

        // Verify session in file
        $sessionId = $_SESSION['admin_session_id'] ?? '';
        $sessions = readJsonFile(SESSIONS_FILE);
        $users = readJsonFile(USERS_FILE);

        $validSession = false;
        foreach ($sessions as $session) {
            if ($session['id'] === $sessionId && $session['expires_at'] > date('Y-m-d H:i:s')) {
                // Check if user is still active
                foreach ($users as $user) {
                    if ($user['id'] === $session['user_id'] && $user['is_active'] == 1) {
                        $validSession = true;
                        break 2;
                    }
                }
            }
        }

        if (!$validSession) {
            self::logout();
            return false;
        }

        return true;
    }
    
    // Get current user info
    public static function getCurrentUser() {
        if (!self::isLoggedIn()) {
            return null;
        }

        $users = readJsonFile(USERS_FILE);
        foreach ($users as $user) {
            if ($user['id'] === $_SESSION['admin_user_id']) {
                return $user;
            }
        }

        return null;
    }
    
    // Logout user
    public static function logout() {
        // Remove session from file
        if (isset($_SESSION['admin_session_id'])) {
            $sessions = readJsonFile(SESSIONS_FILE);
            $sessions = array_filter($sessions, function($session) {
                return $session['id'] !== $_SESSION['admin_session_id'];
            });
            writeJsonFile(SESSIONS_FILE, array_values($sessions));
        }

        // Clear session variables
        session_unset();
        session_destroy();

        // Clear cookie
        setcookie('admin_session', '', [
            'expires' => time() - 3600,
            'path' => '/admin/'
        ]);
    }
    
    // Require login (redirect if not logged in)
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /admin/login.php');
            exit;
        }
    }
    
    // Check if user has specific role
    public static function hasRole($role) {
        return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === $role;
    }
    
    // Generate CSRF token
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    // Verify CSRF token
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    // Clean expired sessions
    public static function cleanExpiredSessions() {
        $sessions = readJsonFile(SESSIONS_FILE);
        $currentTime = date('Y-m-d H:i:s');
        $sessions = array_filter($sessions, function($session) use ($currentTime) {
            return $session['expires_at'] > $currentTime;
        });
        writeJsonFile(SESSIONS_FILE, array_values($sessions));
    }
    
    // Change password
    public static function changePassword($userId, $currentPassword, $newPassword) {
        try {
            $users = readJsonFile(USERS_FILE);
            $userIndex = -1;

            foreach ($users as $index => $user) {
                if ($user['id'] === $userId) {
                    $userIndex = $index;
                    break;
                }
            }

            if ($userIndex === -1 || !password_verify($currentPassword, $users[$userIndex]['password'])) {
                return false;
            }

            $users[$userIndex]['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            $users[$userIndex]['updated_at'] = date('Y-m-d H:i:s');
            writeJsonFile(USERS_FILE, $users);

            return true;
        } catch (Exception $e) {
            error_log("Password change error: " . $e->getMessage());
            return false;
        }
    }
    
    // Update user profile
    public static function updateProfile($userId, $fullName, $email) {
        try {
            $users = readJsonFile(USERS_FILE);

            foreach ($users as &$user) {
                if ($user['id'] === $userId) {
                    $user['full_name'] = $fullName;
                    $user['email'] = $email;
                    $user['updated_at'] = date('Y-m-d H:i:s');
                    break;
                }
            }

            writeJsonFile(USERS_FILE, $users);

            // Update session
            $_SESSION['admin_full_name'] = $fullName;

            return true;
        } catch (Exception $e) {
            error_log("Profile update error: " . $e->getMessage());
            return false;
        }
    }
}

// Clean expired sessions periodically
if (rand(1, 100) === 1) {
    AdminAuth::cleanExpiredSessions();
}
?>
