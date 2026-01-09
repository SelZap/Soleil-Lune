<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();
$admin_id = getAdminId();
$action = $_GET['action'] ?? 'list';
$post_id = $_GET['id'] ?? 0;

// Handle post operations
if (isset($_POST['delete_post'])) {
    $id = sanitize($_POST['post_id']);
    $stmt = $conn->prepare("SELECT image FROM posts WHERE id = ? AND admin_id = ?");
    $stmt->execute([$id, $admin_id]);
    $post = $stmt->fetch();
    
    if ($post && $post['image']) {
        @unlink('../assets/uploads/' . $post['image']);
    }
    
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND admin_id = ?");
    $stmt->execute([$id, $admin_id]);
    $stmt = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
    $stmt->execute([$id]);
    
    setMessage('Post deleted!');
    header('location: posts.php');
    exit();
}

if (isset($_POST['save_post'])) {
    $id = $_POST['post_id'] ?? 0;
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);
    $category = sanitize($_POST['category']);
    $status = sanitize($_POST['status']);
    
    $imageResult = ['success' => ''];
    if (!empty($_FILES['image']['name'])) {
        $imageResult = uploadImage($_FILES['image']);
    }
    
    if ($id) {
        // Update
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, category=?, status=? WHERE id=? AND admin_id=?");
        $stmt->execute([$title, $content, $category, $status, $id, $admin_id]);
        
        if (isset($imageResult['success']) && $imageResult['success']) {
            $stmt = $conn->prepare("UPDATE posts SET image=? WHERE id=?");
            $stmt->execute([$imageResult['success'], $id]);
        }
        
        setMessage('Post updated!');
    } else {
        // Create
        $stmt = $conn->prepare("SELECT name FROM admin WHERE id = ?");
        $stmt->execute([$admin_id]);
        $admin = $stmt->fetch();
        
        $stmt = $conn->prepare("INSERT INTO posts(admin_id, name, title, content, category, image, status) 
                                VALUES(?,?,?,?,?,?,?)");
        $stmt->execute([
            $admin_id, 
            $admin['name'], 
            $title, 
            $content, 
            $category, 
            $imageResult['success'] ?? '', 
            $status
        ]);
        
        setMessage('Post created!');
    }
    
    header('location: posts.php');
    exit();
}

// Get posts
$stmt = $conn->prepare("SELECT * FROM posts WHERE admin_id = ? ORDER BY date DESC");
$stmt->execute([$admin_id]);
$posts = $stmt->fetchAll();

// Get single post for editing
$editPost = null;
if ($action == 'edit' && $post_id) {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND admin_id = ?");
    $stmt->execute([$post_id, $admin_id]);
    $editPost = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body class="admin-page">
    <?php include '../components/header.php'; ?>

    <?php if ($action == 'add' || $action == 'edit'): ?>
    <section class="post-editor">
        <h1 class="heading"><?= $action == 'edit' ? 'Edit' : 'Add' ?> Post</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?= $editPost['id'] ?? '' ?>">
            
            <p>Status <span>*</span></p>
            <select name="status" class="box" required>
                <option value="active" <?= ($editPost['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="deactive" <?= ($editPost['status'] ?? '') == 'deactive' ? 'selected' : '' ?>>Draft</option>
            </select>
            
            <p>Title <span>*</span></p>
            <input type="text" name="title" class="box" required maxlength="100" 
                   value="<?= htmlspecialchars($editPost['title'] ?? '') ?>" placeholder="Post title">
            
            <p>Content <span>*</span></p>
            <textarea name="content" class="box" required maxlength="10000" 
                      placeholder="Write content..." rows="15"><?= htmlspecialchars($editPost['content'] ?? '') ?></textarea>
            
            <p>Category <span>*</span></p>
            <select name="category" class="box" required>
                <option value="">-- Select Category --</option>
                <?php 
                $categories = ['travels', 'education', 'fashion,style,shopping', 'life lately', 
                               'entertainment', 'movies', 'gaming', 'music'];
                foreach ($categories as $cat):
                ?>
                <option value="<?= $cat ?>" <?= ($editPost['category'] ?? '') == $cat ? 'selected' : '' ?>>
                    <?= ucwords($cat) ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <p>Image</p>
            <input type="file" name="image" class="box" accept="image/*">
            <?php if ($editPost && $editPost['image']): ?>
            <img src="/Soleil-Lune/assets/uploads/<?= $editPost['image'] ?>" style="max-width: 300px; margin: 1rem 0;">
            <?php endif; ?>
            
            <div class="flex-btn">
                <input type="submit" value="Save Post" name="save_post" class="btn">
                <a href="posts.php" class="option-btn">Cancel</a>
            </div>
        </form>
    </section>
    
    <?php else: ?>
    <section class="show-posts">
        <h1 class="heading">Your Posts</h1>
        <div style="margin-bottom: 2rem;">
            <a href="?action=add" class="btn">Add New Post</a>
        </div>
        
        <div class="box-container">
            <?php foreach ($posts as $post): ?>
            <form class="box" method="post">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                
                <?php if ($post['image']): ?>
                <img src="/Soleil-Lune/assets/uploads/<?= $post['image'] ?>" class="image" alt="">
                <?php endif; ?>
                
                <div class="status" style="background-color: <?= $post['status'] == 'active' ? 'limegreen' : 'coral' ?>;">
                    <?= ucfirst($post['status']) ?>
                </div>
                
                <div class="title"><?= htmlspecialchars($post['title']) ?></div>
                <div class="posts-content"><?= truncateText($post['content'], 100) ?></div>
                
                <div class="icons">
                    <div><i class="fas fa-heart"></i> <?= countLikes($post['id']) ?></div>
                    <div><i class="fas fa-comment"></i> <?= countComments($post['id']) ?></div>
                </div>
                
                <div class="flex-btn">
                    <a href="?action=edit&id=<?= $post['id'] ?>" class="option-btn">Edit</a>
                    <button type="submit" name="delete_post" class="delete-btn" 
                            onclick="return confirm('Delete this post?');">Delete</button>
                </div>
            </form>
            <?php endforeach; ?>
            
            <?php if (empty($posts)): ?>
            <p class="empty">No posts yet! <a href="?action=add" class="btn">Add Post</a></p>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>