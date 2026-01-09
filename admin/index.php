<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

$action = $_GET['action'] ?? 'dashboard';

if ($action == 'logout') logout(true);

// Handle login
if ($action == 'login') {
    if (isset($_POST['submit'])) {
        if (login(sanitize($_POST['name']), $_POST['pass'], true)) {
            header('location: index.php');
            exit();
        }
        setMessage('Incorrect credentials!');
    }
    include '../includes/admin-login-form.php';
    exit();
}

requireAdmin();
$admin_id = getAdminId();

// Get statistics
$stmt = $conn->prepare("SELECT COUNT(*) FROM posts WHERE admin_id = ?");
$stmt->execute([$admin_id]);
$post_count = $stmt->fetchColumn();

$stmt = $conn->query("SELECT COUNT(*) FROM users");
$user_count = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM comments WHERE admin_id = ?");
$stmt->execute([$admin_id]);
$comment_count = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE admin_id = ?");
$stmt->execute([$admin_id]);
$like_count = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body class="admin-page">
    <?php include '../components/header.php'; ?>

    <section class="dashboard">
        <h1 class="heading">Admin Dashboard</h1>
        <div class="box-container">
            <div class="box">
                <h3>Posts: <?= $post_count ?></h3>
                <a href="posts.php" class="btn">Manage Posts</a>
            </div>
            <div class="box">
                <h3>Users: <?= $user_count ?></h3>
                <p>Total registered users</p>
            </div>
            <div class="box">
                <h3>Comments: <?= $comment_count ?></h3>
                <p>On your posts</p>
            </div>
            <div class="box">
                <h3>Likes: <?= $like_count ?></h3>
                <p>Total likes received</p>
            </div>
        </div>
    </section>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>