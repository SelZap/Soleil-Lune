<?php
function renderPostCard($post, $user_id = '') {
    $post_id = $post['id'];
    $comments = countComments($post_id);
    $likes = countLikes($post_id);
    $isLiked = $user_id ? isLiked($post_id, $user_id) : false;
    ?>
    
    <form class="box" method="post" action="/Soleil-Lune/public/post.php?id=<?php echo $post_id; ?>">
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
        <div class="post-content"><?php echo truncateText($post['content']); ?></div>
        
        <a href="/Soleil-Lune/public/post.php?id=<?php echo $post_id; ?>" class="inline-btn">read more</a>
        <a href="/Soleil-Lune/public/posts.php?category=<?php echo urlencode($post['category']); ?>" class="post-cat">
            <i class="fas fa-tag"></i> <span><?php echo htmlspecialchars($post['category']); ?></span>
        </a>
        
        <div class="icons">
            <a href="/Soleil-Lune/public/post.php?id=<?php echo $post_id; ?>">
                <i class="fas fa-comment"></i><span>(<?php echo $comments; ?>)</span>
            </a>
            <button type="submit" name="like_post">
                <i class="fas fa-heart" style="<?php echo $isLiked ? 'color:var(--red);' : ''; ?>"></i>
                <span>(<?php echo $likes; ?>)</span>
            </button>
        </div>
    </form>
    
    <?php
}
?>