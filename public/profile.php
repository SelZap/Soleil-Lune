<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();
$user_id = getUserId();

$view = $_GET['view'] ?? 'profile';

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    
    if ($name) {
        $stmt = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $stmt->execute([$name, $user_id]);
    }
    
    if ($email) {
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user_id]);
        if ($stmt->rowCount() > 0) {
            setMessage('Email already taken!');
        } else {
            $stmt = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $stmt->execute([$email, $user_id]);
        }
    }
    
    // Password update logic here if needed
    setMessage('Profile updated!');
    header("Location: ?view=profile");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Soleil|Lune Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <section class="home-grid">
        <div class="box-container">
            <div class="box">
                <p>Welcome <span><?= htmlspecialchars($user['name']) ?></span></p>
                <div class="flex-btn">
                    <a href="?view=profile" class="option-btn">Profile</a>
                    <a href="?view=likes" class="option-btn">Likes</a>
                    <a href="?view=comments" class="option-btn">Comments</a>
                </div>
            </div>
        </div>
    </section>

    <?php if ($view == 'profile'): ?>
    <section class="form-container">
        <form action="" method="post">
            <h3>Update Profile</h3>
            <input type="text" name="name" placeholder="<?= $user['name'] ?>" class="box" maxlength="50">
            <input type="email" name="email" placeholder="<?= $user['email'] ?>" class="box" maxlength="50">
            <input type="submit" value="Update Now" name="update_profile" class="btn">
        </form>
    </section>
    
    <?php elseif ($view == 'likes'): 
        $stmt = $conn->prepare("SELECT p.* FROM posts p 
                                JOIN likes l ON p.id = l.post_id 
                                WHERE l.user_id = ? AND p.status = 'active'");
        $stmt->execute([$user_id]);
        $posts = $stmt->fetchAll();
    ?>
    <section class="posts-container">
        <h1 class="heading">Liked Posts</h1>
        <div class="box-container">
            <?php 
            require_once '../components/post-card.php';
            foreach ($posts as $post) {
                renderPostCard($post, $user_id);
            }
            if (empty($posts)) {
                echo '<p class="empty">No liked posts yet!</p>';
            }
            ?>
        </div>
    </section>
    
    <?php elseif ($view == 'comments'):
        $stmt = $conn->prepare("SELECT c.*, p.title as post_title, p.id as post_id 
                                FROM comments c 
                                JOIN posts p ON c.post_id = p.id 
                                WHERE c.user_id = ?");
        $stmt->execute([$user_id]);
        $comments = $stmt->fetchAll();
    ?>
    <section class="comments-container">
        <h1 class="heading">Your Comments</h1>
        <div class="user-comments-container">
            <?php foreach ($comments as $comment): ?>
            <div class="show-comments">
                <div class="post-title">
                    From: <span><?= htmlspecialchars($comment['post_title']) ?></span>
                    <a href="/Soleil-Lune/public/post.php?id=<?= $comment['post_id'] ?>">View Post</a>
                </div>
                <div class="comment-box"><?= htmlspecialchars($comment['comment']) ?></div>
            </div>
            <?php endforeach; ?>
            
            <?php if (empty($comments)): ?>
            <p class="empty">No comments yet!</p>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>