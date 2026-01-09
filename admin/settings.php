<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();
$admin_id = getAdminId();

if (isset($_POST['update'])) {
    $name = sanitize($_POST['name']);
    
    if ($name) {
        $stmt = $conn->prepare("UPDATE admin SET name = ? WHERE id = ?");
        $stmt->execute([$name, $admin_id]);
        setMessage('Profile updated!');
    }
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body class="admin-page">
    <?php include '../components/header.php'; ?>

    <section class="form-container">
        <form action="" method="post">
            <h3>Update Profile</h3>
            <input type="text" name="name" class="box" placeholder="<?= $admin['name'] ?>" maxlength="50">
            <input type="submit" value="Update" name="update" class="btn">
        </form>
    </section>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>