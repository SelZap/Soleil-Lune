<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();
$admin_id = getAdminId();

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $current_password = $_POST['current_pass'] ?? '';
    $new_password = $_POST['new_pass'] ?? '';
    $confirm_password = $_POST['confirm_pass'] ?? '';
    
    $errors = [];
    
    // Validate name
    if (!empty($name) && $name !== $_SESSION['admin_name']) {
        $stmt = $conn->prepare("UPDATE admin SET name = ? WHERE id = ?");
        if ($stmt->execute([$name, $admin_id])) {
            $_SESSION['admin_name'] = $name;
            setMessage('Name updated successfully!', 'success');
        }
    }
    
    // Validate and update email
    if (!empty($email) && $email !== $_SESSION['admin_email']) {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND id != ?");
        $stmt->execute([$email, $admin_id]);
        
        if ($stmt->rowCount() > 0) {
            $errors[] = 'Email already taken by another admin!';
        } else {
            $stmt = $conn->prepare("UPDATE admin SET email = ? WHERE id = ?");
            if ($stmt->execute([$email, $admin_id])) {
                $_SESSION['admin_email'] = $email;
                setMessage('Email updated successfully!', 'success');
            }
        }
    }
    
    // Handle password change
    if (!empty($current_password) && !empty($new_password)) {
        if ($new_password !== $confirm_password) {
            $errors[] = 'New passwords do not match!';
        } else {
            // Verify current password
            $stmt = $conn->prepare("SELECT * FROM admin WHERE id = ? AND password = ?");
            $stmt->execute([$admin_id, sha1($current_password)]);
            
            if ($stmt->rowCount() === 0) {
                $errors[] = 'Current password is incorrect!';
            } else {
                // Update password
                $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
                if ($stmt->execute([sha1($new_password), $admin_id])) {
                    setMessage('Password updated successfully!', 'success');
                }
            }
        }
    }
    
    if (!empty($errors)) {
        setMessage(implode(' ', $errors), 'error');
    }
    
    header("Location: settings.php");
    exit();
}

// Get admin data
$stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - Soleil|Lune</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
    <style>
        .settings-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 3rem 2rem;
        }
        
        .settings-section {
            background: var(--white);
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: var(--box-shadow);
            border: var(--border);
            margin-bottom: 2rem;
        }
        
        .settings-section h2 {
            font-size: 2.4rem;
            color: var(--black);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: var(--border);
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-group label {
            display: block;
            font-size: 1.6rem;
            color: var(--black);
            margin-bottom: 0.8rem;
            font-weight: 600;
        }
        
        .form-group label span {
            color: var(--red);
        }
        
        .current-value {
            font-size: 1.4rem;
            color: var(--light-color);
            margin-bottom: 0.5rem;
            padding: 0.8rem 1.2rem;
            background: var(--light-bg);
            border-radius: 0.5rem;
            display: inline-block;
        }
        
        .help-text {
            font-size: 1.3rem;
            color: var(--light-color);
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <?php include '../components/admin-header.php'; ?>

    <div class="settings-container">
        <h1 class="heading">Account Settings</h1>
        
        <!-- Profile Information -->
        <div class="settings-section">
            <h2><i class="fas fa-user-circle"></i> Profile Information</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label>Name</label>
                    <div class="current-value">
                        Current: <?= htmlspecialchars($admin['name']) ?>
                    </div>
                    <input type="text" name="name" class="box" 
                           placeholder="Enter new name (leave empty to keep current)" 
                           maxlength="50">
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="current-value">
                        Current: <?= htmlspecialchars($admin['email']) ?>
                    </div>
                    <input type="email" name="email" class="box" 
                           placeholder="Enter new email (leave empty to keep current)" 
                           maxlength="100">
                    <p class="help-text">⚠️ Make sure you have access to the new email</p>
                </div>
                
                <input type="submit" value="Update Profile" name="update_profile" class="btn">
            </form>
        </div>
        
        <!-- Change Password -->
        <div class="settings-section">
            <h2><i class="fas fa-lock"></i> Change Password</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label>Current Password <span>*</span></label>
                    <input type="password" name="current_pass" class="box" 
                           placeholder="Enter your current password" 
                           maxlength="20">
                    <p class="help-text">Required to change password</p>
                </div>
                
                <div class="form-group">
                    <label>New Password <span>*</span></label>
                    <input type="password" name="new_pass" class="box" 
                           placeholder="Enter new password (8 digits)" 
                           maxlength="8" pattern="[0-9]{8}">
                    <p class="help-text">Must be exactly 8 numeric digits</p>
                </div>
                
                <div class="form-group">
                    <label>Confirm New Password <span>*</span></label>
                    <input type="password" name="confirm_pass" class="box" 
                           placeholder="Re-enter new password" 
                           maxlength="8" pattern="[0-9]{8}">
                </div>
                
                <input type="submit" value="Change Password" name="update_profile" class="btn">
            </form>
        </div>
        
        <!-- Account Information -->
        <div class="settings-section">
            <h2><i class="fas fa-info-circle"></i> Account Information</h2>
            <div style="font-size: 1.6rem; line-height: 2;">
                <p><strong>Admin ID:</strong> <?= $admin['id'] ?></p>
                <p><strong>Member Since:</strong> <?= date('F j, Y', strtotime($admin['created_at'])) ?></p>
                <p><strong>Account Type:</strong> Administrator</p>
            </div>
        </div>
    </div>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>