<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

$user_id = getUserId();
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$post_id) {
    header('location: posts.php');
    exit();
}

$post = getPost($post_id);
if (!$post || $post['status'] != 'active') {
    setMessage('Post not found!');
    header('location: posts.php');
    exit();
}

// Handle like
if (isset($_POST['like_post']) && $user_id) {
    toggleLike($post_id, $user_id, $post['admin_id']);
    header("Location: ?id=" . $post_id);
    exit();
}

// Handle add comment
if (isset($_POST['add_comment']) && $user_id) {
    $comment = sanitize($_POST['comment']);
    $stmt = $conn->prepare("INSERT INTO `comments`(post_id, admin_id, user_id, user_name, comment) 
                            SELECT ?, ?, ?, u.name, ? FROM users u WHERE u.id = ?");
    $stmt->execute([$post_id, $post['admin_id'], $user_id, $comment, $user_id]);
    setMessage('Comment added!', 'success');
    header("Location: ?id=" . $post_id);
    exit();
}

// Handle edit comment
if (isset($_POST['edit_comment']) && $user_id) {
    $comment_id = sanitize($_POST['comment_id']);
    $comment = sanitize($_POST['comment']);
    $stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$comment, $comment_id, $user_id]);
    setMessage('Comment updated!', 'success');
    header("Location: ?id=" . $post_id);
    exit();
}

// Handle delete comment
if (isset($_POST['delete_comment']) && $user_id) {
    error_log("Delete comment triggered - Comment ID: " . $_POST['comment_id']);
    $comment_id = sanitize($_POST['comment_id']);
    $stmt = $conn->prepare("DELETE FROM `comments` WHERE id = ? AND user_id = ?");
    $stmt->execute([$comment_id, $user_id]);
    setMessage('Comment deleted!', 'success');
    header("Location: ?id=" . $post_id);
    exit();
}

$comments = getComments($post_id);
$like_count = countLikes($post_id);
$is_liked = isLiked($post_id, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Soleil|Lune Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
    <style>
        .edit-comment-form {
            margin-top: 1rem;
            padding: 1.5rem;
            background-color: var(--pastel-blue);
            border-radius: .8rem;
            border: var(--border);
        }
        .edit-comment-form textarea {
            width: 100%;
            padding: 1.2rem;
            border: var(--border);
            border-radius: .5rem;
            font-size: 1.6rem;
            resize: vertical;
            margin-bottom: 1rem;
            background-color: var(--white);
        }
        .comment-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        .comment-actions form {
            margin: 0;
        }
        .edit-btn, .delete-btn-custom {
            padding: 0.8rem 1.5rem;
            color: var(--white);
            border: none;
            border-radius: .5rem;
            cursor: pointer;
            font-size: 1.4rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }
        .edit-btn {
            background-color: var(--orange);
        }
        .edit-btn:hover {
            background-color: #E09350;
            transform: translateY(-2px);
        }
        .delete-btn-custom {
            background-color: var(--red);
        }
        .delete-btn-custom:hover {
            background-color: #C88A8A;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php include '../components/header.php'; ?>

    <section class="posts-container" style="padding-bottom: 0;">
        <div class="box-container" style="grid-template-columns: 1fr;">
            <form class="box" method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <input type="hidden" name="admin_id" value="<?php echo $post['admin_id']; ?>">
                
                <div class="post-admin">
                    <i class="fas fa-user"></i>
                    <div>
                        <a href="/Soleil-Lune/public/posts.php?author=<?php echo urlencode($post['name']); ?>">
                            <?php echo htmlspecialchars($post['name']); ?>
                        </a>
                        <div><?php echo date('M d, Y', strtotime($post['date'])); ?></div>
                    </div>
                </div>
                
                <?php if (!empty($post['image'])): ?>
                <img src="/Soleil-Lune/assets/uploads/<?php echo htmlspecialchars($post['image']); ?>" class="post-image" alt="">
                <?php endif; ?>
                
                <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
                <div class="post-content" style="white-space: pre-line; max-height: none; -webkit-line-clamp: unset;"><?php echo htmlspecialchars($post['content']); ?></div>
                
                <div class="icons">
                    <div><i class="fas fa-comment"></i><span>(<?php echo count($comments); ?>)</span></div>
                    <button type="submit" name="like_post">
                        <i class="fas fa-heart" style="<?php echo $is_liked ? 'color:var(--red);' : ''; ?>"></i>
                        <span>(<?php echo $like_count; ?>)</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="comments-container">
        <p class="comment-title">Add Comment</p>
        <?php if ($user_id): 
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            
            if ($user):
        ?>
        <form action="" method="post" class="add-comment">
            <p class="user"><i class="fas fa-user"></i> <?php echo htmlspecialchars($user['name']); ?></p>
            <textarea name="comment" maxlength="1000" class="comment-box" required placeholder="Write your comment"></textarea>
            <input type="submit" value="Add Comment" class="inline-btn" name="add_comment">
        </form>
        <?php endif; ?>
        <?php else: ?>
        <div class="add-comment">
            <p>Please login to add comments</p>
            <a href="/Soleil-Lune/public/auth.php?action=login" class="inline-btn">Login Now</a>
        </div>
        <?php endif; ?>
        
        <p class="comment-title">Post Comments</p>
        <div class="user-comments-container">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                <div class="show-comments">
                    <div class="comment-user">
                        <i class="fas fa-user"></i>
                        <div>
                            <span><?php echo htmlspecialchars($comment['user_name']); ?></span>
                            <div><?php echo date('M d, Y', strtotime($comment['date'])); ?></div>
                        </div>
                    </div>
                    
                    <!-- Display mode -->
                    <div class="comment-box" id="comment-display-<?php echo $comment['id']; ?>" style="margin-bottom: 0;">
                        <?php echo htmlspecialchars($comment['comment']); ?>
                    </div>
                    
                    <!-- Edit mode (hidden by default) -->
                    <form action="" method="POST" class="edit-comment-form" id="comment-edit-<?php echo $comment['id']; ?>" style="display: none;">
                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                        <textarea name="comment" rows="4" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>
                        <div class="comment-actions">
                            <button type="submit" class="inline-btn" name="edit_comment">Save Changes</button>
                            <button type="button" class="option-btn" onclick="cancelEdit(<?php echo $comment['id']; ?>)">Cancel</button>
                        </div>
                    </form>
                    
                    <?php if ($comment['user_id'] == $user_id): ?>
                    <div class="comment-actions">
                        <button type="button" class="edit-btn" onclick="showEditForm(<?php echo $comment['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                            <button type="submit" class="delete-btn-custom" name="delete_comment">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty">No comments yet!</p>
            <?php endif; ?>
        </div>
    </section>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
    <script>
        function showEditForm(commentId) {
            document.getElementById('comment-display-' + commentId).style.display = 'none';
            document.getElementById('comment-edit-' + commentId).style.display = 'block';
        }
        
        function cancelEdit(commentId) {
            document.getElementById('comment-display-' + commentId).style.display = 'block';
            document.getElementById('comment-edit-' + commentId).style.display = 'none';
        }
    </script>
</body>
</html>