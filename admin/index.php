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
        $email = sanitize($_POST['email']);
        $password = $_POST['pass'];
        
        if (login($email, $password, true)) {
            header('location: index.php');
            exit();
        }
        setMessage('Incorrect email or password!');
    }
    include '../includes/admin-login-form.php';
    exit();
}

requireAdmin();
$admin_id = getAdminId();

// Get admin info
$stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

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
    <title>Admin Dashboard - Soleil|Lune</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
    <style>
        body {
            background: linear-gradient(135deg, #FFF9F0 0%, #FFE5E5 100%);
        }
        .admin-header {
            background: linear-gradient(135deg, var(--main-color), var(--orange));
            color: var(--white);
            padding: 2rem;
            margin-bottom: 3rem;
            border-radius: 1rem;
            box-shadow: var(--box-shadow);
        }
        .admin-header h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        .admin-header p {
            font-size: 1.6rem;
            opacity: 0.9;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .stat-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 1rem;
            border: var(--border);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.15);
        }
        .stat-card i {
            font-size: 4rem;
            color: var(--main-color);
            margin-bottom: 1.5rem;
        }
        .stat-card h3 {
            font-size: 3.5rem;
            color: var(--black);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        .stat-card p {
            font-size: 1.6rem;
            color: var(--light-color);
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
            gap: 1.5rem;
        }
        .action-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            border: var(--border);
            text-align: center;
            transition: var(--transition);
        }
        .action-card:hover {
            background: var(--pastel-yellow);
            transform: translateY(-3px);
        }
        .action-card i {
            font-size: 3rem;
            color: var(--main-color);
            margin-bottom: 1rem;
        }
        .action-card h4 {
            font-size: 1.8rem;
            color: var(--black);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include '../components/admin-header.php'; ?>

    <section style="max-width: 1400px; margin: 0 auto; padding: 3rem 2rem;">
        <div class="admin-header">
            <h1> Welcome back, <?= htmlspecialchars($admin['name']) ?>!</h1>
            <p>Here's what's happening with your blog today</p>
        </div>

        <div class="dashboard-grid">
            <div class="stat-card">
                <i class="fas fa-file-alt"></i>
                <h3><?= $post_count ?></h3>
                <p>Total Posts</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?= $user_count ?></h3>
                <p>Total Users</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-comments"></i>
                <h3><?= $comment_count ?></h3>
                <p>Comments Received</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-heart"></i>
                <h3><?= $like_count ?></h3>
                <p>Total Likes</p>
            </div>
        </div>

        <h2 class="heading" style="margin-bottom: 2rem;">Quick Actions</h2>
        <div class="quick-actions">
            <a href="posts.php" class="action-card">
                <i class="fas fa-edit"></i>
                <h4>Manage Posts</h4>
                <p style="font-size: 1.4rem; color: var(--light-color);">Edit & delete</p>
            </a>
            
            <a href="comments.php" class="action-card">
                <i class="fas fa-comment-dots"></i>
                <h4>Manage Comments</h4>
                <p style="font-size: 1.4rem; color: var(--light-color);">Review & moderate</p>
            </a>
            
            <a href="settings.php" class="action-card">
                <i class="fas fa-cog"></i>
                <h4>Settings</h4>
                <p style="font-size: 1.4rem; color: var(--light-color);">Update profile</p>
            </a>
        </div>
    </section>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>