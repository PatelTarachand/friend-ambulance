<?php
// Image Upload System for Admin Panel

class ImageUpload {
    
    private $uploadDir;
    private $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    private $maxFileSize = 5 * 1024 * 1024; // 5MB
    private $maxWidth = 1920;
    private $maxHeight = 1080;
    
    public function __construct($uploadDir = 'assets/uploads/') {
        $this->uploadDir = '../' . $uploadDir;
        $this->createUploadDirectories();
    }
    
    // Create upload directories if they don't exist
    private function createUploadDirectories() {
        $directories = [
            $this->uploadDir,
            $this->uploadDir . 'slider/',
            $this->uploadDir . 'gallery/',
            $this->uploadDir . 'thumbnails/'
        ];

        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                if (!mkdir($dir, 0755, true)) {
                    error_log("Failed to create directory: $dir");
                }
            }

            // Check if directory is writable
            if (!is_writable($dir)) {
                error_log("Directory not writable: $dir");
            }
        }
    }
    
    // Upload image with validation and processing
    public function uploadImage($file, $type = 'slider', $resize = true) {
        try {
            // Validate file
            $validation = $this->validateFile($file);
            if (!$validation['success']) {
                return $validation;
            }
            
            // Generate unique filename
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = $type . '_' . uniqid() . '_' . time() . '.' . $extension;
            $subDir = $type . '/';
            $uploadPath = $this->uploadDir . $subDir . $filename;
            $relativePath = 'assets/uploads/' . $subDir . $filename;
            
            // Check if upload directory is writable
            $uploadDirPath = dirname($uploadPath);
            if (!is_writable($uploadDirPath)) {
                return ['success' => false, 'message' => 'Upload directory is not writable: ' . $uploadDirPath];
            }

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $error = error_get_last();
                return ['success' => false, 'message' => 'Failed to upload file. Error: ' . ($error['message'] ?? 'Unknown error')];
            }
            
            // Resize image if needed
            if ($resize) {
                $this->resizeImage($uploadPath);
            }
            
            // Create thumbnail for gallery images
            $thumbnailPath = null;
            if ($type === 'gallery') {
                $thumbnailPath = $this->createThumbnail($uploadPath, $filename);
            }
            
            return [
                'success' => true,
                'filename' => $filename,
                'path' => $relativePath,
                'thumbnail' => $thumbnailPath,
                'size' => filesize($uploadPath)
            ];
            
        } catch (Exception $e) {
            error_log("Upload error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Upload failed: ' . $e->getMessage()];
        }
    }
    
    // Validate uploaded file
    private function validateFile($file) {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'File upload error: ' . $this->getUploadErrorMessage($file['error'])];
        }
        
        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            return ['success' => false, 'message' => 'File size exceeds 5MB limit'];
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $this->allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed'];
        }
        
        // Check image dimensions
        $imageInfo = getimagesize($file['tmp_name']);
        if (!$imageInfo) {
            return ['success' => false, 'message' => 'Invalid image file'];
        }
        
        return ['success' => true];
    }
    
    // Resize image to fit within max dimensions
    private function resizeImage($imagePath) {
        $imageInfo = getimagesize($imagePath);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo[2];
        
        // Check if resize is needed
        if ($width <= $this->maxWidth && $height <= $this->maxHeight) {
            return true;
        }
        
        // Calculate new dimensions
        $ratio = min($this->maxWidth / $width, $this->maxHeight / $height);
        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);
        
        // Create image resource
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($imagePath);
                break;
            default:
                return false;
        }
        
        // Create new image
        $destination = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG and GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
            imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Resize image
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Save resized image
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($destination, $imagePath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($destination, $imagePath, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($destination, $imagePath);
                break;
        }
        
        // Clean up
        imagedestroy($source);
        imagedestroy($destination);
        
        return true;
    }
    
    // Create thumbnail for gallery images
    private function createThumbnail($imagePath, $filename) {
        $thumbnailDir = $this->uploadDir . 'thumbnails/';
        $thumbnailPath = $thumbnailDir . 'thumb_' . $filename;
        $relativePath = 'assets/uploads/thumbnails/thumb_' . $filename;
        
        $imageInfo = getimagesize($imagePath);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo[2];
        
        // Thumbnail dimensions
        $thumbWidth = 300;
        $thumbHeight = 200;
        
        // Create image resource
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($imagePath);
                break;
            default:
                return null;
        }
        
        // Create thumbnail
        $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);
        
        // Preserve transparency
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
            $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
            imagefilledrectangle($thumbnail, 0, 0, $thumbWidth, $thumbHeight, $transparent);
        }
        
        // Resize to thumbnail
        imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
        
        // Save thumbnail
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumbnail, $thumbnailPath, 85);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbnail, $thumbnailPath, 8);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumbnail, $thumbnailPath);
                break;
        }
        
        // Clean up
        imagedestroy($source);
        imagedestroy($thumbnail);
        
        return $relativePath;
    }
    
    // Delete image file
    public function deleteImage($imagePath, $thumbnailPath = null) {
        $fullPath = '../' . $imagePath;
        
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        
        if ($thumbnailPath) {
            $fullThumbnailPath = '../' . $thumbnailPath;
            if (file_exists($fullThumbnailPath)) {
                unlink($fullThumbnailPath);
            }
        }
        
        return true;
    }
    
    // Get upload error message
    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'File exceeds upload_max_filesize directive';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File exceeds MAX_FILE_SIZE directive';
            case UPLOAD_ERR_PARTIAL:
                return 'File was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown upload error';
        }
    }
}
?>
