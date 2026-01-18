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
    
    setMessage('Post deleted!', 'success');
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
            // Delete old image
            $stmt = $conn->prepare("SELECT image FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $oldPost = $stmt->fetch();
            if ($oldPost && $oldPost['image']) {
                @unlink('../assets/uploads/' . $oldPost['image']);
            }
            
            $stmt = $conn->prepare("UPDATE posts SET image=? WHERE id=?");
            $stmt->execute([$imageResult['filename'], $id]);
        }
        
        setMessage('Post updated!', 'success');
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
            $imageResult['filename'] ?? '', 
            $status
        ]);
        
        setMessage('Post created!', 'success');
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
    <title>Manage Posts - Soleil|Lune</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
    <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
    <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
    <style>
        .posts-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }
        
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(35rem, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }
        
        .post-card {
            background: var(--white);
            border: var(--border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }
        
        .post-card:hover {
            box-shadow: 0 1rem 2rem rgba(0,0,0,.15);
            transform: translateY(-5px);
        }
        
        .post-card-image {
            width: 100%;
            height: 22rem;
            object-fit: cover;
            border-bottom: var(--border);
        }
        
        .post-card-content {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .post-status-badge {
            display: inline-block;
            padding: 0.6rem 1.5rem;
            border-radius: 2rem;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .status-active {
            background-color: var(--pastel-green);
            color: #2d5016;
        }
        
        .status-deactive {
            background-color: var(--pastel-yellow);
            color: #8b6914;
        }
        
        .post-card-title {
            font-size: 2.2rem;
            color: var(--black);
            margin-bottom: 1rem;
            font-weight: 600;
            line-height: 1.3;
        }
        
        .post-card-excerpt {
            font-size: 1.5rem;
            color: var(--light-color);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex: 1;
        }
        
        .post-card-meta {
            display: flex;
            gap: 2rem;
            padding: 1.5rem;
            background-color: var(--light-bg);
            border-radius: 0.8rem;
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
        }
        
        .post-card-meta div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .post-card-meta i {
            color: var(--main-color);
        }
        
        .post-card-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .add-post-btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .add-post-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem 3rem;
            background: linear-gradient(135deg, var(--main-color), var(--orange));
            color: var(--white);
            border-radius: 0.8rem;
            font-size: 1.8rem;
            font-weight: 600;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            transition: var(--transition);
        }
        
        .add-post-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 .8rem 1.5rem rgba(0,0,0,.15);
        }
        
        .post-count {
            font-size: 1.6rem;
            color: var(--light-color);
        }
        
        /* Editor Styles */
        .post-editor {
            max-width: 90rem;
            margin: 0 auto;
            padding: 3rem 2rem;
        }
        
        .editor-form {
            background: var(--white);
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: var(--box-shadow);
            border: var(--border);
        }
        
        .form-group {
            margin-bottom: 2.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 1.8rem;
            color: var(--black);
            margin-bottom: 0.8rem;
            font-weight: 600;
        }
        
        .form-label span {
            color: var(--red);
        }
        
        .form-help {
            font-size: 1.3rem;
            color: var(--light-color);
            margin-top: 0.5rem;
        }
        
        .image-preview {
            margin-top: 1.5rem;
            max-width: 100%;
            border-radius: 0.8rem;
            border: var(--border);
            box-shadow: 0 .3rem .8rem rgba(0,0,0,.08);
        }
    </style>
</head>
<body>
    <?php include '../components/admin-header.php'; ?>

    <?php if ($action == 'add' || $action == 'edit'): ?>
    <section class="post-editor">
        <h1 class="heading"><?= $action == 'edit' ? 'Edit' : 'Create New' ?> Post</h1>
        
        <form action="" method="post" enctype="multipart/form-data" class="editor-form">
            <input type="hidden" name="post_id" value="<?= $editPost['id'] ?? '' ?>">
            
            <div class="form-group">
                <label class="form-label">
                    Status <span>*</span>
                </label>
                <select name="status" class="box" required>
                    <option value="active" <?= ($editPost['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active (Published)</option>
                    <option value="deactive" <?= ($editPost['status'] ?? '') == 'deactive' ? 'selected' : '' ?>>Draft (Hidden)</option>
                </select>
                <p class="form-help">Active posts are visible to all users</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    Title <span>*</span>
                </label>
                <input type="text" name="title" class="box" required maxlength="100" 
                       value="<?= htmlspecialchars($editPost['title'] ?? '') ?>" 
                       placeholder="Enter an engaging post title">
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    Content <span>*</span>
                </label>
                <textarea name="content" class="box" required maxlength="10000" 
                          placeholder="Write your post content here..." rows="18" 
                          style="resize: vertical; line-height: 1.8;"><?= htmlspecialchars($editPost['content'] ?? '') ?></textarea>
                <p class="form-help">Maximum 10,000 characters</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    Category <span>*</span>
                </label>
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
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    Featured Image
                </label>
                <input type="file" name="image" class="box" accept="image/*">
                <p class="form-help">Recommended size: 800x600px. Max file size: 5MB (jpg, jpeg, png, gif, webp)</p>
                <?php if ($editPost && $editPost['image']): ?>
                <img src="/Soleil-Lune/assets/uploads/<?= $editPost['image'] ?>" 
                     class="image-preview" style="max-width: 400px;">
                <?php endif; ?>
            </div>
            
            <div class="flex-btn" style="margin-top: 3rem;">
                <input type="submit" value="<?= $action == 'edit' ? 'Update' : 'Publish' ?> Post" name="save_post" class="btn">
                <a href="posts.php" class="option-btn">Cancel</a>
            </div>
        </form>
    </section>
    
    <?php else: ?>
    <section class="posts-section">
        <div class="add-post-btn-container">
            <h1 class="heading" style="margin: 0;">Manage Posts</h1>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <span class="post-count">
                    <i class="fas fa-file-alt"></i> <?= count($posts) ?> Post<?= count($posts) != 1 ? 's' : '' ?>
                </span>
                <a href="?action=add" class="add-post-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>Create New Post</span>
                </a>
            </div>
        </div>
        
        <?php if (empty($posts)): ?>
        <div class="empty">
            <i class="fas fa-inbox" style="font-size: 5rem; color: var(--light-color); margin-bottom: 1.5rem;"></i>
            <p style="margin-bottom: 2rem;">No posts yet! Start creating content for your blog.</p>
            <a href="?action=add" class="btn" style="display: inline-block; width: auto;">Create Your First Post</a>
        </div>
        <?php else: ?>
        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <?php if ($post['image']): ?>
                <img src="/Soleil-Lune/assets/uploads/<?= $post['image'] ?>" class="post-card-image" alt="">
                <?php endif; ?>
                
                <div class="post-card-content">
                    <span class="post-status-badge status-<?= $post['status'] ?>">
                        <?= $post['status'] == 'active' ? '✓ Published' : '● Draft' ?>
                    </span>
                    
                    <h3 class="post-card-title"><?= htmlspecialchars($post['title']) ?></h3>
                    
                    <p class="post-card-excerpt"><?= truncateText($post['content'], 120) ?></p>
                    
                    <div class="post-card-meta">
                        <div>
                            <i class="fas fa-calendar"></i>
                            <span><?= date('M d, Y', strtotime($post['date'])) ?></span>
                        </div>
                        <div>
                            <i class="fas fa-tag"></i>
                            <span><?= htmlspecialchars($post['category']) ?></span>
                        </div>
                    </div>
                    
                    <div class="post-card-meta">
                        <div>
                            <i class="fas fa-heart"></i>
                            <span><?= countLikes($post['id']) ?></span>
                        </div>
                        <div>
                            <i class="fas fa-comment"></i>
                            <span><?= countComments($post['id']) ?></span>
                        </div>
                    </div>
                    
                    <div class="post-card-actions">
                        <a href="?action=edit&id=<?= $post['id'] ?>" class="option-btn">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="post" style="margin: 0;">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" name="delete_post" class="delete-btn" 
                                    onclick="return confirmDelete(event, 'Delete this post? All comments will also be deleted.')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <script src="/Soleil-Lune/assets/js/script.js"></script>
</body>
</html>