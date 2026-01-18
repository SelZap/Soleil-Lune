<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();
$admin_id = getAdminId();

// Handle delete comment
if (isset($_POST['delete_comment'])) {
    $comment_id = sanitize($_POST['comment_id']);
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    setMessage('Comment deleted!', 'success');
    header('location: comments.php');
    exit();
}

// Get all comments for admin's posts
$stmt = $conn->prepare("
    SELECT c.*, p.title as post_title, u.name as user_name 
    FROM comments c 
    JOIN posts p ON c.post_id = p.id 
    JOIN users u ON c.user_id = u.id
    WHERE c.admin_id = ? 
    ORDER BY c.date DESC
");
$stmt->execute([$admin_id]);
$comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments - Soleil|Lune</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
    <style>
        .comments-list {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }
        
        .comment-item {
            background: var(--white);
            border: var(--border);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .comment-item:hover {
            box-shadow: 0 .8rem 1.5rem rgba(0,0,0,.12);
            transform: translateY(-3px);
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: var(--border);
        }
        
        .comment-meta {
            flex: 1;
        }
        
        .comment-user {
            font-size: 1.8rem;
            color: var(--main-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .comment-post-title {
            font-size: 1.5rem;
            color: var(--light-color);
            margin-bottom: 0.5rem;
        }
        
        .comment-post-title a {
            color: var(--main-color);
            font-weight: 600;
        }
        
        .comment-post-title a:hover {
            text-decoration: underline;
        }
        
        .comment-date {
            font-size: 1.3rem;
            color: var(--light-color);
        }
        
        .comment-text {
            background: var(--light-bg);
            padding: 1.5rem;
            border-radius: 0.8rem;
            font-size: 1.6rem;
            line-height: 1.6;
            color: var(--black);
            margin-bottom: 1.5rem;
            white-space: pre-line;
        }
        
        .comment-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    <?php include '../components/admin-header.php'; ?>

    <div class="comments-list">
        <h1 class="heading">Manage Comments</h1>
        
        <?php if (empty($comments)): ?>
        <div class="empty">
            <i class="fas fa-inbox" style="font-size: 5rem; color: var(--light-color); margin-bottom: 1.5rem;"></i>
            <p>No comments yet on your posts!</p>
        </div>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
            <div class="comment-item">
                <div class="comment-header">
                    <div class="comment-meta">
                        <div class="comment-user">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($comment['user_name']) ?>
                        </div>
                        <div class="comment-post-title">
                            On post: <a href="/Soleil-Lune/public/post.php?id=<?= $comment['post_id'] ?>" target="_blank">
                                <?= htmlspecialchars($comment['post_title']) ?>
                            </a>
                        </div>
                        <div class="comment-date">
                            <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($comment['date'])) ?>
                        </div>
                    </div>
                </div>
                
                <div class="comment-text">
                    <?= htmlspecialchars($comment['comment']) ?>
                </div>
                
                <div class="comment-actions">
                    <a href="/Soleil-Lune/public/post.php?id=<?= $comment['post_id'] ?>" 
                       class="option-btn" target="_blank">
                        <i class="fas fa-eye"></i> View Post
                    </a>
                    <form method="post" style="margin: 0;">
                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                        <button type="submit" name="delete_comment" class="delete-btn" 
                                onclick="return confirmDelete(event, 'Delete this comment? This cannot be undone.')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>