<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();
$user_id = getUserId();
$action = $_GET['action'] ?? 'list';
$post_id = $_GET['id'] ?? 0;

// Handle delete post
if (isset($_POST['delete_post'])) {
    $id = sanitize($_POST['post_id']);
    $stmt = $conn->prepare("SELECT image FROM posts WHERE id = ? AND admin_id = ?");
    $stmt->execute([$id, $user_id]);
    $post = $stmt->fetch();
    
    if ($post && $post['image']) {
        @unlink('../assets/uploads/' . $post['image']);
    }
    
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND admin_id = ?");
    $stmt->execute([$id, $user_id]);
    $stmt = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
    $stmt->execute([$id]);
    
    setMessage('Post deleted!', 'success');
    header('location: my-posts.php');
    exit();
}

// Handle save post
if (isset($_POST['save_post'])) {
    $id = $_POST['post_id'] ?? 0;
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);
    $category = sanitize($_POST['category']);
    $status = sanitize($_POST['status']);
    
    $imageName = '';
    
    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageResult = uploadImage($_FILES['image']);
        
        if ($imageResult['success']) {
            $imageName = $imageResult['filename'];
        } else {
            setMessage($imageResult['message'], 'error');
            header('location: my-posts.php?action=' . ($id ? 'edit&id='.$id : 'add'));
            exit();
        }
    }
    
    if ($id) {
        // Update existing post
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, category=?, status=? WHERE id=? AND admin_id=?");
        $stmt->execute([$title, $content, $category, $status, $id, $user_id]);
        
        // Update image if new one uploaded
        if ($imageName) {
            // Delete old image
            $stmt = $conn->prepare("SELECT image FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $oldPost = $stmt->fetch();
            if ($oldPost && $oldPost['image']) {
                @unlink('../assets/uploads/' . $oldPost['image']);
            }
            
            $stmt = $conn->prepare("UPDATE posts SET image=? WHERE id=?");
            $stmt->execute([$imageName, $id]);
        }
        
        setMessage('Post updated!', 'success');
    } else {
        // Create new post
        $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        $stmt = $conn->prepare("INSERT INTO posts(admin_id, name, title, content, category, image, status) 
                                VALUES(?,?,?,?,?,?,?)");
        $stmt->execute([
            $user_id, 
            $user['name'], 
            $title, 
            $content, 
            $category, 
            $imageName, 
            $status
        ]);
        
        setMessage('Post created!', 'success');
    }
    
    header('location: my-posts.php');
    exit();
}

// Get user's posts
$stmt = $conn->prepare("SELECT * FROM posts WHERE admin_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$posts = $stmt->fetchAll();

// Get single post for editing
$editPost = null;
if ($action == 'edit' && $post_id) {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND admin_id = ?");
    $stmt->execute([$post_id, $user_id]);
    $editPost = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts - Soleil|Lune</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <?php if ($action == 'add' || $action == 'edit'): ?>
    <section class="post-editor" style="max-width: 90rem; margin: 0 auto; padding: 3rem 2rem;">
        <h1 class="heading"><?= $action == 'edit' ? 'Edit' : 'Add New' ?> Post</h1>
        
        <form action="" method="post" enctype="multipart/form-data" style="background: var(--white); padding: 3rem; border-radius: 1rem; box-shadow: var(--box-shadow); border: var(--border);">
            <input type="hidden" name="post_id" value="<?= $editPost['id'] ?? '' ?>">
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.8rem; color: var(--black); margin-bottom: .8rem; font-weight: 600;">
                    Status <span style="color: var(--red);">*</span>
                </label>
                <select name="status" class="box" required style="width: 100%;">
                    <option value="active" <?= ($editPost['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="deactive" <?= ($editPost['status'] ?? '') == 'deactive' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.8rem; color: var(--black); margin-bottom: .8rem; font-weight: 600;">
                    Title <span style="color: var(--red);">*</span>
                </label>
                <input type="text" name="title" class="box" required maxlength="100" 
                       value="<?= htmlspecialchars($editPost['title'] ?? '') ?>" 
                       placeholder="Post title" style="width: 100%;">
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.8rem; color: var(--black); margin-bottom: .8rem; font-weight: 600;">
                    Content <span style="color: var(--red);">*</span>
                </label>
                <textarea name="content" class="box" required maxlength="10000" 
                          placeholder="Write your content..." rows="15" 
                          style="resize: vertical; width: 100%; line-height: 1.8;"><?= htmlspecialchars($editPost['content'] ?? '') ?></textarea>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.8rem; color: var(--black); margin-bottom: .8rem; font-weight: 600;">
                    Category <span style="color: var(--red);">*</span>
                </label>
                <select name="category" class="box" required style="width: 100%;">
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
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.8rem; color: var(--black); margin-bottom: .8rem; font-weight: 600;">
                    Image
                </label>
                <input type="file" name="image" class="box" accept="image/*" 
                       style="width: 100%; padding: 1.2rem; cursor: pointer;">
                <?php if ($editPost && $editPost['image']): ?>
                <div style="margin-top: 1.5rem;">
                    <img src="/Soleil-Lune/assets/uploads/<?= $editPost['image'] ?>" 
                         style="max-width: 400px; width: 100%; border-radius: .8rem; border: var(--border); box-shadow: 0 .3rem .8rem rgba(0,0,0,.08);">
                </div>
                <?php endif; ?>
            </div>
            
            <div class="flex-btn" style="margin-top: 3rem; gap: 1.5rem;">
                <input type="submit" value="Save Post" name="save_post" class="btn" style="flex: 1;">
                <a href="my-posts.php" class="option-btn" style="flex: 1; text-align: center;">Cancel</a>
            </div>
        </form>
    </section>
    
    <?php else: ?>
    <section class="posts-container" style="padding: 3rem 2rem;">
        <h1 class="heading">My Posts</h1>
        <div style="margin-bottom: 3rem; text-align: center;">
            <a href="?action=add" class="btn" style="display: inline-block; width: auto; padding: 1.5rem 4rem; font-size: 1.8rem;">
                <i class="fas fa-plus" style="margin-right: .8rem;"></i>Add New Post
            </a>
        </div>
        
        <div class="box-container">
            <?php foreach ($posts as $post): ?>
            <div class="box" style="cursor: default; position: relative;">
                
                <!-- Status Badge -->
                <div style="position: absolute; top: 1.5rem; right: 1.5rem; padding: .6rem 1.5rem; background-color: <?= $post['status'] == 'active' ? 'var(--pastel-green)' : 'var(--pastel-yellow)' ?>; border-radius: 2rem; border: var(--border); font-size: 1.3rem; font-weight: 600; color: var(--black);">
                    <?= $post['status'] == 'active' ? '✓ Active' : '● Draft' ?>
                </div>
                
                <?php if ($post['image']): ?>
                <img src="/Soleil-Lune/assets/uploads/<?= $post['image'] ?>" class="post-image" alt="" style="margin-bottom: 1.5rem;">
                <?php endif; ?>
                
                <div class="post-title" style="margin-top: 1rem; margin-bottom: 1rem;"><?= htmlspecialchars($post['title']) ?></div>
                <div class="post-content" style="color: var(--light-color); margin-bottom: 1.5rem;"><?= truncateText($post['content'], 100) ?></div>
                
                <!-- Post Meta -->
                <div style="display: flex; gap: 2rem; margin: 1.5rem 0; padding: 1rem; background-color: var(--light-bg); border-radius: .8rem;">
                    <div style="display: flex; align-items: center; gap: .5rem; font-size: 1.5rem;">
                        <i class="fas fa-heart" style="color: var(--red);"></i> 
                        <span style="font-weight: 600;"><?= countLikes($post['id']) ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: .5rem; font-size: 1.5rem;">
                        <i class="fas fa-comment" style="color: var(--main-color);"></i> 
                        <span style="font-weight: 600;"><?= countComments($post['id']) ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: .5rem; font-size: 1.5rem; margin-left: auto;">
                        <i class="fas fa-calendar" style="color: var(--light-color);"></i> 
                        <span style="color: var(--light-color);"><?= date('M d, Y', strtotime($post['date'])) ?></span>
                    </div>
                </div>
                
                <div class="flex-btn" style="margin-top: 2rem; gap: 1rem;">
                    <a href="?action=edit&id=<?= $post['id'] ?>" class="option-btn" style="flex: 1; text-align: center;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="post" style="flex: 1; margin: 0;" onsubmit="return confirm('Are you sure you want to delete this post? All comments will also be deleted.');">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <button type="submit" name="delete_post" class="delete-btn" style="width: 100%;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if (empty($posts)): ?>
            <div class="empty" style="grid-column: 1/-1;">
                <i class="fas fa-inbox" style="font-size: 5rem; color: var(--light-color); margin-bottom: 1.5rem;"></i>
                <p style="margin-bottom: 2rem;">No posts yet! Start sharing your thoughts with the world.</p>
                <a href="?action=add" class="btn" style="display: inline-block; width: auto;">Create Your First Post</a>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>