<?php
// Simple File-Based Data Storage for Friends Ambulance Admin Panel

// Data storage paths
define('DATA_DIR', __DIR__ . '/../data/');
define('USERS_FILE', DATA_DIR . 'users.json');
define('SLIDERS_FILE', DATA_DIR . 'sliders.json');
define('GALLERY_FILE', DATA_DIR . 'gallery.json');
define('SESSIONS_FILE', DATA_DIR . 'sessions.json');

// Create data directory if it doesn't exist
if (!is_dir(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

// Helper function to read JSON file
function readJsonFile($file) {
    if (!file_exists($file)) {
        return [];
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?: [];
}

// Helper function to write JSON file
function writeJsonFile($file, $data) {
    $result = file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $result !== false;
}

// Helper function to generate unique ID
function generateId() {
    return uniqid() . '_' . time();
}

// Simulate database functions
function executeQuery($query, $params = []) {
    // Handle gallery_images operations
    if (strpos($query, 'gallery_images') !== false) {
        $gallery = readJsonFile(GALLERY_FILE);

        if (strpos($query, 'INSERT') !== false) {
            // Add new gallery image
            $newImage = [
                'id' => generateId(),
                'title' => $params[0] ?? '',
                'description' => $params[1] ?? '',
                'image_path' => $params[2] ?? '',
                'thumbnail_path' => $params[3] ?? '',
                'is_active' => $params[4] ?? 1,
                'sort_order' => $params[5] ?? 0,
                'created_by' => $params[6] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $gallery[] = $newImage;
            return writeJsonFile(GALLERY_FILE, $gallery);
        } elseif (strpos($query, 'UPDATE') !== false) {
            // Update gallery image
            $id = end($params); // Last parameter is usually the ID
            foreach ($gallery as &$image) {
                if ($image['id'] === $id) {
                    if (count($params) === 6) {
                        // Update without image change
                        $image['title'] = $params[0];
                        $image['description'] = $params[1];
                        $image['is_active'] = $params[2];
                        $image['sort_order'] = $params[3];
                        $image['updated_at'] = $params[4];
                    } elseif (count($params) === 8) {
                        // Update with image change
                        $image['title'] = $params[0];
                        $image['description'] = $params[1];
                        $image['image_path'] = $params[2];
                        $image['thumbnail_path'] = $params[3];
                        $image['is_active'] = $params[4];
                        $image['sort_order'] = $params[5];
                        $image['updated_at'] = $params[6];
                    }
                    break;
                }
            }
            return writeJsonFile(GALLERY_FILE, $gallery);
        } elseif (strpos($query, 'DELETE') !== false) {
            // Delete gallery image
            $id = $params[0];
            $gallery = array_filter($gallery, function($image) use ($id) {
                return $image['id'] !== $id;
            });
            return writeJsonFile(GALLERY_FILE, array_values($gallery));
        }
    }

    return true;
}

function getSingleRecord($query, $params = []) {
    // Parse query type and table
    if (strpos($query, 'admin_users') !== false) {
        $users = readJsonFile(USERS_FILE);
        if (strpos($query, 'username') !== false || strpos($query, 'email') !== false) {
            foreach ($users as $user) {
                if ($user['username'] === $params[0] || $user['email'] === $params[0]) {
                    return $user;
                }
            }
        } elseif (strpos($query, 'id') !== false) {
            foreach ($users as $user) {
                if ($user['id'] === $params[0]) {
                    return $user;
                }
            }
        }
    } elseif (strpos($query, 'slider_images') !== false) {
        $sliders = readJsonFile(SLIDERS_FILE);
        if (strpos($query, 'COUNT') !== false) {
            $count = 0;
            foreach ($sliders as $slider) {
                if (!isset($params[0]) || $slider['is_active'] == 1) {
                    $count++;
                }
            }
            return ['count' => $count];
        } elseif (strpos($query, 'id') !== false && isset($params[0])) {
            foreach ($sliders as $slider) {
                if ($slider['id'] === $params[0]) {
                    return $slider;
                }
            }
        }
    } elseif (strpos($query, 'gallery_images') !== false) {
        $gallery = readJsonFile(GALLERY_FILE);
        if (strpos($query, 'COUNT') !== false) {
            $count = 0;
            foreach ($gallery as $image) {
                if (!isset($params[0]) || $image['is_active'] == 1) {
                    $count++;
                }
            }
            return ['count' => $count];
        } elseif (strpos($query, 'id') !== false && isset($params[0])) {
            foreach ($gallery as $image) {
                if ($image['id'] === $params[0]) {
                    return $image;
                }
            }
        }
    }
    return null;
}

function getMultipleRecords($query, $params = []) {
    if (strpos($query, 'admin_users') !== false) {
        return readJsonFile(USERS_FILE);
    } elseif (strpos($query, 'slider_images') !== false) {
        $sliders = readJsonFile(SLIDERS_FILE);
        if (strpos($query, 'is_active = 1') !== false) {
            return array_filter($sliders, function($slider) {
                return $slider['is_active'] == 1;
            });
        }
        return $sliders;
    } elseif (strpos($query, 'gallery_images') !== false) {
        $gallery = readJsonFile(GALLERY_FILE);
        if (strpos($query, 'is_active = 1') !== false) {
            return array_filter($gallery, function($image) {
                return $image['is_active'] == 1;
            });
        }
        return $gallery;
    }
    return [];
}

// Initialize data files
function initializeDatabase() {
    // Create default admin user if users file doesn't exist
    if (!file_exists(USERS_FILE)) {
        $defaultUser = [
            'id' => generateId(),
            'username' => 'admin',
            'email' => 'admin@friendsambulance.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'Administrator',
            'role' => 'admin',
            'is_active' => 1,
            'last_login' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        writeJsonFile(USERS_FILE, [$defaultUser]);
    }

    // Create empty files if they don't exist
    if (!file_exists(SLIDERS_FILE)) {
        writeJsonFile(SLIDERS_FILE, []);
    }
    if (!file_exists(GALLERY_FILE)) {
        writeJsonFile(GALLERY_FILE, []);
    }
    if (!file_exists(SESSIONS_FILE)) {
        writeJsonFile(SESSIONS_FILE, []);
    }

    return true;
}

// Initialize data files on first load
initializeDatabase();
?>
