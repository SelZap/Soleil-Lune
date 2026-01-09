<?php
/**
 * Authentication Functions
 */

// Login function
function login($username, $password, $isAdmin = false) {
    global $conn;
    
    $password = sha1($password);
    
    if ($isAdmin) {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE name = ? AND password = ?");
        $stmt->execute([$username, $password]);
        
        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            return true;
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$username, $password]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
    }
    
    return false;
}

// Logout function
function logout($isAdmin = false) {
    session_destroy();
    
    if ($isAdmin) {
        header('Location: /Soleil-Lune/admin/index.php?action=login');
    } else {
        header('Location: /Soleil-Lune/public/index.php');
    }
    exit();
}

// Register function
function register($name, $email, $password, $confirmPassword) {
    global $conn;
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'All fields are required'];
    }
    
    if ($password !== $confirmPassword) {
        return ['success' => false, 'message' => 'Passwords do not match'];
    }
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        return ['success' => false, 'message' => 'Email already exists'];
    }
    
    // Hash password
    $hashedPassword = sha1($password);
    
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$name, $email, $hashedPassword])) {
        // Auto-login after registration
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        
        return ['success' => true, 'message' => 'Registration successful'];
    }
    
    return ['success' => false, 'message' => 'Registration failed'];
}
?>