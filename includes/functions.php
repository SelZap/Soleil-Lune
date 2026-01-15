<?php

// Sanitize input
function sanitize($data) {
    return filter_var($data, FILTER_SANITIZE_STRING);
}

// Set message in session
function setMessage($message, $type = 'error') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

// Get and display message
function getMessage() {
    if (isset($_SESSION['message'])) {
        $type = $_SESSION['message_type'] ?? 'error';
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        
        echo '<div class="message ' . $type . '">
                <span>' . htmlspecialchars($message) . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
              </div>';
    }
}

// Alias for getMessage
function displayMessages() {
    getMessage();
}

// Format date
function formatDate($date) {
    return date('M j, Y', strtotime($date));
}

// Truncate text
function truncate($text, $length = 150) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if admin is logged in
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

// Get current user ID
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Get current admin ID
function getAdminId() {
    return $_SESSION['admin_id'] ?? null;
}

// Require user to be logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /Soleil-Lune/public/auth.php?action=login');
        exit();
    }
}

// Require admin to be logged in
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /Soleil-Lune/admin/index.php?action=login');
        exit();
    }
}

// Upload image 
function uploadImage($file, $uploadDir = '../assets/uploads/') {
    // Check if file was uploaded
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }
    
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    
    // Get file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    // Validate extension
    if (!in_array($fileExt, $allowed)) {
        return ['success' => false, 'message' => 'Invalid file type. Allowed: jpg, jpeg, png, gif, webp'];
    }
    
    // Check for upload errors
    if ($fileError !== 0) {
        return ['success' => false, 'message' => 'Error uploading file (Code: ' . $fileError . ')'];
    }
    
    // Check file size (5MB max)
    if ($fileSize > 5000000) {
        return ['success' => false, 'message' => 'File too large (max 5MB)'];
    }
    
    // Create unique filename
    $newFileName = uniqid('img_', true) . '.' . $fileExt;
    $fileDestination = $uploadDir . $newFileName;
    
    // Ensure upload directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        return ['success' => true, 'filename' => $newFileName];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

// Delete image
function deleteImage($filename, $uploadDir = '../assets/uploads/') {
    $filePath = $uploadDir . $filename;
    if (file_exists($filePath) && !empty($filename)) {
        unlink($filePath);
        return true;
    }
    return false;
}

// Get single post
function getPost($post_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get comments for a post
function getComments($post_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC");
    $stmt->execute([$post_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if user liked a post
function isLiked($post_id, $user_id) {
    global $conn;
    if (!$user_id) return false;
    
    $stmt = $conn->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$post_id, $user_id]);
    return $stmt->rowCount() > 0;
}

// Count likes for a post
function countLikes($post_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    return $stmt->fetchColumn();
}

// Toggle like (add or remove)
function toggleLike($post_id, $user_id, $admin_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$post_id, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        // Unlike
        $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
    } else {
        // Like
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id, admin_id) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $admin_id]);
    }
}

// Count comments for a post
function countComments($post_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ?");
    $stmt->execute([$post_id]);
    return $stmt->fetchColumn();
}

// Truncate text with ellipsis
function truncateText($text, $length = 150) {
    $text = strip_tags($text);
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}
?>